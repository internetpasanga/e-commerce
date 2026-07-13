<x-layouts.site title="Contact Us">
    <p class="breadcrumb"><a href="{{ route('home') }}">Home</a> / Contact Us</p>
    <h1 class="page-title">Contact Us</h1>

    <div class="contact-layout">
        <section class="card">
            <h2 class="section-title">Contact Information</h2>

            <div class="contact-info-list">
                @if (! empty($siteSettings['address']))
                    <div class="contact-info-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>{{ $siteSettings['address'] }}</span>
                    </div>
                @endif
                @if (! empty($siteSettings['phone']))
                    <div class="contact-info-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <a href="tel:{{ $siteSettings['phone'] }}">{{ $siteSettings['phone'] }}</a>
                    </div>
                @endif
                @if (! empty($siteSettings['email']))
                    <div class="contact-info-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16v16H4z" opacity="0"/><path d="M22 6 12 13 2 6"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                        <a href="mailto:{{ $siteSettings['email'] }}">{{ $siteSettings['email'] }}</a>
                    </div>
                @endif
            </div>

            @php
                $whatsappNumber = ! empty($siteSettings['whatsapp_number']) ? preg_replace('/\D/', '', $siteSettings['whatsapp_number']) : null;
            @endphp

            @if ($whatsappNumber || ! empty($siteSettings['social_facebook']) || ! empty($siteSettings['social_instagram']) || ! empty($siteSettings['social_twitter']) || ! empty($siteSettings['social_youtube']))
                <h2 class="section-title" style="margin-top: 1.75rem;">Follow Us</h2>

                <div class="social-links-grid">
                    @if ($whatsappNumber)
                        <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener" class="social-badge-link">
                            <span class="social-badge social-badge-whatsapp">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39a9.9 9.9 0 0 0 4.75 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.86 9.86 0 0 0 12.04 2zm0 18.13h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.14.82.84-3.06-.2-.32a8.2 8.2 0 0 1-1.26-4.37c0-4.54 3.7-8.24 8.26-8.24 2.2 0 4.27.86 5.83 2.42a8.18 8.18 0 0 1 2.41 5.83c0 4.55-3.7 8.25-8.24 8.25zm4.52-6.17c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.25-.64.81-.78.97-.14.17-.29.19-.53.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.48-1.39-1.73-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.16-.25.25-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.48-.4-.42-.56-.43-.14-.01-.31-.01-.48-.01-.16 0-.43.06-.66.31-.23.25-.86.85-.86 2.06 0 1.22.88 2.4 1.01 2.56.12.17 1.73 2.64 4.19 3.7.59.25 1.04.4 1.4.52.59.19 1.12.16 1.54.1.47-.07 1.47-.6 1.67-1.18.21-.58.21-1.07.14-1.18-.06-.1-.23-.16-.48-.29z"/></svg>
                            </span>
                            <span>WhatsApp</span>
                        </a>
                    @endif
                    @if (! empty($siteSettings['social_facebook']))
                        <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener" class="social-badge-link">
                            <span class="social-badge social-badge-facebook">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.77l-.44 2.89h-2.33v6.99A10 10 0 0 0 22 12z"/></svg>
                            </span>
                            <span>Facebook</span>
                        </a>
                    @endif
                    @if (! empty($siteSettings['social_instagram']))
                        <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener" class="social-badge-link">
                            <span class="social-badge social-badge-instagram">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
                            </span>
                            <span>Instagram</span>
                        </a>
                    @endif
                    @if (! empty($siteSettings['social_twitter']))
                        <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener" class="social-badge-link">
                            <span class="social-badge social-badge-twitter">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 5.9c-.77.35-1.6.58-2.46.68a4.3 4.3 0 0 0 1.88-2.37 8.6 8.6 0 0 1-2.72 1.04 4.28 4.28 0 0 0-7.29 3.9A12.14 12.14 0 0 1 2.9 4.9a4.28 4.28 0 0 0 1.32 5.71c-.7-.02-1.36-.22-1.94-.53v.05a4.28 4.28 0 0 0 3.43 4.2c-.65.18-1.34.2-1.99.08a4.29 4.29 0 0 0 4 2.98A8.6 8.6 0 0 1 1 19.08a12.1 12.1 0 0 0 6.56 1.92c7.88 0 12.2-6.53 12.2-12.2 0-.19 0-.37-.01-.56A8.7 8.7 0 0 0 22 5.9z"/></svg>
                            </span>
                            <span>Twitter</span>
                        </a>
                    @endif
                    @if (! empty($siteSettings['social_youtube']))
                        <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener" class="social-badge-link">
                            <span class="social-badge social-badge-youtube">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23 12s0-3.6-.46-5.32a3 3 0 0 0-2.1-2.13C18.7 4 12 4 12 4s-6.7 0-8.44.55a3 3 0 0 0-2.1 2.13C1 8.4 1 12 1 12s0 3.6.46 5.32a3 3 0 0 0 2.1 2.13C5.3 20 12 20 12 20s6.7 0 8.44-.55a3 3 0 0 0 2.1-2.13C23 15.6 23 12 23 12z"/><path d="M9.75 15.5v-7l6 3.5-6 3.5z" fill="#fff"/></svg>
                            </span>
                            <span>YouTube</span>
                        </a>
                    @endif
                </div>
            @endif
        </section>

        <section class="card">
            <h2 class="section-title">Send us a message</h2>

            @if (session('status'))
                <div class="alert alert-success">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('contact.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="subject" class="form-label">Subject</label>
                    <input id="subject" type="text" name="subject" value="{{ old('subject') }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="message" class="form-label">Message</label>
                    <textarea id="message" name="message" rows="5" required class="form-control">{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </section>
    </div>

    @if (! empty($siteSettings['address']))
        <section class="card contact-map-section">
            <div class="contact-map contact-map-large">
                <iframe
                    src="https://maps.google.com/maps?q={{ urlencode($siteSettings['address']) }}&output=embed"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen>
                </iframe>
            </div>
        </section>
    @endif
</x-layouts.site>
