service cron start
composer install
# composer dump-autoload --optimize
rm -rf public/storage
php artisan storage:link
php artisan route:cache
php artisan cache:clear
php artisan config:clear
php artisan optimize
php artisan passport:install
#php artisan migrate --force
service supervisor start 
# chmod -R 777 /var/www/html/storage
php artisan octane:start --host=0.0.0.0 --port=8000
# php artisan serve --host=0.0.0.0 --port=8000