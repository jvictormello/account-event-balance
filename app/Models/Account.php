<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'balance',
    ];

    /**
     * Get the received events.
     */
    public function received_events(): HasMany
    {
        return $this->hasMany(Event::class, 'origin_account_id', 'id');
    }

    /**
     * Get the origin events.
     */
    public function origin_events(): HasMany
    {
        return $this->hasMany(Event::class, 'destination_account_id', 'id');
    }
}
