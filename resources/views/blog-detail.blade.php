@extends('layouts.blog')

@section('title', $blog->title . ' - Blog System')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($blog->title, 50) }}</li>
            </ol>
        </nav>

        <article class="card shadow-sm">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}" style="max-height: 400px; object-fit: cover;">
            @endif
            
            <div class="card-body">
                <h1 class="card-title mb-3">{{ $blog->title }}</h1>
                
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <div>
                        <span class="text-muted">
                            <i class="bi bi-person-circle"></i> <strong>{{ $blog->user->name }}</strong>
                        </span>
                    </div>
                    <div>
                        <span class="text-muted">
                            <i class="bi bi-calendar"></i> {{ $blog->created_at->format('F d, Y') }}
                        </span>
                    </div>
                </div>

                <div class="blog-content">
                    {!! nl2br(e($blog->content)) !!}
                </div>
            </div>

            <div class="card-footer bg-white">
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Back to Home
                </a>
            </div>
        </article>
    </div>
</div>
@endsection

