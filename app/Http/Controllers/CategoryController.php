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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::get();

        return Inertia::render('Category/Index', ["can" => [
            'show' => Auth::user()->can('show_category'),
            'add' => Auth::user()->can('add_category'),
            'delete' => Auth::user()->can('delete_category'),
            'edit' => Auth::user()->can('edit_category')
        ], 'categories' => $categories]);
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
            $category = Category::find($request->id);
            $category->name = $request->name;
            $category->save();
            return Redirect::back()->with('success', 'Category Updated SuccessFully!!!');
        } else {
            $category = Category::where("name", $request->name)->first();
            if ($category) {
                return Redirect::back()->with('error', 'Category Already Exist !!!');
            }
            $category = new Category;
            $category->name = $request->name;
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
        $category = Category::find($category->id);
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
