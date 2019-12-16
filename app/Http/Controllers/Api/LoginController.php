<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where("email", $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            $api_token = Str::random();
            $user->api_token = $api_token;
            $user->save();
            return $api_token;
        } else {
            abort(401);
        }
    }
}
