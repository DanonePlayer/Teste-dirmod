<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'original_amount',
        'currency',
        'exchange_rate',
        'converted_amount_brl',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
