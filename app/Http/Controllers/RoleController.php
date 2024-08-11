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
        $filter = $this->doFilter(Permission::query(), $request, ['id','name']);
        $permissions = $filter[0];
        return view('admin.permission.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionStoreRequest $request)
    {
        $request->validated();
        Permission::create(['name' => now(),'title' => $request->title]);
        return redirect()->route('permissions.index')->with('success','پرمیشن با موفقیت ساخته شد.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {

        return view('admin.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        $request->validated();
        $permission->update($request->all());
        return redirect()->route('permissions.index')->with('success','پرمیشن با موفقیت اپدیت شد.');
    }
}
