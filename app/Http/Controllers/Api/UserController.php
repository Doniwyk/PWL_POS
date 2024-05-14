<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return UserModel::all();
    }
    public function store(Request $request){
        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);
        return response()->json($user, 201);
    }
    public function show(UserModel $user){
        return UserModel::find($user->user_id);
    }
    public function update(Request $request, UserModel $user){
        $user->update([
            'username' => $request->username ? $request->username : $user->username,
            'nama' => $request->nama ? $request->nama : $user->nama,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'level_id' => $request->level_id ? $request->level_id : $user->level_id,
        ]);
        return $user;
    }
    public function destroy(UserModel $user){
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus'
        ]);
    }
}