<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class StatisticsController extends Controller
{
    public function index(){
        $chartData = new OverviewController();

        return Inertia::render('Statistics/Index',[
            'transaction_options' => $chartData->renderTransactionsChart()->options,
            'transaction_series' => $chartData->renderTransactionsChart()->series,
            'loan_options' => $chartData->renderLoansChart()->options,
            'loan_series' => $chartData->renderLoansChart()->series,
        ]);
    }
}
