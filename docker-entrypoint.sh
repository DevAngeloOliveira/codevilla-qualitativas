#!/bin/bash

# Script de inicialização

set -e

echo "🚀 Iniciando aplicação Codevilla..."

# Definir porta padrão se não estiver definida
export PORT=${PORT:-8080}
echo "📡 Usando porta: $PORT"

# Configurar diretórios writable
echo "📁 Configurando diretórios de escrita..."
mkdir -p /tmp/storage/{app/public,framework/{cache/data,sessions,testing,views},logs}
mkdir -p /tmp/bootstrap/cache
chmod -R 777 /tmp/storage /tmp/bootstrap/cache

# Substituir a porta no template do Nginx
mkdir -p /etc/nginx/sites-available /etc/nginx/sites-enabled
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/sites-available/default
ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default
rm -f /etc/nginx/sites-enabled/default.dpkg-dist

# Verificar configuração do Nginx
nginx -t || { echo "Erro na configuração do Nginx!"; cat /etc/nginx/sites-available/default; exit 1; }

# Gerar APP_KEY se não existir
if [ -z "$APP_KEY" ]; then
    echo "🔑 Gerando APP_KEY..."
    php artisan key:generate --force
fi

# PULAR migrations em modo local (banco já configurado)
if [ "$APP_ENV" != "local" ]; then
    echo "📊 Executando migrations..."
    php artisan migrate --force || echo "⚠️  Erro ao executar migrations, mas continuando..."

    echo "👤 Criando usuário desenvolvedor padrão..."
    php artisan tinker --execute="
    if (!\App\Domains\Usuarios\Models\User::where('email', 'dev@codevilla.com')->exists()) {
        \App\Domains\Usuarios\Models\User::create([
            'name' => 'Desenvolvedor',
            'email' => 'dev@codevilla.com',
            'password' => bcrypt('Dev@2026'),
            'role' => 'desenvolvedor'
        ]);
    }
    " || echo "⚠️  Erro ao criar usuário, mas continuando..."
else
    echo "⏭️  Modo local: pulando migrations (banco já configurado no Supabase)"
fi

# Criar storage link
mkdir -p /tmp/storage/app/public

echo "⚡ Otimizando aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Aplicação pronta!"
echo "🌐 Escutando na porta $PORT"

# Iniciar Supervisor (gerencia Nginx e PHP-FPM)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
