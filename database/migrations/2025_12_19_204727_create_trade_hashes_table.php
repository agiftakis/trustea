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
        Schema::create('trade_hashes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The Peer Tester
            $table->string('ea_identifier');             // The name or unique ID of the EA
            $table->string('trade_hash', 64);            // Current trade SHA-256 fingerprint
            $table->string('previous_hash', 64)->nullable(); // Link to the previous trade's hash
            $table->integer('ticket_number');            // Unique MT4/MT5 Ticket ID
            $table->json('trade_details')->nullable();   // Metadata (Symbol, Profit, Open/Close time)
            $table->timestamps();

            // Indexing for faster verification searches
            $table->index(['ea_identifier', 'ticket_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_hashes');
    }
};
