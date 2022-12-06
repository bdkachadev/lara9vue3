<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_cart', ['only' => ['index', 'show']]);
        $this->middleware('can:add_cart', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_cart', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_cart', ['only' => ['destroy']]);
        $this->middleware('can:buy_now', ['only' => ['checkout']]);
    }
    public function index()
    // public function cartList()
    {
        $carts = Cart::select("p.description", "carts.id", "carts.quantity", "p.title",  "p.price")->join('products as p', 'p.id', 'carts.product_id')->latest("carts.created_at")->where('carts.user_id', auth()->user()->id)->where('is_placed', 0)->paginate(4);
        // dd($cartItems);
        // return view('cart', compact('cartItems'));

        // if ($id) {
        //     $carts = Cart::select("p.description", "carts.id", "carts.quantity", "p.title", "p.image", "p.price")->join('products as p', 'p.id', 'carts.product_id')->latest("carts.created_at")->where('carts.user_id', auth()->user()->id)->where('carts.id', $id)->get();
        // } else {
        $cartsCal = Cart::select("p.description", "carts.id", "carts.quantity", "p.title",  "p.price")->join('products as p', 'p.id', 'carts.product_id')->where('is_placed', 0)->where('carts.user_id', auth()->user()->id)->get();
        // }
        $subTotal = 0;
        foreach ($cartsCal->toArray() as $ke => $st) {
            $subTotal += ($st['price'] * $st['quantity']);
        }
        $shippingTax = 10;
        $total = $subTotal + $shippingTax;
        return Inertia::render('Client/Cart/Index', [
            "carts" => $carts,
            "cartsCal" => $cartsCal,
            "shippingTax" => $shippingTax,
            "subTotal" => $subTotal,
            "total" => $total,
            'can' => [
                'show' => Auth::user()->can('show_cart'),
                'add' => Auth::user()->can('add_cart'),
                'delete' => Auth::user()->can('delete_cart'),
                'edit' => Auth::user()->can('edit_cart'),
                'buy' => Auth::user()->can('buy_now'),
            ]
        ]);
    }


    // public function addToCart(Request $request)
    public function store(Request $request)
    {
        $cart = Cart::where("is_placed", 0)
            ->where('product_id', $request->id)
            ->where('user_id', auth()->user()->id);
        if ($request->variant_id) {
            $cart = $cart->where("variant_id", $request->variant_id);
        }
        $cart = $cart->where('user_id', auth()->user()->id)->first();
        if ($cart) {
            $cart->quantity += $request->count;
        } else {
            $cart = new Cart;
            $cart->quantity = $request->count;
        }
        $cart->user_id = auth()->user()->id;
        $cart->product_id = $request->id;
        $cart->variant_id = $request->variant_id;
        $cart->save();
        Session::flash('success', 'Product is Added to Cart Successfully !');

        // return redirect()->route('cart.list');
        // return Redirect::route('cart.index')->with('success', 'Product is Added to Cart Successfully!!!');
    }

    // public function updateCart(Request $request)
    public function update(Request $request)
    {
        $cart = Cart::find($request->id);
        $cart->user_id = auth()->user()->id;
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->save();

        // session()->flash('success', 'Item Cart is Updated Successfully !');
        return Redirect::route('cart.index')->with('success', 'Item Cart is Updated Successfully !!!');

        // return redirect()->route('cart.list');
    }

    // public function removeCart(Request $request)
    public function destroy($id)
    {
        Cart::where('id', $id)->where('is_placed', 0)->delete();
        Session::flash('success', 'Item removed Successfully !');
        // return Redirect::back()->with("success", "Item removed Successfully");
    }

    public function clearAllCart()
    {
        Cart::where('user_id', auth()->user()->id)->where('is_placed', 0)->delete();
        Session::flash('success', 'Cart Cleared Successfully !');
    }

    public function removeFromCheckout(Request $request)
    {
        Cart::where('id', $request->id)->where('is_placed', 0)->delete();
        Session::flash('success', 'Item Removed Successfully !');
    }

    public function changeQuantity(Request $request)
    {
        Cart::where('id', $request->id)->update(['quantity' => $request->quantity]);
        Session::flash('success', 'Product Quantity Changed Successfully !');
    }

    public function checkout($id = null)
    {
        if ($id) {
            $carts = Cart::select("p.description", "carts.id", "carts.quantity", "p.title", "p.image", "p.price")->join('products as p', 'p.id', 'carts.product_id')->latest("carts.created_at")->where('carts.user_id', auth()->user()->id)->where('carts.is_placed', 0)->where('carts.id', $id)->get();
        } else {
            $carts = Cart::select("p.description", "carts.id", "carts.quantity", "p.title", "p.image", "p.price")->join('products as p', 'p.id', 'carts.product_id')->latest("carts.created_at")->where('carts.user_id', auth()->user()->id)->where('carts.is_placed', 0)->get();
        }
        $subTotal = 0;
        $cartIds = [];
        foreach ($carts->toArray() as $ke => $st) {
            $subTotal += $st['price'] * $st['quantity'];
            $cartIds[] = $st["id"];
        }
        $shippingTax = 10;
        $total = $subTotal + $shippingTax;
        $user = User::find(auth()->user()->id);
        $intent = auth()->user()->createSetupIntent();

        // dd($cartItems);
        // return view('cart', compact('cartItems'));
        return Inertia::render('Client/Cart/Checkout', ["intent" => $intent, "user" => $user, "carts" => $carts, "shippingTax" => $shippingTax, "subTotal" => $subTotal, "total" => $total, 'cartIds' => $cartIds]);
    }
}
