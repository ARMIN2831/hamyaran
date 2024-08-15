<?php

namespace App\Http\Controllers;

use App\Http\Requests\classroom\classroomStoreRequest;
use App\Http\Requests\classroom\classroomUpdateRequest;
use App\Models\Convene;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('view classroom')) {
            $filter = $this->doFilter(Classroom::query()->with('user','country'), $request, ['id', 'name']);
            $classrooms = $filter[0];
            return view('admin.classroom.index', compact('classrooms'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->can('create classroom')) {
            $users = [];
            if ($user->can('all user')) $users = User::with('convene')->get();
            if ($user->can('some user')) $users = User::where('user_id',$user->id)->with('convene')->get();

            return view('admin.classroom.create',compact('users'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassroomStoreRequest $request)
    {
        if (auth()->user()->can('create classroom')) {
            $request->validated();

            $classroom = Classroom::create($request->all());
            //if ($request->convene) $classroom->convenes()->sync($request->convene);
            return redirect()->route('classrooms.index')->with('success','کلاس‌ با موفقیت ساخته شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {

        if (auth()->user()->can('edit classroom')) {
            //$convenes = Convene::get();
            //$ids = $classroom->convenes->pluck('id','id')->toArray();
            return view('admin.classroom.edit', compact('classroom'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassroomUpdateRequest $request, Classroom $classroom)
    {
        if (auth()->user()->can('edit classroom')) {
            $request->validated();
            $classroom->update($request->all());
            //if ($request->convene) $classroom->convenes()->sync($request->convene);
            return redirect()->route('classrooms.index')->with('success','کلاس‌ با موفقیت اپدیت شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        if (auth()->user()->can('delete classroom')) {
            $classroom->delete();
            return redirect()->route('classrooms.index')->with('success','کلاس‌ با موفقیت حذف شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }
}
