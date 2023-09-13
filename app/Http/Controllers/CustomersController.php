<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomersController extends Controller
{
    public function all_users(){
        $customers = Customer::select('id','firstname','lastname','status','profile_picture')->get();

        $allCustomers = collect();
        foreach ($customers as $customer) {
            $tempCollection = (object) [
                'id' => $customer->id,
                'image' => ($customer->profile_picture != null) ? "https://api.tapolgroup.com/storage/documents/profile_pictures/".$customer->profile_picture : "https://api.tapolgroup.com/logo.svg",
                'name' => $customer->firstname." ".$customer->lastname,
                'status' => $customer->status
            ];

            $allCustomers = $allCustomers->concat([$tempCollection]);
        }

        return Inertia::render('Customers/Index',[
            'customers' => $allCustomers
        ]);
        // 0- active 1-suspended
    }
}
