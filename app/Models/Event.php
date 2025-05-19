<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'type',
        'amount',
        'origin_account_id',
        'destination_account_id',
    ];

    /**
     * Get the origin account.
     */
    public function origin_account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the destination account.
     */
    public function destination_account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
