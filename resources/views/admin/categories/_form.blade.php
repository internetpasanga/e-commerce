<div class="alert alert-error" id="category-form-error" style="display: none;"></div>

<div class="form-group">
    <label for="category-name" class="form-label">Name</label>
    <input id="category-name" type="text" name="name" required class="form-control">
    <span class="field-error" id="category-name-error"></span>
</div>

<div class="form-group">
    <label for="category-priority" class="form-label">Priority</label>
    <input id="category-priority" type="number" name="priority" value="0" min="0" class="form-control">
    <span class="field-error" id="category-priority-error"></span>
    <small style="color: var(--text-muted);">Lower numbers appear first on the website.</small>
</div>

<div class="form-group">
    <label class="form-label">Image</label>
    <label for="category-image" class="file-drop" id="category-file-drop">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M17 8l-5-5-5 5"/><path d="M12 3v12"/></svg>
        <span class="file-drop-text" id="category-file-drop-text">Click to upload an image</span>
        <span class="file-drop-hint">PNG, JPG up to 2MB</span>
    </label>
    <input id="category-image" type="file" name="image" accept="image/*" class="file-drop-input">
    <span class="field-error" id="category-image-error"></span>
    <img id="category-image-preview" src="" alt="" class="thumb-lg form-preview" style="display: none;">
</div>

<div class="form-group">
    <label for="category-status" class="form-label">Status</label>
    <select id="category-status" name="status" class="form-control">
        <option value="1" selected>Active</option>
        <option value="0">Inactive</option>
    </select>
</div>
