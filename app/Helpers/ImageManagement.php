<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImageManagement
{
    private static $modifiedFileName = '';
    private static $DBFirendlyFileName = '';

    // --------------------------------------
    public static function storeFile($file, $title, $folder, $disk = 'public'): string
    {
        # Due to proprietary secrecy, code that contained business rules were removed
    }

    // --------------------------------------
    private static function sanitizeForFilename(string $input): string
    {
        $clean = preg_replace('/[^A-Za-z0-9\-_]/', '_', $input);
        return trim($clean, '_');
    }

    // --------------------------------------
    public static function getDirectoryFreeName(): string
    {
        return self::$modifiedFileName;
    }

    // --------------------------------------
    public static function getNewFileName(): string
    {
        return self::$DBFirendlyFileName;
    }
}
