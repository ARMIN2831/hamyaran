<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\UserStoreRequest;
use App\Http\Requests\user\UserUpdateRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('view user')) {
            $filter = $this->doFilter(User::query(), $request, ['id', 'name'], ['level']);
            $user = $filter[0];
            return view('admin.user.index', compact('user'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('create user')) {
            $permissions = Permission::get();
            return view('admin.user.create', compact('permissions'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        if (auth()->user()->can('create user')) {
            $request->validated();
            $user = User::create($request->all());
            if ($request->has('permissions')) {
                $user->syncPermissions($request->permissions);
            }

            return redirect()->route('users.index')->with('success','کاربر با موفقیت ساخته شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        if (auth()->user()->can('edit user')) {
            $permissions = Permission::all();
            $userPermissions = $user->permissions->pluck('title')->toArray();
            $settings = $this->loadSetting([
                'language','education','religious','religion2','opinionAboutIran','financialSituation','donation','sex'
            ]);
            $countries = Country::get();

            return view('admin.user.edit', compact('user', 'permissions', 'userPermissions', 'settings', 'countries'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if (auth()->user()->can('edit user')) {
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
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (auth()->user()->can('delete user')) {
            $user->delete();
            return redirect()->route('users.index')->with('success','کاربر با موفقیت حذف شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    public function loginIndex()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            Auth::user();
            return redirect()->route('dashboard');
        } else return redirect()->route('loginIndex')->with('failed','یوزرنیم یا پسورد اشتباه است!');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('loginIndex')->with('success','با موفقیت از اکانت خارج شدید!');
    }
}
