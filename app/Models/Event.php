<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'artist_id',
        'event_date',
        'venue',
        'venue_address',
        'total_seats',
        'price',
        'status',
        'image'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'price' => 'decimal:2'
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function availableTickets()
    {
        return $this->tickets()->where('status', 'available');
    }
}
