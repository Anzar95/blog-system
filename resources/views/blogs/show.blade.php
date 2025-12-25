@extends('layouts.blog')

@section('title', $blog->title)

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">My Blogs</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($blog->title, 50) }}</li>
            </ol>
        </nav>

        <article class="card shadow-sm">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}" style="max-height: 400px; object-fit: cover;">
            @endif
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="card-title mb-0">{{ $blog->title }}</h1>
                    @if($blog->status === 'pending')
                        <span class="badge bg-warning">
                            <i class="bi bi-clock"></i> Pending Review
                        </span>
                    @elseif($blog->status === 'published')
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i> Published
                        </span>
                    @else
                        <span class="badge bg-danger">
                            <i class="bi bi-x-circle"></i> Rejected
                        </span>
                    @endif
                </div>
                
                <div class="mb-3 pb-3 border-bottom">
                    <small class="text-muted">
                        <i class="bi bi-calendar"></i> Created: {{ $blog->created_at->format('F d, Y h:i A') }}
                    </small>
                    @if($blog->updated_at != $blog->created_at)
                        <small class="text-muted ms-3">
                            <i class="bi bi-pencil"></i> Updated: {{ $blog->updated_at->format('F d, Y h:i A') }}
                        </small>
                    @endif
                </div>

                <div class="blog-content mb-4">
                    {!! nl2br(e($blog->content)) !!}
                </div>

                @if($blog->status === 'rejected')
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> <strong>This blog was rejected.</strong>
                        <p class="mb-0 mt-2">Please review your content and make necessary changes before resubmitting.</p>
                    </div>
                @endif
            </div>

            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('blogs.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Back to My Blogs
                    </a>
                    
                    @if(in_array($blog->status, ['pending', 'rejected']))
                        <div>
                            <a href="{{ route('blogs.edit', $blog) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('blogs.destroy', $blog) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </article>
    </div>
</div>
@endsection

