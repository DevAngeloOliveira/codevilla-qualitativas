<?php

namespace App\Imports;

use App\Domains\Alunos\Models\Aluno;
use App\Domains\Alunos\Models\Turma;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AlunosImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows, WithBatchInserts, WithChunkReading
{
    protected $turmaId;
    protected $errors = [];
    protected $imported = 0;
    protected $skipped = 0;

    public function __construct($turmaId = null)
    {
        $this->turmaId = $turmaId;
    }

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Se turma_id não foi fornecida no construtor, busca pela turma no CSV
                $turmaId = $this->turmaId;

                if (!$turmaId && isset($row['turma'])) {
                    $turma = Turma::where('nome', $row['turma'])
                        ->where('ano_letivo', $row['ano_letivo'] ?? date('Y'))
                        ->first();

                    if (!$turma) {
                        $this->errors[] = "Linha {$row->keys()->first()}: Turma '{$row['turma']}' não encontrada";
                        $this->skipped++;
                        continue;
                    }

                    $turmaId = $turma->id;
                }

                if (!$turmaId) {
                    $this->errors[] = "Linha {$row->keys()->first()}: Turma não especificada";
                    $this->skipped++;
                    continue;
                }

                // Verifica se aluno já existe
                $existingAluno = Aluno::where('turma_id', $turmaId)
                    ->where(function ($query) use ($row) {
                        $query->where('nome', $row['nome'])
                            ->orWhere('numero_chamada', $row['numero_chamada']);
                    })
                    ->first();

                if ($existingAluno) {
                    $this->errors[] = "Aluno '{$row['nome']}' já existe na turma";
                    $this->skipped++;
                    continue;
                }

                // Cria aluno
                Aluno::create([
                    'uuid' => Str::uuid(),
                    'nome' => $row['nome'],
                    'numero_chamada' => $row['numero_chamada'],
                    'turma_id' => $turmaId,
                    'ativo' => $row['ativo'] ?? true,
                ]);

                $this->imported++;
            } catch (\Exception $e) {
                $this->errors[] = "Erro ao importar '{$row['nome']}': " . $e->getMessage();
                $this->skipped++;
            }
        }
    }

    /**
     * Regras de validação
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'numero_chamada' => 'required|integer|min:1',
            'turma' => 'nullable|string|max:50',
            'ano_letivo' => 'nullable|integer|digits:4',
            'ativo' => 'nullable|boolean',
        ];
    }

    /**
     * Mensagens de validação customizadas
     */
    public function customValidationMessages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.string' => 'O nome deve ser um texto válido',
            'numero_chamada.required' => 'O número de chamada é obrigatório',
            'numero_chamada.integer' => 'O número de chamada deve ser um número inteiro',
            'numero_chamada.min' => 'O número de chamada deve ser maior que zero',
        ];
    }

    /**
     * Batch size para inserções em lote
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Chunk size para leitura
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Retorna erros encontrados
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Retorna estatísticas da importação
     */
    public function getStats(): array
    {
        return [
            'imported' => $this->imported,
            'skipped' => $this->skipped,
            'errors' => count($this->errors),
        ];
    }
}
