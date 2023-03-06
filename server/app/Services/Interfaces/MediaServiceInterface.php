<?php

namespace App\Services\Interfaces;

interface MediaServiceInterface
{
    public function getTemporaryUrl($path);
    public function upload($file, $collection);
}
