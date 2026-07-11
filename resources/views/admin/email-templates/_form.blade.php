@if ($errors->any())
    <div class="alert alert-error">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="form-group">
    <label for="name" class="form-label">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name', $emailTemplate->name ?? '') }}" required class="form-control">
    @error('name') <span class="field-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="slug" class="form-label">Slug</label>
    <input id="slug" type="text" name="slug" value="{{ old('slug', $emailTemplate->slug ?? '') }}"
           required class="form-control"
           @if (! empty($emailTemplate) && $emailTemplate->is_system) readonly @endif>
    @error('slug') <span class="field-error">{{ $message }}</span> @enderror
    <small style="color: var(--text-muted);">
        Used by the application code to look up this template.
        @if (! empty($emailTemplate) && $emailTemplate->is_system)
            This is a system template — its slug cannot be changed.
        @endif
    </small>
</div>

<div class="form-group">
    <label for="subject" class="form-label">Subject</label>
    <input id="subject" type="text" name="subject" value="{{ old('subject', $emailTemplate->subject ?? '') }}" required class="form-control">
    @error('subject') <span class="field-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="body" class="form-label">Body</label>
    <textarea id="body" name="body" rows="10" class="form-control" data-rich-text>{{ old('body', $emailTemplate->body ?? '') }}</textarea>
    @error('body') <span class="field-error">{{ $message }}</span> @enderror
    @if (! empty($emailTemplate) && $emailTemplate->description)
        <small style="color: var(--text-muted);">{{ $emailTemplate->description }}</small>
    @endif
</div>

<div class="form-group">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" rows="2" class="form-control">{{ old('description', $emailTemplate->description ?? '') }}</textarea>
    @error('description') <span class="field-error">{{ $message }}</span> @enderror
    <small style="color: var(--text-muted);">Internal note listing the available double-curly-brace variables for this template (e.g. name, verification_url).</small>
</div>

<div class="form-group">
    <label for="is_active" class="form-label">Status</label>
    <select id="is_active" name="is_active" class="form-control">
        <option value="1" {{ old('is_active', $emailTemplate->is_active ?? true) ? 'selected' : '' }}>Active</option>
        <option value="0" {{ ! old('is_active', $emailTemplate->is_active ?? true) ? 'selected' : '' }}>Inactive</option>
    </select>
    <small style="color: var(--text-muted);">When inactive, the built-in default content is used instead.</small>
</div>
