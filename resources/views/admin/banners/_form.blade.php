<div class="alert alert-error" id="banner-form-error" style="display: none;"></div>

<div class="form-group">
    <label for="banner-title" class="form-label">Title</label>
    <input id="banner-title" type="text" name="title" required class="form-control">
    <span class="field-error" id="banner-title-error"></span>
</div>

<div class="form-group">
    <label for="banner-sub_title" class="form-label">Sub-title</label>
    <input id="banner-sub_title" type="text" name="sub_title" class="form-control">
    <span class="field-error" id="banner-sub_title-error"></span>
</div>

<div class="form-group">
    <label for="banner-title_position" class="form-label">Title Position</label>
    <select id="banner-title_position" name="title_position" required class="form-control">
        @foreach (\App\Models\Banner::TITLE_POSITIONS as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>
    <span class="field-error" id="banner-title_position-error"></span>
</div>

<div class="form-group">
    <label for="banner-priority" class="form-label">Priority</label>
    <input id="banner-priority" type="number" name="priority" value="0" min="0" class="form-control">
    <span class="field-error" id="banner-priority-error"></span>
    <small style="color: var(--text-muted);">Lower numbers appear first on the website.</small>
</div>

<div class="form-group">
    <label class="form-label">Banner Image</label>
    <label for="banner-image" class="file-drop" id="banner-file-drop">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M17 8l-5-5-5 5"/><path d="M12 3v12"/></svg>
        <span class="file-drop-text" id="banner-file-drop-text">Click to upload a banner image</span>
        <span class="file-drop-hint">PNG, JPG up to 2MB</span>
    </label>
    <input id="banner-image" type="file" name="image" accept="image/*" class="file-drop-input">
    <span class="field-error" id="banner-image-error"></span>
    <img id="banner-image-preview" src="" alt="" class="thumb-lg form-preview" style="display: none;">
</div>

<div class="form-row">
    <div class="form-group">
        <label for="banner-button_text" class="form-label">Button Text</label>
        <input id="banner-button_text" type="text" name="button_text" class="form-control">
        <span class="field-error" id="banner-button_text-error"></span>
    </div>

    <div class="form-group">
        <label for="banner-button_color" class="form-label">Button Color</label>
        <input id="banner-button_color" type="color" name="button_color" value="#4f46e5" class="form-control" style="padding: 0.25rem; height: 42px;">
        <span class="field-error" id="banner-button_color-error"></span>
    </div>
</div>

<div class="form-group">
    <label for="banner-button_url" class="form-label">Button Click URL</label>
    <input id="banner-button_url" type="url" name="button_url" placeholder="https://example.com" class="form-control">
    <span class="field-error" id="banner-button_url-error"></span>
</div>

<div class="form-group">
    <label for="banner-status" class="form-label">Status</label>
    <select id="banner-status" name="status" class="form-control">
        <option value="1" selected>Active</option>
        <option value="0">Inactive</option>
    </select>
</div>
