<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /** 
     * Permissions
     */
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::all();

        return view('roles.create', ['permission' => $permission]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        try {
            DB::transaction(
                function () use ($request) {
                    $role = Role::create(['name' => $request->input('name')]);
                    $role->syncPermissions($request->input('permission'));
                }
            );
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors([__('app.dberror')]);
        }

        return redirect()->route('roles.index')
            ->with('success', __('app.role.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = $role->getAllPermissions()->pluck('id', 'id')->all();

        return view('roles.edit', [
            'role' => $role,
            'permission' => $permission,
            'rolePermissions' => $rolePermissions,
            'disabled' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = $role->getAllPermissions()->pluck('id', 'id')->all();

        return view('roles.edit', [
            'role' => $role,
            'permission' => $permission,
            'rolePermissions' => $rolePermissions,
            'disabled' => ($id == 1),
            'superadmin' => ($id == 1)
        ]);
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
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);

        if ($id == 1) {
            return redirect()->back()->withErrors([__('app.role.superadmin')]);
        }

        try {
            DB::transaction(
                function () use ($role, $request) {
                    $role->name = $request->input('name');
                    $role->save();
                    $role->syncPermissions($request->input('permission'));
                }
            );
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors([__('app.dberror')]);
        }

        return redirect()->route('roles.index')
            ->with('success', __('app.role.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == 1) {
            return redirect()->back()->withErrors([__('app.role.superadmin')]);
        }

        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('roles.index')
            ->with('success', __('app.role.deleted'));
    }
}
