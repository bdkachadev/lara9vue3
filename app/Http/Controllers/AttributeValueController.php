<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Redirect;
use Validator;


class AttributeValueController extends Controller
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
        // dd($request);
        $validator =  Validator::make($request->all(), [
            'type' => 'required',
            'value' => 'required',

        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }
        if ($request->id) {
            $attributeValue = AttributeValue::find($request->id);
            $attributeValue->attribute_id = $request->type;
            $attributeValue->slug = strtolower($request->value);
            $attributeValue->value = ucwords($request->value);
            $attributeValue->save();
            return Redirect::back()->with('success', 'Attribute Value Updated SuccessFully!!!');
        } else {
            $attributeValue = AttributeValue::where("value", $request->value)->first();
            if ($attributeValue) {
                return Redirect::back()->with('error', 'Attribute Value Already Exist !!!');
            }
            $attributeValue = new AttributeValue;
            $attributeValue->attribute_id = $request->type;
            $attributeValue->slug = strtolower($request->value);
            $attributeValue->value = ucwords($request->value);
            $attributeValue->save();
        }
        return Redirect::route('manage.products.create')->with('success', 'Attribute Value Created Successfully!!!');
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
        $Value = AttributeValue::find($id);
        return response()->json($Value);
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
    public function destroy(AttributeValue $attributeValue)
    {
        //
        $attributeValue->delete();
        return Redirect::back()->with("success", "Attribute Value Deleted Successfully");
    }
}
