<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index(){
        $admin = User::limit(1)->first(); // change this after auth
        return Inertia::render('Profile/Index',[
            'admin' => $admin,
        ]);
    }

    public function update(User $user, Request $request){
        $request->validate([
            'first' => 'required',
            'last' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'pin'=> 'required|max:4',
        ]);

        $user->firstname = $request->first;
        $user->lastname = $request->last;
        $user->email = $request->email;
        $user->pin = $request->pin;
        $user->save();

        return back()->with('success','User Updated Successfully');

    }

    public function update_password(User $user ,Request $request){
        $request->validate([
            'password' => ['required','confirmed',Password::min(8)->mixedCase()->numbers()],
        ]);

        $user->password = Hash::make($request->password);
        // $user->pin = $request->password;
        $user->save();

        return back()->with('success','User Password Updated Successfully');
    }
}
