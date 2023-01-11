<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use App\Models\Cart;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Brand;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_home', ['only' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function welcome(){

    // }
    public function index()
    {
        if (auth()->user()->hasRole('super_admin'))
            return Redirect::route("dashboard");

        $productsCount = Product::count();
        $usersCount = User::whereNot('id', 1)->count();
        $products = Product::with("images", "categories", "brands", "variants", "tags", "taxonomy_attributes")->latest()->get();


        $categories = Category::with("parent_category", "sub_categories")->where('parent_id', '=', null)->get();
        // dd($categories);
        foreach ($categories as $k => $c) {
            $categories[$k]["label"] = $c->name;
            $categories[$k]["value"] = $c->id;
            $categories[$k]["checked"] = false;
        }
        // $categoriesAll = [];
        // foreach ($categories as $k => $c) {
        //     $categoriesAll[$k]["label"] = $c->name;
        //     $categoriesAll[$k]["value"] = $c->id;
        //     $categoriesAll[$k]["id"] = $c->id;
        //     $categoriesAll[$k]["checked"] = false;
        //     $categoriesAll[$k]["sub_categories"] = $c->sub_categories;
        //     $categoriesAll[$k]["parent_category"] = $c->parent_category;
        // }
        // $brands = Brand::get();
        $brands = Brand::get();
        // dd($brands);
        foreach ($brands as $k => $b) {
            $brands[$k]["label"] = $b->name;
            $brands[$k]["value"] = $b->id;
        }

        // $categoriesData = Category::latest()->paginate(5);

        // $brandsAll = [];
        // foreach ($brands as $k => $c) {
        //     $brandsAll[$k]["label"] = $c->name;
        //     $brandsAll[$k]["value"] = $c->id;
        //     $brandsAll[$k]["id"] = $c->id;
        //     $brandsAll[$k]["value"] = false;
        // }

        return Inertia::render('Client/Home', ["can" => [
            'show' => auth()->user()->can('show_home'),
            'edit_category' => auth()->user()->can('edit_category'),
            'edit_brand' => auth()->user()->can('edit_brand'),
            'delete_brand' => auth()->user()->can('delete_brand'),
            'delete_category' => auth()->user()->can('delete_category'),
        ], "brandsAll" => $brands, "categoriesAll" => $categories, "productsCount" => $productsCount, "usersCount" => $usersCount, "products" => $products]);
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
    public function destroy($id)
    {
        //
    }

    public function getCount()
    {
        $count = Cart::where('user_id', auth()->user()->id)->where('is_placed', 0)->sum('quantity');
        return $count;
    }
}
