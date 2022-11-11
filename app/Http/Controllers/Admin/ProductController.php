<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImage;

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
        $products = Product::with("images")->latest()->paginate(10);
        $categories = Category::get();

        return Inertia::render('Product/Index', ["categories" => $categories, 'products' => $products, 'can' => [
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
        $categories = Category::get();
        $categoriesData = Category::latest()->paginate(5);

        $categoriesOption = [];
        foreach ($categories as $k => $c) {
            $categoriesOption[$k]["label"] = $c->name;
            $categoriesOption[$k]["value"] = $c->id;
        }
        $brands = Brand::get();
        $brandsData = Brand::latest()->paginate(5);

        $brandsOption = [];
        foreach ($brands as $k => $c) {
            $brandsOption[$k]["label"] = $c->name;
            $brandsOption[$k]["value"] = $c->id;
        }
        $unitsOption = ["Piece", "Kg", "Liter", "Grams"];
        return Inertia::render('Product/Create', ["categoriesData" => $categoriesData, "brandsData" => $brandsData, "categoriesOption" => $categoriesOption, "brandsOption" => $brandsOption, "unitsOption" => $unitsOption]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->image);
        // if ($request->hasFile('image')) {
        //     $image_path = $request->file('image')->store('image', 'public');
        // }

        Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'quantity' => ['required'],
            // 'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            "category" => ['required'],
            "brand" => ['required'],
            "unit" => ['required'],


        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }


        // dd($images_arr);
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
        $product->category_id = $request->category;
        $product->brand_id = $request->brand;
        $product->unit = $request->unit;

        // $product->image = url('/') . "/uploads/" . $image_name;
        $product->save();
        // $product->images()->createMany($images_arr);
        $imageStore = url('/') . "/uploads/products/" . $product->id . "/";

        $image_name = "";
        if (count($request->image) > 0) {
            foreach ($request->image as $f) {
                if ($request->hasFile('image')) {
                    $image_name = time() . '_' . str_replace(" ", "_", $f->getClientOriginalName());
                    $f->move(public_path('uploads/products/' . $product->id . "/"), $image_name);
                    $product_image = new  ProductImage();
                    // $product_image->image = $image_name;
                    $product_image->image = $imageStore . $image_name;
                    $product_image->product_id = $product->id;
                    $product_image->save();
                }
            }
            Product::where("id", $product->id)->update(array("image" => $imageStore . $image_name));
        }
        return Redirect::route('manage.products.index')->with('success', 'Product Created Successfully!!!');
    }

    // public function store(Request $request)
    // {
    //     // if ($request->hasFile('image')) {
    //     //     $image_path = $request->file('image')->store('image', 'public');
    //     // }

    //     $validator =  Validator::make($request->all(), [
    //         'title' => ['required'],
    //         'description' => ['required'],
    //         'price' => ['required'],
    //         'quantity' => ['required'],
    //         'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048'

    //     ])->validate();

    //     // if ($validator->fails()) {
    //     //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
    //     // }

    //     $image_name = "";
    //     if ($request->hasFile('image')) {
    //         $image_name = time() . '_' . str_replace(" ", "_", $request->image->getClientOriginalName());
    //         $request->file('image')->move(public_path('uploads'), $image_name);
    //     }
    //     $product = Product::where("title", $request->title)->first();
    //     if ($product) {
    //         return Redirect::back()->with('error', 'Product Already Exist !!!');
    //     }
    //     $product = new Product;
    //     $product->title = $request->title;
    //     $product->description = $request->description;
    //     $product->price = $request->price;
    //     $product->quantity = $request->quantity;
    //     $product->description = $request->description;
    //     $product->image = url('/') . "/uploads/" . $image_name;
    //     $product->save();
    //     return Redirect::route('manage.products.index')->with('success', 'Product Created Successfully!!!');
    // }

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
        $categories = Category::get();
        $categoriesData = Category::latest()->paginate(5);

        $categoriesOption = [];
        foreach ($categories as $k => $c) {
            $categoriesOption[$k]["label"] = $c->name;
            $categoriesOption[$k]["value"] = $c->id;
        }
        $brands = Brand::get();
        $brandsData = Brand::latest()->paginate(5);

        $brandsOption = [];
        foreach ($brands as $k => $c) {
            $brandsOption[$k]["label"] = $c->name;
            $brandsOption[$k]["value"] = $c->id;
        }
        $unitsOption = ["Piece", "Kg", "Liter", "Grams"];
        return Inertia::render('Product/Edit', ['product' => $product, "categoriesData" => $categoriesData, "brandsData" => $brandsData, "categoriesOption" => $categoriesOption, "brandsOption" => $brandsOption, "unitsOption" => $unitsOption]);
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
        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }
        // dd($product);
        Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'quantity' => 'digits_between:1,3',
            "description" => "required"
        ])->validate();

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->brand_id = $request->brand;
        $product->unit = $request->unit;
        $product->save();

        // $imageStore = url('/') . "/uploads/products/" . $product->id . "/";

        // $image_name = "";
        // if (count($request->image) > 0) {
        //     foreach ($request->image as $f) {
        //         if ($request->hasFile('image')) {
        //             $image_name = time() . '_' . str_replace(" ", "_", $f->getClientOriginalName());
        //             $f->move(public_path('uploads/products/' . $product->id . "/"), $image_name);
        //             $product_image = new  ProductImage();
        //             // $product_image->image = $image_name;
        //             $product_image->image = $imageStore . $image_name;
        //             $product_image->product_id = $product->id;
        //             $product_image->save();
        //         }
        //     }
        //     Product::where("id", $product->id)->update(array("image" => $imageStore . $image_name));
        // }

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

    public function detail($id)
    {
        $product = Product::with("images")->find($id);
        return Inertia::render('Client/Product/Detail', ['product' => $product]);
    }
}
