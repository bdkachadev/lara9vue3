<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Inertia\Inertia;
use App\Models\CustomTaxonomy;
use App\Models\TaxonomyAttribute;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class TaxonomyAttributeController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:show_taxonomy_attribute', ['only' => ['index', 'show']]);
        $this->middleware('can:add_taxonomy_attribute', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_taxonomy_attribute', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_taxonomy_attribute', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxonomiesOption = [];
        $taxonomyAttributes = TaxonomyAttribute::with("taxonomy")->latest()->paginate(10);
        $taxonomyAttributeData = $taxonomyAttributes;
        $customTaxonomy = CustomTaxonomy::orderBy("taxonomy_name")->get();
        foreach ($customTaxonomy as $ki => $taxonomy) {
            $taxonomiesOption[$ki]["label"] = $taxonomy->taxonomy_name;
            $taxonomiesOption[$ki]["value"] = $taxonomy->id;
        }
        return Inertia::render('TaxonomyAttribute/Index', [
            "taxonomiesOption" => array_unique($taxonomiesOption, SORT_REGULAR),
            "taxonomyAttributeData" => $taxonomyAttributeData,
            "can" => [
                'show' => Auth::user()->can('show_taxonomy_attribute'),
                'add' => Auth::user()->can('add_taxonomy_attribute'),
                'delete' => Auth::user()->can('delete_taxonomy_attribute'),
                'edit' => Auth::user()->can('edit_taxonomy_attribute'),
            ]
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
            'type' => ['required'],

            'name' => ['required'],
            'slug' => ['required']

        ])->validate();

        if ($request->id) {
            $taxonomyAttribute = TaxonomyAttribute::find($request->id);
            $taxonomyAttribute->attribute_name = $request->name;
            $taxonomyAttribute->attribute_slug = $request->slug;
            $taxonomyAttribute->taxonomy_id = $request->type;

            $taxonomyAttribute->save();
            return Redirect::back()->with('success', 'Attribute Updated Successfully!!!');
        } else {

            $taxonomyAttribute = TaxonomyAttribute::where("attribute_name", $request->name)->first();
            if ($taxonomyAttribute) {
                return Redirect::back()->with('error', 'Attribute Already Exist !!!');
            }
            $taxonomyAttribute = new TaxonomyAttribute;
            $taxonomyAttribute->attribute_name = $request->name;
            $taxonomyAttribute->taxonomy_id = $request->type;

            $taxonomyAttribute->attribute_slug = $request->slug;
            $taxonomyAttribute->save();
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
    public function edit($id)
    {
        return response()->json(TaxonomyAttribute::find($id));
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
        TaxonomyAttribute::where('id', $id)->delete();
        return Redirect::back()->with('success', 'Attribute Deleted Successfully!!!');
    }
}
