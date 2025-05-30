<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use League\Csv\Writer;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::query()
            ->with(['event', 'event.artist']);

        // Apply event filter
        if ($request->has('event_id') && $request->event_id) {
            $query->where('event_id', $request->event_id);
        }

        // Apply ticket type filter
        if ($request->has('ticket_type') && $request->ticket_type) {
            $query->where('ticket_type', $request->ticket_type);
        }

        // Apply status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->paginate(15);
        $events = Event::orderBy('name')->get();

        return view('admin.tickets.index', compact('tickets', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::where('status', 'upcoming')->orderBy('name')->get();
        return view('admin.tickets.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_type' => 'required|in:regular,vip,backstage',
            'price' => 'required|numeric|min:0',
            'seat_number' => 'nullable|string|max:50',
            'status' => 'required|in:available,reserved,sold',
        ]);

        Ticket::create([
            'event_id' => $request->event_id,
            'ticket_type' => $request->ticket_type,
            'price' => $request->price,
            'seat_number' => $request->seat_number,
            'status' => $request->status,
            'ticket_number' => 'TIX-' . uniqid(),
        ]);

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket created successfully');
    }

    /**
     * Create multiple tickets at once
     */
    public function bulkCreate(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_type' => 'required|in:regular,vip,backstage',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1|max:1000',
            'status' => 'required|in:available,reserved,sold',
        ]);

        $event = Event::findOrFail($request->event_id);
        $tickets = [];

        for ($i = 1; $i <= $request->quantity; $i++) {
            $tickets[] = [
                'event_id' => $request->event_id,
                'ticket_type' => $request->ticket_type,
                'price' => $request->price,
                'seat_number' => 'SEAT-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'status' => $request->status,
                'ticket_number' => 'TIX-' . uniqid(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert in chunks to prevent memory issues
        foreach (array_chunk($tickets, 100) as $chunk) {
            Ticket::insert($chunk);
        }

        return redirect()->route('admin.tickets.index')
            ->with('success', $request->quantity . ' tickets created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['event', 'event.artist']);
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $events = Event::orderBy('name')->get();
        return view('admin.tickets.edit', compact('ticket', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_type' => 'required|in:regular,vip,backstage',
            'price' => 'required|numeric|min:0',
            'seat_number' => 'nullable|string|max:50',
            'status' => 'required|in:available,reserved,sold',
        ]);

        $ticket->update([
            'event_id' => $request->event_id,
            'ticket_type' => $request->ticket_type,
            'price' => $request->price,
            'seat_number' => $request->seat_number,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        // Check if ticket can be deleted
        if ($ticket->status === 'sold') {
            return back()->with('error', 'Cannot delete a sold ticket. Change status first.');
        }

        $ticket->delete();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket deleted successfully');
    }

    /**
     * Export tickets to CSV
     */
    public function export(Request $request)
    {
        $query = Ticket::with(['event', 'event.artist']);

        // Apply filters
        if ($request->has('event_id') && $request->event_id) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->has('ticket_type') && $request->ticket_type) {
            $query->where('ticket_type', $request->ticket_type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $tickets = $query->get();
        
        // Create CSV file
        $csv = Writer::createFromString('');
        $csv->insertOne([
            'Ticket Number', 
            'Event', 
            'Artist', 
            'Type', 
            'Price', 
            'Seat', 
            'Status', 
            'Created At'
        ]);
        
        foreach ($tickets as $ticket) {
            $csv->insertOne([
                $ticket->ticket_number,
                $ticket->event ? $ticket->event->name : 'N/A',
                $ticket->event && $ticket->event->artist ? $ticket->event->artist->name : 'N/A',
                $ticket->ticket_type,
                $ticket->price,
                $ticket->seat_number,
                $ticket->status,
                $ticket->created_at->format('Y-m-d H:i:s')
            ]);
        }
        
        $filename = 'tickets_export_' . date('Y-m-d_His') . '.csv';
        
        return Response::make($csv->getContent(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
} 