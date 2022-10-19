<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_product', ['only' => ['index', 'show']]);
        $this->middleware('can:add_product', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_product', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_product', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return Inertia::render('Product/Index', ['products' => $products, 'can' => [
            'show' => Auth::user()->can('show_product'),
            'add' => Auth::user()->can('add_product'),
            'delete' => Auth::user()->can('delete_product'),
            'edit' => Auth::user()->can('edit_product'),

        ]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return Inertia::render('Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('image', 'public');
        }

        $validator =  Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'quantity' => ['required'],
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048'

        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }

        $image_path = '';
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('image', 'public');
        }
        $product = Product::where("title", $request->title)->first();
        if ($product) {
            return Redirect::back()->with('error', 'Product Already Exist !!!');
        }
        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->image = $image_path;
        $product->save();
        return Redirect::route('manage.products.index')->with('success', 'Product Created Successfully!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return Inertia::render('Product/Edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $validator =  Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'quantity' => ['required'],
        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->save();

        return Redirect::route('manage.products.index')->with('success', 'Product Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return Redirect::back()->with("success", "Product Deleted Successfully");
    }
}
