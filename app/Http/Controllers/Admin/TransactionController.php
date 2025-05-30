<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'ticket', 'ticket.event']);

        // Apply user filter
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Apply event filter
        if ($request->has('event_id') && $request->event_id) {
            $query->whereHas('ticket', function($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        // Apply status filter
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // Apply date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->latest()->paginate(15);
        $events = Event::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        // Get statistics
        $stats = [
            'total_revenue' => Transaction::where('payment_status', 'completed')->sum('amount'),
            'total_transactions' => Transaction::count(),
            'pending_amount' => Transaction::where('payment_status', 'pending')->sum('amount'),
        ];

        return view('admin.transactions.index', compact('transactions', 'events', 'users', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'ticket', 'ticket.event']);
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Update the status of a transaction.
     */
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,completed,failed,refunded'
        ]);

        $oldStatus = $transaction->payment_status;
        $newStatus = $request->payment_status;
        
        $transaction->payment_status = $newStatus;
        $transaction->save();

        // Update the ticket status if necessary
        if ($transaction->ticket) {
            if ($newStatus === 'completed' && $oldStatus !== 'completed') {
                $transaction->ticket->update(['status' => 'sold']);
            } elseif ($oldStatus === 'completed' && $newStatus !== 'completed') {
                $transaction->ticket->update(['status' => 'available']);
            }
        }

        return redirect()->route('admin.transactions.show', $transaction)
            ->with('success', 'Transaction status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Check if transaction can be deleted
        if ($transaction->payment_status === 'completed') {
            return back()->with('error', 'Completed transactions cannot be deleted. Issue a refund instead.');
        }

        // If the transaction had a ticket, make it available again
        if ($transaction->ticket && $transaction->ticket->status === 'reserved') {
            $transaction->ticket->update(['status' => 'available']);
        }

        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction deleted successfully');
    }

    /**
     * Export transactions to CSV.
     */
    public function export(Request $request)
    {
        $query = Transaction::with(['user', 'ticket', 'ticket.event']);

        // Apply filters
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('event_id') && $request->event_id) {
            $query->whereHas('ticket', function($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->get();

        // Generate CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="transactions_export_' . date('Y-m-d') . '.csv"',
        ];

        $columns = [
            'ID', 
            'Transaction Date', 
            'User', 
            'Email',
            'Event', 
            'Ticket Number', 
            'Amount', 
            'Payment Method', 
            'Status'
        ];

        $callback = function() use ($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->created_at->format('Y-m-d H:i'),
                    $transaction->user ? $transaction->user->name : 'Guest',
                    $transaction->user ? $transaction->user->email : 'N/A',
                    $transaction->ticket && $transaction->ticket->event 
                        ? $transaction->ticket->event->name 
                        : 'N/A',
                    $transaction->ticket ? $transaction->ticket->ticket_number : 'N/A',
                    $transaction->amount,
                    $transaction->payment_method,
                    $transaction->payment_status
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
} 