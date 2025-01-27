#!/bin/bash

# Stop running Docker containers
docker-compose down --remove-orphans

# Start Docker Compose
docker-compose up -d

# Wait for the app container to be ready
echo "Waiting for the app container to be ready..."
sleep 10

# Run database migrations
echo "Running database migrations..."
docker-compose exec app php artisan migrate --force

# Fetch news data
echo "Fetching news data..."
docker-compose exec app php artisan fetch:news

# Generate Swagger documentation
echo "Generating Swagger documentation..."
docker-compose exec app php artisan l5-swagger:generate

# Display status of all containers
docker-compose ps

# Open the browser to the API documentation
echo "Opening browser to API documentation..."
xdg-open http://localhost:8000/api/documentation#/ || open http://localhost:8000/api/documentation#/
