import os
import django

os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'portfolio_project.settings')
django.setup()

from research.models import Publication
from blog.models import Post
from biography.models import Profile

# Biography
if not Profile.objects.exists():
    Profile.objects.create(
        name="Pak Arif",
        role="Ph.D. in Information Systems",
        bio_short="Senior Lecturer & Researcher specialized in Human-Computer Interaction. My work explores the intersection of digital accessibility and pedagogical innovation in higher education.",
        image_url="https://lh3.googleusercontent.com/aida-public/AB6AXuBAITjiCstFHN-i1rFKoy3ril5LnjjRckoZWviPRx0l0Nkbil8UQzVk3PEFAYYZuSZwN8OhpR2e-kj-mV_jQ3-spGUf5dQs_4srshARJM7f5RkdC7FNIpRro_x2_JwQDPIRfvJKBpaA6Q92nqGgWT8chCgfbJ-udXzdopcXYKkoPvV-KLmFui5ig6294vB4nw-F1wwr25r_V11YyYsB6bfQnbwCO4SxtkFtFQH35p0KYTxzoPZL6oD3sBlec5tk73bTpowSWclZzp4"
    )

# Publications
pubs = [
    {
        "title": "The Future of AI in Higher Education: Transformative Pedagogy",
        "authors": "A. Arif, J. Doe, S. Smith",
        "year": 2023,
        "journal": "International Journal of Educational Technology",
        "doi": "10.1016/j.ijedtech.2023.01.004",
        "link": "#"
    },
    {
        "title": "Human-Computer Interaction in Remote Learning Environments",
        "authors": "A. Arif, M. Johnson",
        "year": 2022,
        "journal": "ACM Transactions on Computer-Human Interaction",
        "doi": "10.1145/3543501",
        "link": "#"
    },
    {
        "title": "Information Systems: A Modern Perspective on Data Governance",
        "authors": "K. Williams, A. Arif",
        "year": 2021,
        "journal": "Journal of Information Management",
        "doi": "10.1017/jim.2021.088",
        "link": "#"
    }
]

for p in pubs:
    Publication.objects.get_or_create(title=p["title"], defaults=p)

# Blog Posts
posts = [
    {
        "title": "Navigating the Semester with Hybrid Learning",
        "category": "Education",
        "summary": "Reflecting on the challenges and successes of our recent pilot program for hybrid classroom structures.",
        "date_published": "2023-10-24"
    },
    {
        "title": "Data Privacy in Qualitative Research",
        "category": "Research",
        "summary": "A guide for doctoral candidates on maintaining ethical standards in the age of big data analytics.",
        "date_published": "2023-09-12"
    },
    {
        "title": "Why HCI Matters Now More Than Ever",
        "category": "Opinion",
        "summary": "As interfaces become invisible, the ethics of interaction design become our most critical academic pursuit.",
        "date_published": "2023-08-05"
    }
]

for p in posts:
    Post.objects.get_or_create(title=p["title"], defaults=p)

print("Data populated successfully.")
