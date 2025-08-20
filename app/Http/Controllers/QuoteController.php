<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function show($id)
    {
        $quote = Quote::find($id);
        if (!$quote) {
            return response()->json(['error' => 'Quote not found'], 404);
        }
        return response()->json($quote);
    }
}

