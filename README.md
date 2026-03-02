# Blog MVC

Plain PHP MVC blog application without framework or composer.

## Prerequisites

- PHP 7.4+
- MySQL 8.0
- Docker (optional)

## Installation

### With Docker

```
docker-compose up --build
```

Access at http://localhost:8000

### Without Docker

1. Create MySQL database `blog`
2. Import schema from `db/` if available
3. Run:

```
php -S localhost:8000
```

## Configuration

Environment variables for database connection:

- `DB_HOST` - default: 127.0.0.1
- `DB_USER` - default: admin
- `DB_PASSWORD` - default: root
- `DB_NAME` - default: blog

## Project Structure

```
app/
├── controllers/   # Request handlers
├── models/       # Database models
└── views/        # Templates
assets/           # Static files
db/               # Database files
logs/             # Application logs
index.php         # Entry point
```

## Development

### Syntax check

```
find . -name "*.php" -exec php -l {} \;
```

### Add testing

```
composer require --dev phpunit/phpunit
./vendor/bin/phpunit
```
