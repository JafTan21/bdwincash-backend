<?php

namespace App\Http\Controllers;

use App\Http\Resources\LudoResource;
use App\Models\Ludo;
use App\Models\User;
use App\Models\GameSetting;
use App\Models\Setting;
use Illuminate\Http\Request;

class LudoController extends Controller
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
        $user = User::where('id', $request->user_id)->firstOrFail();
        $setting = GameSetting::where('game_name', 'headtail')->first();
        $balance_setting = Setting::where('name', 'min_balance')->first();

        if (($user->balance-$balance_setting->min) < $request->amount) {
            return response()->json([
                'error' => 'Balance insufficient',
            ]);
        }

        if ($setting->max && $request->amount > $setting->max) {
            return response()->json([
                'error' => 'Maximum amount: '. $setting->max,
            ]);
        }

        if ($setting->min && $request->amount < $setting->min) {
            return response()->json([
                'error' => 'Minimum amount: '. $setting->min,
            ]);
        }

        $winner = array_rand([
            'one' => 'one',
            'two' => 'two',
            'three' => 'three',
            'four' => 'four',
            'five' => 'five',
            'six' => 'six',
        ]);

        $user->ludos()->create([
            'amount' => $request->amount,
            'status' => ($winner == $request->selected),
            'option' => $request->selected,
            'rate' => $setting->rate,
        ]);

        $new_balance = $user->balance - $request->amount;
        if ($winner == $request->selected) {
            $new_balance += ($setting->rate * $request->amount);
        }
        $user->update([
            'balance' =>  $new_balance,
        ]);

        return ($winner == $request->selected)
            ? response()->json([
                'success' => 'You won the game.',
            'played' => $winner.'.png',
            ])
            : response()->json([
                'error' => 'You lost the game.',
            'played' => $winner.'.png',
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

    public function ludos(Request $request)
    {
        return response()->json([
            'ludos' => LudoResource::collection(
                Ludo::where('user_id', $request->user_id)->latest()->get()
            )
        ]);
    }
}
