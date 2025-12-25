@extends('layouts.blog')

@section('title', 'Review Blog - ' . $blog->title)

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Admin Panel</a></li>
                <li class="breadcrumb-item active">Review Blog</li>
            </ol>
        </nav>

        <!-- Status Update Card -->
        <div class="card shadow-sm mb-3">
            <div class="card-body bg-light">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-2">Current Status: 
                            <span id="currentStatus" class="badge 
                                @if($blog->status === 'pending') bg-warning
                                @elseif($blog->status === 'published') bg-success
                                @else bg-danger @endif">
                                {{ ucfirst($blog->status) }}
                            </span>
                        </h5>
                        <small class="text-muted">
                            <i class="bi bi-person-circle"></i> Author: <strong>{{ $blog->user->name }}</strong> ({{ $blog->user->email }})
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="btn-group" role="group" id="statusButtons">
                            @if($blog->status === 'pending')
                                <!-- Pending: Show Publish and Reject -->
                                <button type="button" class="btn btn-success status-btn" data-status="published">
                                    <i class="bi bi-check-circle"></i> Publish
                                </button>
                                <button type="button" class="btn btn-danger status-btn" data-status="rejected">
                                    <i class="bi bi-x-circle"></i> Reject
                                </button>
                            @elseif($blog->status === 'published')
                                <!-- Published: Show Unpublish only (returns to pending for re-review) -->
                                <button type="button" class="btn btn-warning status-btn" data-status="pending">
                                    <i class="bi bi-arrow-counterclockwise"></i> Unpublish
                                </button>
                            @else
                                <!-- Rejected: Show Publish only (to approve) -->
                                <button type="button" class="btn btn-success status-btn" data-status="published">
                                    <i class="bi bi-check-circle"></i> Approve & Publish
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div id="statusMessage" class="mt-3" style="display: none;"></div>
            </div>
        </div>

        <!-- Blog Content -->
        <article class="card shadow-sm">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}" style="max-height: 500px; object-fit: cover;">
            @endif
            
            <div class="card-body">
                <h1 class="card-title mb-3">{{ $blog->title }}</h1>
                
                <div class="mb-3 pb-3 border-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> Created: {{ $blog->created_at->format('F d, Y h:i A') }}
                            </small>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                <i class="bi bi-pencil"></i> Updated: {{ $blog->updated_at->format('F d, Y h:i A') }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="blog-content">
                    {!! nl2br(e($blog->content)) !!}
                </div>
            </div>

            <div class="card-footer bg-white">
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Back to Admin Panel
                </a>
            </div>
        </article>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentStatusBadge = document.getElementById('currentStatus');
    const statusMessage = document.getElementById('statusMessage');
    const statusButtonsContainer = document.getElementById('statusButtons');
    const blogId = {{ $blog->id }};
    
    // Function to get button HTML based on status
    function getButtonsHTML(status) {
        if (status === 'pending') {
            return `
                <button type="button" class="btn btn-success status-btn" data-status="published">
                    <i class="bi bi-check-circle"></i> Publish
                </button>
                <button type="button" class="btn btn-danger status-btn" data-status="rejected">
                    <i class="bi bi-x-circle"></i> Reject
                </button>
            `;
        } else if (status === 'published') {
            return `
                <button type="button" class="btn btn-warning status-btn" data-status="pending">
                    <i class="bi bi-arrow-counterclockwise"></i> Unpublish
                </button>
            `;
        } else {
            return `
                <button type="button" class="btn btn-success status-btn" data-status="published">
                    <i class="bi bi-check-circle"></i> Approve & Publish
                </button>
            `;
        }
    }
    
    // Function to update badge
    function updateBadge(status) {
        currentStatusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        currentStatusBadge.className = 'badge';
        
        if (status === 'pending') {
            currentStatusBadge.classList.add('bg-warning');
        } else if (status === 'published') {
            currentStatusBadge.classList.add('bg-success');
        } else {
            currentStatusBadge.classList.add('bg-danger');
        }
    }
    
    // Function to handle status button clicks
    function attachButtonListeners() {
        const statusButtons = document.querySelectorAll('.status-btn');
        
        statusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const newStatus = this.getAttribute('data-status');
                const statusText = newStatus === 'published' ? 'publish' : 
                                  newStatus === 'pending' ? 'unpublish' : 'reject';
                
                if (!confirm(`Are you sure you want to ${statusText} this blog?`)) {
                    return;
                }
                
                // Disable all buttons during request
                statusButtons.forEach(btn => {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                });
                
                fetch(`/admin/blogs/${blogId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update badge
                        updateBadge(newStatus);
                        
                        // Update buttons
                        statusButtonsContainer.innerHTML = getButtonsHTML(newStatus);
                        
                        // Reattach listeners to new buttons
                        attachButtonListeners();
                        
                        // Show success message with animation
                        statusMessage.className = 'alert alert-success mt-3 fade-in-up';
                        statusMessage.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>' + data.message;
                        statusMessage.style.display = 'block';
                        
                        // Hide message after 3 seconds
                        setTimeout(() => {
                            statusMessage.style.display = 'none';
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    statusMessage.className = 'alert alert-danger mt-3 fade-in-up';
                    statusMessage.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>An error occurred. Please try again.';
                    statusMessage.style.display = 'block';
                    
                    // Restore original buttons on error
                    statusButtonsContainer.innerHTML = getButtonsHTML('{{ $blog->status }}');
                    attachButtonListeners();
                });
            });
        });
    }
    
    // Initial attachment
    attachButtonListeners();
});
</script>
@endpush

