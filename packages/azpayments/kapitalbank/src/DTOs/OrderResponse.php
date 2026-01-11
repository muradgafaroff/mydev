<?php

namespace AZPayments\Kapitalbank\DTOs;

class OrderResponse
{
    public function __construct(
        public readonly int $id,
        public readonly string $hppUrl,
        public readonly string $password,
        public readonly string $status,
        public readonly ?string $secret = null,
        public readonly ?string $cvv2AuthStatus = null,
    ) {}

    public function getPaymentUrl(): string
    {
        return "{$this->hppUrl}?id={$this->id}&password={$this->password}";
    }

    public function redirect()
    {
        return redirect($this->getPaymentUrl());
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'hpp_url' => $this->hppUrl,
            'password' => $this->password,
            'status' => $this->status,
            'secret' => $this->secret,
            'cvv2_auth_status' => $this->cvv2AuthStatus,
            'payment_url' => $this->getPaymentUrl(),
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}