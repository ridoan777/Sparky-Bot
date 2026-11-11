<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait MediaUploadTrait
{
    public function uploadMedia(UploadedFile $file, string $mediaType): string
    {
        $folder = match ($mediaType) {
            'image' => 'uploads/posts/images',
            'video' => 'uploads/posts/videos',
            default => 'uploads/posts/others',
        };

        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $destination = public_path($folder);

        // Ensure folder exists
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Move file
        $file->move($destination, $filename);

        return $folder . '/' . $filename; // Only relative path stored in DB
    }
}

