@extends('layouts.blog')

@section('title', 'Create Blog')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">My Blogs</a></li>
                <li class="breadcrumb-item active">Create New Blog</li>
            </ol>
        </nav>

        <div class="card shadow-sm fade-in-up">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 fw-bold"><i class="bi bi-plus-circle"></i> Create New Blog</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Write your blog content here.</div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/jpeg,image/png,image/gif">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Upload an image (JPG, PNG, GIF - Max: 1MB)</div>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Your blog will be submitted for review and will be published after admin approval.
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Submit Blog
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

