<?php

namespace App\Services\FileStorageStrategies;

interface FileStorageStrategyInterface
{
    public function getPath(): string;
}
