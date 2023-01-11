<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Models\Attribute;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AttributeValueController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_attribute_value', ['only' => ['index', 'show']]);
        $this->middleware('can:add_attribute_value', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_attribute_value', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_attribute_value', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributesOption = [];

        $attributes = Attribute::select("id", "name")->get();

        foreach ($attributes as $attkey => $attribute) {
            $attributesOption[$attkey]["label"] = $attribute->name;
            $attributesOption[$attkey]["value"] = $attribute->id;
        }
        // dd($attributesOption);
        // dd($attributesValueOption);

        $attributesValueData = AttributeValue::with("attribute")->latest()->paginate(10);
        return Inertia::render('AttributeValue/Index', [

            "attributesValueData" => $attributesValueData,
            "attributesOption" => $attributesOption,
            "can" =>  [
                'show' => Auth::user()->can('show_attribute_value'),
                'add' => Auth::user()->can('add_attribute_value'),
                'delete' => Auth::user()->can('delete_attribute_value'),
                'edit' => Auth::user()->can('edit_attribute_value'),
            ],
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
            $attributeValue->slug = $request->slug;
            $attributeValue->value = ucwords($request->value);


            $attributeValue->save();
            return Redirect::back()->with('success', 'Attribute Value Updated SuccessFully!!!');
        } else {
            $attributeValue = AttributeValue::where("attribute_id", $request->attribute_id)->where("value", $request->value)->first();
            if ($attributeValue) {
                return Redirect::back()->with('error', 'Attribute Value Already Exist !!!');
            }
            $attributeValue = new AttributeValue;
            $attributeValue->attribute_id = $request->type;
            $attributeValue->slug = $request->slug;
            $attributeValue->value = ucwords($request->value);

            $attributeValue->save(); // = $request->description;
        }
        return Redirect::back()->with('success', 'Attribute Value Created Successfully!!!');
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
    public function destroy($id)
    {
        //
        AttributeValue::where("id", $id)->delete();
        return Redirect::back()->with("success", "Attribute Value Deleted Successfully");
    }
}
