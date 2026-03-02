# AGENTS.md - Development Guidelines for blog-mvc

## Project Overview

Plain PHP MVC blog application (no framework, no composer). Located at `/Users/arthur/Developer/blog-mvc`.

## Project Structure

```
blog-mvc/
├── app/
│   ├── controllers/   # Request handlers (PHP files)
│   ├── models/       # Database models (*.inc.php)
│   └── views/        # View templates (*.view.php)
├── assets/           # Static assets (CSS, JS, images)
├── db/               # Database files
├── logs/             # Application logs
└── index.php         # Entry point
```

## Build / Run / Test Commands

### Running with Docker

```bash
# Build and start containers
docker-compose up --build

# Run in background
docker-compose up -d --build

# Stop containers
docker-compose down
```

### Running without Docker

```bash
php -S localhost:8000
```

### Environment Variables (Docker)

- `DB_HOST` - Database host (default: 127.0.0.1)
- `DB_USER` - Database user (default: admin)
- `DB_PASSWORD` - Database password (default: root)
- `DB_NAME` - Database name (default: blog)

### Testing

**No test framework configured.** To add testing:

```bash
composer require --dev phpunit/phpunit
./vendor/bin/phpunit
./vendor/bin/phpunit tests/SomeTest.php
./vendor/bin/phpunit --filter testMethodName
```

### Linting / Code Quality

```bash
# Syntax check all PHP files
find . -name "*.php" -exec php -l {} \;

# Install PHP_CodeSniffer
composer require --dev squizlabs/php_codesniffer

# Check coding standards
./vendor/bin/phpcs --standard=PSR12 app/

# Auto-fix
./vendor/bin/phpcbf app/
```

## Code Style Guidelines

### General Conventions

- **Language**: French for user-facing messages
- **Encoding**: UTF-8
- **PHP Version**: PHP 7.4+
- **Indentation**: 4 spaces

### Naming Conventions

| Element | Convention | Example |
|---------|------------|---------|
| Classes | PascalCase | `Utilisateur`, `Logger` |
| Functions | camelCase | `getPdo()`, `isLoggedOn()` |
| Variables | camelCase | `$userModel`, `$error` |
| Database tables | UPPER_CASE | `USERS`, `COMMENTS` |
| Database columns | UPPER_CASE | `USER_ID`, `PSSWRD` |
| Files (models) | *.inc.php | `db.inc.php` |
| Files (views) | *.view.php | `login.view.php` |

### PHP Code Style

- Always use `<?php` tag (no short tags)
- Use `require_once` for includes
- Spaces around operators: `$a = $b`
- Spaces after commas: `func($a, $b, $c)`
- Spaces after control keywords: `if (...)`, `foreach (...)`

### Type Hints

- Use on class properties: `private PDO $pdo`
- Use return types: `function getUserCount(): int`
- Do NOT use on function parameters

### Error Handling

- Use try-catch for database operations
- Use `PDO::ERRMODE_EXCEPTION`
- On fatal errors: `die($e)`
- Return `null` for not-found cases

### Database Patterns

- Always use **prepared statements** with named parameters
- Use `PDO::FETCH_ASSOC`
- Bind integers: `$stmt->bindValue(":limit", $limit, PDO::PARAM_INT)`
- Hash passwords: `password_hash($password, CRYPT_SHA256)`

### Authentication

- Check auth: `isLoggedOn()`, admin: `isAdmin()`
- Start session: `if (session_status() === PHP_SESSION_NONE) { session_start(); }`
- Store: `userId`, `email`, `username`, `isAdmin`
- Log actions: `Logger::log("ACTION_NAME", ["key" => "value"])`

### Views

- Files end in `.view.php`
- Use short PHP tags: `<?php if ($error): ?>...<?php endif; ?>`
- French text for UI
- Use `htmlspecialchars()` for output

### Security

- Database credentials use `getenv()` in `db.inc.php`
- No CSRF protection on forms
- Use `htmlspecialchars()` for XSS prevention

### Session Management

- Check session status: `session_status() === PHP_SESSION_NONE`
- Destroy properly on logout

## Existing Patterns

1. **Model methods**: Return `null` if not found, use prepared statements
2. **Controller flow**: POST → validation → model → redirect or render view
3. **Error handling**: Set `$error` and re-render view
4. **Success**: Use `header("Location: ...")` and `exit;`

## Database Schema

- Users: `USERS` (USER_ID, USERNAME, EMAIL, PSSWRD, IS_ADMIN, IS_RESTRICTED)
- Posts: `POSTS`
- Comments: `COMMENTS`
