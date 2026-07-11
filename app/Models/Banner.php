<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public const TITLE_POSITIONS = [
        'center' => 'Center',
        'top' => 'Top',
        'bottom' => 'Bottom',
        'left' => 'Left',
        'right' => 'Right',
        'top-left' => 'Top Left',
        'top-right' => 'Top Right',
        'bottom-left' => 'Bottom Left',
        'bottom-right' => 'Bottom Right',
    ];

    protected $fillable = [
        'title',
        'sub_title',
        'image',
        'title_position',
        'button_text',
        'button_url',
        'button_color',
        'priority',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'priority' => 'integer',
        ];
    }
}
