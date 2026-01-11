<?php

namespace AZPayments\Kapitalbank\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use AZPayments\Kapitalbank\Facades\Kapitalbank;
use AZPayments\Kapitalbank\Events\PaymentSuccessful;
use AZPayments\Kapitalbank\Events\PaymentFailed;
use AZPayments\Kapitalbank\Exceptions\KapitalbankException;

class KapitalbankController extends Controller
{
    /**
     * Ödəniş callback-i
     * Kapitalbank ödəniş tamamlandıqdan sonra bura yönləndirir
     */
    public function callback(Request $request)
    {
        Log::info('Kapitalbank Callback', $request->all());

        try {
            // Callback məlumatlarını yoxla
            $result = Kapitalbank::verifyCallback($request->all());
            
            $orderId = $result['order_id'];
            $status = $result['actual_status'];
            $order = $result['order'];

            // Saxlanılan kart ID-si (əgər varsa)
            $storedTokenId = $order['storedTokens'][0]['id'] ?? null;

            if ($result['is_successful']) {
                // Uğurlu ödəniş eventi
                event(new PaymentSuccessful(
                    orderId: $orderId,
                    status: $status,
                    orderDetails: $order,
                    storedTokenId: $storedTokenId
                ));

                return redirect()
                    ->to(config('kapitalbank.success_url'))
                    ->with([
                        'kapitalbank_order_id' => $orderId,
                        'kapitalbank_status' => $status,
                        'kapitalbank_success' => true,
                    ]);
            } else {
                // Uğursuz ödəniş eventi
                event(new PaymentFailed(
                    orderId: $orderId,
                    status: $status,
                    orderDetails: $order,
                    errorCode: $status,
                    errorMessage: "Ödəniş uğursuz oldu: {$status}"
                ));

                return redirect()
                    ->to(config('kapitalbank.error_url'))
                    ->with([
                        'kapitalbank_order_id' => $orderId,
                        'kapitalbank_status' => $status,
                        'kapitalbank_success' => false,
                        'kapitalbank_error' => "Ödəniş uğursuz oldu",
                    ]);
            }

        } catch (KapitalbankException $e) {
            Log::error('Kapitalbank Callback Error', $e->toArray());

            return redirect()
                ->to(config('kapitalbank.error_url'))
                ->with([
                    'kapitalbank_success' => false,
                    'kapitalbank_error' => $e->getMessage(),
                ]);

        } catch (\Exception $e) {
            Log::error('Kapitalbank Callback Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->to(config('kapitalbank.error_url'))
                ->with([
                    'kapitalbank_success' => false,
                    'kapitalbank_error' => 'Xəta baş verdi',
                ]);
        }
    }

    /**
     * Uğurlu ödəniş səhifəsi
     */
    public function success(Request $request)
    {
        return view('kapitalbank::success', [
            'order_id' => session('kapitalbank_order_id'),
            'status' => session('kapitalbank_status'),
        ]);
    }

    /**
     * Uğursuz ödəniş səhifəsi
     */
    public function error(Request $request)
    {
        return view('kapitalbank::error', [
            'order_id' => session('kapitalbank_order_id'),
            'status' => session('kapitalbank_status'),
            'error' => session('kapitalbank_error'),
        ]);
    }
}