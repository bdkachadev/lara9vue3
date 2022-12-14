<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use Validator;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_permission', ['only' => ['index', 'show']]);
        $this->middleware('can:add_permission', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_permission', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_permission', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::whereNotIn('name', ['super_admin'])->get();
        $permissions = Permission::with('roles')->latest()->paginate(10);
        $options = array_column($roles->toArray(), "name");

        return Inertia::render('Permissions', ["can" => [
            'show' => Auth::user()->can('show_permission'),
            'add' => Auth::user()->can('add_permission'),
            'delete' => Auth::user()->can('delete_permission'),
            'edit' => Auth::user()->can('edit_permission')
        ], 'roles' => $roles, 'permissions' => $permissions, "options" => $options]);
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
            // 'role' => 'required'
        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }
        if ($request->id) {
            $permission = Permission::find($request->id);
            $permission->name = $request->name;
            $permission->save();
            // sync Roles
            if ($request->role) {
                $permission->syncRoles($request->role);
            }
            // if (!$permission->hasRole('super_admin')) {
            //     $permission->assignRole('super_admin');
            // }

            return Redirect::back()->with('success', 'Permission Updated SuccessFully!!!');
        } else {
            $permission = Permission::where("name", $request->name)->first();
            if ($permission) {
                return Redirect::back()->with('error', 'Permission Already Exist!!!');
            }
            $permission = new Permission;
            $permission->name = $request->name;
            $permission->save();
            // sync Roles
            if ($request->role) {
                $permission->syncRoles($request->role);
            }
            // if (!$permission->hasRole('super_admin')) {
            //     $permission->assignRole('super_admin');
            // }
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
    public function edit(Request $request, Permission $permission)
    {
        $permissions = Permission::with('roles')->find($permission->id);
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
    public function destroy(Permission $permission)
    {
        $permission = Permission::with('roles')->find($permission->id);
        if (count($permission->roles) > 1) {
            return Redirect::back()->with('error', 'This Permission is Given To Role So not Deleted!!!');
        }
        $permission->delete();
        return Redirect::back()->with('success', 'Permission Deleted Successfully!!!');
    }
}
