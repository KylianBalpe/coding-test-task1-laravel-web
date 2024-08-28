<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p style="font-weight: bold; font-size: 16px;">Laravel version: 10</p>

### Installation

#### Clone the repository

```bash
git clone https://github.com/KylianBalpe/coding-test-task1-laravel-web.git <your-folder-name>
```

```bash
cd <your-folder-name>
```

#### Install dependencies

```bash
composer install
```

#### Create a copy of your .env file

```bash
cp .env.example .env
```

#### Generate an app encryption key

```bash
php artisan key:generate
```

#### Create an empty database for the application

```bash
php artisan migrate
```

#### Unit Test (optional)

```bash
php artisan test --filter=ProductTest
```

#### Seed the database

```bash
php artisan db:seed
```

#### Start the local development server

```bash
php artisan serve
```

Seeded needed at least add user to the database

### Authentication

##### Admin

```bash
email: admin@example.com
password: password
```

##### User

```bash
email: user@example.com
password: password
```
