<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\AccountStatus;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        // validate
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required|confirmed',
        ]);
        // call service
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password)
        ]);

        // verify email
        // notify admin
        //response
        return response()->json([
            'token' => $user()->createToken()->plainTextToken,
        ]);
    }
}
