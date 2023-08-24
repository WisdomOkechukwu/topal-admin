<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function PHPSTORM_META\type;

class TransactionController extends Controller
{
    public function transactions(Customer $customer, Request $request){
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
                'name' => $transaction->user->firstname . ' ' . $transaction->user->lastname,
                'type' => ucwords($transaction->type),
                'date' => Carbon::parse($transaction->created_at)->format('d F Y'),
            ];

            $transactionCollection = $transactionCollection->concat([$tempCollection]);
        }
        return Inertia::render('Customer/Catalog',[
            'customer' => $customer,
            'transactions' => $transactionCollection,
        ]);
    }

}
