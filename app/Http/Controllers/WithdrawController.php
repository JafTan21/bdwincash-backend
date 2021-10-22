<?php

namespace App\Http\Controllers;

use App\Http\Resources\WithdrawResource;
use App\Models\Setting;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setting = Setting::where('name', 'min_balance')->first();
        $user = User::where('id', $request->user_id)->firstOrFail();
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Wrong password',
            ]);
        }

        if (($user->balance-$setting->min) < $request->amount) {
            return response()->json([
                'data' => $request->all(),
                'error' => 'Balance insufficient',
            ]);
        }

        $setting = Setting::where('name', 'withdraw')->first();

        if ($setting) {
            if (!$setting->status) {
                return response()->json([
                    'error' => 'Feature is turned off.'
                ]);
            }

            if ($request->amount < $setting->min || $request->amount > $setting->max) {
                return response()->json([
                    'error' => 'Minimum: '.$setting->min.' and Maximum: '.$setting->max,
                ]);
            }

            $last = Withdraw::where('user_id', $request->user_id)->latest()->first();
            if ($setting->time_limit && $last->created_at->diffInHours(now()) < $setting->time_limit) {
               return response()->json([
                    'error' => 'Please wait '
                    . ($setting->time_limit - $last->created_at->diffInHours(now()))
                    . ' hours',
                ]);
            }
        }

        $withdraw = Withdraw::create([
            'user_id' => $request->user_id,
            'number' => $request->number,
            'method' => $request->method,
            'amount' => $request->amount,
        ]);

        $user->update([
            'balance' => $user->balance - $withdraw->amount,
        ]);

        return response()->json([
            'withdraw' => new WithdrawResource($withdraw),
            'success' => 'Successful',
            'user' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $withdraw = Withdraw::where('id', $id)->firstOrFail();
        $withdraw->update([
            'status' => $request->status,
        ]);
        if ($request->status == 0) {
            $withdraw->user()->update([
                'balance' => ($withdraw->user->balance + $withdraw->amount)
            ]);
        }
        return response()->json([
            'withdraw' => new WithdrawResource($withdraw),
            'success' => 'Successful'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Withdraw::where('id', $id)->delete();
        return response()->json([
           'success' => 'Deleted'
       ]);
    }

    public function withdraws(Request $request)
    {
        $withdraws = Withdraw::latest();

        if ($request->user_id) {
            $withdraws = $withdraws->where('user_id', $request->user_id);
        }

        return response()->json([
            'withdraws' => WithdrawResource::collection(
                $withdraws->get(),
            ),
        ]);
    }
}
