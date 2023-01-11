<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Support\Facades\Auth;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_role', ['only' => ['index', 'show']]);
        $this->middleware('can:add_role', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_role', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')->whereNotIn('name', ['super_admin'])->latest()->paginate(10);
        $permissions = Permission::all();
        $options = array_column($permissions->toArray(), "name");
        return Inertia::render('Roles', ['roles' => $roles, 'permissions' => $permissions, "options" => $options, 'can' => [
            'add' => Auth::user()->can('add_role'),
            'edit' => auth()->user()->can('edit_role'),
            'delete' => auth()->user()->can('delete_role'),
            'show' => auth()->user()->can('show_role'),

        ]]);
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
            'permission' => 'required'
        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }
        if ($request->id) {
            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->save();
            // sync Permissions
            if ($request->permission) {
                $role->syncPermissions($request->permission);
            }
            return Redirect::back()->with('success', 'Role Updated SuccessFully!!!');
        } else {
            $role = Role::where("name", $request->name)->first();
            if ($role) {
                return Redirect::back()->with('error', 'Role Already Exist!!!');
            }
            $role = new Role;
            $role->name = $request->name;
            $role->save();
            // sync Permissions
            if ($request->permission) {
                $role->syncPermissions($request->permission);
            }
        }



        return Redirect::back()->with('success', 'Role Created Successfully!!!');
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
    public function edit(Role $role)
    {
        $role = Role::with('permissions')->find($role->id);
        return response()->json($role);
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
    public function destroy(Role $role)
    {
        $role = Role::with('users')->find($role->id);
        if (count($role->users) > 0) {
            return Redirect::back()->with('error', 'This Role is Assigned To User So not Deleted!!!');
        }
        $role->delete();
        return Redirect::back()->with('success', 'Role Deleted Successfully!!!');
    }
}
