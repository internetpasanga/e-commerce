<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('mail_templates', []) as $slug => $template) {
            EmailTemplate::query()->firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $template['name'],
                    'subject' => $template['subject'],
                    'body' => $template['body'],
                    'description' => $template['description'] ?? null,
                    'is_system' => true,
                    'is_active' => true,
                ]
            );
        }
    }
}
