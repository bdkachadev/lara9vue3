<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CustomTaxonomy;
use App\Models\TaxonomyAttribute;
use Validator;
use Illuminate\Support\Facades\Redirect;

class CustomTaxonomyController extends Controller
{
    public function __construct()
    {
        // $this->middleware('can:show_taxonomy', ['only' => ['index', 'show']]);
        // $this->middleware('can:add_taxonomy', ['only' => ['create', 'store']]);
        // $this->middleware('can:edit_taxonomy', ['only' => ['edit', 'update']]);
        // $this->middleware('can:delete_taxonomy', ['only' => ['destroy']]);
        // $this->middleware('can:cancel_taxonomy', ['only' => ['cancel']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxonomiesOption = [];
        $taxonomies = CustomTaxonomy::get();
        $taxonomiesData = $taxonomies;

        foreach ($taxonomies as $ki => $taxonomy) {
            $taxonomiesOption[$ki]["label"] = $taxonomy->taxonomy_name;
            $taxonomiesOption[$ki]["value"] = $taxonomy->id;
        }
        $taxonomyAttributeData = TaxonomyAttribute::get();
        return Inertia::render('CustomTaxonomy/Index', [
            "taxonomiesOption" => $taxonomiesOption,
            "taxonomiesData" => $taxonomiesData,
            "taxonomyAttributeData" => $taxonomyAttributeData,
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
        Validator::make($request->all(), [
            'name' => ['required'],
            'slug' => ['required']

        ])->validate();

        if ($request->id) {
            $CustomTaxonomy = CustomTaxonomy::find($request->id);
            $CustomTaxonomy->taxonomy_name = $request->name;
            $CustomTaxonomy->taxonomy_description = $request->description;
            $CustomTaxonomy->taxonomy_slug = $request->slug;
            $CustomTaxonomy->save();
            return Redirect::back()->with('success', 'Taxonomy Updated Successfully!!!');
        } else {

            $CustomTaxonomy = CustomTaxonomy::where("taxonomy_name", $request->name)->first();
            if ($CustomTaxonomy) {
                return Redirect::back()->with('error', 'Taxonomy Already Exist !!!');
            }
            $CustomTaxonomy = new CustomTaxonomy;
            $CustomTaxonomy->taxonomy_name = $request->name;
            $CustomTaxonomy->taxonomy_description = $request->description;
            $CustomTaxonomy->taxonomy_slug = $request->slug;
            $CustomTaxonomy->save();
        }
        return Redirect::back()->with('success', 'Taxonomy Created Successfully!!!');
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
    public function edit(CustomTaxonomy $CustomTaxonomy)
    {
        return response()->json($CustomTaxonomy);
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

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        CustomTaxonomy::where('id', $id)->delete();
        return Redirect::back()->with('success', 'CustomTaxonomy Deleted Successfully!!!');
    }
}
