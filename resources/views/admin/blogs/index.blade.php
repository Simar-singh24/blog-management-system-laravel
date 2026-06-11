<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Blogs - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                            <h3 class="mb-0">All Blogs</h3>
                            <small class="text-muted">Manage your blog posts</small>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.blogs.create') }}" class="btn btn-danger">
                                <i class="fas fa-plus me-2"></i>Add New Blog
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="container-fluid p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Blogs Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr style="border-top: 2px solid #dee2e6;">
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($blogs as $blog)
                                            <tr>
                                                <td>
                                                    @if($blog->image)
                                                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                                    @else
                                                        <div style="width: 50px; height: 50px; background: #ddd; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td><strong>{{ Str::limit($blog->title, 50) }}</strong></td>
                                                <td><span class="badge bg-danger">{{ $blog->category->name }}</span></td>
                                                <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.blogs.destroy', $blog->id) }}" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">No blogs found. <a href="{{ route('admin.blogs.create') }}">Create one!</a></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($blogs->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $blogs->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
