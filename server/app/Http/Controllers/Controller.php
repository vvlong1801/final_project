<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function responseOk($data, $message = "success")
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => Response::HTTP_OK,
        ]);
    }

    public function responseNoContent($message = '')
    {
        return response()->json([
            'message' => $message,
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }
}
