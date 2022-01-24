# SymfonyExerciseMediaMonks

## Installation

### Install dependencies

```php
    composer install
```

### Add an .env file

```bash
    cp env.example .env
```

### Fill out the Google's OAuth2 keys

In case you don't want to generate the keys, go to `security.yml` and comment out this line:

```php
    //config/packages/security.yml
    - { path: ^/admin, roles: ROLE_ADMIN }

```

### Set up your user as an admin

1. Go to **App\Fixtures\UserFixture** and set up your data instead of mine.
2. Run the migrations and run the fixtures:

```bash
    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:fixtures:load
```

### Build and start the container

```bash
docker-compose up -d
```

### Your app is running on localhost:8000

You can find the dashboard at **localhost:8000/admin/dashboard**
