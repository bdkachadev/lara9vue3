<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Inertia\Inertia;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Auth;

class AttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_attribute', ['only' => ['index', 'show']]);
        $this->middleware('can:add_attribute', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_attribute', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_attribute', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $attributesData = Attribute::with("values")->latest()->paginate(10);
        return Inertia::render('Attribute/Index', [

            "attributesData" => $attributesData,
            "can" =>  [
                'show' => Auth::user()->can('show_attribute'),
                'add' => Auth::user()->can('add_attribute'),
                'delete' => Auth::user()->can('delete_attribute'),
                'edit' => Auth::user()->can('edit_attribute'),
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
        $validator =  Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',

        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }
        if ($request->id) {
            $attribute = Attribute::find($request->id);
            $attribute->slug = $request->slug;
            $attribute->description = $request->description;
            $attribute->name = ucwords($request->name);
            $attribute->save();
            return Redirect::back()->with('success', 'Attribute Updated SuccessFully!!!');
        } else {
            $attribute = Attribute::where("name", $request->name)->first();
            if ($attribute) {
                return Redirect::back()->with('error', 'Attribute Already Exist !!!');
            }
            $attribute = new Attribute;
            $attribute->slug = $request->slug;
            $attribute->description = $request->description;
            $attribute->name = ucwords($request->name);
            $attribute->save();
        }
        return Redirect::back()->with('success', 'Attribute Created Successfully!!!');
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
        $attribute->delete();
        return Redirect::back()->with("success", "Attribute Deleted Successfully");
    }
}
