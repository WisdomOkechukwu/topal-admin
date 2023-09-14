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
    public function index()
    {
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
        // $transaction = Transaction::select('type')->distinct('type')->get();
        // foreach($transaction as $t){
        //     $t->name = ucwords($t->type);
        //     if(str_contains($t->type,'_')){
        //         $t->name = (ucwords(str_replace('_', ' ', $t->type)));
        //     }
        // }

        $url = env('APP_ENV') == 'local' ? 'http://localhost:8000' : 'https://admin.tapolgroup.com';
        return Inertia::render('Overview/Index', [
            'transaction_options' => $this->renderTransactionsChart()->options,
            'transaction_series' => $this->renderTransactionsChart()->series,
            'loan_options' => $this->renderLoansChart()->options,
            'loan_series' => $this->renderLoansChart()->series,
            'saving_options' => $this->renderSavingsChart()->options,
            'saving_series' => $this->renderSavingsChart()->series,
            'transactions' => $this->transactions(),
            'transaction_dropdown' => $transaction,
            'url' => $url,
        ]);
    }

    public function transactions()
    {
        $transactions = Transaction::with('user')
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();
        $transactionCollection = collect();

        foreach ($transactions as $transaction) {
            $tempCollection = (object) [
                'id' => $transaction->id,
                'image' => $transaction->user?->profile_picture != null ? 'https://api.tapolgroup.com/storage/documents/profile_pictures/' . $transaction->user?->profile_picture : 'https://api.tapolgroup.com/logo.svg',
                'name' => $transaction->user?->firstname . ' ' . $transaction->user?->lastname,
                'type' => ucwords($transaction->type),
                'date' => Carbon::parse($transaction->created_at)->format('d F Y'),
            ];
            $transactionCollection = $transactionCollection->concat([$tempCollection]);
        }

        return $transactionCollection;
    }

    public function renderTransactionsChart($endDate = null, $month = 4)
    {
        $endDate = $endDate == null ? now() : $endDate;
        $startDate = $endDate
            ->copy()
            ->subMonths($month)
            ->startOfMonth();
        $endDate = $endDate->endOfMonth();

        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])->get();
        $months = [];
        $amount = [];

        for ($i = 0; $i <= $month; $i++) {
            $start = $startDate
                ->copy()
                ->addMonths($i)
                ->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $monthsTnx = $transactions->where('created_at', '>=', $start)->where('created_at', '<=', $end);
            $months[] = $start->format('F');
            $amount[] = $monthsTnx->sum('amount');
        }
        // dd($months, $amount);

        return $this->generateChartOptions($months, $amount);
    }

    public function renderLoansChart($endDate = null, $month = 4)
    {
        $endDate = $endDate == null ? now() : $endDate;
        $startDate = $endDate
            ->copy()
            ->subMonths($month)
            ->startOfMonth();
        $endDate = $endDate->endOfMonth();

        $loans = Loan::whereBetween('created_at', [$startDate, $endDate])->get();
        $months = [];
        $amount = [];

        for ($i = 0; $i <= $month; $i++) {
            $start = $startDate
                ->copy()
                ->addMonths($i)
                ->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $monthsTnx = $loans->where('created_at', '>=', $start)->where('created_at', '<=', $end);
            $months[] = $start->format('F');
            $amount[] = $monthsTnx->sum('amount');
        }

        return $this->generateChartOptions($months, $amount);
    }

    public function renderSavingsChart($endDate = null, $month = 4)
    {
        $endDate = $endDate == null ? now() : $endDate;
        $startDate = $endDate
            ->copy()
            ->subMonths($month)
            ->startOfMonth();
        $endDate = $endDate->endOfMonth();

        $savings = Saving::whereBetween('created_at', [$startDate, $endDate])->get();
        $months = [];
        $amount = [];

        for ($i = 0; $i <= $month; $i++) {
            $start = $startDate
                ->copy()
                ->addMonths($i)
                ->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $monthsTnx = $savings->where('created_at', '>=', $start)->where('created_at', '<=', $end);
            $months[] = $start->format('F');
            $amount[] = $monthsTnx->sum('amount_to_save');
        }

        return $this->generateChartOptions($months, $amount);
    }

    public function generateChartOptions($categories, $data)
    {
        $options = (object) [
            'chart' => (object) [
                'id' => 'Chart',
            ],
            'xaxis' => (object) [
                'categories' => $categories,
            ],
            'colors' => ['#753F8D'],
            'dataLabels' => (object) [
                'enabled' => false,
            ],
            'chart' => (object) [
                'animations' => (object) [
                    'enabled' => true,
                    'easing' => 'easeinout',
                    'speed' => 800,
                    'animateGradually' => (object) [
                        'enabled' => true,
                        'delay' => 150,
                    ],
                    'dynamicAnimation' => (object) [
                        'enabled' => true,
                        'speed' => 350,
                    ],
                ],
            ],
        ];

        $series = [
            (object) [
                'name' => 'data',
                'data' => $data,
            ],
        ];

        return (object) [
            'options' => $options,
            'series' => $series,
        ];
    }
}
