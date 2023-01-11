<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Validator;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_brand', ['only' => ['index', 'show']]);
        $this->middleware('can:add_brand', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_brand', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_brand', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $brands = Brand::latest()->paginate(10);

        // foreach ($brands as $k => $c) {
        //     $brands[$k]["label"] = $c->name;
        //     $brands[$k]["value"] = $c->id;
        // }


        return Inertia::render('Brand/Index', ["can" => [
            'show' => Auth::user()->can('show_brand'),
            'add' => Auth::user()->can('add_brand'),
            'delete_brand' => Auth::user()->can('delete_brand'),
            'edit_brand' => Auth::user()->can('edit_brand')
        ],  'brands' => $brands]);
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
        $validator =  Validator::make($request->all(), [
            'name' => 'required',
        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }
        if ($request->id) {
            $brand = Brand::find($request->id);
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->description = $request->description;
            $brand->save();
            return Redirect::back()->with('success', 'Brand Updated SuccessFully!!!');
        } else {
            $brand = Brand::where("name", $request->name)->first();
            if ($brand) {
                return Redirect::back()->with('error', 'Brand Already Exist !!!');
            }
            $brand = new Brand;
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->description = $request->description;
            $brand->save();
        }
        return Redirect::back()->with('success', 'Bradn Created Successfully!!!');
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
    public function edit(Brand $brand)
    {
        $brand = Brand::find($brand->id);
        return response()->json($brand);
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
    public function destroy(Brand $brand)
    {
        //
        $brand->delete();
        return Redirect::back()->with("success", "Brand Deleted Successfully");
    }
}
