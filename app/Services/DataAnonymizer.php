<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Serviço para anonimizar dados sensíveis
 * Útil para criar ambientes de staging com dados de produção
 */
class DataAnonymizer
{
    /**
     * Anonimiza um nome completo mantendo iniciais
     * Ex: "João Silva Santos" -> "João S. S."
     */
    public static function anonymizeName(string $name): string
    {
        $parts = explode(' ', trim($name));

        if (count($parts) === 1) {
            return $parts[0];
        }

        $firstName = $parts[0];
        $restParts = array_slice($parts, 1);

        $anonymizedRest = array_map(function ($part) {
            return mb_substr($part, 0, 1) . '.';
        }, $restParts);

        return $firstName . ' ' . implode(' ', $anonymizedRest);
    }

    /**
     * Anonimiza um email mantendo domínio
     * Ex: "joao.silva@escola.com" -> "usuario_abc123@escola.com"
     */
    public static function anonymizeEmail(string $email): string
    {
        [$localPart, $domain] = explode('@', $email);

        $randomPart = Str::random(6);

        return "usuario_{$randomPart}@{$domain}";
    }

    /**
     * Gera uma senha padrão para usuários anonimizados
     */
    public static function generateDefaultPassword(): string
    {
        return Hash::make('staging@2026');
    }

    /**
     * Anonimiza número de telefone
     * Ex: "(11) 98765-4321" -> "(11) 9****-****"
     */
    public static function anonymizePhone(string $phone): string
    {
        return preg_replace('/\d(?=\d{4})/', '*', $phone);
    }

    /**
     * Anonimiza CPF
     * Ex: "123.456.789-00" -> "***.***.789-**"
     */
    public static function anonymizeCPF(string $cpf): string
    {
        return preg_replace('/^(\d{3})\.?(\d{3})\.?(\d{3})-?(\d{2})$/', '***.***.${3}-**', $cpf);
    }

    /**
     * Anonimiza endereço parcialmente
     * Mantém cidade/estado, oculta rua e número
     */
    public static function anonymizeAddress(array $address): array
    {
        return [
            'rua' => 'Rua ***',
            'numero' => '***',
            'complemento' => null,
            'bairro' => $address['bairro'] ?? 'Bairro ***',
            'cidade' => $address['cidade'] ?? 'Cidade',
            'estado' => $address['estado'] ?? 'UF',
            'cep' => preg_replace('/\d/', '*', $address['cep'] ?? '00000-000'),
        ];
    }

    /**
     * Anonimiza data de nascimento mantendo mês e ano
     * Útil para preservar idade aproximada
     * Ex: "1990-05-15" -> "1990-05-01"
     */
    public static function anonymizeBirthDate(string $date): string
    {
        $parsed = \DateTime::createFromFormat('Y-m-d', $date);

        if (!$parsed) {
            return $date;
        }

        return $parsed->format('Y-m') . '-01';
    }

    /**
     * Anonimiza objeto User completo
     */
    public static function anonymizeUser(object $user): array
    {
        return [
            'name' => self::anonymizeName($user->name),
            'email' => self::anonymizeEmail($user->email),
            'password' => self::generateDefaultPassword(),
        ];
    }

    /**
     * Anonimiza objeto Aluno completo
     */
    public static function anonymizeAluno(object $aluno): array
    {
        return [
            'nome' => self::anonymizeName($aluno->nome),
            'foto' => null, // Remove fotos em staging
        ];
    }

    /**
     * Anonimiza observações de avaliações
     * Remove texto específico mas mantém estrutura
     */
    public static function anonymizeObservacao(string $observacao): string
    {
        $patterns = [
            '/\b[A-Z][a-zà-ú]+\b/' => 'Aluno',  // Nomes próprios
            '/\d{2}\/\d{2}\/\d{4}/' => 'XX/XX/XXXX',  // Datas
            '/[0-9]{2,}/' => 'XXX',  // Números específicos
        ];

        $anonymized = $observacao;

        foreach ($patterns as $pattern => $replacement) {
            $anonymized = preg_replace($pattern, $replacement, $anonymized);
        }

        return $anonymized;
    }

    /**
     * Anonimiza em lote preservando estrutura relacional
     * Mantém IDs e relacionamentos, apenas anonimiza dados pessoais
     */
    public static function anonymizeBatch(string $model, array $records): array
    {
        $anonymized = [];

        foreach ($records as $record) {
            $data = (array) $record;

            switch ($model) {
                case 'User':
                    $data = array_merge($data, self::anonymizeUser((object) $record));
                    break;

                case 'Aluno':
                    $data = array_merge($data, self::anonymizeAluno((object) $record));
                    break;

                default:
                    break;
            }

            $anonymized[] = $data;
        }

        return $anonymized;
    }

    /**
     * Verifica se um ambiente deve usar dados anonimizados
     */
    public static function shouldAnonymize(): bool
    {
        return in_array(app()->environment(), ['staging', 'testing']);
    }
}
