<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Validator;
use Inertia\Inertia;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_category', ['only' => ['index', 'show']]);
        $this->middleware('can:add_category', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_category', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_category', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cat = Category::with("parent_category", "sub_categories")->orderBy('name', 'asc');
        // $categories = $cat->paginate(10);
        $categories = $cat->where('parent_id',  NULL)->get();
        // dd($categories);
        foreach ($categories as $k => $c) {
            $categories[$k]["label"] = $c->name;
            $categories[$k]["value"] = $c->id;
            $categories[$k]["checked"] = false;
        }
        $parentCategories = [];
        foreach ($cat->get() as $ky => $ca) {
            $parentCategories[$ky]["label"] = $ca->name;
            $parentCategories[$ky]["value"] = $ca->id;
        }

        return Inertia::render('Category/Index', ["can" => [
            'show' => Auth::user()->can('show_category'),
            'add' => Auth::user()->can('add_category'),
            'delete_category' => Auth::user()->can('delete_category'),
            'edit_category' => Auth::user()->can('edit_category'),

        ], 'categories' => $categories, "parentCategories" => $parentCategories]);
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
            'slug' => 'required',
            'parent_id' => 'nullable|numeric'


        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }
        if ($request->id) {
            $category = Category::find($request->id);
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->description = $request->description;
            $category->parent_id = $request->parent_id;

            $category->save();
            return Redirect::back()->with('success', 'Category Updated SuccessFully!!!');
        } else {
            $category = Category::where("name", $request->name)->first();
            if ($category) {
                return Redirect::back()->with('error', 'Category Already Exist !!!');
            }
            $category = new Category;
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->parent_id = $request->parent_id;
            $category->description = $request->description;
            $category->save();
        }
        return Redirect::back()->with('success', 'Category Created Successfully!!!');
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
    public function edit(Category $category)
    {
        $category = Category::with("parent_category", "sub_categories")->find($category->id);
        return response()->json($category);
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
    public function destroy(Category $category)
    {
        //
        $category->delete();
        return Redirect::back()->with("success", "Category Deleted Successfully");
    }
}
