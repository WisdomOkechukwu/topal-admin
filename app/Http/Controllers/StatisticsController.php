<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatisticsController extends Controller
{
    public function index(){
        $transaction = Transaction::select('type')->distinct('type')->get();
        foreach($transaction as $t){
            $t->name = ucwords($t->type);
            if(str_contains($t->type,'_')){
                $t->name = (ucwords(str_replace('_', ' ', $t->type)));
            }
        }
        $chartData = new OverviewController();
        $url = (env('APP_ENV') == 'local' ? 'http://localhost:8000' : 'https://admin.tapolgroup.com');
        return Inertia::render('Statistics/Index',[
            'transaction_options' => $chartData->renderTransactionsChart()->options,
            'transaction_series' => $chartData->renderTransactionsChart()->series,
            'loan_options' => $chartData->renderLoansChart()->options,
            'loan_series' => $chartData->renderLoansChart()->series,
            'transaction_dropdown' => $transaction,
            'url' => $url
        ]);
    }
}
