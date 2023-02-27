<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        // dd($request->user());
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'success',
        ]);
    }
}
