<?php

namespace AZPayments\Kapitalbank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KapitalbankSavedCard extends Model
{
    protected $table = 'kapitalbank_saved_cards';

    protected $fillable = [
        'user_id', 'stored_token_id', 'card_mask', 'card_brand',
        'expiration', 'display_name', 'is_default', 'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(KapitalbankPayment::class, 'stored_token_id', 'stored_token_id');
    }

    public function getLastFourAttribute(): string
    {
        return substr($this->card_mask, -4);
    }

    public function getFormattedMaskAttribute(): string
    {
        return "**** **** **** " . $this->last_four;
    }

    public function isExpired(): bool
    {
        if (!$this->expiration) return false;
        
        $month = substr($this->expiration, 0, 2);
        $year = '20' . substr($this->expiration, 2, 2);
        $expDate = \Carbon\Carbon::createFromDate($year, $month, 1)->endOfMonth();
        
        return $expDate->isPast();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function makeDefault(): void
    {
        static::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }
}