@extends('layouts.blog')

@section('title', 'Home - Blog System')

@section('content')
<div class="row mb-5 fade-in-up">
    <div class="col-md-12 text-center">
        <h1 class="display-3 fw-bold mb-3">
            <i class="bi bi-journal-richtext text-primary"></i> Latest Blogs
        </h1>
        <p class="lead text-muted">Discover amazing stories from our community</p>
        @guest
            <div class="mt-4">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">
                    <i class="bi bi-person-plus"></i> Join Us
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            </div>
        @endguest
    </div>
</div>

@if($blogs->count() > 0)
    <div class="row g-4">
        @foreach($blogs as $blog)
            <div class="col-md-4">
                <div class="card blog-card h-100 shadow-sm fade-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                    @if($blog->image)
                        <div style="overflow: hidden; height: 220px; border-radius: 12px 12px 0 0;">
                            <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top blog-image" alt="{{ $blog->title }}">
                        </div>
                    @else
                        <div class="bg-gradient blog-image d-flex align-items-center justify-content-center" 
                             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px 12px 0 0;">
                            <i class="bi bi-image text-white" style="font-size: 3rem; opacity: 0.7;"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-3">{{ Str::limit($blog->title, 50) }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <small class="text-muted">
                                <i class="bi bi-person-circle text-primary"></i> <strong>{{ $blog->user->name }}</strong>
                            </small>
                            <small class="text-muted">
                                <i class="bi bi-calendar3"></i> {{ $blog->created_at->format('M d') }}
                            </small>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0">
                        <a href="{{ route('blog.show', $blog) }}" class="btn btn-primary w-100">
                            Read More <i class="bi bi-arrow-right-circle"></i>
                        </a>
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
        <p class="mb-0 mt-3">No published blogs yet. Check back soon!</p>
    </div>
@endif
@endsection

