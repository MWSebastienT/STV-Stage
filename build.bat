php composer.phar install
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load --append

echo "Build termine : admin / admin pour se connecter"
pause