<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::query();
        
        // Apply filters if any
        if ($request->has('event_id') && $request->event_id) {
            $query->where('event_id', $request->event_id);
        }
        
        if ($request->has('ticket_type') && $request->ticket_type) {
            $query->where('ticket_type', $request->ticket_type);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $tickets = $query->with(['event', 'event.artist'])->latest()->paginate(10);
        $events = Event::orderBy('event_date', 'desc')->get();
        
        return view('tickets.index', compact('tickets', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::where('status', 'upcoming')->get();
        return view('tickets.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_type' => 'required|in:regular,vip,backstage',
            'price' => 'required|numeric|min:0',
            'seat_number' => 'nullable|string|max:50'
        ]);

        $validated['ticket_number'] = 'TIX-' . uniqid();
        $validated['status'] = 'available';

        Ticket::create($validated);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['event', 'event.artist', 'transaction']);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $events = Event::where('status', 'upcoming')->get();
        return view('tickets.edit', compact('ticket', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_type' => 'required|in:regular,vip,backstage',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,reserved,sold',
            'seat_number' => 'nullable|string|max:50'
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        if ($ticket->status === 'sold') {
            return redirect()->route('tickets.index')
                ->with('error', 'Cannot delete a sold ticket.');
        }
        
        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }

    public function purchase(Ticket $ticket)
    {
        if ($ticket->status !== 'available') {
            return redirect()->route('tickets.show', $ticket)
                ->with('error', 'This ticket is not available for purchase.');
        }

        // For development purposes, we'll create a dummy transaction
        $transaction = $ticket->transaction()->create([
            'user_id' => auth()->id(),
            'transaction_number' => 'TRX-' . uniqid(),
            'amount' => $ticket->price,
            'payment_method' => 'dummy',
            'payment_status' => 'completed',
            'payment_details' => json_encode([
                'method' => 'dummy',
                'time' => now()->toIso8601String()
            ]),
            'payment_date' => now()
        ]);

        $ticket->update(['status' => 'sold']);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket purchased successfully.');
    }
}
