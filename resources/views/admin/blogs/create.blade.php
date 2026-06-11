<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #f8f9fa;
        }
        .sidebar {
            background: linear-gradient(135deg, #8B0000 0%, #C41E3A 100%);
            min-height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: all 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 30px;
        }
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid white;
        }
        .topbar {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-danger {
            background: #8B0000 !important;
            border: none !important;
        }
        .btn-danger:hover {
            background: #C41E3A !important;
        }
        .form-control, .form-select {
            border-radius: 5px;
        }
        .image-preview {
            margin-top: 10px;
            max-width: 100%;
            max-height: 300px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 sidebar">
                <div class="text-center mb-4">
                    <h5 class="text-white fw-bold"><i class="fas fa-feather me-2"></i>Blog Dashboard</h5>
                </div>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-chart-line me-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.blogs') }}" class="active">
                    <i class="fas fa-newspaper me-2"></i>All Blogs
                </a>
                <a href="{{ route('admin.blogs.create') }}">
                    <i class="fas fa-plus-circle me-2"></i>Add New Blog
                </a>
                <hr class="bg-white-50">
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-link text-white text-start w-100" style="border: none; text-decoration: none; padding: 12px 20px; display: block;">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10">
                <!-- Topbar -->
                <div class="topbar">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Create New Blog</h3>
                            <small class="text-muted">Add a new article to your blog</small>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="container-fluid p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Blog Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                            <option value="">-- Select Category --</option>
                                            @forelse($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Featured Image <span class="text-danger">*</span></label>
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required onchange="previewImage(event)">
                                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <img id="imagePreview" class="image-preview" style="display: none;">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Short Description <span class="text-danger">*</span></label>
                                    <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2" required>{{ old('short_description') }}</textarea>
                                    @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Full Content <span class="text-danger">*</span></label>
                                    <textarea id="content" name="content" class="@error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-save me-2"></i>Publish Blog
                                    </button>
                                    <a href="{{ route('admin.blogs') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize CKEditor
        CKEDITOR.replace('content', {
            height: 400
        });

        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
