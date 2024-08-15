<?php

namespace App\Http\Controllers;

use App\Http\Requests\role\RoleStoreRequest;
use App\Http\Requests\role\RoleUpdateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('view role')) {
            $filter = $this->doFilter(Role::query(), $request, ['id','title']);
            $roles = $filter[0];
            return view('admin.role.index',compact('roles'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('create role')) {
            $permissions = Permission::get();
            return view('admin.role.create',compact('permissions'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        if (auth()->user()->can('create role')) {
            $request->validated();
            $role = Role::create(['name' => $request->name]);
            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }
            return redirect()->route('roles.index')->with('success','نقش با موفقیت ساخته شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if (auth()->user()->can('edit role')) {
            $permissions = Permission::get();
            $rolePermissions = $role->permissions->pluck('name')->toArray();
            return view('admin.role.edit', compact('role', 'permissions', 'rolePermissions'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        if (auth()->user()->can('edit role')) {
            $request->validated();
            $role->update($request->all());
            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }
            return redirect()->route('roles.index')->with('success','نقش با موفقیت اپدیت شد.');
        }
        return redirect()->route('dashboard')->with('failed','نقش به این بخش دسترسی ندارید!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (auth()->user()->can('delete role')) {
            $role->delete();
            return redirect()->route('courses.index')->with('success','نقش با موفقیت حذف شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }
}
