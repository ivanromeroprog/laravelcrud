<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /** 
     * Permissions
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(5);
        return view('users.index', ['data' => $data])
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ], [], [
            'confirm-password' => __('app.user.confirm-password'),
            'password' => __('app.user.password'),
            'name' => __('app.user.name'),
            'roles' => __('app.user.roles'),
            'email' => __('app.user.email')
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        try {
            DB::transaction(
                function () use ($input, $request) {
                    $user = User::create($input);
                    $user->assignRole($request->input('roles'));
                }
            );
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors([__('app.dberror')]);
        }

        return redirect()->route('users.index')
            ->with('success', __('app.user.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $roles = Role::all();

        $userRoles = $user->roles->pluck('id', 'id')->all();

        return view(
            'users.edit',
            [
                'user' => $user,
                'roles' => $roles,
                'userRoles' => $userRoles,
                'disabled' => true
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();

        $userRoles = $user->roles->pluck('id', 'id')->all();

        return view(
            'users.edit',
            [
                'user' => $user,
                'roles' => $roles,
                'userRoles' => $userRoles,
                'disabled' => false,
                'superadmin' => ($id == 1)
            ]
        );
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
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => ($id == 1) ? '' : 'required'
        ], [],  [
            'confirm-password' => __('app.user.confirm-password'),
            'password' => __('app.user.password'),
            'name' => __('app.user.name'),
            'roles' => __('app.user.roles'),
            'email' => __('app.user.email')
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);



        try {
            DB::transaction(
                function () use ($user, $input, $request) {
                    $user->update($input);
                    if ($user->id != 1) $user->syncRoles($request->input('roles'));
                    //DB::table('model_has_roles')->where('model_id', $id)->delete();
                    //$user->assignRole($request->input('roles'));
                }
            );
        } catch (\Exception $ex) {
            return redirect()->back()->withErrors([__('app.dberror')]);
        }

        return redirect()->route('users.index')
            ->with('success', __('app.user.updated'));
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
            return redirect()->back()->withErrors([__('app.user.superadmin')]);
        }

        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('users.index')
            ->with('success', __('app.user.deleted'));
    }
}
