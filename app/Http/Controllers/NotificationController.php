<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function get() {
        $notifications = Notification::all();
        return $notifications;
    }
}
