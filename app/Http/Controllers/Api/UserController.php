<?php

namespace App\Http\Controllers\Api;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->api_token = Str::random(80);
        $user->save();
        return $user->api_token;
    }

    public function show(Request $request)
    {
        $token = $request->bearerToken();
        $user = User::where('api_token', $token)->first();
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $token = $request->bearerToken();
        if ($user->api_token == $token) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
        } else {
            throw new AuthorizationException('you are not allowed to update');
        }

    }

    public function destroy(Request $request, User $user)
    {
        $token = $request->bearerToken();
        if ($user->api_token == $token) {
            $user->delete();
        } else {
            throw new AuthorizationException('you are not allowed to delete');
        }
    }
}
