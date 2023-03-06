<?php

namespace App\Services\Interfaces;

interface MediaServiceInterface
{
    public function getUrl(string $disk, string $path);
    public function upload(array $payload);
    public function createMedia(string $path);
}
