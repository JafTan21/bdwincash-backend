<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $user = User::where('id', $id)->firstOrFail();

        $user_count = User::where('email', $request->email)->count();
        if ($user_count > 0 && $user->email != $request->email) {
            return response()->json([
                'error' => 'Email already taken.',
            ]);
        }

        $user_count = User::where('phone', $request->phone)->count();
        if ($user_count > 0 && $user->phone != $request->phone) {
            return response()->json([
                'error' => 'Phone already taken.',
            ]);
        }

        $user_count = User::where('username', $request->username)->count();
        if ($user_count > 0 && $user->username != $request->username) {
            return response()->json([
                'error' => 'Username already taken.',
            ]);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'balance'=>$request->balance ?? $user->balance,
        ]);

        if($request->password != null){
            $user->update([
                'password'=> Hash::make($request->password)
            ]);
        }

        return response()->json([
            'success' => 'Successful.',
            'user' => $user,
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
        $user = User::where('id', $id)->firstOrFail();
        if ($user->delete()) {
            return response()->json([
                'success' => 'Successful'
            ]);
        }
        return response()->json([
            'error' => 'Something went wrong',
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = User::where('id', $request->user_id)->firstOrFail();

        if (Hash::check($request->oldPassword, $user->password)) {
            $user->update([
                'password' => Hash::make($request->newPassword),
            ]);
        } else {
            return response()->json([
                'error' => 'Wrong password'
            ]);
        }

        return response()->json([
            'success' => 'Successful',
        ]);
    }

    public function getUsers()
    {
        return response()->json([
            'users' => UserResource::collection(
                User::with('roles')->get()
            ),
        ]);
    }

    public function checkAdmin(Request $request)
    {
        if (!$request->user_id) {
            return response()->json([
                'isAdmin' => false
            ]);
        }


        return response()->json([
        'isAdmin' => User::where('id', $request->user_id)->firstOrFail()->isAdmin
        ]);
    }

    public function checkUser(Request $request)
    {
        if (!$request->user_id) {
            return response()->json([
            'isUser' => true
            ]);
        }

        return response()->json([
'isUser' => User::where('id', $request->user_id)->firstOrFail()->isUser
        ]);
    }

    public function getUser(Request $request)
    {
        return response()->json([
            'user'=>User::where('id', $request->user_id)->orWhere('username', $request->user_id)->with('roles')->firstOrFail(),
        ]);
    }

    public function toggleUser(Request $request)
    {
        $user = User::where('id', $request->user_id)->firstOrFail();
if($user->is_active){
    $user->is_active = false;
} else {
    $user->is_active = true;
}

$user->save();

        return response()->json([
            'success' => 'Successful',
            'users'=>UserResource::collection(
                User::with('roles')->get()
            ),
            'user'=>$user,
        ]);
    }
}
