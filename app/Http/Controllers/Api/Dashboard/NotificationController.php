<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\NotificationRequest;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = notification::all();
        $formattedNotifications = $notifications->map(function ($notification) {
            return $notification->formatForJson();
        });

        return response()->json($formattedNotifications);
    }
    public function store(NotificationRequest $request)
    {
        $data = $request->except('image');
        $notification = notification::create($data);

        if ($request->hasFile('image')) {
            $notification->addMediaFromRequest('image')->toMediaCollection('Notifications');
        }
        return response()->json([
            'message' => 'Notification created successfully',
            'notification' => $notification
        ], 201);
    }
    public function update(NotificationRequest $request, string $id)
    {
        $notification = notification::find($id);
        if (!$notification) {return response()->json(['error' => 'Notification not found'], 404);}
        $data = $request->all();
        $notification->update($data);
        if ($request->hasFile('image')) {
            $new_image = $request->file('image');
            $notification->clearMediaCollection('Notifications');
            $notification->addMedia($new_image)->toMediaCollection('Notifications');
        }
        return response()->json([
            'message' => 'Notification updated successfully',
            'Notification' => $notification
        ], 200);
    }
    public function show($notification)
    {
        $notification = notification::find($notification);
        if (!$notification) {return response()->json(['error' => 'Notification not found'], 404);}
        $notification->load('trips','media');
        $notification->media->transform(function ($media) {
            return [
                'media' =>  str_replace('http://localhost', '', $media->original_url)
            ];
        });
        return response()->json(['Notification' => $notification], 200);
    }
    public function destroy($notification)
    {
        $notification = notification::find($notification);
        if (!$notification) {return response()->json(['error' => 'Notification not found'], 404);}
        $notification->delete();
        return response()->json([
        'message' => 'Notification deleted successfully',
        ], 201);
    }
}
