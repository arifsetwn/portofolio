"""
URL configuration for portfolio_project project.

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/5.1/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""

from django.contrib import admin
from django.urls import path, include
from . import views
from django.conf import settings
from django.conf.urls.static import static

from django.contrib.sitemaps.views import sitemap
from blog.sitemaps import BlogSitemap

sitemaps = {
    "blog": BlogSitemap,
}

urlpatterns = [
    path("admin/", admin.site.urls),
    path("tinymce/", include('tinymce.urls')),
    path("", views.index, name="index"),
    path("about/", views.about, name="about"),
    path("publications/", views.publications_list, name="publications"),
    path("blog/", views.blog_list, name="blog"),
    path("blog/<slug:slug>/", views.blog_detail, name="blog_detail"),
    path("sitemap.xml", sitemap, {"sitemaps": sitemaps}, name="django.contrib.sitemaps.views.sitemap"),
    path("robots.txt", views.robots_txt, name="robots_txt"),
]

# Serve media files (development and production)
urlpatterns += static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)
urlpatterns += static(settings.STATIC_URL, document_root=settings.STATIC_ROOT)
