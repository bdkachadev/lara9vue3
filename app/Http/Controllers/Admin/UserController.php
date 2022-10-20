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

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_user', ['only' => ['index', 'show']]);
        $this->middleware('can:add_user', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_user', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_user', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::with('roles')->whereNotIn('id', [1])->get();
        $users = User::with('roles')->whereNotIn('id', [1])->latest()->paginate(10);

        $roles = Role::with('permissions')->whereNotIn('name', ['super_admin'])->get();

        $permissions = Permission::all();
        $options = array_column($roles->toArray(), "name");

        return Inertia::render('Users', ["can" => [
            'add' => Auth::user()->can('add_user'),
            'edit' => auth()->user()->can('edit_user'),
            'delete' => auth()->user()->can('delete_user'),
            'show' => auth()->user()->can('show_user'),

        ], 'users' => $users, 'roles' => $roles, "options" => $options, 'permissions' => $permissions]);
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
            'email' => ['required'],
            'role' => ['required'],

        ])->validate();

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->with('error', 'Something went wrong!.');
        // }

        if ($request->id) {
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            // sync Roles
            if ($request->role) {
                $user->syncRoles($request->role);
            }
            return Redirect::back()->with('success', 'User Updated SuccessFully!!!');
        } else {
            return Redirect::back()->with('warning', 'Please Select Any One User And Update Them!!!');

            // $user = User::where("email", $request->email)->first();
            // if ($user) {
            //     return Redirect::back()->with('error', 'User Already Exist With Email!!!');
            // }
            // $user = new User;
            // $user->name = $request->name;
            // $user->email = $request->email;
            // $user->save();
            // // sync Roles
            // if ($request->role) {
            //     $user->syncRoles($request->role);
            // }
        }
        return Redirect::back()->with('success', 'User Created Successfully!!!');
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
    public function edit(Request $request, User $user)
    {
        $user = User::with('roles')->find($user->id);
        return response()->json($user);
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
    public function destroy(User $user)
    {
        $user->delete();
        return Redirect::back()->with('success', 'User Deleted Successfully!!!');
    }
}
