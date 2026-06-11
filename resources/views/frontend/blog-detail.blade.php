@extends('layouts.app')

@section('title', $blog->title . ' - Blog Dashboard')

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
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#blogs">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/login">Admin Panel</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Reading Progress Bar -->
<div id="readingProgress" style="position: fixed; top: 0; left: 0; height: 4px; background: linear-gradient(90deg, #8B0000, #C41E3A); width: 0%; z-index: 1000;"></div>

<!-- Blog Header -->
<section class="blog-header py-5" style="background: linear-gradient(135deg, #8B0000 0%, #C41E3A 100%);">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <a href="/" class="text-white-50 text-decoration-none mb-4 d-inline-block">
                    <i class="fas fa-arrow-left me-2"></i>Back to Home
                </a>
                <h1 class="display-4 fw-bold text-white mb-4">{{ $blog->title }}</h1>
                <div class="d-flex gap-4 flex-wrap text-white-50">
                    <span>
                        <i class="far fa-calendar me-2"></i>{{ $blog->formatted_date }}
                    </span>
                    <span>
                        <i class="fas fa-tag me-2"></i>{{ $blog->category->name ?? 'Uncategorized' }}
                    </span>
                    <span>
                        <i class="far fa-clock me-2"></i>{{ $blog->reading_time }} min read
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="blog-content py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Featured Image -->
                @if($blog->image)
                    <div class="mb-5 rounded overflow-hidden">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid w-100">
                    </div>
                @else
                    <div class="mb-5 rounded overflow-hidden" style="background: linear-gradient(135deg, #8B0000, #C41E3A); height: 400px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-image text-white" style="font-size: 5rem; opacity: 0.5;"></i>
                    </div>
                @endif

                <!-- Article Content -->
                <article class="blog-article">
                    {!! $blog->content !!}
                </article>

                <!-- Share Buttons -->
                <div class="mt-5 pt-5 border-top">
                    <h5 class="fw-bold mb-3">Share This Article</h5>
                    <div class="d-flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="btn btn-outline-danger rounded-circle p-3">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $blog->title }}" target="_blank" class="btn btn-outline-danger rounded-circle p-3">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank" class="btn btn-outline-danger rounded-circle p-3">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="mailto:?subject={{ $blog->title }}&body={{ url()->current() }}" class="btn btn-outline-danger rounded-circle p-3">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Blogs -->
@if($relatedBlogs->count() > 0)
    <section class="related-blogs py-5" style="background: #f8f9fa;">
        <div class="container py-5">
            <h2 class="fw-bold mb-5">Related Articles</h2>
            <div class="row g-4">
                @forelse($relatedBlogs as $relatedBlog)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 rounded-0 shadow-sm overflow-hidden" style="border: none;">
                            <div class="position-relative overflow-hidden" style="height: 200px; background: linear-gradient(135deg, #8B0000, #C41E3A);">
                                @if($relatedBlog->image)
                                    <img src="{{ asset('storage/' . $relatedBlog->image) }}" alt="{{ $relatedBlog->title }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image text-white" style="font-size: 2rem; opacity: 0.5;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">{{ $relatedBlog->title }}</h5>
                                <p class="card-text text-muted mb-3">{{ Str::limit($relatedBlog->short_description, 80) }}</p>
                                <a href="{{ route('blogs.show', $relatedBlog->id) }}" class="btn btn-danger btn-sm rounded-0">
                                    Read More <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
@endif

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
                    <li><a href="/" class="text-muted text-decoration-none">Home</a></li>
                    <li><a href="/#blogs" class="text-muted text-decoration-none">Blogs</a></li>
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
    // Reading Progress Bar
    $(window).on('scroll', function() {
        const winScroll = $(window).scrollTop();
        const docHeight = $(document).height() - $(window).height();
        const scrolled = (winScroll / docHeight) * 100;
        $('#readingProgress').width(scrolled + '%');
    });

    // GSAP Animations
    gsap.registerPlugin(ScrollTrigger);

    gsap.from('.blog-article', {
        opacity: 0,
        y: 30,
        duration: 1,
        ease: 'power3.out',
        scrollTrigger: {
            trigger: '.blog-article',
            start: 'top 80%',
            toggleActions: 'play none none none'
        }
    });
});
</script>
@endsection
