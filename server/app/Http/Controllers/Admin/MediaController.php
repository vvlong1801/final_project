<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadRequest;
use App\Services\Interfaces\MediaServiceInterface;

class MediaController extends Controller
{
    protected $mediaService;
    public function __construct(MediaServiceInterface $mediaService)
    {
        $this->mediaService = $mediaService;
    }
    /**
     * Handle the incoming request.
     */
    public function upload(UploadRequest $request)
    {
        $input = $request->validated();
        $path = $this->mediaService->upload($input['image'], $input['collection']);
        return response()->json(["path" => $path]);
    }

    public function getTempUrl(String $collection, String $filename)
    {
        $path = $collection . '/' . $filename;
        $url  = $this->mediaService->getTemporaryUrl($path);
        return response()->json(["url" => $url]);
    }
}
