php bin/console doctrine:database:drop --force
rm -r migrations
php bin/console doctrine:database:create
mkdir migrations
php bin/console make:migration
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load