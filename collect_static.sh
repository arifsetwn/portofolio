#!/bin/bash

echo "🧹 Cleaning old static files..."
rm -rf staticfiles/*

echo "📦 Collecting static files..."
python manage.py collectstatic --noinput

echo "✅ Static files collected successfully!"

# Show TinyMCE files
if [ -d "staticfiles/tinymce" ]; then
    echo "✅ TinyMCE static files found!"
else
    echo "❌ TinyMCE static files NOT found!"
fi
