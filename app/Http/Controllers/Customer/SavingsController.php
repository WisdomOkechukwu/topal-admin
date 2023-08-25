<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Saving;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SavingsController extends Controller
{
    public function savings(Customer $customer, Request $request){
        $savings = Saving::with('user')->where('customer_id', $customer->customer_id);
        if($request->status){
            $savings = $savings->where('type',$request->status);
        }

        if($request->date){
            $start = Carbon::parse($request->date)->startOfDay();
            $end = Carbon::parse($request->date)->endOfDay();
            $savings = $savings->whereBetween('maturity_date',[$start, $end]);
        }

        $savings = $savings->orderBy('id','DESC')->get();
        $savingsData = collect();

        foreach ($savings as $saving) {
            $tempCollection = (object) [
                'id' => $saving->id,
                'name' => $saving->user?->firstname . ' ' . $saving->user?->lastname,
                'interest' => round(($saving->interest_due / $saving->amount_to_save) * 100, 2),
                'status' => $saving->status,
                'duration' => Carbon::parse($saving->start_date)->diffInMonths(Carbon::parse($saving->maturity_date)),
                'expiration' => Carbon::parse($saving->maturity_date)->format('d F Y'),
            ];

            $savingsData = $savingsData->concat([$tempCollection]);
        }

        return Inertia::render('Customer/Catalog',[
            'customer' => $customer,
            'savings' => $savingsData,
        ]);
    }
}
