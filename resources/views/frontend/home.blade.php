@extends('layouts.app')

@section('title', 'Home - Blog Dashboard')

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
<section class="hero-section position-relative overflow-hidden" style="background: linear-gradient(135deg, #8B0000 0%, #C41E3A 100%); min-height: 100vh; display: flex; align-items: center;">
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
                <div class="hero-image-wrapper">
                    <div class="hero-shape" style="width: 300px; height: 400px; background: rgba(255,255,255,0.1); border-radius: 20px; margin: 50px auto;"></div>
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
                    <div style="background: linear-gradient(135deg, #8B0000, #C41E3A); width: 100%; height: 400px; border-radius: 20px;"></div>
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
<section class="ticker-section py-5" style="background: #8B0000; overflow: hidden;">
    <div class="container-fluid">
        <div class="ticker-content" style="white-space: nowrap;">
            <span style="display: inline-block; color: white; font-size: 2rem; font-weight: bold; margin-right: 100px; animation: scroll-left 20s linear infinite;">
                ✨ Creative Content ✨ Social Strategy ✨ Visual Design ✨ Digital Marketing ✨ Creative Content ✨ Social Strategy ✨
            </span>
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
});
</script>
@endsection
