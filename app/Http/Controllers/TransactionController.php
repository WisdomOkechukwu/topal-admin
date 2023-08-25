<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index(Request $request){
        $transactions = Transaction::with('user');

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
                'type' => ucwords($transaction->type),
                'date' => Carbon::parse($transaction->created_at)->format('d F Y'),
            ];

            $transactionCollection = $transactionCollection->concat([$tempCollection]);
        }
        return Inertia::render('Transactions/Index',[
            'transactions' => $transactionCollection,
        ]);
    }

    public function show(Transaction $transaction){
        $transactionData = collect(
            (object) [
                'id' => $transaction->id,
                'name' => $transaction->user?->firstname . ' ' . $transaction->user?->lastname,
                'type' => ucwords($transaction->type),
                'date' => Carbon::parse($transaction->created_at)->format('d F Y'),
                'time' => Carbon::parse($transaction->created_at)->format('h:ia'),
                'amount' => 'NGN' . number_format($transaction->amount),
                'description' => $transaction->message,
            ],
        );
        return Inertia::render('Transactions/Show',[
            'transaction' => $transactionData,
        ]);
    }
}
