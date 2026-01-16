#!/bin/bash

# Script de inicialização para Google Cloud Run

set -e

echo "🚀 Iniciando aplicação Codevilla no Cloud Run..."

# Definir porta padrão se não estiver definida
export PORT=${PORT:-8080}
echo "📡 Usando porta: $PORT"

# Configurar diretórios writable no Cloud Run (filesystem é read-only exceto /tmp)
echo "📁 Configurando diretórios de escrita..."
mkdir -p /tmp/storage/{app/public,framework/{cache/data,sessions,testing,views},logs}
mkdir -p /tmp/bootstrap/cache

# Ajustar permissões em /tmp
chmod -R 777 /tmp/storage
chmod -R 777 /tmp/bootstrap/cache

# Substituir a porta no template do Nginx
mkdir -p /etc/nginx/sites-available /etc/nginx/sites-enabled
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/sites-available/default
ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default
rm -f /etc/nginx/sites-enabled/default.dpkg-dist

# Verificar se o nginx está configurado corretamente
nginx -t || { echo "Erro na configuração do Nginx!"; cat /etc/nginx/sites-available/default; exit 1; }

# Gerar APP_KEY se não existir
if [ -z "$APP_KEY" ]; then
    echo "🔑 Gerando APP_KEY..."
    php artisan key:generate --force
fi

# Executar migrations automaticamente (SEM seeders para evitar timeout)
echo "📊 Executando migrations..."
php artisan migrate --force || echo "⚠️  Erro ao executar migrations, mas continuando..."

# Criar usuário desenvolvedor padrão se não existir
echo "👤 Criando usuário desenvolvedor padrão..."
php artisan tinker --execute="
if (!\App\Domains\Usuarios\Models\User::where('email', 'dev@codevilla.com')->exists()) {
    \App\Domains\Usuarios\Models\User::create([
        'name' => 'Desenvolvedor',
        'email' => 'dev@codevilla.com',
        'password' => bcrypt('Dev@2026'),
        'role' => 'desenvolvedor'
    ]);
    echo 'Usuário desenvolvedor criado: dev@codevilla.com / Dev@2026\n';
} else {
    echo 'Usuário desenvolvedor já existe\n';
}
" || echo "⚠️  Erro ao criar usuário, mas continuando..."

# Criar storage link em /tmp/storage
if [ ! -d "/tmp/storage/app/public" ]; then
    mkdir -p /tmp/storage/app/public
fi

echo "⚡ Otimizando aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Aplicação pronta!"
echo "🌐 Escutando na porta $PORT"

# Iniciar Supervisor (que gerenciará Nginx e PHP-FPM)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ajustar permissões
echo "🔒 Ajustando permissões..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "✅ Aplicação pronta!"

# Executar comando passado para o container
exec "$@"
