<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relação de Turmas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8pt;
            color: #11245C;
            line-height: 1.2;
            padding: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 2px solid #1A2E6B;
        }

        .header .logo {
            margin-bottom: 4px;
        }

        .header .logo img {
            max-width: 80px;
            height: auto;
        }

        .header h1 {
            color: #1A2E6B;
            font-size: 13pt;
            margin-bottom: 2px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header p {
            color: #5a6a9a;
            font-size: 7pt;
            margin: 0;
        }

        .info-geral {
            background: linear-gradient(135deg, #f4f6fb 0%, #e8ecf7 100%);
            padding: 6px 10px;
            border-radius: 4px;
            margin-bottom: 8px;
            border-left: 3px solid #2E63BF;
        }

        .info-geral p {
            margin: 0;
            font-size: 8pt;
            color: #11245C;
            display: inline;
            margin-right: 15px;
            white-space: nowrap;
        }

        .info-geral strong {
            color: #1A2E6B;
            font-weight: 700;
        }

        .turma-section {
            margin-bottom: 15px;
            page-break-inside: avoid;
            border: 1px solid #dde2f4;
            border-radius: 5px;
            overflow: hidden;
        }

        .turma-header {
            background: linear-gradient(135deg, #1A2E6B 0%, #2E63BF 100%);
            color: white;
            padding: 6px 10px;
            margin-bottom: 0;
        }

        .turma-header h2 {
            font-size: 11pt;
            margin-bottom: 0;
            font-weight: 700;
        }

        .turma-info {
            background: #f9fafb;
            padding: 4px 10px;
            border-bottom: 1px solid #dde2f4;
            font-size: 7pt;
            display: table;
            width: 100%;
        }

        .turma-info .info-row {
            display: table-row;
        }

        .turma-info .info-label {
            display: table-cell;
            font-weight: 700;
            color: #1A2E6B;
            padding: 1px 8px 1px 0;
            width: 75px;
        }

        .turma-info .info-value {
            display: table-cell;
            color: #11245C;
            padding: 1px 0;
        }

        .alunos-list {
            border-top: none;
        }

        .alunos-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .alunos-list thead {
            background: linear-gradient(to bottom, #e8ecf7 0%, #f4f6fb 100%);
        }

        .alunos-list th {
            padding: 4px 6px;
            text-align: left;
            font-weight: 700;
            color: #1A2E6B;
            border-bottom: 2px solid #2E63BF;
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .alunos-list th.numero {
            width: 7%;
            text-align: center;
        }

        .alunos-list th.nome {
            width: 58%;
        }

        .alunos-list th.assinatura {
            width: 35%;
            text-align: center;
        }

        .alunos-list td {
            padding: 3px 6px;
            border-bottom: 1px solid #e8ecf7;
            font-size: 8pt;
            color: #11245C;
        }

        .alunos-list td.numero {
            text-align: center;
            font-weight: 700;
            color: #2E63BF;
            font-size: 9pt;
        }

        .alunos-list td.assinatura {
            border-bottom: 1px solid #11245C;
            background: #fafbfd;
        }

        .alunos-list tr:last-child td {
            border-bottom: none;
        }

        .alunos-list tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .turma-footer {
            background: #f9fafb;
            padding: 5px 10px;
            border-top: 1px solid #dde2f4;
            margin-top: 0;
            font-size: 6pt;
            color: #5a6a9a;
            text-align: center;
        }

        .footer {
            text-align: center;
            padding: 8px 10px;
            margin-top: 10px;
            font-size: 6pt;
            color: #5a6a9a;
            border-top: 1px solid #dde2f4;
        }

        .no-alunos {
            padding: 12px;
            text-align: center;
            color: #5a6a9a;
            font-style: italic;
            background: #f9fafb;
            font-size: 8pt;
        }

        .page-break {
            page-break-after: always;
        }

        .metadata {
            font-size: 6pt;
            color: #5a6a9a;
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <div class="header">
        @if ($logoBase64)
            <div class="logo">
                <img src="data:image/png;base64,{{ $logoBase64 }}" alt="Codevilla">
            </div>
        @endif
        <h1>Relação de Alunos</h1>
    </div>

    <div class="info-geral">
        <strong>Total de Turmas:</strong> {{ $turmas->count() }} | <strong>Total de Alunos:</strong>
        {{ $turmas->sum('alunos_count') }} | <strong>Data de Geração:</strong> {{ now()->format('d/m/Y H:i') }}
    </div>

    @foreach ($turmas as $index => $turma)
        <div class="turma-section">
            <div class="turma-header">
                <h2>{{ $turma->nome }}</h2>
            </div>

            <div class="turma-info">
                <div class="info-row">
                    <span class="info-label">Ano Letivo:</span>
                    <span class="info-value">{{ $turma->ano_letivo }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Turno:</span>
                    <span class="info-value">{{ $turma->turno }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Segmento:</span>
                    <span class="info-value">{{ $turma->segmento ?: 'Não informado' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total de Alunos:</span>
                    <span class="info-value">{{ $turma->alunos->count() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">{{ $turma->ativa ? 'Ativa' : 'Inativa' }}</span>
                </div>
            </div>

            <div class="alunos-list">
                @if ($turma->alunos->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th class="numero">Nº</th>
                                <th class="nome">Nome do Aluno</th>
                                <th class="assinatura">Assinatura</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($turma->alunos as $aluno)
                                <tr>
                                    <td class="numero">{{ $aluno->numero_chamada }}</td>
                                    <td class="nome">{{ $aluno->nome }}</td>
                                    <td class="assinatura">&nbsp;</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="no-alunos">
                        Nenhum aluno cadastrado nesta turma
                    </div>
                @endif
            </div>

            <div class="turma-footer">
                Prof. Responsável: _________________ | Coord. Pedagógica: _________________
            </div>
        </div>
    @endforeach

    <div class="footer">
        <p>Documento gerado em {{ now()->format('d/m/Y às H:i') }}</p>
    </div>
</body>

</html>
