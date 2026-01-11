<?php

namespace App\Http\Controllers;

use AZPayments\Kapitalbank\Facades\Kapitalbank;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Ödəniş formasını göstərir
     * İstifadəçi bu səhifədə məbləği daxil edəcək
     */
    public function checkout()
    {
        return view('payment.checkout');
    }

    /**
     * Ödənişi başladır və istifadəçini Kapitalbank səhifəsinə yönləndirir
     * Form göndərildikdə bu metod işə düşür
     */
    public function pay(Request $request)
    {
        // Daxil edilən məlumatları yoxlayırıq
        $request->validate([
            'amount' => 'required|numeric|min:0.1',
        ]);

        try {
            // Kapitalbank-da ödəniş yaradırıq
            $order = Kapitalbank::createOrder([
                'amount' => $request->amount,
                'description' => 'Sifariş ödənişi',
                'title' => 'Online Ödəniş',
            ]);

            // İstifadəçini Kapitalbank ödəniş səhifəsinə yönləndiririk
            // İstifadəçi bu səhifədə kart məlumatlarını daxil edəcək
            return $order->redirect();

        } catch (\Exception $e) {
            // Əgər xəta baş verdisə, istifadəçiyə bildiririk
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    /**
     * Kapitalbank-dan callback gəldikdə bu metod işə düşür
     * Ödəniş tamamlandıqdan sonra istifadəçi bura yönləndirilir
     */
    public function callback(Request $request)
    {
        try {
            // Callback məlumatlarını yoxlayırıq
            $result = Kapitalbank::verifyCallback($request->all());

            if ($result['is_successful']) {
                // ✅ Ödəniş uğurlu!
                // Burada sifarişi "ödənildi" statusuna keçirə bilərsiniz
                
                return redirect('/payment/success')->with([
                    'order_id' => $result['order_id'],
                    'message' => 'Ödəniş uğurla tamamlandı!'
                ]);
            }

            // ❌ Ödəniş uğursuz
            return redirect('/payment/error')->with([
                'order_id' => $result['order_id'],
                'message' => 'Ödəniş uğursuz oldu.'
            ]);

        } catch (\Exception $e) {
            return redirect('/payment/error')->with([
                'message' => 'Xəta: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Ödəniş uğurlu olduqda istifadəçi bu səhifəyə gəlir
     */
    public function success()
    {
        return view('payment.success', [
            'order_id' => session('order_id'),
            'message' => session('message', 'Ödəniş uğurla tamamlandı!')
        ]);
    }

    /**
     * Ödəniş uğursuz olduqda istifadəçi bu səhifəyə gəlir
     */
    public function error()
    {
        return view('payment.error', [
            'order_id' => session('order_id'),
            'message' => session('message', 'Ödəniş uğursuz oldu.')
        ]);
    }
}