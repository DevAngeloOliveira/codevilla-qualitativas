<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Usuarios\Models\User;
use App\Domains\Alunos\Models\{Aluno, Turma};
use App\Domains\Disciplinas\Models\Disciplina;
use App\Domains\Avaliacoes\Models\Criterio;
use App\Services\DataAnonymizer;
use Illuminate\Support\Facades\DB;

/**
 * Seeder para ambiente de Staging
 *
 * Comportamento:
 * - Se DATABASE_SOURCE_TYPE=production: Copia e anonimiza dados de produção
 * - Se DATABASE_SOURCE_TYPE=fake (padrão): Usa dados fictícios
 *
 * Configurar no .env.staging:
 * DATABASE_SOURCE_TYPE=fake  # ou 'production'
 * DATABASE_SOURCE_CONNECTION=mysql_production  # conexão com banco de produção
 */
class StagingSeeder extends Seeder
{
    protected $sourceType;
    protected $sourceConnection;

    public function __construct()
    {
        $this->sourceType = env('DATABASE_SOURCE_TYPE', 'fake');
        $this->sourceConnection = env('DATABASE_SOURCE_CONNECTION', 'mysql_production');
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info("🚀 Iniciando Staging Seeder");
        $this->command->info("📊 Tipo de fonte: {$this->sourceType}");

        if ($this->sourceType === 'production') {
            $this->seedFromProduction();
        } else {
            $this->seedWithFakeData();
        }

        $this->command->info("✅ Staging Seeder concluído!");
    }

