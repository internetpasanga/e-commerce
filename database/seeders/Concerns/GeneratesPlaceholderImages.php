<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait GeneratesPlaceholderImages
{
    protected function placeholderImage(string $directory, string $label, string $bgHex = '#4f46e5', int $width = 800, int $height = 800): string
    {
        [$r, $g, $b] = sscanf($bgHex, '#%02x%02x%02x');

        $image = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($image, $r, $g, $b);
        imagefill($image, 0, 0, $bg);

        $white = imagecolorallocate($image, 255, 255, 255);
        $font = 5;
        $textWidth = imagefontwidth($font) * strlen($label);
        $textHeight = imagefontheight($font);
        $x = max((int) (($width - $textWidth) / 2), 8);
        $y = (int) (($height - $textHeight) / 2);
        imagestring($image, $font, $x, $y, $label, $white);

        ob_start();
        imagepng($image);
        $contents = ob_get_clean();
        imagedestroy($image);

        $filename = $directory.'/'.Str::random(24).'.png';
        Storage::disk('public')->put($filename, $contents);

        return $filename;
    }
}
