<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use Illuminate\Support\Facades\Redirect;
use Validator;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $attribute = Attribute::find($request->id);
            $attribute->slug = strtolower($request->name);
            $attribute->name = ucwords($request->name);
            $attribute->save();
            return Redirect::back()->with('success', 'Attribute Updated SuccessFully!!!');
        } else {
            $attribute = Attribute::where("name", $request->name)->first();
            if ($attribute) {
                return Redirect::back()->with('error', 'Attribute Already Exist !!!');
            }
            $attribute = new Attribute;
            $attribute->slug = strtolower($request->name);
            $attribute->name = ucwords($request->name);
            $attribute->save();
        }
        return Redirect::route('manage.products.create')->with('success', 'Attribute Created Successfully!!!');
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
    public function edit(Attribute $attribute)
    {
        $attribute = Attribute::find($attribute->id);
        return response()->json($attribute);
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
    public function destroy(Attribute $attribute)
    {
        //
        dd($attribute);
        $attribute->delete();
        return Redirect::back()->with("success", "Attribute Deleted Successfully");
    }
}
