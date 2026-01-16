@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('page_title', 'Blog Management')
@section('breadcrumb', 'All Posts')

@section('page_actions')
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i> New Post
    </a>
@endsection

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>Featured Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blogs as $blog)
                    <tr>
                        <td>
                            <img src="{{ $blog->featured_image ? Storage::url($blog->featured_image) : 'https://via.placeholder.com/80x60' }}" 
                                 class="rounded" width="80" height="60" 
                                 style="object-fit: cover;" alt="{{ $blog->title }}">
                        </td>
                        <td>
                            <strong>{{ $blog->title }}</strong>
                            <div class="text-muted small">{{ Str::limit($blog->brief_description, 80) }}</div>
                            @if($blog->tags)
                                <div class="mt-1">
                                    @foreach(array_slice($blog->tags, 0, 3) as $tag)
                                        <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td>{{ $blog->category }}</td>
                        <td>{{ $blog->author->name }}</td>
                        <td>
                            <form action="{{ route('admin.blogs.toggle-publish', $blog) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-{{ $blog->is_published ? 'success' : 'secondary' }}">
                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $blog->view_count }}</span>
                        </td>
                        <td>
                            @if($blog->published_at)
                                {{ $blog->published_at->format('M d, Y') }}
                            @else
                                <span class="text-muted">Not published</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.blogs.show', $blog) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog) }}" 
                                   class="btn btn-sm btn-outline-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('blog.show', $blog->slug) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-secondary" title="Preview">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete" 
                                            data-item-name="Blog '{{ $blog->title }}'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Showing {{ $blogs->firstItem() }} to {{ $blogs->lastItem() }} of {{ $blogs->total() }} entries
            </div>
            <div>
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection