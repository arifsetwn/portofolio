from django.shortcuts import render, get_object_or_404
from django.core.paginator import Paginator, EmptyPage, PageNotAnInteger
from django.views.decorators.cache import cache_page
from research.models import Publication
from blog.models import Post
from biography.models import Profile

def index(request):
    publications = Publication.objects.all()
    posts = Post.objects.all()
    
    # Get the first profile or None if not exists
    profile = Profile.objects.first()

    context = {
        'publications': publications,
        'posts': posts,
        'profile': profile,
    }
    return render(request, 'index.html', context)

def publications_list(request):
    publications = Publication.objects.all()
    profile = Profile.objects.first()
    
    context = {
        'publications': publications,
        'profile': profile,
    }
    return render(request, 'publications.html', context)

@cache_page(60 * 15)  # Cache selama 15 menit
def blog_list(request):
    posts_list = Post.objects.all().only('slug', 'category', 'title', 'summary', 'date_published')
    profile = Profile.objects.first()
    
    # Pagination - 9 posts per halaman
    paginator = Paginator(posts_list, 9)
    page = request.GET.get('page', 1)
    
    try:
        posts = paginator.page(page)
    except PageNotAnInteger:
        posts = paginator.page(1)
    except EmptyPage:
        posts = paginator.page(paginator.num_pages)
    
    context = {
        'posts': posts,
        'profile': profile,
    }
    return render(request, 'blog.html', context)

from django.http import HttpResponse

def blog_detail(request, slug):
    post = get_object_or_404(Post, slug=slug)
    profile = Profile.objects.first()
    
    context = {
        'post': post,
        'profile': profile,
    }
    return render(request, 'blog_detail.html', context)

def robots_txt(request):
    lines = [
        "User-Agent: *",
        "Disallow: /admin/",
        "Sitemap: /sitemap.xml",
    ]
    return HttpResponse("\n".join(lines), content_type="text/plain")
