<?php

namespace App\Http\Controllers;

use App\Http\Resources\BalanceTransferResource;
use App\Models\BalanceTransfer;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BalanceTransferController extends Controller
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
        $setting = Setting::where('name', 'transfer')->first();

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
        }

        $from_user = User::where('username', $request->from_user_username)->first();
        $to_user = User::where('username', $request->to_user_username)->first();

        if (!$from_user || !$to_user) {
            return response()->json([
                'error'=>'User not found'
            ]);
        }

        if ($request->amount > $from_user->balance) {
            return response()->json([
                'error'=>'You don\'t have enough balance'
            ]);
        }

        if (!Hash::check($request->password, $from_user->password)) {
            return response()->json([
                'error'=>'Wrong password'
            ]);
        }

        $from_user->update([
            'balance'=>$from_user->balance - $request->amount
        ]);

        $to_user->update([
            'balance'=>$to_user->balance + $request->amount
        ]);

        BalanceTransfer::create([
            'from'=>$from_user->username,
            'to'=>$to_user->username,
            'amount'=>$request->amount,
        ]);

        return  response()->json([
            'success'=>'Successful'
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getBalanaceTransfers(Request $request)
    {
        if ($request->user_id) {
            $user = User::where('id', $request->user_id)->first();
            return BalanceTransferResource::collection(
                $user->balanceTransferHistory
            );
        }

        
        return BalanceTransferResource::collection(
            BalanceTransfer::latest()->get()
        );
    }
}
