<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Order;

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
    public function purchase(Request $request)
    {
        // dump($request);
        // dd($request->user());
        $user          = $request->user();
        $paymentMethod = $request->input('payment_method');

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge($request->price * 100, $paymentMethod);

            $order = new Order;
            $order->cart_ids = json_encode($request->cart_ids);
            // $order->payment_transaction_id=;
            $order->order_total = $request->price;
            $order->order_status    = "paid";
            $order->name = $request->name;
            $order->user_id = auth()->user()->id;

            $order->email = $request->email;
            $order->address = $request->address;
            $order->city = $request->city;
            $order->notes = $request->notes;
            $order->save();
            Order::where('id', $order->id)->update(["order_id" => "quanticedge-order-" . $order->id]);
            Cart::whereIn('id', $request->cart_ids)->update(["is_placed" => 1]);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('success', 'Thank You For Purchased! Your Order Placed successfully!');
    }
}
