# Docker Setup for Examinee Application

## Quick Start

### 1. Build and start the containers
```bash
docker compose up -d
```

### 2. Install dependencies and build assets
```bash
# Install PHP dependencies (if not already done)
docker compose exec app composer install

# Install Node dependencies and build assets
docker compose run --rm node sh -c "npm install && npm run build"

# Or use the build profile
docker compose --profile build up node
```

### 3. Setup the application
```bash
# Copy environment file
cp .env.example .env

# Generate application key
docker compose exec app php artisan key:generate

# Run migrations
docker compose exec app php artisan migrate

# Run seeders (optional)
docker compose exec app php artisan db:seed

# Create storage link
docker compose exec app php artisan storage:link

# Clear and cache config
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
```

### 4. Access the application
- **Application**: http://localhost:8000
- **Database**: localhost:3307
  - Database: examinee_db
  - User: examinee_user
  - Password: examinee_password
  - Root Password: root_password
- **Redis**: localhost:6380

## Services

- **app**: PHP 8.2-FPM application container
- **nginx**: Nginx web server (port 8000)
- **db**: MySQL 8.0 database (port 3307)
- **redis**: Redis cache and queue backend (port 6380)
- **queue**: Laravel queue worker
- **node**: Node.js for asset compilation (run on-demand)

## Common Commands

### Container Management
```bash
# Start containers
docker compose up -d

# Stop containers
docker compose down

# View logs
docker compose logs -f

# View specific service logs
docker compose logs -f app
docker compose logs -f nginx
docker compose logs -f queue

# Restart a service
docker compose restart app
```

### Laravel Commands
```bash
# Run artisan commands
docker compose exec app php artisan [command]

# Access Laravel tinker
docker compose exec app php artisan tinker

# Clear caches
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear

# Run migrations
docker compose exec app php artisan migrate
docker compose exec app php artisan migrate:fresh --seed
```

### Asset Building
```bash
# Development build
docker compose run --rm node npm run dev

# Production build
docker compose run --rm node npm run build

# Watch mode (for development)
docker compose run --rm node npm run watch
```

### Database Access
```bash
# Access MySQL CLI
docker compose exec db mysql -u examinee_user -pexaminee_password examinee_db

# Import database
docker compose exec -T db mysql -u examinee_user -pexaminee_password examinee_db < backup.sql

# Export database
docker compose exec db mysqldump -u examinee_user -pexaminee_password examinee_db > backup.sql
```

### Queue Management
```bash
# View queue logs
docker compose logs -f queue

# Restart queue worker
docker compose restart queue

# Run queue manually (for testing)
docker compose exec app php artisan queue:work
```

### Shell Access
```bash
# Access app container shell
docker compose exec app bash

# Access as root
docker compose exec -u root app bash
```

## Environment Variables

Update your `.env` file with these Docker settings:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=examinee_db
DB_USERNAME=examinee_user
DB_PASSWORD=examinee_password

REDIS_HOST=redis
REDIS_PORT=6379

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## Troubleshooting

### Permission Issues
```bash
# Fix storage permissions
docker compose exec -u root app chown -R www-data:www-data /var/www/html/storage
docker compose exec -u root app chmod -R 755 /var/www/html/storage
```

### Reset Everything
```bash
# Stop and remove containers, volumes
docker compose down -v

# Rebuild from scratch
docker compose build --no-cache
docker compose up -d
```

### Database Connection Issues
- Ensure the `db` service is running: `docker compose ps`
- Check database logs: `docker compose logs db`
- Verify credentials in `.env` match `docker-compose.yml`

## Production Considerations

1. **Change default passwords** in `docker-compose.yml`
2. **Use environment-specific files**: Create `docker-compose.prod.yml`
3. **Enable HTTPS**: Add SSL certificates and update nginx config
4. **Set proper APP_ENV**: Change to `production` in `.env`
5. **Disable debug mode**: Set `APP_DEBUG=false`
6. **Use proper storage**: Mount volumes for persistent data
7. **Implement backups**: Regular database and file backups
8. **Monitoring**: Add logging and monitoring solutions

## Development vs Production

For development with hot reload:
```bash
# Run Vite dev server on host machine
npm install
npm run dev

# Access via http://localhost:5173
```

Update `.env`:
```env
VITE_DEV_SERVER_URL=http://localhost:5173
```
