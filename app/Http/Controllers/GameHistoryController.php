<?php

namespace App\Http\Controllers;

use App\Http\Resources\EvenOddResource;
use App\Http\Resources\HeadTailResource;
use App\Http\Resources\KingsResource;
use App\Http\Resources\LudoResource;
use App\Models\EvenOdd;
use App\Models\HeadTail;
use App\Models\Kings;
use App\Models\Ludo;
use Illuminate\Http\Request;

class GameHistoryController extends Controller
{
    public function getGameHistory(Request $request)
    {
        return response()->json([
            'history' => $this->getHistoryOf($request->game_name),
        ]);
    }

    public function getHistoryOf($game_name)
    {
        if ($game_name == 'headtail') {
            return HeadTailResource::collection(
                HeadTail::with('user')->latest()->get(),
            );
        }

        if ($game_name == 'evenodd') {
            return EvenOddResource::collection(
                EvenOdd::with('user')->latest()->get(),
            );
        }

        if ($game_name == 'kings') {
            return KingsResource::collection(
                Kings::with('user')->latest()->get(),
            );
        }

        if ($game_name == 'ludo') {
            return LudoResource::collection(
                Ludo::with('user')->latest()->get(),
            );
        }

        return null;
    }
}
