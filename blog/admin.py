from django.contrib import admin
from .models import Post

@admin.register(Post)
class PostAdmin(admin.ModelAdmin):
    list_display = ('title', 'category', 'date_published')
    list_filter = ('category',)
    prepopulated_fields = {'slug': ('title',)}
