<?php

namespace App\Console\Commands;

use App\Models\Saving;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckSavings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-savings';

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
        $savings = Saving::where('status',0)->get();

        foreach ($savings as $saving) {
            $endDate = Carbon::parse($saving->maturity_date)->startOfDay();
            if(now() > $endDate){
                $saving->status = 1;
                $saving->save();

                $userWallet = Wallet::where('customer_id', $saving->customer_id)->first();
                $userWallet->balance += $saving->total_maturity_amount;
                $userWallet->save();
            }
        }
        Log::info('Savings Cron Job Done');
        return true;
    }
}
