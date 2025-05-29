<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Artist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $upcomingEvents = Event::where('event_date', '>=', now())
            ->with('artist')
            ->orderBy('event_date')
            ->take(6)
            ->get();
            
        $featuredArtists = Artist::whereHas('events')
            ->inRandomOrder()
            ->take(3)
            ->get();
            
        return view('home', compact('upcomingEvents', 'featuredArtists'));
    }
} 