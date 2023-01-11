<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Cart;
use Session;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_order', ['only' => ['index', 'show']]);
        $this->middleware('can:add_order', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_order', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_order', ['only' => ['destroy']]);
        $this->middleware('can:cancel_order', ['only' => ['cancel']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    // public function cartList()
    {
        // dump(auth()->user()->id);
        if (Auth::user()->hasRole("user")) {
            $orders = Order::where("user_id", auth()->user()->id)->latest()->paginate(10);
        } else {
            $orders = Order::latest()->paginate(10);
        }
        // dd($orders);
        return Inertia::render('Order/Index', [
            "orders" => $orders,
            'can' => [
                'show' => Auth::user()->can('show_order'),
                'add' => Auth::user()->can('add_order'),
                'delete' => Auth::user()->can('delete_order'),
                'edit' => Auth::user()->can('edit_order'),
                'cancel' => Auth::user()->can('cancel_order'),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // dd(Auth::user()->hasRole('user'));
        // if (Auth::user()->hasRole('user')) {
        $order = Order::where("id", $id)->first();
        $cart = Cart::select("carts.*", "p.title", "p.description")->join("products as p", "p.id", "carts.product_id")->whereIn('carts.id', explode(",", $order->cart_ids))->get();
        // dd($order);
        // dd($cart);
        // foreach($order as $o){
        //     dd($o->title);
        // }
        return Inertia::render('Client/MyOrder/Index', [
            "order" => $order,
            "cart" => $cart
        ]);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
        $order->delete();
        Session::flash('success', 'Order removed Successfully !');
    }

    public function changeStatus(Request $request)
    {
        // \DB::enableQueryLog();
        Order::where("id", $request->id)->update(["order_status" => $request->status]);
        // dd(\DB::getQueryLog());
        Session::flash('success', 'Order status Changed Successfully !');
    }
    public function cancelOrder(Request $request)
    {
        Order::where("id", $request->id)->update(["order_status" => 'canceled']);

        Session::flash('success', 'Your Order Cancelled Successfully!');
    }
}