    /**
     * Popula com dados anonimizados de produção
     */
    protected function seedFromProduction(): void
    {
        $this->command->warn("⚠️  Copiando e anonimizando dados de PRODUÇÃO");
        $this->command->warn("Conexão: {$this->sourceConnection}");

        if (!$this->command->confirm('Confirma a cópia de dados de produção?', false)) {
            $this->command->error('Operação cancelada pelo usuário');
            return;
        }

        DB::beginTransaction();

        try {
            // 1. Critérios (copiar sem anonimizar - são dados de negócio)
            $this->copyTableDirectly('criterios');

            // 2. Disciplinas (copiar sem anonimizar - são dados de negócio)
            $this->copyTableDirectly('disciplinas');

            // 3. Turmas (copiar sem anonimizar - são dados estruturais)
            $this->copyTableDirectly('turmas');

            // 4. Usuários (ANONIMIZAR)
            $this->copyAndAnonymizeUsers();

            // 5. Alunos (ANONIMIZAR)
            $this->copyAndAnonymizeAlunos();

            // 6. Relacionamentos professor_disciplina
            $this->copyTableDirectly('professor_disciplina');

            // 7. Relacionamentos professor_turma
            $this->copyTableDirectly('professor_turma');

            // 8. Avaliações (anonimizar observações)
            $this->copyAndAnonymizeAvaliacoes();

            DB::commit();
            $this->command->info("✅ Dados copiados e anonimizados com sucesso!");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("❌ Erro ao copiar dados: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Popula com dados fictícios (comportamento padrão)
     */
    protected function seedWithFakeData(): void
    {
        $this->command->info("🎭 Gerando dados fictícios para staging");

        // Chama seeders de desenvolvimento
        $this->call([
            CriterioSeeder::class,
            DisciplinaSeeder::class,
            UserSeeder::class,
            TurmaSeeder::class,
            AlunoSeeder::class,
            ProfessorSeeder::class,
            AtribuicaoSeeder::class,
        ]);

        $this->command->info("✅ Dados fictícios gerados!");
    }

    /**
     * Copia tabela diretamente sem anonimização
     */
    protected function copyTableDirectly(string $table): void
    {
        $this->command->info("📋 Copiando tabela: {$table}");

        $records = DB::connection($this->sourceConnection)
            ->table($table)
            ->get()
            ->toArray();

        if (empty($records)) {
            $this->command->warn("⚠️  Tabela {$table} está vazia");
            return;
        }

        // Converte objetos para arrays
        $records = array_map(fn($r) => (array) $r, $records);

        // Insere em lotes
        foreach (array_chunk($records, 100) as $chunk) {
            DB::table($table)->insert($chunk);
        }

        $count = count($records);
        $this->command->info("✓ {$count} registros copiados de {$table}");
    }

    /**
     * Copia e anonimiza usuários
     */
    protected function copyAndAnonymizeUsers(): void
    {
        $this->command->info("👤 Copiando e anonimizando usuários");

        $users = DB::connection($this->sourceConnection)
            ->table('users')
            ->get();

        foreach ($users as $user) {
            $anonymized = DataAnonymizer::anonymizeUser($user);

            DB::table('users')->insert([
                'id' => $user->id,
                'name' => $anonymized['name'],
                'email' => $anonymized['email'],
                'password' => $anonymized['password'],
                'role' => $user->role,
                'is_active' => $user->is_active,
                'email_verified_at' => now(),
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        }

        $this->command->info("✓ {$users->count()} usuários anonimizados");
        $this->command->warn("🔑 Senha padrão para todos: staging@2026");
    }

    /**
     * Copia e anonimiza alunos
     */
    protected function copyAndAnonymizeAlunos(): void
    {
        $this->command->info("🎓 Copiando e anonimizando alunos");

        $alunos = DB::connection($this->sourceConnection)
            ->table('alunos')
            ->get();

        foreach ($alunos as $aluno) {
            $anonymized = DataAnonymizer::anonymizeAluno($aluno);

            DB::table('alunos')->insert([
                'id' => $aluno->id,
                'uuid' => $aluno->uuid,
                'nome' => $anonymized['nome'],
                'numero_chamada' => $aluno->numero_chamada,
                'turma_id' => $aluno->turma_id,
                'foto' => null, // Remove fotos
                'ativo' => $aluno->ativo,
                'created_at' => $aluno->created_at,
                'updated_at' => $aluno->updated_at,
            ]);
        }

        $this->command->info("✓ {$alunos->count()} alunos anonimizados");
    }

    /**
     * Copia e anonimiza avaliações (apenas observações)
     */
    protected function copyAndAnonymizeAvaliacoes(): void
    {
        $this->command->info("📝 Copiando e anonimizando avaliações");

        $avaliacoes = DB::connection($this->sourceConnection)
            ->table('avaliacoes')
            ->get();

        foreach ($avaliacoes as $avaliacao) {
            $observacoesAnon = $avaliacao->observacoes
                ? DataAnonymizer::anonymizeObservacao($avaliacao->observacoes)
                : null;

            DB::table('avaliacoes')->insert([
                'id' => $avaliacao->id,
                'aluno_id' => $avaliacao->aluno_id,
                'professor_id' => $avaliacao->professor_id,
                'disciplina_id' => $avaliacao->disciplina_id,
                'turma_id' => $avaliacao->turma_id,
                'trimestre' => $avaliacao->trimestre,
                'ano_letivo' => $avaliacao->ano_letivo,
                'criterios_versao' => $avaliacao->criterios_versao ?? '1.0',
                'nota_final' => $avaliacao->nota_final,
                'observacoes' => $observacoesAnon,
                'finalizada' => $avaliacao->finalizada,
                'created_at' => $avaliacao->created_at,
                'updated_at' => $avaliacao->updated_at,
            ]);
        }

        // Copiar avaliacao_criterio
        $criterios = DB::connection($this->sourceConnection)
            ->table('avaliacao_criterio')
            ->get()
            ->toArray();

        if (!empty($criterios)) {
            $criterios = array_map(fn($c) => (array) $c, $criterios);

            foreach (array_chunk($criterios, 100) as $chunk) {
                DB::table('avaliacao_criterio')->insert($chunk);
            }
        }

        $this->command->info("✓ {$avaliacoes->count()} avaliações anonimizadas");
    }
}
