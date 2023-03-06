<?php

namespace App\Services;

use App\Enums\MediaCollection;
use App\Enums\MediaDisk;
use App\Services\Interfaces\MediaServiceInterface;
use Illuminate\Support\Facades\Storage;

class LocalService extends BaseService implements MediaServiceInterface
{
    public function getTemporaryUrl($path)
    {
        $disk = Storage::disk(MediaDisk::public);
        if (($path !== null) && $disk->exists($path)) {
            return $disk->url($path);
        } else return null;
    }

    public function upload($file, $collection)
    {
        $collectionName = in_array($collection, MediaCollection::getValues()) ? MediaCollection::fromValue($collection) : null;
        if ($collectionName) {
            return $file->store($collectionName, MediaDisk::public);
        } else {
            return null;
        }
    }
}
