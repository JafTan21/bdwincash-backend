<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepositResource;
use App\Models\Deposit;
use App\Models\Setting;
use Illuminate\Http\Request;

class DepositController extends Controller
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
        $setting = Setting::where('name', 'deposit')->first();

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
            
            $last = Deposit::where('user_id', $request->user_id)->latest()->first();
            if ($setting->time_limit && $last->created_at->diffInHours(now()) < $setting->time_limit) {
               return response()->json([
                    'error' => 'Please wait '
                    . ($setting->time_limit - $last->created_at->diffInHours(now()))
                    . ' hours',
                ]);
            }
        }

        $deposit = Deposit::create([
            'user_id' => $request->user_id,
            'from_number' => $request->from_number,
            'from_method' => $request->from_method,
            'to_number' => $request->to_number,
            'to_method' => $request->to_method,
            'amount' => $request->amount,
            'transaction_number' => $request->transaction_number,
        ]);
        return response()->json([
            'deposit' => new DepositResource($deposit),
            'success' => 'Successful'
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
        $deposit = Deposit::where('id', $id)->firstOrFail();
        $deposit->update([
            'status' => $request->status,
        ]);
        if ($request->status == 1) {
            $deposit->user()->update([
                'balance' => ($deposit->user->balance + $deposit->amount)
            ]);
        }
        return response()->json([
            'withdraw' => new DepositResource($deposit),
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
        Deposit::where('id', $id)->delete();
        return response()->json([
           'success' => 'Deleted'
       ]);
    }

    public function deposits(Request $request)
    {
        $deposits = Deposit::latest();

        if ($request->user_id) {
            $deposits = $deposits->where('user_id', $request->user_id);
        }

        return response()->json([
            'deposits' => DepositResource::collection(
                $deposits->get(),
            ),
        ]);
    }
}
