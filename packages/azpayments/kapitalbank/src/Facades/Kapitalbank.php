<?php

namespace AZPayments\Kapitalbank\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \AZPayments\Kapitalbank\DTOs\OrderResponse createOrder(array $data)
 * @method static \AZPayments\Kapitalbank\DTOs\OrderResponse createPreAuthOrder(array $data)
 * @method static \AZPayments\Kapitalbank\DTOs\OrderResponse createRecurringOrder(array $data)
 * @method static string getPaymentUrl(int $orderId, string $password)
 * @method static array getOrderDetails(int $orderId, array $options = [])
 * @method static array executeTransaction(int $orderId, array $data)
 * @method static array completePreAuth(int $orderId, float $amount)
 * @method static array refund(int $orderId, float $amount = null)
 * @method static array reversal(int $orderId, string $type = 'Full', float $amount = null)
 * @method static array setSrcToken(int $orderId, string $password, int $storedId)
 * @method static array setDstToken(int $orderId, string $password, string $pan)
 * @method static bool isSuccessful(string $status)
 * @method static \AZPayments\Kapitalbank\Services\KapitalbankService setLanguage(string $lang)
 * @method static \AZPayments\Kapitalbank\Services\KapitalbankService setCurrency(string $currency)
 *
 * @see \AZPayments\Kapitalbank\Services\KapitalbankService
 */
class Kapitalbank extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'kapitalbank';
    }
}