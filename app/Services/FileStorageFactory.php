<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileStorageFactory
{
    public static function create(string $type): string
    {
        return match ($type) {
            'poliza' => Storage::disk('public')->path('polizas'),
            default => Storage::disk('public')->path('otros'),
        };
    }
}
