<?php

namespace App\Http\Controllers\Api;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users|max:30',
            'email' => 'required|unique:users|email',
            'password' => 'required|max:100|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

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
            $validator = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'max:30',
                    Rule::unique('users')->ignore($user->id),
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->id),
                ],
                'password' => 'required|max:100|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 400);
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
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

    public function registerComment(Request $request, User $user)
    {
        $token = $request->bearerToken();
        if ($user->api_token == $token) {
            $user->comment = $request->comment;
            $user->save();
        } else {
            throw new AuthorizationException('you are not allowed to comment');
        }
    }
}
