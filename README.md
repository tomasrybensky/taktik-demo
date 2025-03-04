## Local installation

- Clone repository
- Create .env file from .env.example
- Setup database conenction in .env file
- run `composer install`
- php `artisan key:generate`
- php `artisan migrate --seed`

## Usage
- Api docs are available at `/docs/api` route
- Test user can be created with `php artisan app:generate-test-user` command
