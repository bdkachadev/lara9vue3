<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Validator;

class permissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return Inertia::render('Permissions', ['roles' => $roles, 'permissions' => $permissions]);
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
            'name' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        }

        if ($request->id) {
            $permission = Permission::find($request->id);
            $permission->name = $request->name;
            $permission->save();

            return Redirect::back()->with('success', 'Permission Updated SuccessFully!!!');
        } else {
            $permission = Permission::where("name", $request->name)->first();
            if ($permission) {
                return Redirect::back()->with('error', 'Permission Already Exist!!!');
            }
            $permission = new Permission;
            $permission->name = $request->name;
            $permission->save();
        }
        return Redirect::back()->with('success', 'Permission Created Successfully!!!');
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
    public function edit(Request $request)
    {
        $permissions = Permission::find($request->id);
        return response()->json($permissions);
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignRole(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'role' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        }


        $permission = new Permission;
        $permission->name = $request->name;
        $permission->save();

        return Redirect::back()->with('success', 'Assign Role Successfully!!!');
    }
}
