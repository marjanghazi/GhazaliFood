@extends('layouts.admin')

@section('title', 'Edit Announcement')
@section('page_title', 'Announcements')
@section('breadcrumb', 'Edit Announcement')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Announcement</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="text" class="form-label">Announcement Text *</label>
                                <textarea class="form-control @error('text') is-invalid @enderror" 
                                          id="text" name="text" rows="3" required>{{ old('text', $announcement->text) }}</textarea>
                                @error('text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="link_url" class="form-label">Link URL</label>
                                <input type="url" class="form-control @error('link_url') is-invalid @enderror" 
                                       id="link_url" name="link_url" value="{{ old('link_url', $announcement->link_url) }}">
                                @error('link_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="background_color" class="form-label">Background Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           id="background_color" name="background_color" 
                                           value="{{ old('background_color', $announcement->background_color) }}">
                                    <input type="text" class="form-control" 
                                           value="{{ old('background_color', $announcement->background_color) }}" 
                                           id="background_color_text" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="text_color" class="form-label">Text Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           id="text_color" name="text_color" 
                                           value="{{ old('text_color', $announcement->text_color) }}">
                                    <input type="text" class="form-control" 
                                           value="{{ old('text_color', $announcement->text_color) }}" 
                                           id="text_color_text" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="display_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('display_order') is-invalid @enderror" 
                                       id="display_order" name="display_order" 
                                       value="{{ old('display_order', $announcement->display_order) }}" min="0">
                                @error('display_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="is_closable" name="is_closable" value="1" 
                                           {{ old('is_closable', $announcement->is_closable) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_closable">
                                        Allow users to close
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="active" {{ old('status', $announcement->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $announcement->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="scheduled" {{ old('status', $announcement->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date *</label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" 
                                       value="{{ old('start_date', $announcement->start_date->format('Y-m-d\TH:i')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date *</label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" 
                                       value="{{ old('end_date', $announcement->end_date->format('Y-m-d\TH:i')) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Preview</h6>
                        </div>
                        <div class="card-body">
                            <div id="announcement_preview" class="p-4 rounded" 
                                 style="background-color: {{ $announcement->background_color }}; 
                                        color: {{ $announcement->text_color }};">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Announcement</h5>
                                    @if($announcement->is_closable)
                                        <button type="button" class="btn btn-sm btn-light">×</button>
                                    @endif
                                </div>
                                <p class="mb-0" id="preview_text">{{ $announcement->text }}</p>
                                @if($announcement->link_url)
                                    <div class="mt-3">
                                        <a href="{{ $announcement->link_url }}" 
                                           class="btn btn-sm btn-outline-light" id="preview_link">
                                            Learn More
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Announcement
                        </button>
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updatePreview() {
        const bgColor = document.getElementById('background_color').value;
        const textColor = document.getElementById('text_color').value;
        const text = document.getElementById('text').value;
        const linkUrl = document.getElementById('link_url').value;
        
        // Update text inputs
        document.getElementById('background_color_text').value = bgColor;
        document.getElementById('text_color_text').value = textColor;
        
        // Update preview
        const preview = document.getElementById('announcement_preview');
        preview.style.backgroundColor = bgColor;
        preview.style.color = textColor;
        document.getElementById('preview_text').textContent = text;
        
        // Update link
        const linkPreview = document.getElementById('preview_link');
        if (linkPreview && linkUrl) {
            linkPreview.href = linkUrl;
            linkPreview.style.display = 'inline-block';
        } else if (linkPreview) {
            linkPreview.style.display = 'none';
        }
    }

    // Initialize preview
    document.addEventListener('DOMContentLoaded', function() {
        updatePreview();
        
        // Add event listeners
        document.getElementById('background_color').addEventListener('input', updatePreview);
        document.getElementById('text_color').addEventListener('input', updatePreview);
        document.getElementById('text').addEventListener('input', updatePreview);
        document.getElementById('link_url').addEventListener('input', updatePreview);
    });
</script>
@endpush