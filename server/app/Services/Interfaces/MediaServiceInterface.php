<?php

namespace App\Services\Interfaces;

use App\Enums\MediaCollection;

interface MediaServiceInterface
{
    public function getUrl(string $disk, string $path);
    public function upload(array $payload);
    public function createMedia($file, MediaCollection $collection);
    public function updateMedia($file, MediaCollection $collection);
}
