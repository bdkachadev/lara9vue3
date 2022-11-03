<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    //
    public function getStripeSession(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET_KEY"));
        $checkout = $stripe->checkout->sessions->create([
            'success_url' => url('/success'),
            'cancel_url' => url('/cancel'),
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => $request->price * 100,
                        'product_data' => [
                            'name' => 'Order Payment'
                        ]
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
        ]);
        return $checkout;
    }
}
