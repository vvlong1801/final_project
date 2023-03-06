<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Http\Requests\Admin\UploadRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function getResponse($data, $message, $status = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status,
        ]);
    }

    public function getUploadTemporaryUrl(string $collection)
    {
        $filenameUpload = $collection . '/' . uniqid() . '-' . now()->timestamp;
        $tmpUploadUrl = Storage::disk('s3-tmp')->temporaryUploadUrl($filenameUpload, now()->addMinutes(5));
        return response()->json($tmpUploadUrl);
    }

    public function upload(UploadRequest $request)
    {
        $input = $request->validated();
        $file = $input['fileUpload'];
        $path = $file->store($input['collection'], 's3-tmp');
        return response()->json(["path" => $path]);
    }
}
