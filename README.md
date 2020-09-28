# PGROU

## Outils utilisés

- Symfony CLI v4.13.3
- Composer v1.10.1
- PostgreSQL v11.5

## Installation des dépendances

A la racine du projet :

```bash
composer install
```

## Base de données
pgrou

To seed your database with test data, run the following:

```bash
php bin/console doctrine:fixtures:load
```

The default login information for the admin user are:
`admin@admin.fr`:`admin`

## Lancement du serveur

Pour lancer le serveur, exécuter à la racine du projet :

```bash
symfony server:start
```
