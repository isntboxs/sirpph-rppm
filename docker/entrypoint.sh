#!/bin/sh
set -e

prepare_directories() {
    mkdir -p \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache

    chown -R www-data:www-data storage bootstrap/cache
    chmod -R ug+rwX storage bootstrap/cache
}

wait_for_database() {
    if [ "${DB_CONNECTION:-}" != "mysql" ] && [ "${DB_CONNECTION:-}" != "mariadb" ]; then
        return 0
    fi

    echo "Waiting for database..."
    attempts=0

    until php -r '
        $host = getenv("DB_HOST") ?: "127.0.0.1";
        $port = getenv("DB_PORT") ?: "3306";
        $database = getenv("DB_DATABASE") ?: "";
        $username = getenv("DB_USERNAME") ?: "root";
        $password = getenv("DB_PASSWORD") ?: "";

        try {
            new PDO("mysql:host={$host};port={$port};dbname={$database}", $username, $password, [
                PDO::ATTR_TIMEOUT => 3,
            ]);
            exit(0);
        } catch (Throwable $e) {
            exit(1);
        }
    '; do
        attempts=$((attempts + 1))

        if [ "$attempts" -ge "${DB_WAIT_RETRIES:-30}" ]; then
            echo "Database is not reachable after ${DB_WAIT_RETRIES:-30} attempts." >&2
            exit 1
        fi

        sleep "${DB_WAIT_SLEEP:-2}"
    done
}

ensure_app_key() {
    if [ "${APP_ENV:-production}" = "production" ] && [ -z "${APP_KEY:-}" ]; then
        echo "APP_KEY is required in production. Generate one with: php artisan key:generate --show" >&2
        exit 1
    fi
}

run_laravel_startup_tasks() {
    if [ "${RUN_STORAGE_LINK:-true}" = "true" ]; then
        php artisan storage:link >/dev/null 2>&1 || true
    fi

    if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
        php artisan migrate --force
    fi

    if [ "${RUN_OPTIMIZE:-true}" = "true" ]; then
        php artisan optimize:clear
        php artisan config:cache
        php artisan view:cache
    fi

    if [ "${RUN_ROUTE_CACHE:-false}" = "true" ]; then
        php artisan route:cache
    fi
}

prepare_directories

if [ "${SKIP_STARTUP_TASKS:-false}" != "true" ]; then
    ensure_app_key
    wait_for_database
    run_laravel_startup_tasks
fi

if [ "$#" -gt 0 ]; then
    exec "$@"
fi

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
