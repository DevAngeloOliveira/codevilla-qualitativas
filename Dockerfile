FROM php:8.3-fpm

# Argumentos de build
ARG USER_ID=1000
ARG GROUP_ID=1000

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário do sistema
RUN groupadd -g ${GROUP_ID} appuser && \
    useradd -u ${USER_ID} -g appuser -m -s /bin/bash appuser

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto
COPY --chown=appuser:appuser . /var/www/html

# Configurar permissões
RUN chown -R appuser:appuser /var/www/html && \
    chmod -R 755 /var/www/html/storage && \
    chmod -R 755 /var/www/html/bootstrap/cache

# Instalar dependências do Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Instalar dependências do Node.js e buildar assets
RUN npm install && npm run build && npm cache clean --force

# Copiar configuração do Nginx
COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# Copiar configuração do Supervisor
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Criar diretórios necessários
RUN mkdir -p /var/www/html/storage/app/public \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache

# Ajustar permissões finais
RUN chown -R appuser:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expor porta 80
EXPOSE 80

# Iniciar Supervisor (que gerenciará Nginx e PHP-FPM)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
