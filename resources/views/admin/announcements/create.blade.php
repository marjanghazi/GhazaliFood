@extends('layouts.admin')

@section('title', 'Create Announcement')
@section('page_title', 'Announcements')
@section('breadcrumb', 'Create Announcement')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Create New Announcement</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.announcements.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="text" class="form-label">Announcement Text *</label>
                                <textarea class="form-control @error('text') is-invalid @enderror" 
                                          id="text" name="text" rows="3" required
                                          placeholder="Enter announcement text here...">{{ old('text') }}</textarea>
                                @error('text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="link_url" class="form-label">Link URL (Optional)</label>
                                <input type="url" class="form-control @error('link_url') is-invalid @enderror" 
                                       id="link_url" name="link_url" value="{{ old('link_url') }}"
                                       placeholder="https://example.com">
                                @error('link_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave blank if no link is needed.</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="background_color" class="form-label">Background Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           id="background_color" name="background_color" 
                                           value="{{ old('background_color', '#000000') }}">
                                    <input type="text" class="form-control" 
                                           value="{{ old('background_color', '#000000') }}" 
                                           id="background_color_text" readonly>
                                </div>
                                @error('background_color')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="text_color" class="form-label">Text Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" 
                                           id="text_color" name="text_color" 
                                           value="{{ old('text_color', '#FFFFFF') }}">
                                    <input type="text" class="form-control" 
                                           value="{{ old('text_color', '#FFFFFF') }}" 
                                           id="text_color_text" readonly>
                                </div>
                                @error('text_color')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="display_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('display_order') is-invalid @enderror" 
                                       id="display_order" name="display_order" 
                                       value="{{ old('display_order', 0) }}" min="0">
                                @error('display_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Lower numbers display first.</small>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="is_closable" name="is_closable" value="1" 
                                           {{ old('is_closable') ? 'checked' : 'checked' }}>
                                    <label class="form-check-label" for="is_closable">
                                        Allow users to close announcement
                                    </label>
                                </div>
                            </div>

                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Preview</h6>
                                    <div id="announcement_preview" 
                                         style="background-color: #000000; color: #FFFFFF; padding: 10px; border-radius: 4px;">
                                        Your announcement text will appear here...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date *</label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" 
                                       value="{{ old('start_date') }}" required>
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
                                       value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Create Announcement
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
    // Update color text inputs and preview
    function updatePreview() {
        const bgColor = document.getElementById('background_color').value;
        const textColor = document.getElementById('text_color').value;
        const text = document.getElementById('text').value || 'Your announcement text will appear here...';
        
        // Update text inputs
        document.getElementById('background_color_text').value = bgColor;
        document.getElementById('text_color_text').value = textColor;
        
        // Update preview
        const preview = document.getElementById('announcement_preview');
        preview.style.backgroundColor = bgColor;
        preview.style.color = textColor;
        preview.textContent = text;
    }

    // Initialize preview
    document.addEventListener('DOMContentLoaded', function() {
        updatePreview();
        
        // Add event listeners
        document.getElementById('background_color').addEventListener('input', updatePreview);
        document.getElementById('text_color').addEventListener('input', updatePreview);
        document.getElementById('text').addEventListener('input', updatePreview);
        
        // Set default datetime values if not set
        const now = new Date();
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        
        if (!startDate.value) {
            startDate.value = now.toISOString().slice(0, 16);
        }
        
        if (!endDate.value) {
            const tomorrow = new Date(now);
            tomorrow.setDate(tomorrow.getDate() + 1);
            endDate.value = tomorrow.toISOString().slice(0, 16);
        }
    });
</script>
@endpush