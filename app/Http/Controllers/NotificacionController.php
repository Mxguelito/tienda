<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificacionController extends Controller
{
    public function index()
    {
        // Traer notificaciones del usuario logueado
        $notificaciones = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Marcar como leídas
        Notification::where('user_id', auth()->id())
            ->where('leida', false)
            ->update(['leida' => true]);

        return view('notificaciones.index', compact('notificaciones'));
    }
}
