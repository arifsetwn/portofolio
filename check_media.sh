#!/bin/bash

echo "🔍 Checking Media Files Configuration..."
echo ""

# Check container status
echo "1. Container Status:"
docker compose -f docker-compose.prod.yml ps
echo ""

# Check media directory in container
echo "2. Media Directory Contents:"
docker compose -f docker-compose.prod.yml exec -T web ls -lah /app/media/
echo ""

# Check blog_images directory
echo "3. Blog Images Directory:"
docker compose -f docker-compose.prod.yml exec -T web ls -lah /app/media/blog_images/ 2>/dev/null || echo "⚠️  blog_images directory not found"
echo ""

# Check media volume
echo "4. Docker Volume Info:"
docker volume inspect portofolio_media_volume 2>/dev/null || echo "⚠️  Volume not found"
echo ""

# Check permissions
echo "5. Media Directory Permissions:"
docker compose -f docker-compose.prod.yml exec -T web stat /app/media
echo ""

# Test Django settings
echo "6. Django Media Settings:"
docker compose -f docker-compose.prod.yml exec -T web python -c "
from django.conf import settings
print(f'MEDIA_URL: {settings.MEDIA_URL}')
print(f'MEDIA_ROOT: {settings.MEDIA_ROOT}')
print(f'DEBUG: {settings.DEBUG}')
import os
if os.path.exists(settings.MEDIA_ROOT):
    print(f'Media root exists: ✅')
    files = os.listdir(settings.MEDIA_ROOT)
    print(f'Files in media root: {files}')
else:
    print(f'Media root does not exist: ❌')
"
echo ""

# Check if web container can write to media
echo "7. Testing Write Permission:"
docker compose -f docker-compose.prod.yml exec -T web touch /app/media/test_write.txt && echo "✅ Write permission OK" || echo "❌ Write permission FAILED"
docker compose -f docker-compose.prod.yml exec -T web rm -f /app/media/test_write.txt
echo ""

# Check URL routing
echo "8. Testing Media URL (from inside container):"
docker compose -f docker-compose.prod.yml exec -T web curl -I http://localhost:8000/media/ 2>/dev/null | head -n 1
echo ""

echo "✅ Check completed!"
echo ""
echo "💡 If images still not showing:"
echo "   1. Make sure files exist in /app/media/blog_images/"
echo "   2. Check permissions (should be 777)"
echo "   3. Restart containers: docker compose -f docker-compose.prod.yml restart"
echo "   4. Check Cloudflare cache (purge if needed)"
