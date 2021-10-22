<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'today_deposit' => Deposit::whereDate('created_at', Carbon::today())->where('status', 1)->sum('amount'),
            'today_withdraw' => Withdraw::whereDate('created_at', Carbon::today())->where('status', 1)->sum('amount'),
            'total_deposit' => Deposit::where('status', 1)->sum('amount'),
            'total_withdraw' => Withdraw::where('status', 1)->sum('amount'),
            'total_user' => User::count(),
        ]);
    }

    public function withdrawDepositNotificationCount(Request $request)
    {
        return response()->json([
            'withdraw_count' => Withdraw::where('status', 2)->count(),
            'deposit_count' => Deposit::where('status', 2)->count(),
        ]);
    }
}
