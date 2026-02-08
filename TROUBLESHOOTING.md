# Troubleshooting Guide - VPS Deployment

## Problem 1: TinyMCE Tidak Muncul di Django Admin

### Diagnosis:
```bash
# Check if TinyMCE static files exist
docker-compose -f docker-compose.prod.yml exec web ls -la /app/staticfiles/tinymce

# Check if collectstatic ran successfully
docker-compose -f docker-compose.prod.yml logs web | grep collectstatic
```

### Solution:
```bash
# Force collect static files
docker-compose -f docker-compose.prod.yml exec web python manage.py collectstatic --noinput --clear

# Restart container
docker-compose -f docker-compose.prod.yml restart web
```

### Root Cause:
- Static files tidak ter-collect saat build
- STATICFILES_DIRS tidak include TinyMCE package files

---

## Problem 2: Gambar Blog Post Tidak Muncul

### Diagnosis:
```bash
# Check media directory
docker-compose -f docker-compose.prod.yml exec web ls -la /app/media/blog_images

# Check volume mount
docker volume inspect portofolio_media_volume

# Check permissions
docker-compose -f docker-compose.prod.yml exec web stat /app/media
```

### Solution:
```bash
# Set correct permissions
docker-compose -f docker-compose.prod.yml exec web chmod -R 777 /app/media

# Check if MEDIA_URL is accessible
curl http://localhost:8180/media/blog_images/your-image.jpg
```

### Root Cause:
- Media files hanya di-serve saat DEBUG=True
- WhiteNoise tidak serve media files by default
- Permission issues di media directory

---

## Quick Fix Commands

### Rebuild Everything:
```bash
docker-compose -f docker-compose.prod.yml down
docker-compose -f docker-compose.prod.yml build --no-cache
docker-compose -f docker-compose.prod.yml up -d
docker-compose -f docker-compose.prod.yml exec web python manage.py migrate
docker-compose -f docker-compose.prod.yml exec web python manage.py collectstatic --noinput --clear
docker-compose -f docker-compose.prod.yml exec web chmod -R 777 /app/media
```

### Check Logs:
```bash
# All logs
docker-compose -f docker-compose.prod.yml logs -f

# Web service only
docker-compose -f docker-compose.prod.yml logs -f web

# Last 100 lines
docker-compose -f docker-compose.prod.yml logs --tail=100 web
```

### Access Container Shell:
```bash
docker-compose -f docker-compose.prod.yml exec web bash
```

### Test Media Serving:
```bash
# From inside container
docker-compose -f docker-compose.prod.yml exec web python manage.py shell
>>> from django.conf import settings
>>> print(settings.MEDIA_URL)
>>> print(settings.MEDIA_ROOT)
>>> import os
>>> print(os.listdir(settings.MEDIA_ROOT))
```

---

## Verification Checklist

After deployment, verify:

- [ ] TinyMCE editor loads in Django admin (`/admin/blog/post/add/`)
- [ ] Can upload images in blog post form
- [ ] Uploaded images display correctly on website
- [ ] Static files (CSS/JS) load properly
- [ ] No 404 errors for `/media/` URLs
- [ ] No permission denied errors in logs

---

## Common Errors

### 1. "DisallowedHost at /"
**Fix:** Add your domain/IP to `ALLOWED_HOSTS` in `.env.prod`:
```
ALLOWED_HOSTS=your-domain.com,your-vps-ip,localhost
```

### 2. "OperationalError: could not connect to server"
**Fix:** Database not ready. Wait 10-15 seconds and try again.

### 3. "404 Not Found: /media/blog_images/..."
**Fix:** Check file permissions and ensure URL routing is correct:
```bash
docker-compose -f docker-compose.prod.yml exec web chmod -R 777 /app/media
```

### 4. "The included URLconf is empty"
**Fix:** Check if TinyMCE URLs are properly included in `urls.py`.

---

## Performance Optimization

After fixing issues, optimize:

```bash
# Enable gzip compression (already done with WhiteNoise)
# Set cache headers
# Optimize images before upload
# Use CDN for static files (optional)
```

---

## Monitoring

```bash
# Container stats
docker stats

# Disk usage
docker system df

# Remove unused data
docker system prune -af --volumes
```
