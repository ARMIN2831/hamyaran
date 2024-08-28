<?php

namespace App\Http\Controllers;

use App\Http\Requests\institute\InstituteStoreRequest;
use App\Http\Requests\institute\InstituteUpdateRequest;
use App\Jobs\ImportInstitutesJob;
use App\Jobs\ImportStudentsJob;
use App\Models\Convene;
use App\Models\Country;
use App\Models\Institute;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            if ($user->can('some user')) $users = User::whereHas('conveneB', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
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
            if ($request->mobile) $request->merge(['mobile'=>$request->c_mobile.' '.$request->mobile]);
            if ($request->whatsapp) $request->merge(['mobile'=>$request->c_whatsapp.' '.$request->whatsapp]);
            $institute = Institute::create($request->all());
            return redirect()->route('institutes.edit',$institute->id)->with('success','موسسه با موفقیت ساخته شد.');
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
            if ($user->can('some user')) $users = User::whereHas('conveneB', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
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
            if ($request->mobile) $request->merge(['mobile'=>$request->c_mobile.' '.$request->mobile]);
            if ($request->whatsapp) $request->merge(['mobile'=>$request->c_whatsapp.' '.$request->whatsapp]);
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
    public function showUploadForm()
    {
        $log = Storage::disk('local')->exists('upload_log_institute.txt') ? Storage::get('upload_log_institute.txt') : null;
        return view('admin.institute.ins-add-excel', compact('log'));
    }

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx|max:1024',
            'error' => 'required|string',
        ]);
        $filePath = $request->file('file')->storeAs('uploads', 'institute.xlsx');
        Storage::put('upload_log_institute.txt', "File uploaded successfully at " . now() . "\n");

        Institute::where('excel', 1)->update(['excel' => 0]);

        ImportInstitutesJob::dispatch($filePath, $request->input('error'),auth()->user()->can('one user'));

        return redirect()->route('institutes.upload')->with('success', 'File uploaded and processing started.');
    }
    public function rollbackLastUpload()
    {
        $filePath = storage_path('app/uploads/students.xlsx');
        if (!file_exists($filePath)) {
            return redirect()->route('institutes.upload')->with('error', 'No file to rollback.');
        }

        Institute::where('excel',1)->delete();

        Storage::append('upload_log_institute.txt', "Rollback performed at " . now() . "\n");

        return redirect()->route('institutes.upload')->with('success', 'Rollback successful.');
    }
}
