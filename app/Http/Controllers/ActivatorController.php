<?php

namespace App\Http\Controllers;

use App\Models\Activator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ActivatorController extends Controller
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
        $activator=Activator::oldest()->first();

        $activator->update([
            'domain'=>md5($request->domain),
            'key'=>md5($request->key),
        ]);

        $activator = Activator::oldest()->first();
 
        $secret = Http::asForm()->post('https://licensekey.company/api/v1/get-security-key.php', [
            'domain'=>$request->domain
        ])->json();

        if ($secret['status'] == 'success'
            && $activator->domain == $secret['domain']
            && $activator->key == $secret['key']) {
            return response()->json([
                'success'=>'Successful. Please refesh the page to complete setup.',
            ]);
        }


        return response()->json([
            'error'=>'Something went wrong'
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

    public function check(Request $request)
    {
        $activator = Activator::oldest()->first();
 
        $secret = Http::asForm()->post('https://licensekey.company/api/v1/get-security-key.php', [
            'domain'=>$request->domain
        ])->json();

        if ($secret['status'] == 'success'
            && $activator->domain == $secret['domain']
            && $activator->key == $secret['key']) {
            return response()->json([
                'activated'=>'1',
            ]);
        }

        return response()->json([
            'activated'=>'0',
        ]);
    }
}
