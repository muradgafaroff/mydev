<?php

namespace AZPayments\Kapitalbank\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use AZPayments\Kapitalbank\Exceptions\KapitalbankException;
use AZPayments\Kapitalbank\DTOs\OrderResponse;

class KapitalbankService
{
    protected array $config;
    protected string $baseUrl;
    protected string $hppUrl;
    protected string $username;
    protected string $password;
    protected string $currency;
    protected string $language;

    public function __construct(array $config)
    {
        $this->config = $config;
        $mode = $config['mode'] ?? 'test';
        $this->baseUrl = $config['base_url'][$mode];
        $this->hppUrl = $config['hpp_url'][$mode];
        $this->username = $config['username'];
        $this->password = $config['password'];
        $this->currency = $config['currency'] ?? 'AZN';
        $this->language = $config['language'] ?? 'az';
    }

    /**
     * Dili dəyiş
     */
    public function setLanguage(string $lang): self
    {
        $this->language = $lang;
        return $this;
    }

    /**
     * Valyutanı dəyiş
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Sadə ödəniş sifarişi yarat (Order_SMS)
     */
    public function createOrder(array $data): OrderResponse
    {
        return $this->createOrderByType('Order_SMS', $data);
    }

    /**
     * PreAuth sifarişi yarat (Order_DMS)
     */
    public function createPreAuthOrder(array $data): OrderResponse
    {
        return $this->createOrderByType('Order_DMS', $data);
    }

    /**
     * Təkrar ödəniş sifarişi yarat (Order_REC)
     */
    public function createRecurringOrder(array $data): OrderResponse
    {
        return $this->createOrderByType('Order_REC', $data);
    }

    /**
     * Kartdan karta transfer sifarişi yarat (OCT)
     */
    public function createCardToCardOrder(array $data): OrderResponse
    {
        return $this->createOrderByType('OCT', $data);
    }

    /**
     * Taksitli ödəniş sifarişi yarat
     */
    public function createInstallmentOrder(array $data, int $months): OrderResponse
    {
        $data['description'] = "TAKSIT={$months}";
        return $this->createOrderByType('Order_SMS', $data);
    }

    /**
     * Sifariş növünə görə yarat
     */
    protected function createOrderByType(string $typeRid, array $data): OrderResponse
    {
        $payload = [
            'order' => [
                'typeRid' => $typeRid,
                'amount' => (string) $data['amount'],
                'currency' => $data['currency'] ?? $this->currency,
                'language' => $data['language'] ?? $this->language,
                'description' => $data['description'] ?? '',
                'hppRedirectUrl' => $data['redirect_url'] ?? url($this->config['redirect_url']),
            ]
        ];

        // Title əlavə et
        if (isset($data['title'])) {
            $payload['order']['title'] = $data['title'];
        }

        // Kart saxlama aktivdirsə
        if (($this->config['save_cards'] ?? false) || ($data['save_card'] ?? false)) {
            $payload['order']['hppCofCapturePurposes'] = ['UnspecifiedMit', 'Cit', 'Recurring'];
            $payload['order']['aut'] = ['purpose' => 'AddCard'];
            
            if (isset($data['stored_id'])) {
                $payload['order']['srcToken'] = ['storedId' => $data['stored_id']];
            }
        }

        $response = $this->request('POST', '/order', $payload);

        return new OrderResponse(
            id: $response['order']['id'],
            hppUrl: $response['order']['hppUrl'],
            password: $response['order']['password'],
            status: $response['order']['status'],
            secret: $response['order']['secret'] ?? null,
            cvv2AuthStatus: $response['order']['cvv2AuthStatus'] ?? null
        );
    }

    /**
     * Ödəniş səhifəsinin URL-ini al
     */
    public function getPaymentUrl(int $orderId, string $password): string
    {
        return "{$this->hppUrl}?id={$orderId}&password={$password}";
    }

    /**
     * Ödəniş səhifəsinə redirect et
     */
    public function redirectToPayment(int $orderId, string $password)
    {
        return redirect($this->getPaymentUrl($orderId, $password));
    }

    /**
     * Sifariş detallarını al
     */
    public function getOrderDetails(int $orderId, array $options = []): array
    {
        $query = [];
        
        if ($options['full'] ?? false) {
            $query = [
                'tranDetailLevel' => 2,
                'tokenDetailLevel' => 2,
                'orderDetailLevel' => 2,
            ];
        } else {
            if (isset($options['tranDetailLevel'])) $query['tranDetailLevel'] = $options['tranDetailLevel'];
            if (isset($options['tokenDetailLevel'])) $query['tokenDetailLevel'] = $options['tokenDetailLevel'];
            if (isset($options['orderDetailLevel'])) $query['orderDetailLevel'] = $options['orderDetailLevel'];
        }

        $queryString = !empty($query) ? '?' . http_build_query($query) : '';
        
        return $this->request('GET', "/order/{$orderId}{$queryString}");
    }

    /**
     * Sifarişin statusunu yoxla
     */
    public function getOrderStatus(int $orderId): string
    {
        $details = $this->getOrderDetails($orderId);
        return $details['order']['status'] ?? 'Unknown';
    }

    /**
     * Əməliyyatı icra et
     */
    public function executeTransaction(int $orderId, array $data): array
    {
        return $this->request('POST', "/order/{$orderId}/exec-tran", ['tran' => $data]);
    }

