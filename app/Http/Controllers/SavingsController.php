<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SavingsController extends Controller
{
    public function index( Request $request )
    {
        $savings = Saving::with('user');

        if ($request->name) {
            $name = $request->name;
            $savings = $savings->WhereHas('user', function ($query) use ($name) {
                $query->where('firstname', 'like', '%' . $name . '%')->orWhere('lastname', 'like', '%' . $name . '%');
            });
        }

        if ($request->date) {
            $start_date = Carbon::parse($request->date)->startOfDay();
            $end_date = Carbon::parse($request->date)->endOfDay();

            $savings = $savings->whereBetween('created_at', [$start_date, $end_date]);
        }

        if ($request->status) {
            $savings = $savings->where('status', $request->status);
        }

        $savings = $savings->orderBy('id','DESC')->get();
        $savingsData = collect();
        foreach ($savings as $saving) {
            $tempCollection = (object) [
                'id' => $saving->id,
                'name' => $saving->user?->firstname . ' ' . $saving->user?->lastname,
                'interest' => round(($saving->interest_due / $saving->amount_to_save) * 100, 2),
                'status' => $saving->status,
                'duration' => Carbon::parse($saving->start_date)->diffInMonths(Carbon::parse($saving->maturity_date)),
                'expiration' => Carbon::parse($saving->maturity_date)->format('d F Y'),
            ];

            $savingsData = $savingsData->concat([$tempCollection]);
        }
        return Inertia::render('Savings/Index', [
            'savings' => $savingsData,
        ]);
    }

    public function show(Saving $saving)
    {
        $user = $saving->user;

        $options = [
            'join' => ', ',
            'parts' => 2,
            'syntax' => CarbonInterface::DIFF_ABSOLUTE,
        ];

        $duration_left = '';
        if (now() > Carbon::parse($saving->maturity_date)) {
            $duration_left = 'done';
        } else {
            $duration_left = now()->diffForHumans(Carbon::parse($saving->maturity_date), $options);
        }

        $savingsData = collect(
            (object) [
                'id' => $saving->id,
                'interest' => round(($saving->interest_due / $saving->amount_to_save) * 100, 2),
                'status' => $saving->status == 0 ? 'Active' : 'Completed',
                'duration' => Carbon::parse($saving->start_date)->diffInMonths(Carbon::parse($saving->maturity_date)),
                'expiration' => Carbon::parse($saving->maturity_date)->format('d F Y'),
                'date' => Carbon::parse($saving->start_date)->format('d F Y'),
                'time' => Carbon::parse($saving->start_date)->format('h:ia'),
                'entry' => 'NGN' . $saving->amount_to_save,
                'accrued' => $saving->interest_due,
                'description' => $saving->saving_title,
                'duration_left' => $duration_left,
            ],
        );

        return Inertia::render('Savings/Show', [
            'user' => $user,
            'saving' => $savingsData,
        ]);
    }

}
