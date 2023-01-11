<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Validator;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_tag', ['only' => ['index', 'show']]);
        $this->middleware('can:add_tag', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_tag', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_tag', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tags = Tag::latest()->paginate(10);

        return Inertia::render('Tag/Index', [
            "can" => [
                'show' => Auth::user()->can('show_tag'),
                'add' => Auth::user()->can('add_tag'),
                'delete' => Auth::user()->can('delete_tag'),
                'edit' => Auth::user()->can('edit_tag')
            ],  'tags' => $tags
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
            'description' => 'required',

        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }
        if ($request->id) {
            $tag = Tag::find($request->id);
            $tag->name = $request->name;
            $tag->slug = $request->slug;
            $tag->description = $request->description;

            $tag->save();
            return Redirect::back()->with('success', 'Tag Updated SuccessFully!!!');
        } else {
            $tag = Tag::where("name", $request->name)->first();
            if ($tag) {
                return Redirect::back()->with('error', 'Tag Already Exist !!!');
            }
            $tag = new Tag;
            $tag->name = $request->name;
            $tag->slug = $request->slug;
            $tag->description = $request->description;
            $tag->save();
        }
        return Redirect::back()->with('success', 'Tag Created Successfully!!!');
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
    public function edit(Tag $tag)
    {
        $tag = Tag::find($tag->id);
        return response()->json($tag);
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
    public function destroy(Tag $tag)
    {
        //
        $tag->delete();
        return Redirect::back()->with("success", "Tag Deleted Successfully");
    }
}
