<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class LoansController extends Controller
{
    public function index(Request $request){
        $loans = Loan::with('user');
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
                'loan_type' => $loan->loan_purpose,
                'status' => $loan->status,
                'duration' => $loan->duration." Months",
                'expiration_date' => $loan->loan_end_date ? Carbon::parse($loan->loan_end_date)->format('d F Y') : 'Loan Pending',
            ];

            $loanData = $loanData->concat([$tempCollection]);
        }

        return Inertia::render('Loans/Index',[
            'loans' => $loanData
        ]);
    }

    public function show(Loan $loan){
        $user = $loan->user?;

        $options = [
            'join' => ', ',
            'parts' => 2,
            'syntax' => CarbonInterface::DIFF_ABSOLUTE,
        ];

        $loanData = collect(
            (object) [
                'id' => $loan->id,
                'name' => $user->firstname . ' ' . $user->lastname,
                'loan_type' => $loan->loan_purpose,
                'status' => $loan->status,
                'duration' => $loan->duration." Months",
                'expiration_date' => $loan->loan_end_date ? Carbon::parse($loan->loan_end_date)->format('d F Y') : 'Loan Pending',
                'date' => Carbon::parse($loan->start_date)->format('d F Y'),
                'time' => Carbon::parse($loan->start_date)->format('h:ia'),
                'interest' => round(($loan->amount / $loan->total_repayment) * 100, 2),
                'amount' => 'NGN ' . number_format($loan->amount,2),
                'monthly_amount' =>  number_format($loan->total_repayment,2),
                'paid_back' => 0.00,
                'duration_left' => $loan->loan_end_date
                ? now()->diffForHumans(Carbon::parse($loan->loan_end_date), $options).' left'
                : 'Loan not ongoing'
            ],
        );
        // dd($loanData);

        return Inertia::render('Loans/Show', [
            'user' => $user,
            'loan' => $loanData,
        ]);
    }

    public function approve(Request $request){
        $loan = Loan::find($request->loan_id);
        if(!$loan){
            return back()->with('error','Loan not found');
        }

        if($loan->status !== 0){
            return back()->with('error','Loan is not pending for approval');
        }

        if($request->pin != Auth::user()->pin){
            return back()->with('error','incorrect pin');
        }

        $loan->status = 1;
        $loan->disbursed_date = now();
        $loan->loan_start_date = now();
        $loan->loan_end_date = now()->addMonths($loan->duration);
        $loan->save();

        $message = "Loan for ".$loan->loan_purpose." worth NGN".number_format($loan->amount)." has been approved";

        try{
            $client = new Client();
            $loginUrl = 'http://localhost:3000/api/loan/mailer/send';

            $approve = $client->request('POST', $loginUrl, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' =>  [
                    "type" => "approve",
                    "customer_id" => $loan->customer_id,
                    "loanid" => $loan->loanid,
                    "amount" => $loan->amount,
                    "monthly_repayment" => $loan->monthly_repayment,
                    "duration" => $loan->duration,
                    "message" => $message
                ]
            ]);
        } catch(\Throwable $e){
            return Log::alert('Error '.$e->getMessage());
        }

        return back()->with('success','loan approved');
    }

    public function decline(Request $request){
        $loan = Loan::find($request->loan_id);
        if(!$loan){
            return back()->with('error','Loan not found');
        }

        if($loan->status !== 0){
            return back()->with('error','Loan is not pending for approval');
        }

        if($request->pin != Auth::user()->pin){
            return back()->with('error','incorrect pin');
        }

        $loan->status = 2;
        $loan->save();

        $message = "Loan for ".$loan->loan_purpose." worth NGN".number_format($loan->amount)." has been declined";

        try{
            $client = new Client();
            $loginUrl = 'http://localhost:3000/api/loan/mailer/send';

            $decline = $client->request('POST', $loginUrl, [
                'headers' => ['Content-Type' => 'application/json'],
                'json' =>  [
                    "type" => "decline",
                    "customer_id" => $loan->customer_id,
                    "loanid" => $loan->loanid,
                    "amount" => $loan->amount,
                    "monthly_repayment" => $loan->monthly_repayment,
                    "duration" => $loan->duration,
                    "message" => $message
                ]
            ]);
        } catch(\Throwable $e){
            return Log::alert('Error '.$e->getMessage());
        }

        return back()->with('success','loan declined');
    }
}
