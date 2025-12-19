<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeHash extends Model
{
    /**
     * The attributes that are mass assignable.
     * These match the columns we created in your migration.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ea_identifier',
        'trade_hash',
        'previous_hash',
        'ticket_number',
        'trade_details',
    ];

    /**
     * The attributes that should be cast.
     * This automatically turns the JSON 'trade_details' column 
     * back into a PHP array when you use it.
     */
    protected $casts = [
        'trade_details' => 'array',
    ];

    /**
     * Get the user (tester) that owns this trade hash.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}