@extends('layouts.app')

@section('title', 'Home - Blog Dashboard')

@section('styles')
<style>
/* Featured Article Card - Glassmorphism premium card */
.featured-card-wrapper { display:flex; justify-content:center; align-items:center; }
.featured-card { position: relative; width: 340px; max-width:100%; border-radius:24px; overflow:hidden; background: rgba(255,255,255,0.06); box-shadow: 0 10px 30px rgba(0,0,0,0.25); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.06); transition: transform .25s ease, box-shadow .25s ease; }
.featured-card:hover{ transform: translateY(-10px); box-shadow: 0 30px 60px rgba(0,0,0,0.35); }
.featured-card .featured-media{ width:100%; height:200px; object-fit:cover; display:block; }
.featured-card .card-body{ padding:18px; }
.featured-badge{ display:inline-block; background: rgba(255,255,255,0.06); color:#fff; padding:6px 10px; border-radius:999px; font-size:13px; font-weight:600; backdrop-filter: blur(6px); }
.featured-title{ font-size:1.25rem; font-weight:700; margin:12px 0; color:#fff; line-height:1.2; }
.featured-meta{ font-size:0.9rem; color:rgba(255,255,255,0.75); display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
.featured-desc{ color:rgba(255,255,255,0.85); margin-top:10px; font-size:0.95rem; }
.featured-cta{ display:inline-block; margin-top:14px; color:#8B0000; font-weight:700; text-decoration:none; }

/* Responsive: make card full width on small screens */
@media (max-width: 991px){
    .featured-card { width: 380px; margin: 0 auto; }
}
@media (max-width: 576px){
    .featured-card { width: 100%; border-radius:18px; }
    .featured-card .featured-media{ height:180px; }
}

/* Ticker (continuous) */
.ticker-track{ display:flex; gap:100px; align-items:center; white-space:nowrap; }
.ticker-item{ color:#fff; font-size:2rem; font-weight:800; }
@keyframes tickerScroll{ 0%{ transform: translateX(0%);} 100%{ transform: translateX(-50%);} }
.ticker-track.animate{ animation: tickerScroll 20s linear infinite; }

/* Footer newsletter */
.footer-newsletter .form-control{ max-width:420px; border-radius:6px 0 0 6px; }
.footer-newsletter .btn{ border-radius:0 6px 6px 0; }

</style>
@endsection

@section('content')
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: rgba(139, 0, 0, 0.95);">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/">
            <i class="fas fa-feather"></i> Blog Dashboard
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#blogs">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/login">Admin Panel</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden" style="background: linear-gradient(135deg, #8B0000 0%, #C41E3A 100%); min-height: 100vh; display: flex; align-items: center; background-size: cover; background-position: center; background-repeat: no-repeat; background-image: url('{{ asset('images/hero-bg.jpg') }}');">
    <div class="container-fluid position-relative z-2">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="display-2 fw-bold text-white mb-4 hero-title">
                        THE CREATIVE<br>COLLECTION
                    </h1>
                    <p class="fs-5 text-white-50 mb-5 hero-subtitle">
                        Discover inspiring stories, valuable insights, and creative ideas from our collection of expertly crafted content.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#blogs" class="btn btn-light btn-lg rounded-0 px-5 hero-btn">
                            Explore Articles
                        </a>
                        <a href="#" class="btn btn-outline-light btn-lg rounded-0 px-5 hero-btn">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 position-relative">
                @php $featured = $blogs->first(); @endphp
                <div class="featured-card-wrapper">
                    <!-- Featured card: premium hero-side article (glassmorphism) -->
                    <article class="featured-card" aria-labelledby="featured-title">
                        {{-- Featured media --}}
                        <img class="featured-media" src="{{ $featured && $featured->image ? asset('images/' . $featured->image) : asset('images/hero-card.jpg') }}" alt="{{ $featured->title ?? 'Featured' }}">

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="featured-badge">{{ $featured && $featured->category ? $featured->category->name : 'Featured' }}</span>
                            </div>

                            <h3 id="featured-title" class="featured-title">{{ $featured->title ?? 'A Featured Story From Our Collection' }}</h3>

                            <div class="featured-meta">
                                <span>By {{ $featured ? ($featured->author_name ?? 'Admin') : 'Admin' }}</span>
                                <span>&middot;</span>
                                <span>{{ $featured ? $featured->formatted_date : now()->format('M d, Y') }}</span>
                                <span>&middot;</span>
                                <span>{{ $featured ? $featured->reading_time . ' min read' : '3 min read' }}</span>
                            </div>

                            <p class="featured-desc">{{ $featured->short_description ?? 'Dive into this specially curated article that highlights creativity, strategy, and design—perfect for readers who want both inspiration and practical insights.' }}</p>

                            <a href="{{ $featured ? url('/blogs/'.$featured->id) : '#' }}" class="featured-cta">Read Article &rarr;</a>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
    <!-- Background elements -->
    <div class="hero-bg-element" style="position: absolute; width: 500px; height: 500px; background: rgba(255,255,255,0.05); border-radius: 50%; right: -200px; top: -200px;"></div>
    <div class="hero-bg-element" style="position: absolute; width: 300px; height: 300px; background: rgba(255,255,255,0.03); border-radius: 50%; left: -150px; bottom: -150px;"></div>
</section>

<!-- About Section -->
<section class="about-section py-5" style="background: #fff;">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <p class="text-muted text-uppercase fw-bold mb-3">Who We Are</p>
                <h2 class="display-5 fw-bold mb-4">
                    We're Not Your Average<br><span style="color: #8B0000;">Content Creator</span>
                </h2>
                <p class="fs-5 text-muted mb-4">
                    Our approach combines strategic thinking with creative excellence to deliver content that not only looks beautiful but also drives real results for your business.
                </p>
                <ul class="list-unstyled">
                    <li class="mb-3"><i class="fas fa-check text-danger me-3"></i> Strategic Content Planning</li>
                    <li class="mb-3"><i class="fas fa-check text-danger me-3"></i> Creative Excellence</li>
                    <li class="mb-3"><i class="fas fa-check text-danger me-3"></i> Data-Driven Insights</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="about-images position-relative">
                    <img src="{{ asset('images/about-card.jpg') }}" alt="About" class="img-fluid rounded-4" style="width:100%; height:400px; object-fit:cover;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="filter-section py-5" style="background: #f8f9fa;">
    <div class="container py-5">
        <h2 class="text-center mb-5 fw-bold">Browse Our Articles</h2>
        
        <div class="row mb-4">
            <div class="col-lg-3 mb-3">
                <input type="text" id="searchInput" class="form-control form-control-lg rounded-0" placeholder="Search articles..." style="border: 2px solid #8B0000;">
            </div>
            <div class="col-lg-3 mb-3">
                <select id="categoryFilter" class="form-select form-select-lg rounded-0" style="border: 2px solid #8B0000;">
                    <option value="">All Categories</option>
                    @forelse($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="col-lg-3 mb-3">
                <select id="dateFilter" class="form-select form-select-lg rounded-0" style="border: 2px solid #8B0000;">
                    <option value="">All Time</option>
                    <option value="7">Last 7 Days</option>
                    <option value="30">Last 30 Days</option>
                    <option value="90">Last 90 Days</option>
                </select>
            </div>
            <div class="col-lg-3 mb-3">
                <button id="resetFilters" class="btn btn-danger btn-lg rounded-0 w-100">Reset Filters</button>
            </div>
        </div>
    </div>
</section>

<!-- Featured Work Section -->
<section id="blogs" class="featured-section py-5">
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-lg-6">
                <p class="text-muted text-uppercase fw-bold mb-3">Featured Articles</p>
                <h2 class="display-5 fw-bold">Explore The Creative Suite</h2>
            </div>
        </div>

        <!-- Blog Container -->
        <div id="blogContainer" class="row g-4">
            @include('frontend.partials.blog-cards', ['blogs' => $blogs])
        </div>
    </div>
</section>

<!-- Ticker Section -->
<section class="ticker-section py-3" style="background: #8B0000; overflow: hidden;">
    <div class="container-fluid">
        <div class="ticker-track animate" aria-hidden="true">
            <div class="ticker-item">✨ Creative Content ✨ Social Strategy ✨ Visual Design ✨ Digital Marketing ✨ Creative Content ✨ Social Strategy ✨</div>
            <div class="ticker-item">✨ Creative Content ✨ Social Strategy ✨ Visual Design ✨ Digital Marketing ✨ Creative Content ✨ Social Strategy ✨</div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-3 mb-4">
                <h5 class="fw-bold mb-4">Blog Dashboard</h5>
                <p class="text-muted">Creating inspiring content and building meaningful connections.</p>
            </div>
            <div class="col-lg-3 mb-4">
                <h5 class="fw-bold mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted text-decoration-none">Home</a></li>
                    <li><a href="#blogs" class="text-muted text-decoration-none">Blogs</a></li>
                    <li><a href="/admin/login" class="text-muted text-decoration-none">Admin</a></li>
                </ul>
            </div>
            <div class="col-lg-3 mb-4">
                <h5 class="fw-bold mb-4">Follow Us</h5>
                <div class="d-flex gap-3">
                    <a href="#" class="text-muted"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-muted"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-muted"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <h5 class="fw-bold mb-4">Contact</h5>
                <p class="text-muted">
                    <i class="fas fa-envelope me-2"></i>info@blogdashboard.com<br>
                    <i class="fas fa-phone me-2"></i>+1 (555) 123-4567
                </p>
            </div>
        </div>
        <div class="row mb-4 footer-newsletter">
            <div class="col-12 text-center">
                <form action="#" method="POST" class="d-flex justify-content-center align-items-center gap-2" style="max-width:720px;margin:0 auto;">
                    @csrf
                    <input type="email" name="email" class="form-control form-control-lg rounded-0" placeholder="Enter your email to get highlights" aria-label="Email">
                    <button class="btn btn-danger btn-lg rounded-0">Subscribe</button>
                </form>
                <p class="text-muted small mt-2">Monthly highlights, featured articles, and creative tips — delivered to your inbox.</p>
            </div>
        </div>
        <hr class="bg-secondary">
        <div class="text-center text-muted">
            <p>&copy; 2024 Blog Dashboard. All rights reserved. | Built with <i class="fas fa-heart text-danger"></i> by Creative Team</p>
        </div>
    </div>
</footer>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // AJAX Filtering
    function filterBlogs() {
        const searchValue = $('#searchInput').val();
        const categoryValue = $('#categoryFilter').val();
        const dateValue = $('#dateFilter').val();

        $.ajax({
            url: '{{ route("blogs.filter") }}',
            type: 'POST',
            data: {
                search: searchValue,
                category: categoryValue,
                date_filter: dateValue,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#blogContainer').html(response.data);
                    // Reapply animations
                    gsap.utils.toArray('.blog-card').forEach((card, index) => {
                        gsap.from(card, {
                            opacity: 0,
                            y: 30,
                            duration: 0.6,
                            delay: index * 0.1
                        });
                    });
                }
            },
            error: function() {
                alert('Error filtering blogs');
            }
        });
    }

    $('#searchInput').on('keyup', filterBlogs);
    $('#categoryFilter').on('change', filterBlogs);
    $('#dateFilter').on('change', filterBlogs);

    $('#resetFilters').on('click', function() {
        $('#searchInput').val('');
        $('#categoryFilter').val('');
        $('#dateFilter').val('');
        filterBlogs();
    });

    // GSAP Animations
    gsap.registerPlugin(ScrollTrigger);

    // Hero animation
    gsap.from('.hero-title', {
        opacity: 0,
        y: 50,
        duration: 1,
        ease: 'power3.out'
    });

    gsap.from('.hero-subtitle', {
        opacity: 0,
        y: 30,
        duration: 1,
        delay: 0.2,
        ease: 'power3.out'
    });

    gsap.from('.hero-btn', {
        opacity: 0,
        y: 20,
        duration: 0.8,
        delay: 0.4,
        stagger: 0.1,
        ease: 'power3.out'
    });

    // Blog card stagger animation
    gsap.utils.toArray('.blog-card').forEach((card, index) => {
        gsap.from(card, {
            opacity: 0,
            y: 30,
            duration: 0.6,
            delay: index * 0.1,
            scrollTrigger: {
                trigger: card,
                start: 'top 80%',
                toggleActions: 'play none none none'
            }
        });
    });

    // Hover animation for blog cards
    gsap.utils.toArray('.blog-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            gsap.to(this, {
                y: -10,
                boxShadow: '0 20px 40px rgba(139, 0, 0, 0.3)',
                duration: 0.3
            });
        });

        card.addEventListener('mouseleave', function() {
            gsap.to(this, {
                y: 0,
                boxShadow: '0 5px 15px rgba(0, 0, 0, 0.1)',
                duration: 0.3
            });
        });
    });

    // Section reveal animation (exclude hero so it remains visible on load)
    gsap.utils.toArray('section').forEach(section => {
        if (section.classList && section.classList.contains('hero-section')) return;

        gsap.from(section, {
            opacity: 0,
            y: 40,
            duration: 0.8,
            scrollTrigger: {
                trigger: section,
                start: 'top 85%',
                toggleActions: 'play none none none'
            }
        });
    });

    // Featured card floating effect
    gsap.to('.featured-card', {
        y: -8,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut',
        duration: 3,
        delay: 0.6
    });

    // Hover interaction for featured card (subtle scale)
    document.querySelectorAll('.featured-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card, { scale: 1.02, duration: 0.2 });
        });
        card.addEventListener('mouseleave', () => {
            gsap.to(card, { scale: 1, duration: 0.2 });
        });
    });
});
</script>
@endsection
