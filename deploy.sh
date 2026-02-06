#!/bin/bash

echo "🚀 Starting deployment..."

# Pull latest code
echo "📥 Pulling latest code from git..."
git pull origin main

# Stop existing containers
echo "🛑 Stopping existing containers..."
docker compose -f docker-compose.prod.yml down

# Build containers
echo "🔨 Building Docker images..."
docker compose -f docker-compose.prod.yml build --no-cache

# Start containers
echo "▶️  Starting containers..."
docker compose -f docker-compose.prod.yml up -d

# Wait for database to be ready
echo "⏳ Waiting for database to be ready..."
sleep 10

# Run migrations
echo "🔄 Running database migrations..."
docker compose -f docker-compose.prod.yml exec -T web python manage.py migrate

# Collect static files
echo "📦 Collecting static files..."
docker compose -f docker-compose.prod.yml exec -T web python manage.py collectstatic --noinput

# Show container status
echo "📊 Container status:"
docker compose -f docker-compose.prod.yml ps

echo "✅ Deployment completed successfully!"
echo "🌐 Your site should be available at your domain"
echo ""
echo "To view logs, run: docker-compose -f docker-compose.prod.yml logs -f"
