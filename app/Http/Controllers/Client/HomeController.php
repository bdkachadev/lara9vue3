<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
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
        $productsCount = Product::count();
        $usersCount = User::whereNot('id', 1)->count();
        $products = Product::all();


        $categories = Category::get();
        $categoriesAll = [];
        foreach ($categories as $k => $c) {
            $categoriesAll[$k]["label"] = $c->name;
            $categoriesAll[$k]["value"] = $c->id;
            $categoriesAll[$k]["id"] = $c->id;
            $categoriesAll[$k]["checked"] = false;
        }
        $brands = Brand::get();

        // $categoriesData = Category::latest()->paginate(5);

        $brandsAll = [];
        foreach ($brands as $k => $c) {
            $brandsAll[$k]["label"] = $c->name;
            $brandsAll[$k]["value"] = $c->id;
            $brandsAll[$k]["id"] = $c->id;
            $brandsAll[$k]["value"] = false;
        }

        return Inertia::render('Client/Home', [["can" => [
            'show' => auth()->user()->can('show_home'),
        ]], "brandsAll" => $brandsAll, "categoriesAll" => $categoriesAll, "productsCount" => $productsCount, "usersCount" => $usersCount, "products" => $products]);
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
