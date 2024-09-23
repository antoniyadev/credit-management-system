<?php

namespace App\Models;

use App\Observers\CreditObserver;
use App\Services\CreditService;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([CreditObserver::class])]

class Credit extends Model
{
    use HasFactory;

    protected $with = ['recipient'];
    protected $fillable = [
        'recipient_id',
        'serial_number',
        'amount',
        'term_in_months',
    ];

    public function monthlyInstallment(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => (new CreditService())->calculateMonthlyInstallment($attributes['amount'], $attributes['term_in_months']),
        );
    }

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    public function remainingBalance(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->amount - $this->payments()->sum('amount')/100,
        );
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Recipient::class);
    }
}
