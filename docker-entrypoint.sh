#!/bin/bash

# Script de inicialização para Google Cloud Run

set -e

echo "🚀 Iniciando aplicação Codevilla no Cloud Run..."

# Definir porta padrão se não estiver definida
export PORT=${PORT:-8080}
echo "📡 Usando porta: $PORT"

# Substituir a porta no template do Nginx
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/sites-available/default
ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default
rm -f /etc/nginx/sites-enabled/default.dpkg-dist

# Criar arquivo SQLite se estiver usando SQLite
if [ "$DB_CONNECTION" = "sqlite" ]; then
    if [ ! -f "/var/www/html/database/database.sqlite" ]; then
        echo "📝 Criando arquivo SQLite..."
        touch /var/www/html/database/database.sqlite
        chmod 664 /var/www/html/database/database.sqlite
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
