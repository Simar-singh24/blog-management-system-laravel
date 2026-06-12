@forelse($blogs as $blog)
    <div class="col-lg-4 col-md-6 mb-4 blog-card" data-aos="fade-up">
        <div class="card h-100 rounded-0 shadow-sm overflow-hidden" style="border: none; transition: all 0.3s ease;">
            <!-- Blog Image -->
            <div class="position-relative overflow-hidden" style="height: 250px; background: linear-gradient(135deg, #8B0000, #C41E3A);">
                @if($blog->image)
                    <img src="{{ asset(str_starts_with($blog->image, 'images/') ? $blog->image : 'images/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-100 h-100 object-fit-cover">
                @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                        <i class="fas fa-image text-white" style="font-size: 3rem; opacity: 0.5;"></i>
                    </div>
                @endif
                <div class="position-absolute top-3 start-3">
                    <span class="badge bg-danger rounded-0">{{ $blog->category->name ?? 'Uncategorized' }}</span>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body d-flex flex-column">
                <div class="mb-3">
                    <small class="text-muted">
                        <i class="far fa-calendar me-2"></i>{{ $blog->formatted_date }}
                    </small>
                </div>
                <h5 class="card-title fw-bold mb-3 flex-grow-1">{{ $blog->title }}</h5>
                <p class="card-text text-muted mb-4">
                    {{ Str::limit($blog->short_description, 100) }}
                </p>
                <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-danger btn-sm rounded-0 align-self-start">
                    Read More <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-info text-center rounded-0">
            <i class="fas fa-info-circle me-2"></i> No articles found. Try adjusting your filters.
        </div>
    </div>
@endforelse
