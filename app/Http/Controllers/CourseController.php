<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CourseStoreRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use App\Models\Convene;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('view course')) {
            $filter = $this->doFilter(Course::query(), $request, ['id', 'name']);
            $courses = $filter[0];
            return view('admin.course.index', compact('courses'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('create course')) {
            $convenes = Convene::get();
            return view('admin.course.create', compact('convenes'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseStoreRequest $request)
    {
        if (auth()->user()->can('create course')) {
            $request->validated();

            $course = Course::create($request->all());
            if ($request->convene) $course->convenes()->sync($request->convene);
            return redirect()->route('courses.index')->with('success','دوره با موفقیت ساخته شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {

        if (auth()->user()->can('edit course')) {
            $convenes = Convene::get();

            $ids = $course->convenes->pluck('id','id')->toArray();
            return view('admin.course.edit', compact('course','convenes', 'ids'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request, Course $course)
    {
        if (auth()->user()->can('edit course')) {
            $request->validated();
            $course->update($request->all());
            if ($request->convene) $course->convenes()->sync($request->convene);
            return redirect()->route('courses.index')->with('success','دوره با موفقیت اپدیت شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if (auth()->user()->can('delete course')) {
            $course->delete();
            return redirect()->route('courses.index')->with('success','دوره با موفقیت حذف شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }
}
