from django.db import models

class Publication(models.Model):
    title = models.CharField(max_length=255)
    doi = models.CharField(max_length=100, blank=True, null=True)
    journal = models.CharField(max_length=255)
    year = models.IntegerField()
    authors = models.CharField(max_length=500, help_text="e.g. A. Arif, J. Doe")
    link = models.URLField(blank=True, null=True)

    def __str__(self):
        return self.title

    class Meta:
        ordering = ['-year']
