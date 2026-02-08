from django.contrib import admin
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
    
    def formfield_for_dbfield(self, db_field, request, **kwargs):
        if db_field.name in ['content', 'summary']:
            return db_field.formfield(widget=TinyMCE(
                attrs={'cols': 80, 'rows': 30},
                mce_attrs={'height': 500}
            ))
        return super().formfield_for_dbfield(db_field, request, **kwargs)
    
    def has_image(self, obj):
        return bool(obj.image)
    has_image.boolean = True
    has_image.short_description = 'Image'
