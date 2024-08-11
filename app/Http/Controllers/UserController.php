<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\UserStoreRequest;
use App\Http\Requests\user\UserUpdateRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filter = $this->doFilter(User::query(), $request, ['id','name']);
        $user = $filter[0];
        return view('admin.user.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.user.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $request->validated();
        $user = User::create($request->all());
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        return redirect()->route('users.index')->with('success','کاربر با موفقیت ساخته شد.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $permissions = Permission::all();
        $userPermissions = $user->permissions->pluck('title')->toArray();
        $settings = $this->loadSetting([
            'language','education','religious','religion2','opinionAboutIran','financialSituation','donation','sex'
        ]);
        $countries = Country::get();

        return view('admin.user.edit', compact('user', 'permissions', 'userPermissions', 'settings', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $request->validated();
        $input = $request->all();

        if (!empty($input['password'])) {
            $input['password'] = bcrypt($request->password);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user->update($input);
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }
        return redirect()->route('users.index')->with('success','کاربر با موفقیت اپدیت شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success','کاربر با موفقیت حذف شد.');
    }
}
