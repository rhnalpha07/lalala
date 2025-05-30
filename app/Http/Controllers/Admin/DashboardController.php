<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Artist;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $stats = [
            'total_events' => Event::count(),
            'total_artists' => Artist::count(),
            'total_users' => User::count(),
            'upcoming_events' => Event::where('status', 'upcoming')->count(),
            'total_tickets' => Ticket::count(),
            'sold_tickets' => Ticket::where('status', 'sold')->count(),
            'total_revenue' => Transaction::where('payment_status', 'completed')->sum('amount')
        ];

        // Get latest events
        $latest_events = Event::with('artist')
            ->latest()
            ->take(5)
            ->get();
            
        // Get upcoming events by month
        $upcoming_events_by_month = Event::where('status', 'upcoming')
            ->where('event_date', '>=', now())
            ->orderBy('event_date')
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->event_date)->format('F Y');
            })
            ->map(function($events) {
                return $events->count();
            })
            ->take(6);
            
        // Get popular artists (with most events and ticket sales)
        $popular_artists = Artist::withCount(['events'])
            ->withCount(['events as events_tickets_count' => function($query) {
                $query->join('tickets', 'events.id', '=', 'tickets.event_id')
                      ->where('tickets.status', 'sold');
            }])
            ->orderBy('events_count', 'desc')
            ->take(5)
            ->get();
            
        // Get user registration stats by month for current year
        $user_stats = User::whereYear('created_at', now()->year)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [Carbon::create(null, $item->month)->format('F') => $item->count];
            });

        // Get recent transactions
        $recent_transactions = Transaction::with(['user', 'ticket', 'ticket.event'])
            ->latest()
            ->take(5)
            ->get();
            
        // Get ticket sales data for chart
        $ticket_sales_data = Ticket::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "sold" THEN 1 ELSE 0 END) as sold')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'latest_events',
            'upcoming_events_by_month',
            'popular_artists',
            'user_stats',
            'recent_transactions',
            'ticket_sales_data'
        ));
    }
} 