<?php

namespace App\Services;

use App\Enums\CommonStatus;
use App\Enums\MediaType;
use App\Models\Media;
use App\Services\Interfaces\MediaServiceInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class S3Service extends BaseService implements MediaServiceInterface
{
    protected Filesystem $tempDisk;
    protected Filesystem $disk;

    public function __construct()
    {
        $this->tempDisk = Storage::disk('s3-tmp');
        $this->disk = Storage::disk('s3');
    }

    public function getUrl($diskType, string $path)
    {
        return $diskType == 's3' ? $this->disk->temporaryUrl($path, now()->addDay()) : $this->tempDisk->temporaryUrl($path, now()->addDay());
    }

    public function upload($payload)
    {
        $file = \Arr::get($payload, 'file', false);
        $collection = \Arr::get($payload, 'collection', false);
        $type = \Arr::get($payload, 'type', false);
        if ($file && $collection && $type) {
            $filename = $file->getClientOriginalName();
            $path =  $this->tempDisk->putFile($collection, $file);
            $typeValue = MediaType::fromName($type);
            return new Media([
                'path' => $path,
                'name' => $filename,
                'collection_name' => $collection,
                'type' => $typeValue,
                'disk' => 's3-tmp',
            ]);
        } else {
            return null;
        }
    }

    public function createMedia($file)
    {
        $path = \Arr::get($file, 'path', false);
        $filename = \Arr::get($file, 'filename', false);
        $type = \Arr::get($file, 'type', false);
        $collection = \Arr::get($file, 'collection', '');

        if ($path && $this->tempDisk->exists($path) && $filename) {
            $newPath =  $collection . '/' . uniqid() . '-' . $filename;
            $typeValue = MediaType::fromName($type);

            $result = $this->disk->getClient()->copyObject([
                'Bucket' => env('AWS_BUCKET'),
                'CopySource' => env('AWS_BUCKET_TMP') . '/' . $path,
                'Key' => $newPath,
            ]);
            if ($result['@metadata']['statusCode'] == 200) {
                return new Media([
                    'name' => $filename,
                    'path' => $newPath,
                    'type' => $typeValue,
                    'collection_name' => $collection,
                    'status' => CommonStatus::comming->value,
                    'disk' => 's3'
                ]);
            } else return null;
        } else return null;
    }
}
