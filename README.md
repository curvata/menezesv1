# menezesv1

Cette application web est un portfolio. 

Procédure d'installation du projet:

1. Récupérer le dépôt git ```git clone https://github.com/curvata/menezesv1.git```
2. Installation des dépendances php ```composer update```
3. Renseigner les informations suivantes: MY_MAIL, MAILER_DSN et DATABASE_URL dans le fichier .env
4. Installation des dépendances js ```npm install```
5. Compilation des assets ```npm run build```
6. Executer la migration ```php bin/console doctrine:migrations:migrate```
7. Mise en place des fixtures ```php bin/console doctrine:fixtures:load --group=AppFixtures```

Procédure pour lancer les tests

1. Renseigner le DATABASE_URL dans le fichier .env.test
2. Lancer les tests ```php bin/phpunit```
3. Lancer le code coverage ```XDEBUG_MODE=coverage bin/phpunit --coverage-html coverage```

CodeSniffer

1. ```php vendor/bin/phpcbf --standard=PSR2  --exclude=Generic.Files.LineLength src/```
1. ```php vendor/bin/phpccs --standard=PSR2  --exclude=Generic.Files.LineLength src/```