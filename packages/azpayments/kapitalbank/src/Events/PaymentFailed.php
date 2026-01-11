<?php

namespace AZPayments\Kapitalbank\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentFailed
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly int $orderId,
        public readonly string $status,
        public readonly array $orderDetails,
        public readonly ?string $errorCode = null,
        public readonly ?string $errorMessage = null,
    ) {}

    /**
     * Ödəniş məbləğini al
     */
    public function getAmount(): float
    {
        return (float) ($this->orderDetails['amount'] ?? 0);
    }

    /**
     * Valyutanı al
     */
    public function getCurrency(): string
    {
        return $this->orderDetails['currency'] ?? 'AZN';
    }

    /**
     * Decline səbəbini al
     */
    public function getDeclineReason(): ?string
    {
        return $this->errorCode;
    }
}