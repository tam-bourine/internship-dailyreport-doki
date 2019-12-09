<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

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
        $user->email_verified_at = $request->email_verified_at;
        $user->password = $request->password;
        $user->remember_token = $request->remember_token;
        $user->save();
    }

    public function show($id)
    {
        $user = User::find($id);
        return $user;
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->body = $request->body;
        $user->save();
        return redirect('api/users'.$id);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('api/users');
    }
}
