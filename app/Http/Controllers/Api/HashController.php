<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TradeHash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HashController extends Controller
{
    /**
     * Store a new trade hash from the MQL4 Agent.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming data from the MQL4 Agent
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|exists:users,id',
            'ea_identifier' => 'required|string|max:255',
            'trade_hash'    => 'required|string|size:64',
            'previous_hash' => 'nullable|string|size:64',
            'ticket_number' => 'required|integer',
            'trade_details' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Save the data to the MySQL table using our TradeHash model
        $hash = TradeHash::create([
            'user_id'       => $request->user_id,
            'ea_identifier' => $request->ea_identifier,
            'trade_hash'    => $request->trade_hash,
            'previous_hash' => $request->previous_hash,
            'ticket_number' => $request->ticket_number,
            'trade_details' => $request->trade_details,
        ]);

        // 3. Return success to the Agent
        return response()->json([
            'status'    => 'success',
            'message'   => 'Hash committed to the chain.',
            'hash_id'   => $hash->id,
            'timestamp' => now()->toIso8601String()
        ], 201);
    }
}