<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Saving;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OverviewController extends Controller
{
    public function index(){
        return Inertia::render('Overview/Index',[
            'transaction_options' => $this->renderTransactionsChart()->options,
            'transaction_series' => $this->renderTransactionsChart()->series,
            'loan_options' => $this->renderLoansChart()->options,
            'loan_series' => $this->renderLoansChart()->series,
            'saving_options' => $this->renderSavingsChart()->options,
            'saving_series' => $this->renderSavingsChart()->series,
            'transactions' => $this->transactions(),
        ]);
    }

    public function transactions(){
        $transactions = Transaction::with('user')->orderBy('id','DESC')->limit(10)->get();
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

        return $transactionCollection;
    }

    public function renderTransactionsChart($endDate = NULL, $month = 4){

        $endDate = ($endDate == NULL) ? now() : $endDate;
        $startDate = $endDate->copy()->subMonths($month)->startOfMonth();
        $endDate = $endDate->endOfMonth();

        $transactions = Transaction::whereBetween('created_at',[$startDate,$endDate])->get();
        $months = [];
        $amount = [];

        for ($i=0; $i <= $month; $i++) {
            $start = $startDate->copy()->addMonths($i)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $monthsTnx = $transactions->where('created_at','>=',$start)->where('created_at','<=',$end);
            $months[] = $start->format('F');
            $amount[] = $monthsTnx->sum('amount');
        }
        // dd($months, $amount);

        return $this->generateChartOptions($months, $amount);

    }

    public function renderLoansChart($endDate = NULL, $month = 4){
        $endDate = ($endDate == NULL) ? now() : $endDate;
        $startDate = $endDate->copy()->subMonths($month)->startOfMonth();
        $endDate = $endDate->endOfMonth();

        $loans = Loan::whereBetween('created_at',[$startDate,$endDate])->get();
        $months = [];
        $amount = [];

        for ($i=0; $i <= $month; $i++) {
            $start = $startDate->copy()->addMonths($i)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $monthsTnx = $loans->where('created_at','>=',$start)->where('created_at','<=',$end);
            $months[] = $start->format('F');
            $amount[] = $monthsTnx->sum('amount');
        }

        return $this->generateChartOptions($months, $amount);
    }

    public function renderSavingsChart($endDate = NULL, $month = 4){
        $endDate = ($endDate == NULL) ? now() : $endDate;
        $startDate = $endDate->copy()->subMonths($month)->startOfMonth();
        $endDate = $endDate->endOfMonth();

        $savings = Saving::whereBetween('created_at',[$startDate,$endDate])->get();
        $months = [];
        $amount = [];

        for ($i=0; $i <= $month; $i++) {
            $start = $startDate->copy()->addMonths($i)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $monthsTnx = $savings->where('created_at','>=',$start)->where('created_at','<=',$end);
            $months[] = $start->format('F');
            $amount[] = $monthsTnx->sum('amount_to_save');
        }

        return $this->generateChartOptions($months, $amount);
    }

    public function generateChartOptions($categories, $data){
        $options = (Object)[
            'chart' => (Object)[
                'id' => 'Chart'
            ],
            'xaxis' => (Object)[
                'categories' => $categories
            ],
            'colors'=> ['#753F8D'],
            'dataLabels' => (object)[
                'enabled' => false
            ],
            'chart' => (Object)[
                'animations' => (Object)[
                    'enabled' => true,
                    'easing' => 'easeinout',
                    'speed' => 800,
                    'animateGradually' => (Object)[
                        'enabled' => true,
                        'delay' => 150
                    ],
                    'dynamicAnimation' => (Object)[
                        'enabled' => true,
                        'speed' =>350
                    ]
                ]
            ]
        ];

        $series = [(Object)[
            'name'=> 'data',
            'data'=> $data
        ]];

        return (Object)[
            'options' => $options,
            'series' => $series
        ];
    }
}