    /**
     * Saxlanılan kartla ödəniş (Single)
     */
    public function chargeWithSavedCard(int $orderId, string $password, int $storedId): array
    {
        // Token təyin et
        $this->setSrcToken($orderId, $password, $storedId);

        // Əməliyyatı icra et
        return $this->executeTransaction($orderId, [
            'phase' => 'Single',
            'conditions' => ['cofUsage' => 'Recurring']
        ]);
    }

    /**
     * PreAuth tamamla (Clearing)
     */
    public function completePreAuth(int $orderId, float $amount = null): array
    {
        $data = ['phase' => 'Clearing'];
        
        if ($amount !== null) {
            $data['amount'] = (string) $amount;
        }

        return $this->executeTransaction($orderId, $data);
    }

    /**
     * Geri ödəniş (Refund)
     */
    public function refund(int $orderId, float $amount = null): array
    {
        $data = [
            'phase' => 'Single',
            'type' => 'Refund'
        ];

        if ($amount !== null) {
            $data['amount'] = (string) $amount;
        }

        return $this->executeTransaction($orderId, $data);
    }

    /**
     * Ləğv et (Reversal)
     */
    public function reversal(int $orderId, string $type = 'Full', float $amount = null): array
    {
        $data = [
            'phase' => 'Single',
            'voidKind' => $type // Full or Partial
        ];

        if ($type === 'Partial' && $amount !== null) {
            $data['amount'] = (string) $amount;
        }

        return $this->executeTransaction($orderId, $data);
    }

    /**
     * PreAuth ləğv et
     */
    public function reversalPreAuth(int $orderId, string $phase = 'Auth'): array
    {
        return $this->executeTransaction($orderId, [
            'phase' => $phase, // Auth or Clearing
            'voidKind' => 'Full'
        ]);
    }

    /**
     * Mənbə tokeni təyin et (saxlanılan kart)
     */
    public function setSrcToken(int $orderId, string $password, int $storedId): array
    {
        return $this->request('POST', "/order/{$orderId}/set-src-token?password={$password}", [
            'order' => ['initiationEnvKind' => 'Server'],
            'token' => ['storedId' => $storedId]
        ]);
    }

    /**
     * Təyinat tokeni təyin et (kartdan karta üçün)
     */
    public function setDstToken(int $orderId, string $password, string $pan): array
    {
        return $this->request('POST', "/order/{$orderId}/set-dst-token?password={$password}", [
            'token' => [
                'card' => [
                    'panBlock' => ['data' => $pan],
                    'entryMode' => 'ECommerce'
                ]
            ]
        ]);
    }

    /**
     * Kartdan karta transfer icra et
     */
    public function executeCardToCard(int $orderId): array
    {
        return $this->executeTransaction($orderId, [
            'phase' => 'Single',
            'type' => 'Credit'
        ]);
    }

    /**
     * Status uğurludurmu yoxla
     */
    public function isSuccessful(string $status): bool
    {
        return in_array($status, ['FullyPaid', 'PartiallyPaid', 'Approved']);
    }

    /**
     * Callback-dən gələn statusu yoxla
     */
    public function verifyCallback(array $data): array
    {
        $orderId = $data['ID'] ?? $data['id'] ?? null;
        $status = $data['STATUS'] ?? $data['status'] ?? null;

        if (!$orderId) {
            throw new KapitalbankException('Order ID tapılmadı callback-də');
        }

        // API-dən statusu təsdiqləyirik
        $orderDetails = $this->getOrderDetails($orderId, ['full' => true]);
        $actualStatus = $orderDetails['order']['status'] ?? 'Unknown';

        return [
            'order_id' => $orderId,
            'callback_status' => $status,
            'actual_status' => $actualStatus,
            'is_successful' => $this->isSuccessful($actualStatus),
            'order' => $orderDetails['order']
        ];
    }

    /**
     * API sorğusu göndər
     */
    protected function request(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . $endpoint;

        $this->log('request', [
            'method' => $method,
            'url' => $url,
            'data' => $data
        ]);

        try {
            $response = Http::withBasicAuth($this->username, $this->password)
                ->timeout($this->config['timeout'] ?? 30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ]);

            if ($method === 'GET') {
                $response = $response->get($url);
            } else {
                $response = $response->post($url, $data);
            }

            $result = $response->json();

            $this->log('response', [
                'status' => $response->status(),
                'body' => $result
            ]);

            if ($response->failed()) {
                throw new KapitalbankException(
                    $result['errorDescription'] ?? 'API xətası',
                    $result['errorCode'] ?? 'UNKNOWN',
                    $result['errorDetails'] ?? []
                );
            }

            return $result;

        } catch (\Exception $e) {
            if ($e instanceof KapitalbankException) {
                throw $e;
            }
            
            $this->log('error', ['message' => $e->getMessage()]);
            throw new KapitalbankException('Kapitalbank API ilə əlaqə xətası: ' . $e->getMessage());
        }
    }

    /**
     * Loqlama
     */
    protected function log(string $type, array $data): void
    {
        if ($this->config['logging']['enabled'] ?? false) {
            Log::channel($this->config['logging']['channel'] ?? 'stack')
                ->info("Kapitalbank [{$type}]", $data);
        }
    }
}