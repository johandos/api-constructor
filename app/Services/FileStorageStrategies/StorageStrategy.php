<?php

namespace App\Services\FileStorageStrategies;

use Illuminate\Support\Facades\Storage;

abstract class StorageStrategy implements FileStorageStrategyInterface
{
    public function getPath(): string
    {
        return Storage::disk($this->getDisk())->path($this->getDirectory());
    }

    abstract protected function getDisk(): string;

    abstract protected function getDirectory(): string;
}
