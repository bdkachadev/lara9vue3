<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Option;
use Validator;

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

        Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'holder_name' => ['required'],

        ])->validate();
        // dump($request);
        // dd($request->user());
        $user          = $request->user();
        $paymentMethod = $request->input('payment_method');
        $shipping_charge = Option::where("oprion_key", "shipping_charge")->value("option_value");

        $t = $request->price + $shipping_charge;
        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge($t * 100, $paymentMethod);

            $order = new Order;
            $order->cart_ids = implode(",", $request->cart_ids);
            // $order->payment_transaction_id=;
            $order->order_status    = "confirmed";
            $order->name = $request->name;
            $order->user_id = auth()->user()->id;
            $order->shipping_charge = $shipping_charge;
            $order->order_subtotal = $request->price;
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

        return redirect()->route('manage.orders.show', $order->id)->with('success', 'Thank You For Purchased! Your Order Confirmed Successfully!');
    }
}
