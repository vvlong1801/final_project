<?php

namespace App\Services;

use App\Enums\MediaCollection;
use App\Enums\MediaDisk;
use App\Enums\MediaType;
use App\Enums\UploadCollection;
use App\Services\Interfaces\MediaServiceInterface;


class S3Service extends BaseService implements MediaServiceInterface
{
    public function getTemporaryUrl($path)
    {
    }

    public function upload($file, $collection)
    {
        $collectionLabel = in_array($collection, MediaCollection::getValues()) ? MediaCollection::fromValue($collection) : null;
        if ($collectionLabel) {
            return $file->store($collectionLabel, MediaDisk::temporaryS3);
        } else {
            return null;
        }
    }
}
