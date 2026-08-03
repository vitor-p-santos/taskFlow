#!/bin/sh
set -e

echo "🚀 Iniciando o Entrypoint do Laravel..."

if [ ! -f ".env" ]; then
    echo "📄 Arquivo .env não encontrado. Copiando .env.example..."
    if [ -f ".env.example" ]; then
        cp .env.example .env
    else
        echo "⚠️ Alerta: .env.example não encontrado para copiar!"
    fi
fi

if [ ! -d "vendor" ]; then
    echo "📦 Pasta vendor não encontrada no volume local. Instalando dependências do Composer..."
    composer install --no-interaction --no-plugins --no-scripts
else
    echo "✅ Pasta vendor detectada."
fi

if [ -f ".env" ]; then
    if grep -q "^APP_KEY=.+" .env; then
        echo "🔑 APP_KEY já existe e tem um valor"
    else
        echo "🔑 Gerando chave da aplicação..."
        php artisan key:generate
    fi
fi

echo "🔒 Ajustando permissões das pastas storage e bootstrap/cache..."
mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "🏁 Tudo pronto! Passando o controle para o comando principal..."

exec "$@"