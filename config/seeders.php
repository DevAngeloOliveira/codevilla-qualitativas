<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Ano Letivo Atual
    |--------------------------------------------------------------------------
    |
    | Define o ano letivo padrão para os seeders. Se não configurado via ENV,
    | usa o ano atual.
    |
    */
    'ano_letivo_atual' => env('SEEDER_ANO_LETIVO', date('Y')),

    /*
    |--------------------------------------------------------------------------
    | Critérios de Avaliação
    |--------------------------------------------------------------------------
    |
    | Define os critérios padrão usados para avaliação dos alunos.
    | Estrutura: código, descrição, peso, versão.
    |
    */
    'criterios' => [
        [
            'codigo' => 'PART',
            'descricao' => 'Participação e Interesse',
            'peso' => 1.0,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
        [
            'codigo' => 'COMP',
            'descricao' => 'Compreensão e Domínio do Conteúdo',
            'peso' => 2.0,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
        [
            'codigo' => 'TRAB',
            'descricao' => 'Trabalhos e Atividades',
            'peso' => 1.5,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
        [
            'codigo' => 'AVAL',
            'descricao' => 'Avaliações e Provas',
            'peso' => 2.5,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
        [
            'codigo' => 'COOP',
            'descricao' => 'Cooperação e Trabalho em Equipe',
            'peso' => 1.0,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
        [
            'codigo' => 'CRIT',
            'descricao' => 'Pensamento Crítico',
            'peso' => 1.5,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
        [
            'codigo' => 'CRIA',
            'descricao' => 'Criatividade e Inovação',
            'peso' => 1.0,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
        [
            'codigo' => 'ORG',
            'descricao' => 'Organização e Responsabilidade',
            'peso' => 1.0,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
        [
            'codigo' => 'EVOL',
            'descricao' => 'Evolução e Progressão',
            'peso' => 1.5,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
        [
            'codigo' => 'AUTO',
            'descricao' => 'Autonomia e Iniciativa',
            'peso' => 1.0,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
        [
            'codigo' => 'COMU',
            'descricao' => 'Comunicação Oral e Escrita',
            'peso' => 1.5,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
        [
            'codigo' => 'RESP',
            'descricao' => 'Respeito e Ética',
            'peso' => 1.0,
            'versao' => '1.0',
            'vigencia_inicio' => '2024-01-01',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Disciplinas
    |--------------------------------------------------------------------------
    |
    | Define as disciplinas disponíveis no sistema.
    | Estrutura: nome, código, segmento, ativa.
    |
    */
    'disciplinas' => [
        [
            'nome' => 'Português',
            'codigo' => 'PORT',
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ],
        [
            'nome' => 'Matemática',
            'codigo' => 'MAT',
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ],
        [
            'nome' => 'Ciências',
            'codigo' => 'CIEN',
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ],
        [
            'nome' => 'História',
            'codigo' => 'HIST',
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ],
        [
            'nome' => 'Geografia',
            'codigo' => 'GEO',
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ],
        [
            'nome' => 'Inglês',
            'codigo' => 'ING',
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ],
        [
            'nome' => 'Educação Física',
            'codigo' => 'EDFIS',
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ],
        [
            'nome' => 'Artes',
            'codigo' => 'ART',
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ],
        [
            'nome' => 'Música',
            'codigo' => 'MUS',
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ],
        [
            'nome' => 'Tecnologia',
            'codigo' => 'TEC',
            'segmento' => 'Ensino Fundamental II',
            'ativa' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Usuário Desenvolvedor
    |--------------------------------------------------------------------------
    |
    | Credenciais do usuário desenvolvedor criado nos seeders essenciais.
    |
    */
    'dev_user' => [
        'name' => 'Desenvolvedor',
        'email' => 'dev@codevilla.com',
        'password' => 'Dev@2026',
        'role' => 'desenvolvedor',
    ],
];
