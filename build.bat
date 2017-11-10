php bin/console doctrine:schema:update --force
pause
rem php bin/console doctrine:fixtures:load --append
rem php bin/console doctrine:generate:entities tonBundle:Entite