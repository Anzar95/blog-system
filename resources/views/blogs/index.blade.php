@extends('layouts.blog')

@section('title', 'My Blogs')

@section('content')
<div class="row mb-4 fade-in-up">
    <div class="col-md-8">
        <h1 class="display-5 fw-bold">
            <i class="bi bi-journal-text text-primary"></i> My Blogs
        </h1>
        <p class="lead text-muted">Manage and track your blog posts</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('blogs.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Create New Blog
        </a>
    </div>
</div>

@if($blogs->count() > 0)
    <div class="row g-4">
        @foreach($blogs as $blog)
            <div class="col-md-12">
                <div class="card shadow-sm fade-in-up" style="animation-delay: {{ $loop->index * 0.05 }}s;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                @if($blog->image)
                                    <div style="overflow: hidden; border-radius: 12px;">
                                        <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid" alt="{{ $blog->title }}" style="height: 120px; width: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    <div class="rounded d-flex align-items-center justify-content-center" 
                                         style="height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="bi bi-image text-white fs-1" style="opacity: 0.7;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <div class="d-flex align-items-center mb-2">
                                    <h5 class="card-title mb-0 fw-bold me-3">{{ $blog->title }}</h5>
                                    @if($blog->status === 'pending')
                                        <span class="badge bg-warning status-badge">
                                            <i class="bi bi-clock-history"></i> Pending
                                        </span>
                                    @elseif($blog->status === 'published')
                                        <span class="badge bg-success status-badge">
                                            <i class="bi bi-check-circle-fill"></i> Published
                                        </span>
                                    @else
                                        <span class="badge bg-danger status-badge">
                                            <i class="bi bi-x-circle-fill"></i> Rejected
                                        </span>
                                    @endif
                                </div>
                                <p class="card-text text-muted mb-2">{{ Str::limit(strip_tags($blog->content), 150) }}</p>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 text-primary"></i> {{ $blog->created_at->format('M d, Y') }}
                                </small>
                            </div>
                            <div class="col-md-3 d-flex align-items-center justify-content-end">
                                <div class="d-flex gap-2" role="group">
                                    <a href="{{ route('blogs.show', $blog) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye-fill"></i> View
                                    </a>
                                    
                                    @if(in_array($blog->status, ['pending', 'rejected']))
                                        <a href="{{ route('blogs.edit', $blog) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-fill"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="if(confirm('Are you sure you want to delete this blog?')) { document.getElementById('delete-form-{{ $blog->id }}').submit(); }">
                                            <i class="bi bi-trash3-fill"></i> Delete
                                        </button>
                                        <form id="delete-form-{{ $blog->id }}" action="{{ route('blogs.destroy', $blog) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $blogs->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="alert alert-info text-center">
        <i class="bi bi-info-circle fs-1"></i>
        <p class="mb-3 mt-3">You haven't created any blogs yet.</p>
        <a href="{{ route('blogs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create Your First Blog
        </a>
    </div>
@endif
@endsection

