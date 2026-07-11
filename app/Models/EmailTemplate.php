<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'subject',
        'body',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_system' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Render a template's subject and body, substituting {{ variable }} placeholders.
     *
     * @param  array<string, string>  $variables
     * @return array{subject: string, body: string}
     */
    public static function render(string $slug, array $variables = []): array
    {
        $template = static::query()->where('slug', $slug)->where('is_active', true)->first();

        if ($template) {
            $subject = $template->subject;
            $body = $template->body;
        } else {
            $default = config("mail_templates.{$slug}", []);
            $subject = $default['subject'] ?? '';
            $body = $default['body'] ?? '';
        }

        $replace = function (string $text) use ($variables): string {
            return preg_replace_callback('/\{\{\s*(\w+)\s*\}\}/', function ($matches) use ($variables) {
                return $variables[$matches[1]] ?? $matches[0];
            }, $text);
        };

        return [
            'subject' => $replace($subject),
            'body' => $replace($body),
        ];
    }
}
