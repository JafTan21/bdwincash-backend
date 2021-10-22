<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
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
        if ($request->receiver == 'all') {
            $user_ids = User::all()->pluck('id');
        } else {
            $user_ids = $request->user_ids;
        }
        
        foreach ($user_ids as $id) {
            Notification::create([
                'subject'=>$request->subject,
                'message'=>$request->message,
                'user_id'=>$id,
                'for_all'=>$request->receiver == 'all',
            ]);
        }

        return response()->json([
            'success'=>'Successful.',
            'data'=>$user_ids
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

    public function getNotifications(Request $request)
    {
        if ($request->user_id) {
            $notifications = Notification::where('user_id', $request->user_id)
            ->orWhere('for_all', true)
            ->with('user')
            ->latest()
            ->get();
        } else {
            $notifications = Notification::with('user')->latest()->get();
        }

        foreach ($notifications->whereNull('viewed_at') as $notification) {
            $notification->update([
                'viewed_at'=>now(),
            ]);
        }

        return response()->json([
            'notifications' => NotificationResource::collection(
                $notifications
            ),
        ]);
    }

    public function getNotificationCount(Request $request)
    {
        return response()->json([
            'notification_count'=> Notification::where(function ($query) use ($request) {
                $query->where('user_id', $request->user_id)->orWhere('for_all', true);
            })
            ->whereNull('viewed_at')
            ->count()
        ]);
    }
}
