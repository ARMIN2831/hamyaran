<?php

namespace App\Http\Controllers;

use App\Http\Requests\permission\PermissionStoreRequest;
use App\Http\Requests\permission\PermissionUpdateRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('view permission')) {
            $filter = $this->doFilter(Permission::query(), $request, ['id','name']);
            $permissions = $filter[0];
            return view('admin.permission.index',compact('permissions'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('create permission')) {
        return view('admin.permission.create');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionStoreRequest $request)
    {
        if (auth()->user()->can('create permission')) {
            $request->validated();
            Permission::create(['name' => now(),'title' => $request->title]);
            return redirect()->route('permissions.index')->with('success','پرمیشن با موفقیت ساخته شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        if (auth()->user()->can('edit permission')) {
            return view('admin.permission.edit', compact('permission'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        if (auth()->user()->can('edit permission')) {
            $request->validated();
            $permission->update($request->all());
            return redirect()->route('permissions.index')->with('success','پرمیشن با موفقیت اپدیت شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }
}
