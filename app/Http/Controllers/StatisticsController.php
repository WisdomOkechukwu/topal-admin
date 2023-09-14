<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatisticsController extends Controller
{
    public function index(){
        $transaction = [
            [
                'name' => 'Saving',
                'type' => 'savings',
            ],
            [
                'name' => 'Loan',
                'type' => 'loan',
            ],
            [
                'name' => 'Wallet Top Up',
                'type' => 'wallet_topup',
            ],
            [
                'name' => 'Wallet Withdrawal',
                'type' => 'wallet_withdrawal',
            ],
            [
                'name' => 'Send Airtime',
                'type' => 'debit',
            ],
            [
                'name' => 'Data',
                'type' => 'data',
            ],
            [
                'name' => 'Cable',
                'type' => 'cable_tv',
            ],
            [
                'name' => 'Electricity',
                'type' => 'electricity',
            ],
            [
                'name' => 'Betting',
                'type' => 'bet',
            ],
        ];

        $transaction = collect($transaction);
        
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
