<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show($customer){
        $customer = Customer::find($customer);
        if(!$customer) return redirect()->route('customers.profile')->with('error','Error Finding User');
        $admin = User::where('email',$customer->email)->first();

        return Inertia::render('Customer/Profile',[
            'customer' => $customer,
            'is_admin' => ($admin) ? 1 : 0,
        ]);
    }

    public function update(Customer $customer, Request $request){
        $request->validate([
            'first' => 'required',
            'last' => 'required',
            'email' => 'required|unique:customers,email,' . $customer->id,
            'phone'=> 'required|unique:customers,telephone,' . $customer->id,
            'gender'=> 'required',
            'employee_status'=> 'required',
            'marital_status'=> 'required',
        ]);

        $customer->firstname = $request->first;
        $customer->lastname = $request->last;
        $customer->email = $request->email;
        $customer->telephone = $request->phone;
        $customer->gender = $request->gender;
        $customer->employment_status = $request->employee_status;
        $customer->marital_status = $request->marital_status;
        $customer->save();

        return back()->with('success','User Updated Successfully');

    }

    public function update_password(Customer $customer ,Request $request){
        $request->validate([
            'password' => ['required','confirmed',Password::min(8)->mixedCase()->numbers()],
        ]);

        $customer->password = md5($request->password);
        $customer->save();

        return back()->with('success','User Password Updated Successfully');
    }

    public function update_to_admin(Customer $customer, Request $request){

        $user = New User();
        $user->authid = Str::random(7);
        $user->firstname = $customer->firstname;
        $user->lastname = $customer->lastname;
        $user->email = $customer->email;
        $user->pin = 0000; //default pin
        $user->password = Hash::make('12345678');
        $user->save();

        return back()->with('success','Admin Link Created');
    }

    public function downgradeAdmin(Customer $customer, Request $request){
        User::where('email', $customer->email)->delete();
        return back()->with('success','Admin Privilege Revoked');
    }

    public function delete(Request $request){
        $user = Customer::find($request->id);
        $user->delete();

        return redirect()->route('customers.profile')->with('success','User Deleted Successfully');
    }
}
