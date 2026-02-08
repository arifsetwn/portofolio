#!/bin/bash

# Deployment Script untuk VPS
# Pastikan sudah di directory /var/www/portfolio

set -e  # Exit on error

echo "🚀 Starting deployment..."

# Pull latest code
echo "📥 Pulling latest code from GitHub..."
git fetch origin main
git reset --hard origin/main

# Stop containers
echo "⏹️  Stopping containers..."
docker compose -f docker-compose.prod.yml down

# Remove old images (optional - uncomment if needed)
# echo "🗑️  Removing old images..."
# docker-compose -f docker-compose.prod.yml rm -f

# Build with no cache to ensure fresh build
echo "🔨 Building Docker images..."
docker compose -f docker-compose.prod.yml build --no-cache

# Start containers
echo "▶️  Starting containers..."
docker compose -f docker-compose.prod.yml up -d

# Wait for database to be ready
echo "⏳ Waiting for database..."
sleep 10

# Run migrations
echo "🗄️  Running database migrations..."
docker compose -f docker-compose.prod.yml exec -T web python manage.py migrate --noinput

# Collect static files (including TinyMCE)
echo "📦 Collecting static files..."
docker compose -f docker-compose.prod.yml exec -T web python manage.py collectstatic --noinput --clear

# Verify TinyMCE installation
echo "🔍 Verifying TinyMCE..."
docker compose -f docker-compose.prod.yml exec -T web python -c "import tinymce; print('TinyMCE version:', tinymce.__version__)" && echo "✅ TinyMCE installed!" || echo "❌ TinyMCE not found!"

# Check if TinyMCE static files exist
echo "🔍 Checking TinyMCE static files..."
docker compose -f docker-compose.prod.yml exec -T web ls -la /app/staticfiles/tinymce 2>/dev/null && echo "✅ TinyMCE static files found!" || echo "⚠️  Using CDN for TinyMCE"

# Create superuser if needed (commented out by default)
# echo "👤 Creating superuser..."
# docker-compose -f docker-compose.prod.yml exec -T web python manage.py createsuperuser --noinput

# Set correct permissions for media files
echo "🔐 Setting media directory permissions..."
docker compose -f docker-compose.prod.yml exec -T web chmod -R 777 /app/media

# Clean up unused Docker resources
echo "🧹 Cleaning up..."
docker system prune -f

# Show container status
echo ""
echo "📊 Container Status:"
docker compose -f docker-compose.prod.yml ps

# Show logs
echo ""
echo "📜 Recent logs:"
docker compose -f docker-compose.prod.yml logs --tail=50

echo ""
echo "✅ Deployment completed successfully!"
echo ""
echo "🌐 Your site should be available at: http://your-vps-ip:8180"
echo ""
echo "📝 Useful commands:"
echo "  - View logs: docker-compose -f docker-compose.prod.yml logs -f"
echo "  - Restart: docker-compose -f docker-compose.prod.yml restart"
echo "  - Stop: docker-compose -f docker-compose.prod.yml down"
echo ""
