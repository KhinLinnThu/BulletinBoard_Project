# BulletinBoard

## Requirements
- PHP 8.2.4
- MySQL 5.2.1

## Installation

Clone the repo locally:
```
https://github.com/KhinLinnThu/BulletinBoard_Project.git
```

`cd` into cloned directory and install dependencies. run below command one by one.
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
composer dump-autoload
composer require maatwebsite/excel
```

### Configuration in `.env` file

Database **eg.**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bulletinBoard
DB_USERNAME=root
DB_PASSWORD=
```
ResetMail **eg.**
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=yourmail@gmail.com
MAIL_PASSWORD=twofactorcode
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=yourmail@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Database Migration

Run database migrations:
```
php artisan migrate
```

Run database seeder:
```
php artisan db:seed
```

## Server Run

Run the dev server:
```
php artisan serve
```

Visit below url:
```
http://localhost:8000
```
