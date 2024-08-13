# Laravel GraphQL

## Installation

Run the commands below:

### Install Composer Packages
```bash
composer install
```

### Run the migrations and seeders

```bash
php artisan migrate:fresh --seed
```

### Run the Laravel GraphQL Server

```bash
php artisan serve
```

## For Improvement Notes

1. Implement better authentication. We could use `passport` for example for to adhere to oauth2 standard. I used sanctum for now since the project does not need the whole capability of passport or oauth2.
2. Implement better architecture. Currently, I only used Mutator/Controller, Service Pattern, Repository Pattern. There could be some better architecture which is more suitable for GraphQL as backend. It's the first time for me to develop using graphql via Laravel, so I'm sure there's a lot of things I have missed or needs to improve for this type of backend.
3. Implement better data validation. I'm used to using Laravel Request or Laravel Spatie Data for data validation, but it seems that it's different with GraphQL.
4. Write better tests.
5. Better scalability
6. I could have used Docker for this project, but since my pc currently has VBox and Vagrant installed, there will be conflict with the virtualization settings.
