<?php

namespace AZPayments\Kapitalbank\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessful
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly int $orderId,
        public readonly string $status,
        public readonly array $orderDetails,
        public readonly ?int $storedTokenId = null,
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
     * Kart maskasını al
     */
    public function getCardMask(): ?string
    {
        return $this->orderDetails['srcToken']['displayName'] ?? null;
    }

    /**
     * Əməliyyat ID-sini al
     */
    public function getTransactionId(): ?string
    {
        $trans = $this->orderDetails['trans'] ?? [];
        return $trans[0]['actionId'] ?? null;
    }

    /**
     * Approval kodunu al
     */
    public function getApprovalCode(): ?string
    {
        $trans = $this->orderDetails['trans'] ?? [];
        return $trans[0]['approvalCode'] ?? null;
    }
}