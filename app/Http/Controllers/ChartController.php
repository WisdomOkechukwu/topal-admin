<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Saving;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function transactions($date = NULL, $status = NULL){
        $endDate = ($date == NULL) ? now() : Carbon::parse($date);
        $startDate = $endDate->copy()->subMonths(4)->startOfMonth();
        $endDate = $endDate->endOfMonth();

        $transactions = Transaction::whereBetween('created_at',[$startDate,$endDate]);

        if($status != NULL or $status != ''){
            $transactions = $transactions->where('type',$status);
        }

        $transactions = $transactions->get();

        $months = [];
        $amount = [];

        for ($i=0; $i <= 4; $i++) {
            $start = $startDate->copy()->addMonths($i)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $monthsTnx = $transactions->where('created_at','>=',$start)->where('created_at','<=',$end);
            $months[] = $start->format('F');
            $amount[] = $monthsTnx->sum('amount');
        }
        // dd($months, $amount);

        return $this->generateChartOptions($months, $amount);
    }

    public function savings($date = NULL, $status = NULL){
        $endDate = ($date == NULL) ? now() : Carbon::parse($date);
        $startDate = $endDate->copy()->subMonths(4)->startOfMonth();
        $endDate = $endDate->endOfMonth();

        $savings = Saving::whereBetween('created_at',[$startDate,$endDate]);

        if($status != NULL or $status != ''){
            $savings = $savings->where('status',$status);
        }

        $savings = $savings->get();
        $months = [];
        $amount = [];

        for ($i=0; $i <= 4; $i++) {
            $start = $startDate->copy()->addMonths($i)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $monthsTnx = $savings->where('created_at','>=',$start)->where('created_at','<=',$end);
            $months[] = $start->format('F');
            $amount[] = $monthsTnx->sum('amount_to_save');
        }
        // dd($months, $amount);

        return $this->generateChartOptions($months, $amount);
    }

    public function loans($date = NULL, $status = NULL){
        $endDate = ($date == NULL) ? now() : Carbon::parse($date);
        $startDate = $endDate->copy()->subMonths(4)->startOfMonth();
        $endDate = $endDate->endOfMonth();

        $loans = Loan::whereBetween('created_at',[$startDate,$endDate]);
        $months = [];
        $amount = [];

        if($status != NULL or $status != ''){
            $loans = $loans->where('status',$status);
        }

        $loans = $loans->get();

        for ($i=0; $i <= 4; $i++) {
            $start = $startDate->copy()->addMonths($i)->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $monthsTnx = $loans->where('created_at','>=',$start)->where('created_at','<=',$end);
            $months[] = $start->format('F');
            $amount[] = $monthsTnx->sum('amount');
        }
        // dd($months, $amount);

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
