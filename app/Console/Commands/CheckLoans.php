<?php

namespace App\Console\Commands;

use App\Models\Loan;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckLoans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-loans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // check if expired for approved loans
        $approvedLoans = Loan::where('status', 1)->get();
        foreach ($approvedLoans as $loan) {
            $loanEndDate = Carbon::parse($loan->loan_end_date);
            if(now() > $loanEndDate){
                $loan->status = 3;
                if($loan->paid_amount < $loan->total_repayment){
                    $remaining_amount = $loan->total_repayment - $loan->paid_amount;
                    $userWallet = Wallet::where('customer_id', $loan->customer_id)->first();
                    $userBalance = $userWallet->balance;

                    $balance = $userBalance - $remaining_amount;

                    if($balance < 0){
                        $userWallet->balance = 0;
                        $loan->paid_amount += $userBalance;
                        $loan->status = 4;
                    }

                    if($balance > 0) {
                        $userWallet->balance -= $remaining_amount;
                        $loan->paid_amount += $remaining_amount;
                    }

                    $userWallet->save();
                }
            }
            $loan->save();
        }
        Log::info('Loans Cron Job Done');
        return true;
    }
}
