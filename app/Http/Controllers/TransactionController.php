<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::query()->with(['user', 'ticket', 'ticket.event']);
        
        // Apply filters if any
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }
        
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }
        
        $transactions = $query->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $availableTickets = Ticket::where('status', 'available')->get();
        return view('transactions.create', compact('availableTickets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'payment_method' => 'required|string'
        ]);

        $ticket = Ticket::findOrFail($validated['ticket_id']);

        if ($ticket->status !== 'available') {
            return redirect()->back()
                ->with('error', 'This ticket is not available for purchase.');
        }

        // Create dummy transaction for development
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'ticket_id' => $ticket->id,
            'transaction_number' => 'TRX-' . uniqid(),
            'amount' => $ticket->price,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'completed',
            'payment_details' => json_encode([
                'method' => $validated['payment_method'],
                'time' => now()->toIso8601String()
            ]),
            'payment_date' => now()
        ]);

        $ticket->update(['status' => 'sold']);

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaction completed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'ticket', 'ticket.event']);
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function userTransactions()
    {
        $transactions = Transaction::with(['ticket', 'ticket.event'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('transactions.user-transactions', compact('transactions'));
    }
}
