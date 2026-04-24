.PHONY: help build up down restart logs shell composer artisan migrate fresh test clean

# Colors for output
BLUE=\033[0;34m
GREEN=\033[0;32m
RED=\033[0;31m
NC=\033[0m # No Color

help: ## Show this help message
	@echo '${BLUE}Available commands:${NC}'
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  ${GREEN}%-15s${NC} %s\n", $$1, $$2}'

build: ## Build Docker containers
	@echo "${BLUE}Building Docker containers...${NC}"
	docker compose build

up: ## Start all containers
	@echo "${BLUE}Starting containers...${NC}"
	docker compose up -d
	@echo "${GREEN}Containers started! Access the app at http://localhost:8000${NC}"

down: ## Stop all containers
	@echo "${BLUE}Stopping containers...${NC}"
	docker compose down

restart: ## Restart all containers
	@echo "${BLUE}Restarting containers...${NC}"
	docker compose restart

logs: ## Show logs from all containers
	docker compose logs -f

logs-app: ## Show logs from app container
	docker compose logs -f app

logs-queue: ## Show logs from queue container
	docker compose logs -f queue

logs-nginx: ## Show logs from nginx container
	docker compose logs -f nginx

shell: ## Access app container shell
	docker compose exec app bash

shell-root: ## Access app container shell as root
	docker compose exec -u root app bash

composer: ## Install PHP dependencies
	@echo "${BLUE}Installing PHP dependencies...${NC}"
	docker compose exec app composer install

npm: ## Install Node dependencies and build assets
	@echo "${BLUE}Installing Node dependencies and building assets...${NC}"
	docker compose run --rm node sh -c "npm install && npm run build"

npm-dev: ## Run Vite in development mode
	@echo "${BLUE}Running Vite dev server...${NC}"
	docker compose run --rm -p 5173:5173 node npm run dev

artisan: ## Run artisan command (usage: make artisan cmd="migrate")
	docker compose exec app php artisan $(cmd)

migrate: ## Run database migrations
	@echo "${BLUE}Running migrations...${NC}"
	docker compose exec app php artisan migrate

migrate-fresh: ## Fresh migration with seeding
	@echo "${BLUE}Running fresh migrations with seeding...${NC}"
	docker compose exec app php artisan migrate:fresh --seed

seed: ## Run database seeders
	@echo "${BLUE}Running seeders...${NC}"
	docker compose exec app php artisan db:seed

test: ## Run tests
	@echo "${BLUE}Running tests...${NC}"
	docker compose exec app php artisan test

tinker: ## Run Laravel tinker
	docker compose exec app php artisan tinker

cache-clear: ## Clear all caches
	@echo "${BLUE}Clearing caches...${NC}"
	docker compose exec app php artisan cache:clear
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan route:clear
	docker compose exec app php artisan view:clear

cache: ## Cache config, routes, and views
	@echo "${BLUE}Caching configuration...${NC}"
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache

optimize: ## Optimize the application
	@echo "${BLUE}Optimizing application...${NC}"
	docker compose exec app php artisan optimize

queue-restart: ## Restart queue worker
	@echo "${BLUE}Restarting queue worker...${NC}"
	docker compose restart queue

db: ## Access MySQL CLI
	docker compose exec db mysql -u examinee_user -pexaminee_password examinee_db

setup: ## Initial setup (for first time)
	@echo "${BLUE}Setting up the application...${NC}"
	@if [ ! -f .env ]; then \
		cp .env.docker .env; \
		echo "${GREEN}.env file created from .env.docker${NC}"; \
	fi
	@echo "${BLUE}Building containers...${NC}"
	docker compose build
	@echo "${BLUE}Starting containers...${NC}"
	docker compose up -d
	@echo "${BLUE}Installing dependencies...${NC}"
	docker compose exec app composer install
	@echo "${BLUE}Generating application key...${NC}"
	docker compose exec app php artisan key:generate
	@echo "${BLUE}Running migrations...${NC}"
	docker compose exec app php artisan migrate
	@echo "${BLUE}Creating storage link...${NC}"
	docker compose exec app php artisan storage:link
	@echo "${BLUE}Installing Node dependencies and building assets...${NC}"
	docker compose run --rm node sh -c "npm install && npm run build"
	@echo "${GREEN}Setup complete! Access the app at http://localhost:8000${NC}"

clean: ## Remove all containers, volumes, and images
	@echo "${RED}Removing all containers, volumes, and images...${NC}"
	docker compose down -v
	docker system prune -f

fix-permissions: ## Fix storage permissions
	@echo "${BLUE}Fixing permissions...${NC}"
	docker compose exec -u root app chown -R www-data:www-data /var/www/html/storage
	docker compose exec -u root app chown -R www-data:www-data /var/www/html/bootstrap/cache
	docker compose exec -u root app chmod -R 755 /var/www/html/storage
	docker compose exec -u root app chmod -R 755 /var/www/html/bootstrap/cache

status: ## Show status of all containers
	docker compose ps
