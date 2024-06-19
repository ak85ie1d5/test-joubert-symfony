## Prérequis
- Un serveur web (apache, nginx, etc)
- PHP 8.*
- MySQL ou MariaDB
- crontab
- Composer

## Installation
- cloner le projet à la racine du serveur web
- changer la racine du serveur web pour pointer vers le dossier `/public`
- copier le fichier `.env.example` en `.env` et modifier les informations de connexion à la base de données
- lancer la commande composer install
- lancer la commande pour la création de la base de données `php bin/console doctrine:database:create`
- lancer la commande pour la création des tables `php bin/console doctrine:migrations:migrate`
- lancer la commande pour l'insertion les options par défaut `php bin/console doctrine:fixtures:load`, puis modifier la clé `api_key` dans la table `options` avec votre clé d'API sour la forme `["ma_clé_api"]`.
- créer les tâches cron suivante :
```shell
$ crontab -e

* * * * * php /path/to/your/project/bin/console app:fetch-datas
* * * * * php /path/to/your/project/bin/console app:history-fixing
```

## Utilisation
- Avant d'utiliser l'application, il faut renseigner la clé d'API dans la table `options` de la base de données.
- Pour accéder à la liste des métaux, il suffit de se rendre sur la page `/commodity/market`.

## Paramètres de l'API

- `GET /api/real-time-commodity/{code}` : retourne le cours actuel d'un métal. Le code étant l'identifiant du métal (XAU, XAG, XPT, XPD)
- `GET /api/history-fixing/{period}` : retourne l'historique du cours d'un métal sur une période donnée. `period` est la période de l'historique (daily, weekly, monthly, yearly)
