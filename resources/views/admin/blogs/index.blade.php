@extends('layouts.blog')

@section('title', 'Admin - Manage Blogs')

@section('content')
<div class="row mb-4 fade-in-up">
    <div class="col-md-12">
        <h1 class="display-5 fw-bold">
            <i class="bi bi-shield-check text-primary"></i> Admin Panel
        </h1>
        <p class="lead text-muted">Review and manage all submitted blogs</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="stat-card bg-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-2 opacity-75">Pending Review</h6>
                    <h2 class="mb-0 fw-bold">{{ $blogs->where('status', 'pending')->count() }}</h2>
                </div>
                <div>
                    <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card bg-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-2 opacity-75">Published</h6>
                    <h2 class="mb-0 fw-bold">{{ $blogs->where('status', 'published')->count() }}</h2>
                </div>
                <div>
                    <i class="bi bi-check-circle-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card bg-danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-2 opacity-75">Rejected</h6>
                    <h2 class="mb-0 fw-bold">{{ $blogs->where('status', 'rejected')->count() }}</h2>
                </div>
                <div>
                    <i class="bi bi-x-circle-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@if($blogs->count() > 0)
    <div class="card shadow-sm fade-in-up">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Image</th>
                            <th>Title</th>
                            <th style="width: 150px;">Author</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 120px;">Created</th>
                            <th style="width: 120px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                            <tr style="animation: fadeInUp 0.5s ease; animation-delay: {{ $loop->index * 0.05 }}s; animation-fill-mode: both;">
                                <td>
                                    @if($blog->image)
                                        <img src="{{ asset('storage/' . $blog->image) }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" alt="{{ $blog->title }}">
                                    @else
                                        <div class="rounded d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="bi bi-image text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <strong class="d-block mb-1">{{ Str::limit($blog->title, 50) }}</strong>
                                    <small class="text-muted">{{ Str::limit(strip_tags($blog->content), 60) }}</small>
                                </td>
                                <td class="align-middle">
                                    <i class="bi bi-person-circle text-primary"></i> {{ $blog->user->name }}
                                </td>
                                <td class="align-middle">
                                    <span class="badge status-badge 
                                        @if($blog->status === 'pending') bg-warning text-dark
                                        @elseif($blog->status === 'published') bg-success
                                        @else bg-danger @endif">
                                        @if($blog->status === 'pending')
                                            <i class="bi bi-clock-history"></i>
                                        @elseif($blog->status === 'published')
                                            <i class="bi bi-check-circle-fill"></i>
                                        @else
                                            <i class="bi bi-x-circle-fill"></i>
                                        @endif
                                        {{ ucfirst($blog->status) }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3"></i> {{ $blog->created_at->format('M d, Y') }}
                                    </small>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye-fill"></i> Review
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $blogs->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="alert alert-info text-center">
        <i class="bi bi-info-circle fs-1"></i>
        <p class="mb-0 mt-3">No blogs submitted yet.</p>
    </div>
@endif
@endsection

