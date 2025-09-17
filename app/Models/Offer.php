<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'insurer',
        'request_payload',
        'response_payload',
        'premium_amount',
        'premium_amount_net',
        'bonus_malus',
        'green_card_exclusions',
    ];

    protected $casts = [
        'request_payload'  => 'array',
        'response_payload' => 'array',
    ];
}
