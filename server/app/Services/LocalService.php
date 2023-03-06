<?php

namespace App\Services;

use App\Enums\CommonStatus;
use App\Enums\MediaType;
use App\Models\Media;
use App\Services\Interfaces\MediaServiceInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class LocalService extends BaseService implements MediaServiceInterface
{
    protected Filesystem $tempDisk;
    protected Filesystem $disk;

    public function __construct()
    {
        $this->tempDisk = Storage::disk('public');
        $this->disk = Storage::disk('local');
    }

    public function getUrl($diskType, $path)
    {
        if ($diskType === 'local') {
            $this->disk->copy($path, 'public/' . $path);
        }
        return $this->tempDisk->url($path);
    }

    public function upload(array $payload)
    {
        $file = \Arr::get($payload, 'file', false);
        $collection = \Arr::get($payload, 'collection', false);
        $type = \Arr::get($payload, 'type', false);

        //save to temporary disk
        if ($file && $collection && $type) {
            $filename = $file->getClientOriginalName();
            $path =  $this->tempDisk->putFile($collection, $file);
            $typeValue = MediaType::fromName($type);
            return new Media([
                'path' => $path,
                'name' => $filename,
                'collection_name' => $collection,
                'type' => $typeValue,
                'disk' => 'public',
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
            $newPath = $collection . '/' . uniqid() . '-' . $filename;
            $typeValue = MediaType::fromName($type);
            $this->disk->copy('public/' . $path, $newPath);
            return new Media([
                'name' => $filename,
                'path' => $newPath,
                'type' => $typeValue,
                'collection_name' => $collection,
                'status' => CommonStatus::comming->value,
                'disk' => 'local'
            ]);
        } else return null;
    }
}
