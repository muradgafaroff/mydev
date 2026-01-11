<?php

namespace AZPayments\Kapitalbank\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KapitalbankPayment extends Model
{
    protected $table = 'kapitalbank_payments';

    protected $fillable = [
        'order_id', 'password', 'secret', 'amount', 'currency',
        'status', 'type', 'approval_code', 'transaction_id', 'rrn',
        'card_mask', 'card_brand', 'stored_token_id', 'description',
        'language', 'error_code', 'error_message', 'reference_type',
        'reference_id', 'user_id', 'meta', 'response', 'ip_address', 'user_agent',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'meta' => 'array',
        'response' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }

    public function savedCard(): BelongsTo
    {
        return $this->belongsTo(KapitalbankSavedCard::class, 'stored_token_id', 'stored_token_id');
    }

    public function isSuccessful(): bool
    {
        return in_array($this->status, ['FullyPaid', 'PartiallyPaid', 'Approved']);
    }

    public function isPending(): bool
    {
        return $this->status === 'Preparing';
    }

    public function getPaymentUrl(): string
    {
        $mode = config('kapitalbank.mode', 'test');
        $hppUrl = config("kapitalbank.hpp_url.{$mode}");
        return "{$hppUrl}?id={$this->order_id}&password={$this->password}";
    }

    public function scopeSuccessful($query)
    {
        return $query->whereIn('status', ['FullyPaid', 'PartiallyPaid', 'Approved']);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Preparing');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}