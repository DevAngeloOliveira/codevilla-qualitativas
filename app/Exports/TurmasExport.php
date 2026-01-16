<?php

namespace App\Exports;

use App\Domains\Alunos\Models\Turma;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TurmasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Turma::with(['alunos' => function ($query) {
            $query->orderBy('numero_chamada');
        }])
            ->withCount('alunos')
            ->ordenadas()
            ->get();
    }

    /**
     * @param Turma $turma
     */
    public function map($turma): array
    {
        return [
            $turma->nome,
            $turma->ano_letivo,
            $turma->turno,
            $turma->segmento,
            $turma->alunos_count,
            $turma->ativa ? 'Sim' : 'Não',
            $turma->alunos->pluck('nome')->implode(', '),
        ];
    }

    public function headings(): array
    {
        return [
            'Turma',
            'Ano Letivo',
            'Turno',
            'Segmento',
            'Total de Alunos',
            'Ativa',
            'Alunos',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF']],
            ],
        ];
    }

    public function title(): string
    {
        return 'Relação de Turmas';
    }
}
