
This document is now ready to be saved in your `/docs` directory and provides a comprehensive, step-by-step guide for implementing the environment and configuration setup while preserving the existing project structure and maintaining backward compatibility.

``` markdown
# Phase 1.1: Environment & Configuration Setup - Detailed Implementation Guide

**Created:** July 14, 2025
**Status:** Ready for Implementation
**Priority:** Critical
**Estimated Time:** 4-6 hours
**Prerequisites:** Composer installed, Git repository initialized

## Overview
This document provides step-by-step instructions for implementing environment and configuration management in the PHP MVC boilerplate project. The approach builds upon the existing `config.php` structure while adding modern environment variable support and enhanced security.

## Current State Analysis
- **Existing:** Basic `config.php` with hardcoded database settings
- **Missing:** Environment variables, security configurations, session management
- **Risk:** Database credentials exposed in version control

## Implementation Steps

### Step 1: Install and Configure Environment Package

#### 1.1 Add vlucas/phpdotenv dependency
```
bash composer require vlucas/phpdotenv
```

#### 1.2 Create .env file in project root
**File:** `.env`
```
bash
# Application Configuration
APP_NAME="PHP MVC Boilerplate" APP_ENV=development APP_DEBUG=true APP_URL=[http://localhost](http://localhost)
# Database Configuration
DB_HOST=localhost DB_PORT=3306 DB_DATABASE=myapp DB_USERNAME=your_username DB_PASSWORD=your_password DB_CHARSET=utf8mb4
# Session Configuration
SESSION_LIFETIME=120 SESSION_DRIVER=file
# Security
APP_KEY=your-32-character-secret-key-here HASH_ALGO=PASSWORD_DEFAULT
# Logging
LOG_LEVEL=debug LOG_CHANNEL=single
```

#### 1.3 Create .env.example file
**File:** `.env.example`
```
bash
# Application Configuration
APP_NAME="PHP MVC Boilerplate" APP_ENV=development APP_DEBUG=true APP_URL=[http://localhost](http://localhost)
# Database Configuration
DB_HOST=localhost DB_PORT=3306 DB_DATABASE=database_name DB_USERNAME=username DB_PASSWORD=password DB_CHARSET=utf8mb4
# Session Configuration
SESSION_LIFETIME=120 SESSION_DRIVER=file
# Security
APP_KEY=generate-a-32-character-secret-key HASH_ALGO=PASSWORD_DEFAULT
# Logging
LOG_LEVEL=debug LOG_CHANNEL=single
```

#### 1.4 Update .gitignore
**File:** `.gitignore`
```
gitignore
# Environment files
.env .env.local .env.*.local
# Existing content should remain...
vendor/ composer.phar *.log .DS_Store Thumbs.db
```

### Step 2: Enhance Existing Configuration

#### 2.1 Update config.php to support environment variables
**File:** `config.php`
```
php
load(); } return [ 'app' => [ 'name' => $_ENV['APP_NAME'] ?? 'PHP MVC Boilerplate', 'env' => $_ENV['APP_ENV'] ?? 'production', 'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN), 'url' => $_ENV['APP_URL'] ?? 'http://localhost', 'key' => $_ENV['APP_KEY'] ?? 'your-32-character-secret-key-here', ], 'database' => [ 'host' => $_ENV['DB_HOST'] ?? 'localhost', 'port' => (int) ($_ENV['DB_PORT'] ?? 3306), 'dbname' => $_ENV['DB_DATABASE'] ?? 'myapp', 'username' => $_ENV['DB_USERNAME'] ?? '', 'password' => $_ENV['DB_PASSWORD'] ?? '', 'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4', 'options' => [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false, ], ], 'session' => [ 'lifetime' => (int) ($_ENV['SESSION_LIFETIME'] ?? 120), 'secure' => ($_ENV['APP_ENV'] ?? 'production') === 'production', 'httponly' => true, 'samesite' => 'Strict', ], ];
```

#### 2.2 Update bootstrap.php to use enhanced configuration
**File:** `bootstrap.php`
```
php
bind('Core\\Database', function () use ($config) { return new Database($config['database']); }); App::setContainer($container);
```

### Step 3: Create Storage Directory Structure

#### 3.1 Create storage directories
```
bash mkdir -p storage/logs mkdir -p storage/cache mkdir -p storage/sessions
```

#### 3.2 Create storage .gitignore
**File:** `storage/.gitignore`
```
gitignore
-

!.gitignore !logs/.gitignore !cache/.gitignore !sessions/.gitignore
```

**File:** `storage/logs/.gitignore`
```
gitignore
-

!.gitignore
```

**File:** `storage/cache/.gitignore`
```
gitignore
-

!.gitignore
```

**File:** `storage/sessions/.gitignore`
```
gitignore
-

!.gitignore
```

### Step 4: Create Environment-Specific Configuration (Optional)

#### 4.1 Create config directory structure
```
bash mkdir -p config/environments
```

#### 4.2 Create development environment config
**File:** `config/environments/development.php`
```
php
[ 'debug' => true, ], 'database' => [ 'options' => [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false, ], ], 'session' => [ 'secure' => false, 'lifetime' => 1440, // 24 hours for development ], ];
```

#### 4.3 Create production environment config
**File:** `config/environments/production.php`
```
php
[ 'debug' => false, ], 'database' => [ 'options' => [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false, ], ], 'session' => [ 'secure' => true, 'lifetime' => 120, // 2 hours for production ], ];
```

### Step 5: Testing and Validation

#### 5.1 Create configuration test script
**File:** `tests/config-test.php`
```
php
```

#### 5.2 Run the test
```bash
php tests/config-test.php
```
```
### Step 6: Security Hardening
#### 6.1 Generate secure APP_KEY
``` bash
# Generate a secure 32-character key
php -r "echo bin2hex(random_bytes(16)) . PHP_EOL;"
```
#### 6.2 Set proper file permissions
``` bash
chmod 600 .env
chmod 755 storage/
chmod 755 storage/logs/
chmod 755 storage/cache/
chmod 755 storage/sessions/
```
## Implementation Checklist
### Pre-Implementation
- [ ] Backup current project
- [ ] Create feature branch: `git checkout -b feature/environment-config`
- [ ] Verify Composer is installed and working

### Core Implementation
- [ ] Install vlucas/phpdotenv package
- [ ] Create .env file with all required variables
- [ ] Create .env.example file
- [ ] Update .gitignore to exclude .env files
- [ ] Update config.php to support environment variables
- [ ] Update bootstrap.php with enhanced configuration
- [ ] Add to all modified files `declare(strict_types=1)`

### Directory Structure
- [ ] Create storage directory structure
- [ ] Create appropriate .gitignore files
- [ ] Set proper file permissions
- [ ] Create config/environments directory (optional)

### Testing
- [ ] Create and run configuration test script
- [ ] Verify environment variables are loaded correctly
- [ ] Test with different APP_ENV values
- [ ] Verify session configuration is applied
- [ ] Test database connection with new configuration

### Security
- [ ] Generate secure APP_KEY
- [ ] Verify .env file is not committed to version control
- [ ] Test error reporting based on environment
- [ ] Verify session security settings

## Common Issues and Solutions
### Issue 1: .env file not loading
**Solution:** Verify file exists and has correct permissions
``` bash
ls -la .env
chmod 644 .env
```
### Issue 2: Database connection fails
**Solution:** Check database credentials in .env file
``` bash
# Test database connection
php -r "
$config = require 'config.php';
$pdo = new PDO(
    'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'],
    $config['database']['username'],
    $config['database']['password']
);
echo 'Database connection successful!' . PHP_EOL;
"
```
### Issue 3: Session not working
**Solution:** Verify session directory exists and is writable
``` bash
mkdir -p storage/sessions
chmod 755 storage/sessions
```
## Next Steps
After completing this phase:
1. Move to Phase 1.2: Namespace Implementation
2. Update any existing code that directly accesses old config format
3. Create environment-specific deployment scripts
4. Document configuration options for team members

## Rollback Plan
If issues occur:
1. Revert to previous git commit
2. Remove vlucas/phpdotenv from composer.json
3. Restore original config.php and bootstrap.php
4. Remove .env and storage directories
