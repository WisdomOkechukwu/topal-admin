<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoansController extends Controller
{
    public function loans(Customer $customer, Request $request){

        $loans_collected = Loan::where('customer_id', $customer->customer_id)->whereNotIn('status',[0,2,4])->sum('amount');
        $loans_paid = Loan::where('customer_id', $customer->customer_id)->whereNotIn('status',[0,2,4])->sum('paid_amount');
        $loans = Loan::with('user')->where('customer_id', $customer->customer_id);
        if($request->status){
            $loans = $loans->where('type',$request->status);
        }

        if($request->date){
            $start = Carbon::parse($request->date)->startOfDay();
            $end = Carbon::parse($request->date)->endOfDay();
            $loans = $loans->whereBetween('created_at',[$start, $end]);
        }

        $loans = $loans->orderBy('id','DESC')->get();
        $loanData = collect();

        foreach ($loans as $loan) {
            $tempCollection = (object) [
                'id' => $loan->id,
                'name' => $loan->user?->firstname . ' ' . $loan->user?->lastname,
                'image' => ($loan->user?->profile_picture != null) ? "https://api.tapolgroup.com/storage/documents/profile_pictures/".$loan->user?->profile_picture : "https://api.tapolgroup.com/logo.svg",
                'loan_type' => $loan->loan_purpose,
                'status' => $loan->status,
                'duration' => $loan->duration." Months",
                'expiration_date' => $loan->loan_end_date ? Carbon::parse($loan->loan_end_date)->format('d F Y') : 'Loan Pending',
            ];

            $loanData = $loanData->concat([$tempCollection]);
        }

        return Inertia::render('Customer/Catalog',[
            'customer' => $customer,
            'loans' => $loanData,
            'loans_collected' => number_format($loans_collected),
            'loans_paid' => number_format($loans_paid)
        ]);
    }
}
