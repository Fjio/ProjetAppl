# PGROU 2019-2020 & PAPPL 2020-2021 - Ecole Centrale de Nantes

Connection & management pages by PGROU\
Sign in & code upgrade by PAPPL : Fjio & IrNRV

## Used tools

- Symfony CLI v4.13.3
- Composer v1.10.1
- PostgreSQL v11.5

## Dependencies installation

To install dependencies, run the following from the project root :

```bash
composer install
```

## Database
The default login information for the database  is:
`pgrou`:`pgrou` with db `pgrou`

To seed your database with test data, run the following from the project root:

```bash
php bin/console doctrine:fixtures:load
```

The default login information for the admin user is:
`admin@admin.fr`:`admin`

The default login information for the eleve user is:
`eleve1@eleve.fr`:`eleve`

The default login information for the prof user is:
`prof1@prof.fr`:`prof`

To update doctrine database schema, run the following from the project root:

```bash
php bin/console doctrine:schema:update --force
```

## Server launch

To start the server, run the following from the project root (CLI needed) :

```bash
symfony server:start
```
