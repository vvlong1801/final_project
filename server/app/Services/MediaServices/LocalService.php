<?php

namespace App\Services\MediaServices;

use App\Enums\CommonStatus;
use App\Enums\MediaCollection;
use App\Enums\MediaType;
use App\Enums\TypeMedia;
use App\Models\Media;
use App\Services\BaseService;
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
        try {
            $file = \Arr::get($payload, 'file');
            $filename = $file->getClientOriginalName();
            // save file to temp storage
            $path =  $this->tempDisk->putFile(MediaCollection::Temporary->value, $file);
            $type = TypeMedia::getType($file->extension());

            // save to database
            return Media::create([
                'path' => $path,
                'name' => $filename,
                'collection_name' => MediaCollection::Temporary,
                'type' => $type,
                'disk' => 'local-tmp',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createMedia($file, $collection)
    {
        $path = $file['path'];
        $filename = $file['filename'];
        // check existed in temp disk
        $existedInStorage = $this->tempDisk->exists($path);
        if (!$existedInStorage) throw new \Exception("not found temporary file", 1);



        // create media instance
        $newPath = $collection->value . '/' . uniqid() . '-' . $filename;
        $this->disk->copy('public/' . $path, $newPath);
        // delete in database
        $tempMedia = Media::where('disk', 'local-tmp')->where('path', $path)
            ->where('name', $filename)->first();

        $type = $tempMedia->type;

        return new Media([
            'name' => $filename,
            'path' => $newPath,
            'type' => $type,
            'collection_name' => $collection,
            'status' => CommonStatus::comming,
            'disk' => 'local'
        ]);
    }

    public function updateMedia($file, $collection)
    {
        // select disk of media in database
        $media = Media::wherePath($file['path'])->whereName($file['filename'])->first();

        // if existed media in local disk then return
        // if existed media in temp disk then create
        if ($media->disk === 'local') {
            return;
        } else {
            return $this->createMedia($file, $collection);
        }
    }
}
