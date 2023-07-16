<?php

namespace App\Services\FileStorageStrategies;

class PolizasStorageStrategy extends StorageStrategy
{
    protected function getDisk(): string
    {
        return 'public';
    }

    protected function getDirectory(): string
    {
        return 'polizas';
    }
}
