<?php

namespace App\Http\Controllers;

use App\Http\Requests\institute\InstituteStoreRequest;
use App\Http\Requests\institute\InstituteUpdateRequest;
use App\Models\Convene;
use App\Models\Country;
use App\Models\Institute;
use App\Models\User;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('view institute')) {
            $filter = $this->doFilter(Institute::query()->with('user','country'), $request, ['id', 'name']);
            $institutes = $filter[0];
            return view('admin.institute.index', compact('institutes'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->can('create institute')) {
            $countries = Country::get();
            $users = [];
            if ($user->can('all user')) $users = User::with('convene')->get();
            if ($user->can('some user')) $users = User::where('user_id',$user->id)->with('convene')->get();
            $settings = $this->loadSetting(['language']);
            return view('admin.institute.create', compact('users', 'countries', 'settings'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstituteStoreRequest $request)
    {
        if (auth()->user()->can('create institute')) {
            $request->validated();
            if ($request->startTS){
                if (strpos($request->startTS, ':') !== false) $startTS = Jalalian::fromFormat('Y/n/j H:i:s', $request->startTS)->getTimestamp();
                else $startTS = Jalalian::fromFormat('Y/n/j', $request->startTS)->getTimestamp();
                $request->merge(['startTS' => $startTS]);
            }
            if ($request->timeinterface){
                if (strpos($request->timeinterface, ':') !== false) $timeinterface = Jalalian::fromFormat('Y/n/j H:i:s', $request->timeinterface)->getTimestamp();
                else $timeinterface = Jalalian::fromFormat('Y/n/j', $request->timeinterface)->getTimestamp();
                $request->merge(['timeinterface' => $timeinterface]);
            }
            Institute::create($request->all());
            return redirect()->route('institutes.index')->with('success','موسسه با موفقیت ساخته شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institute $institute)
    {
        $user = auth()->user();
        if ($user->can('edit institute')) {
            $settings = $this->loadSetting(['language', 'classInstituteType', 'religious', 'religion2', 'ActivityInstitute', 'AssessmentInstitute']);
            $countries = Country::get();
            $users = [];
            if ($user->can('all user')) $users = User::with('convene')->get();
            if ($user->can('some user')) $users = User::where('user_id',$user->id)->with('convene')->get();
            return view('admin.institute.edit', compact('institute', 'settings', 'countries', 'users'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstituteUpdateRequest $request, Institute $institute)
    {
        if (auth()->user()->can('edit institute')) {
            $request->validated();
            if ($request->startTS){
                if (strpos($request->startTS, ':') !== false) $startTS = Jalalian::fromFormat('Y/n/j H:i:s', $request->startTS)->getTimestamp();
                else $startTS = Jalalian::fromFormat('Y/n/j', $request->startTS)->getTimestamp();
                $request->merge(['startTS' => $startTS]);
            }
            if ($request->timeinterface){
                if (strpos($request->timeinterface, ':') !== false) $timeinterface = Jalalian::fromFormat('Y/n/j H:i:s', $request->timeinterface)->getTimestamp();
                else $timeinterface = Jalalian::fromFormat('Y/n/j', $request->timeinterface)->getTimestamp();
                $request->merge(['timeinterface' => $timeinterface]);
            }
            $institute->update($request->all());
            return redirect()->route('institutes.index')->with('success','موسسه با موفقیت اپدیت شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institute $institute)
    {
        if (auth()->user()->can('delete institute')) {
            $institute->delete();
            return redirect()->route('institutes.index')->with('success','موسسه با موفقیت حذف شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }
}
