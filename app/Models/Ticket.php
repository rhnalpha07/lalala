<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_id',
        'ticket_number',
        'status',
        'seat_number',
        'price',
        'ticket_type'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function generateTicketNumber()
    {
        return 'TIX-' . strtoupper(uniqid());
    }
}
