<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Loan;
use App\Models\Saving;
use App\Models\Transaction;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function PHPSTORM_META\type;

class TransactionController extends Controller
{
    public function transactions(Customer $customer, Request $request){
        $loans_collected = Loan::where('customer_id', $customer->customer_id)->whereNotIn('status',[0,2,4])->sum('amount');
        $wallet = Wallet::where('customer_id', $customer->customer_id)->first()->balance;
        $savings = Saving::where('customer_id', $customer->customer_id)->sum('amount_to_save');

        $transactions = Transaction::with('user')->where('customer_id', $customer->customer_id);

        if($request->status){
            $transactions = $transactions->where('type',$request->status);
        }

        if($request->date){
            $start = Carbon::parse($request->date)->startOfDay();
            $end = Carbon::parse($request->date)->endOfDay();
            $transactions = $transactions->whereBetween('created_at',[$start, $end]);
        }

        $transactions = $transactions->orderBy('id','DESC')->get();
        $transactionCollection = collect();

        foreach ($transactions as $transaction) {
            $tempCollection = (Object)[
                'id' => $transaction->id,
                'name' => $transaction->user?->firstname . ' ' . $transaction->user?->lastname,
                'image' => ($transaction->user?->profile_picture != null) ? "https://api.tapolgroup.com/storage/documents/profile_pictures/".$transaction->user?->profile_picture : "https://api.tapolgroup.com/logo.svg",
                'type' => ucwords($transaction->type),
                'date' => Carbon::parse($transaction->created_at)->format('d F Y'),
            ];

            $transactionCollection = $transactionCollection->concat([$tempCollection]);
        }
        return Inertia::render('Customer/Catalog',[
            'customer' => $customer,
            'transactions' => $transactionCollection,
            'loans_collected' => number_format($loans_collected),
            'wallet_data' => number_format($wallet),
            'savings_data' => number_format($savings),
        ]);
    }

}
