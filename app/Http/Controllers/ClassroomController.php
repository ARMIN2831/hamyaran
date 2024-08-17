<?php

namespace App\Http\Controllers;

use App\Http\Requests\classroom\classroomStoreRequest;
use App\Http\Requests\classroom\classroomUpdateRequest;
use App\Models\Convene;
use App\Models\Classroom;
use App\Models\Country;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('view classroom')) {
            $filter = $this->doFilter(Classroom::query()->with('user','country','student'), $request, ['id', 'name']);
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
            $courses = Course::query();
            if ($user->can('all user')) {
                $courses = $courses->get();
            }else{
                $courses = $courses->whereHas('convenes', function($query) use ($user) {
                    $query->where('id', $user->convene_id);
                })->get();
            }
            $users = [];
            if ($user->can('all user')) $users = User::with('convene')->get();
            if ($user->can('some user')) $users = User::whereHas('conveneB', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
            $countries = Country::get();
            $settings = $this->loadSetting(['platforms', 'language', 'sex', 'classState']);

            return view('admin.classroom.create',compact('users','courses', 'settings', 'countries'));
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
            if ($request->startTS){
                if (strpos($request->startTS, ':') !== false) $startTS = Jalalian::fromFormat('Y/n/j H:i:s', $request->startTS)->getTimestamp();
                else $startTS = Jalalian::fromFormat('Y/n/j', $request->startTS)->getTimestamp();
                $request->merge(['startTS' => $startTS]);
            }
            if ($request->endTS){
                if (strpos($request->endTS, ':') !== false) $endTS = Jalalian::fromFormat('Y/n/j H:i:s', $request->endTS)->getTimestamp();
                else $endTS = Jalalian::fromFormat('Y/n/j', $request->endTS)->getTimestamp();
                $request->merge(['endTS' => $endTS]);
            }
            Classroom::create($request->all());
            return redirect()->route('classrooms.index')->with('success','کلاس‌ با موفقیت ساخته شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        $user = auth()->user();
        if ($user->can('edit classroom')) {
            $courses = Course::query();
            if ($user->can('all user')) {
                $courses = $courses->get();
            }else{
                $courses = $courses->whereHas('convenes', function($query) use ($user) {
                    $query->where('id', $user->convene_id);
                })->get();
            }
            $users = [];
            if ($user->can('all user')) $users = User::with('convene')->get();
            if ($user->can('some user')) $users = User::whereHas('conveneB', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
            $countries = Country::get();
            $settings = $this->loadSetting(['platforms', 'language', 'sex', 'classState']);
            return view('admin.classroom.edit', compact('classroom', 'users', 'courses', 'countries', 'settings'));
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
            if ($request->startTS){
                if (strpos($request->startTS, ':') !== false) $startTS = Jalalian::fromFormat('Y/n/j H:i:s', $request->startTS)->getTimestamp();
                else $startTS = Jalalian::fromFormat('Y/n/j', $request->startTS)->getTimestamp();
                $request->merge(['startTS' => $startTS]);
            }
            if ($request->endTS){
                if (strpos($request->endTS, ':') !== false) $endTS = Jalalian::fromFormat('Y/n/j H:i:s', $request->endTS)->getTimestamp();
                else $endTS = Jalalian::fromFormat('Y/n/j', $request->endTS)->getTimestamp();
                $request->merge(['endTS' => $endTS]);
            }
            $classroom->update($request->all());
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
