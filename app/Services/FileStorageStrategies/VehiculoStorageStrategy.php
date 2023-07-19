<?php

namespace App\Services\FileStorageStrategies;

class VehiculoStorageStrategy extends StorageStrategy
{
    protected function getDisk(): string
    {
        return 'public';
    }

    protected function getDirectory(): string
    {
        return 'vehiculos';
    }
}
