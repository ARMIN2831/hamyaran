<?php

namespace App\Http\Controllers;

use App\Http\Requests\convene\ConveneStoreRequest;
use App\Http\Requests\convene\ConveneUpdateRequest;
use App\Models\Convene;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ConveneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('view convene')) {
            $filter = $this->doFilter(Convene::query()->with('user'), $request, ['id', 'name']);
            $convenes = $filter[0];
            return view('admin.convene.index', compact('convenes'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('create convene')) {
            $users = User::get();
            return view('admin.convene.create', compact('users'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConveneStoreRequest $request)
    {
        if (auth()->user()->can('create convene')) {
            $request->validated();
            Convene::create($request->all());

            return redirect()->route('convenes.index')->with('success','مجتمع با موفقیت ساخته شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Convene $convene)
    {

        if (auth()->user()->can('edit convene')) {
            $users = User::get();
            return view('admin.convene.edit', compact('convene','users'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConveneUpdateRequest $request, Convene $convene)
    {
        if (auth()->user()->can('edit convene')) {
            $request->validated();
            $convene->update($request->all());
            return redirect()->route('convenes.index')->with('success','مجتمع با موفقیت اپدیت شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Convene $convene)
    {
        if (auth()->user()->can('delete convene')) {
            $convene->delete();
            return redirect()->route('convenes.index')->with('success','مجتمع با موفقیت حذف شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }
}
