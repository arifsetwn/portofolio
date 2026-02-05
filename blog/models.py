from django.db import models

class Post(models.Model):
    CATEGORY_CHOICES = [
        ('Education', 'Education'),
        ('Research', 'Research'),
        ('Opinion', 'Opinion'),
    ]
    
    title = models.CharField(max_length=255)
    slug = models.SlugField(max_length=255, unique=True, blank=True, null=True)
    category = models.CharField(max_length=50, choices=CATEGORY_CHOICES, default='Education')
    content = models.TextField()
    date_published = models.DateField(auto_now_add=True)
    summary = models.TextField(help_text="Short description for the card")

    def save(self, *args, **kwargs):
        if not self.slug:
            from django.utils.text import slugify
            self.slug = slugify(self.title)
        super().save(*args, **kwargs)

    def __str__(self):
        return self.title

    class Meta:
        ordering = ['-date_published']
