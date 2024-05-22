<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard',compact('users'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if(!$user){
            return "Usuario no encontrado";
        }

        $user -> active = $request->active;
        $user->save();
    }

}
