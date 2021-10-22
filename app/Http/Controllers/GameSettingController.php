<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameSettingResource;
use App\Models\GameSetting;
use Illuminate\Http\Request;

class GameSettingController extends Controller
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
        //
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
        $setting = GameSetting::where('id', $id)->first();
if($request->status == 'toggle'){
$setting->status = !$setting->status;
}

if($request->rate){
    $setting->rate = $request->rate;
    }
    if($request->min){
        $setting->min = $request->min;
        }
        if($request->max){
            $setting->max = $request->max;
            }

$setting->save();

        return response()->json([
            'success' => 'Successful.',
'setting'=>$setting,
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
        //
    }

    public function getGameSettings()
    {
        return GameSettingResource::collection(
            GameSetting::all()
        );
    }
}
