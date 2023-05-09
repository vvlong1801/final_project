<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadRequest;
use App\Http\Resources\MediaResource;
use App\Services\Interfaces\MediaServiceInterface;
use Symfony\Component\HttpFoundation\Response;

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
        try {
            $payload = $request->validated();
            $media = $this->mediaService->upload($payload);
            return $this->responseOk(new MediaResource($media), 'upload is success');
        } catch (\Throwable $th) {
            abort(Response::HTTP_BAD_REQUEST);
        }
    }

    public function getTempUrl(String $collection, String $filename)
    {
        $path = $collection . '/' . $filename;
        $url  = $this->mediaService->getTemporaryUrl($path);
        return response()->json(["url" => $url]);
    }
}
