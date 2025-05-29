<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_events' => Event::count(),
            'total_artists' => Artist::count(),
            'total_users' => User::count(),
            'upcoming_events' => Event::where('status', 'upcoming')->count(),
        ];

        $latest_events = Event::with('artist')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latest_events'));
    }
} 