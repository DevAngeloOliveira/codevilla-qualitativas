#!/bin/bash

# Script de inicialização para Google Cloud Run

set -e

echo "🚀 Iniciando aplicação Codevilla no Cloud Run..."

# Definir porta padrão se não estiver definida
export PORT=${PORT:-8080}
echo "📡 Usando porta: $PORT"

# Substituir a porta no template do Nginx
mkdir -p /etc/nginx/sites-available /etc/nginx/sites-enabled
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/sites-available/default
ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default
rm -f /etc/nginx/sites-enabled/default.dpkg-dist

# Verificar se o nginx está configurado corretamente
nginx -t || { echo "Erro na configuração do Nginx!"; cat /etc/nginx/sites-available/default; exit 1; }

# Configurar diretórios writable no Cloud Run (filesystem é read-only exceto /tmp)
echo "📁 Configurando diretórios de escrita..."
mkdir -p /tmp/storage/{app,framework/{cache,sessions,views},logs}
mkdir -p /tmp/cache
mkdir -p /tmp/database

# Criar links simbólicos para diretórios writable
rm -rf /var/www/html/storage
ln -sf /tmp/storage /var/www/html/storage

rm -rf /var/www/html/bootstrap/cache
ln -sf /tmp/cache /var/www/html/bootstrap/cache

# Criar arquivo SQLite em /tmp se estiver usando SQLite
if [ "$DB_CONNECTION" = "sqlite" ]; then
    export DB_DATABASE="/tmp/database/database.sqlite"
    if [ ! -f "$DB_DATABASE" ]; then
        echo "📝 Criando arquivo SQLite em /tmp..."
        touch "$DB_DATABASE"
        chmod 666 "$DB_DATABASE"
        chmod 777 /tmp/database
    fi
fi

# Gerar APP_KEY se não existir
if [ -z "$APP_KEY" ]; then
    echo "🔑 Gerando APP_KEY..."
    php artisan key:generate --force
fi

# Executar migrations (descomente se necessário)
# echo "📊 Executando migrations..."
# php artisan migrate --force

# Criar storage link
if [ ! -L "/var/www/html/public/storage" ]; then
    echo "🔗 Criando storage link..."
    php artisan storage:link --force || true
fi

# Otimizar aplicação para produção
echo "⚡ Otimizando aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ajustar permissões
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

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
