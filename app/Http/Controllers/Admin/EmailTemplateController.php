<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmailTemplateController extends Controller
{
    public function index(): View
    {
        $emailTemplates = EmailTemplate::orderBy('name')->paginate(10);

        return view('admin.email-templates.index', compact('emailTemplates'));
    }

    public function create(): View
    {
        return view('admin.email-templates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateEmailTemplate($request);

        EmailTemplate::create($validated);

        return redirect()->route('admin.email-templates.index')->with('status', 'Email template created successfully.');
    }

    public function edit(EmailTemplate $emailTemplate): View
    {
        return view('admin.email-templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate): RedirectResponse
    {
        $validated = $this->validateEmailTemplate($request, $emailTemplate);

        if ($emailTemplate->is_system) {
            unset($validated['slug']);
        }

        $emailTemplate->update($validated);

        return redirect()->route('admin.email-templates.index')->with('status', 'Email template updated successfully.');
    }

    public function destroy(EmailTemplate $emailTemplate): RedirectResponse
    {
        if ($emailTemplate->is_system) {
            return back()->withErrors(['email_template' => 'System email templates cannot be deleted.']);
        }

        $emailTemplate->delete();

        return redirect()->route('admin.email-templates.index')->with('status', 'Email template deleted successfully.');
    }

    private function validateEmailTemplate(Request $request, ?EmailTemplate $emailTemplate = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('email_templates', 'slug')->ignore($emailTemplate)],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
