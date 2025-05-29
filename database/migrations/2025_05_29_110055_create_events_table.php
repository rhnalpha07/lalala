<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->dateTime('event_date');
            $table->string('venue');
            $table->string('venue_address');
            $table->integer('total_seats');
            $table->decimal('price', 10, 2);
            $table->string('status')->default('upcoming'); // upcoming, ongoing, completed, cancelled
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
