from django.contrib import admin
from django.db import models
from tinymce.widgets import TinyMCE
from .models import Post

@admin.register(Post)
class PostAdmin(admin.ModelAdmin):
    list_display = ('title', 'category', 'date_published', 'has_image')
    list_filter = ('category',)
    prepopulated_fields = {'slug': ('title',)}
    fieldsets = (
        (None, {
            'fields': ('title', 'slug', 'category')
        }),
        ('Content', {
            'fields': ('image', 'summary', 'content')
        }),
    )
    
    formfield_overrides = {
        models.TextField: {'widget': TinyMCE()},
    }
    
    def has_image(self, obj):
        return bool(obj.image)
    has_image.boolean = True
    has_image.short_description = 'Image'
