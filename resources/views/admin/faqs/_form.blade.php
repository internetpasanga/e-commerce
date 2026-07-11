@if ($errors->any())
    <div class="alert alert-error">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="form-group">
    <label for="question" class="form-label">Question</label>
    <input id="question" type="text" name="question" value="{{ old('question', $faq->question ?? '') }}" required class="form-control">
    @error('question') <span class="field-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="answer" class="form-label">Answer</label>
    <textarea id="answer" name="answer" rows="8" class="form-control" data-rich-text>{{ old('answer', $faq->answer ?? '') }}</textarea>
    @error('answer') <span class="field-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="priority" class="form-label">Priority</label>
    <input id="priority" type="number" name="priority" value="{{ old('priority', $faq->priority ?? 0) }}" min="0" class="form-control">
    @error('priority') <span class="field-error">{{ $message }}</span> @enderror
    <small style="color: var(--text-muted);">Lower numbers appear first on the FAQs page.</small>
</div>

<div class="form-group">
    <label for="is_active" class="form-label">Status</label>
    <select id="is_active" name="is_active" class="form-control">
        <option value="1" {{ old('is_active', $faq->is_active ?? true) ? 'selected' : '' }}>Active</option>
        <option value="0" {{ ! old('is_active', $faq->is_active ?? true) ? 'selected' : '' }}>Inactive</option>
    </select>
    <small style="color: var(--text-muted);">Inactive FAQs are hidden from the public FAQs page.</small>
</div>
