# PGROU - Cinésup

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

La base utilisée est une base PostgreSQL. Le fichier SQL contenant le schéma de la base est présent dans l'archive qui a été rendue aux encadrants du projet.

- nom de la base : `pgrou`
- nom de l'utilisateur : `pgrou`
- mot de passe : `pgrou`

La base doit être possédée par l'utilisateur `pgrou`.

## Lancement du serveur

Pour lancer le serveur, exécuter à la racine du projet :

```bash
symfony server:start
```
