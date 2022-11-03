<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function test(Request $request)
    {
        // dd("jh");
        $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET_KEY"));

        // $customer = $stripe->customers->create([
        //     'name' => 'John',
        //     'email' => 'test@example.com',
        //     'description' => 'My First Test Customer (created for API docs)',
        // ]);

        $intent = $stripe->paymentIntents->create(
            [
                'amount' => 3000,
                'currency' => 'eur',
            ]
        );

        // $paymentIntent = $stripe->paymentIntents->create([
        //     'amount' => 2000,
        //     'currency' => 'inr',
        //     // 'payment_method_types' => ['card'],
        //     'customer' => "cus_MjT7hN4UNJdIX2",
        //     'type' => 'card',
        //     'card' => [
        //         'number' => '4242424242424242',
        //         'exp_month' => 11,
        //         'exp_year' => 2023,
        //         'cvc' => '314',
        //     ],

        // ]);
        // dd($paymentIntent);
        // dd()
    }
}
