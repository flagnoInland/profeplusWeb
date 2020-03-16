#!/bin/bash

RED=$'\e[1;31m'
YELLOW=$'\e[1;33m'
NC=$'\e[0m'

echo -e "${RED}RESET MIGRATION${NC}"
php artisan migrate:reset
echo -e "${RED}MIGRATE${NC}"
php artisan migrate:fresh
echo -e "${YELLOW}PASSPORT${NC}"
php artisan passport:install
echo -e "${YELLOW}COMPOSER${NC}"
composer dump-autoload