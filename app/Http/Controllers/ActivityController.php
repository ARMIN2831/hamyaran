<?php

namespace App\Http\Controllers;

use App\Http\Requests\activity\ActivityStoreRequest;
use App\Http\Requests\activity\ActivityUpdateRequest;
use App\Models\Convene;
use App\Models\Activity;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('view activity')) {
            $a = Activity::query();
            if ($request->search){
                $name = $request->search;
                $a->WhereHas('student',function ($query) use ($name) {
                    $query->where(
                        DB::raw("CONCAT(firstName,' ',lastName)"), 'LIKE', "%{$name}%"
                    );
                });
            }

            $filter = $this->doFilter($a, $request, ['id', 'title'],['student_id']);
            $activities = $filter[0];
            return view('admin.activity.index', compact('activities'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->can('create activity')) {
            $settings = $this->loadSetting(['actionState']);
            return view('admin.activity.create', compact('settings'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityStoreRequest $request)
    {
        if (auth()->user()->can('create activity')) {
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
            $image = $this->uploadFile($request,'image',null,'activity/image');
            $activity = Activity::create($request->all());
            if ($image) $activity->image = $image;
            $activity->save();
            return redirect()->route('activities.edit',$activity)->with('success','فعالیت با موفقیت ساخته شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {

        if (auth()->user()->can('edit activity')) {
            $settings = $this->loadSetting(['actionState']);
            $student = Student::where('id',$activity->student_id)
                ->select('id', DB::raw('CONCAT(firstName, " ", lastName) as text'))
                ->first();
            return view('admin.activity.edit', compact('activity', 'settings','student'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityUpdateRequest $request, Activity $activity)
    {
        if (auth()->user()->can('edit activity')) {
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
            $image = $this->uploadFile($request,'image',$activity,'activity/image');
            if ($image) $activity->image = $image;
            $activity->update($request->all());
            $activity->save();
            return redirect()->route('activities.index')->with('success','فعالیت با موفقیت اپدیت شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        if (auth()->user()->can('delete activity')) {
            $activity->delete();
            return redirect()->route('activities.index')->with('success','فعالیت با موفقیت حذف شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }


    public function search(Request $request)
    {
        $search = $request->get('q');
        $students = Student::where('firstName', 'like', '%' . $search . '%')
            ->orWhere('lastName', 'like', '%' . $search . '%')->orWhere('mobile', 'like', '%' . $search . '%')
            ->select('id', DB::raw('CONCAT(firstName, " ", lastName) as text'))
            ->get();
        return response()->json($students);
    }
}
