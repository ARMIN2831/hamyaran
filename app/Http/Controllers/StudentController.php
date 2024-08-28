<?php

namespace App\Http\Controllers;

use App\Http\Requests\student\StudentStoreRequest;
use App\Http\Requests\student\StudentUpdateRequest;
use App\Jobs\ImportStudentsJob;
use App\Models\Country;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\Jalalian;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('view student')) {
            $filter = $this->doFilter(Student::query()->with('user','country'), $request, ['id', 'firstName', 'lastName']);
            $students = $filter[0];
            return view('admin.student.index', compact('students'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->can('create student')) {
            $countries = Country::get();
            $users = [];
            if ($user->can('all user')) $users = User::with('convene')->get();
            if ($user->can('some user')) $users = User::whereHas('conveneB', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();

            $settings = $this->loadSetting(['language', 'sex', 'education']);
            return view('admin.student.create', compact('users', 'countries', 'settings'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentStoreRequest $request)
    {
        if (auth()->user()->can('create student')) {
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
            if ($request->mobile) $request->merge(['mobile'=>$request->c_mobile.'-'.$request->mobile]);
            $student = Student::create($request->all());
            return redirect()->route('students.edit',$student->id)->with('success','دانشجو با موفقیت ساخته شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $user = auth()->user();
        if ($user->can('edit student')) {
            $settings = $this->loadSetting(['language', 'opinionAboutIran', 'religious', 'religion2', 'financialSituation', 'donation', 'sex', 'education']);
            $countries = Country::get();
            $users = [];
            if ($user->can('all user')) $users = User::with('convene')->get();
            if ($user->can('some user')) $users = User::whereHas('conveneB', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
            return view('admin.student.edit', compact('student', 'settings', 'countries', 'users'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentUpdateRequest $request, Student $student)
    {
        if (auth()->user()->can('edit student')) {
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

            $profileImg = $this->uploadFile($request,'profileImg',$student,'students/profileImg');
            $passportImg = $this->uploadFile($request,'passportImg',$student,'students/passportImg');
            $evidenceImg = $this->uploadFile($request,'evidenceImg',$student,'students/evidenceImg');
            if ($profileImg) $student->profileImg = $profileImg;
            if ($passportImg) $student->passportImg = $passportImg;
            if ($evidenceImg) $student->evidenceImg = $evidenceImg;

            if ($request->mobile) $request->merge(['mobile'=>$request->c_mobile.'-'.$request->mobile]);
            $student->update($request->except('profileImg'));
            $student->save();
            return redirect()->route('students.index')->with('success','دانشجو با موفقیت اپدیت شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if (auth()->user()->can('delete student')) {
            $student->delete();
            return redirect()->route('students.index')->with('success','دانشجو با موفقیت حذف شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }
    public function showUploadForm()
    {
        $log = Storage::disk('local')->exists('upload_log.txt') ? Storage::get('upload_log.txt') : null;
        return view('admin.student.stu-add-excel', compact('log'));
    }

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
            'error' => 'required|string',
        ]);
        $filePath = $request->file('file')->storeAs('uploads', 'students.xlsx');
        Storage::put('upload_log.txt', "File uploaded successfully at " . now() . "\n");

        Student::where('excel', 1)->update(['excel' => 0]);

        ImportStudentsJob::dispatch($filePath, $request->input('error'),auth()->user()->can('one user'));

        return redirect()->route('students.upload')->with('success', 'File uploaded and processing started.');
    }
    public function rollbackLastUpload()
    {
        $filePath = storage_path('app/uploads/students.xlsx');
        if (!file_exists($filePath)) {
            return redirect()->route('students.upload')->with('error', 'No file to rollback.');
        }

        Student::where('excel',1)->delete();

        Storage::append('upload_log.txt', "Rollback performed at " . now() . "\n");

        return redirect()->route('students.upload')->with('success', 'Rollback successful.');
    }
}
