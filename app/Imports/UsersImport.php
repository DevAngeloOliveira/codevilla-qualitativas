<?php

namespace App\Imports;

use App\Domains\Usuarios\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows, WithBatchInserts, WithChunkReading
{
    protected $errors = [];
    protected $imported = 0;
    protected $skipped = 0;
    protected $defaultPassword;

    public function __construct($defaultPassword = 'mudar@123')
    {
        $this->defaultPassword = $defaultPassword;
    }

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Verifica se usuário já existe
                $existingUser = User::where('email', $row['email'])->first();

                if ($existingUser) {
                    $this->errors[] = "Email '{$row['email']}' já cadastrado";
                    $this->skipped++;
                    continue;
                }

                // Valida role
                $role = strtolower($row['role'] ?? 'professor');
                if (!in_array($role, ['professor', 'coordenacao', 'desenvolvedor'])) {
                    $this->errors[] = "Role inválida para '{$row['email']}': {$role}";
                    $this->skipped++;
                    continue;
                }

                // Define senha
                $password = !empty($row['password'])
                    ? $row['password']
                    : $this->defaultPassword;

                // Cria usuário
                User::create([
                    'name' => $row['nome'],
                    'email' => $row['email'],
                    'password' => Hash::make($password),
                    'role' => $role,
                    'is_active' => $row['ativo'] ?? true,
                    'email_verified_at' => now(),
                ]);

                $this->imported++;
            } catch (\Exception $e) {
                $this->errors[] = "Erro ao importar '{$row['email']}': " . $e->getMessage();
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
            'email' => 'required|email|max:255',
            'role' => 'required|string|in:professor,coordenacao,desenvolvedor',
            'password' => 'nullable|string|min:6',
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
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'O email deve ser válido',
            'role.required' => 'O campo role é obrigatório',
            'role.in' => 'A role deve ser: professor, coordenacao ou desenvolvedor',
        ];
    }

    /**
     * Batch size para inserções em lote
     */
    public function batchSize(): int
    {
        return 50;
    }

    /**
     * Chunk size para leitura
     */
    public function chunkSize(): int
    {
        return 50;
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
