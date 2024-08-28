<?php

namespace App\Http\Controllers;

use App\Exports\ClassroomsExport;
use App\Models\Classroom;
use App\Models\Country;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;

class ClassStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->can('view classStudent')) {
            $classroom = null;
            $student = null;
            if ($request->class_id) $classroom = Classroom::where('id',$request->class_id)->first();
            if ($request->student_id) $student = Student::where('id',$request->student_id)
                ->select('id', DB::raw('CONCAT(firstName, " ", lastName) as text'))
                ->first();
            return view('admin.classStudent.index', compact('classroom', 'student'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->can('create classStudent')) {
            $classroomId = $request->input('classroom_id');
            $studentId = $request->input('student_id');
            $classroom = Classroom::findOrFail($classroomId);
            $student = Student::findOrFail($studentId);
            $classroom->student()->attach($student->id, ['ts' => now()]);
            return redirect()->route('classStudents.index')->with('success','دانشجوی کلاس‌ با موفقیت ساخته شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (auth()->user()->can('edit classroom')) {
            $classroom = Classroom::findOrFail($id);
            $students = $classroom->student()->paginate(20);
            return view('admin.classStudent.edit', compact('classroom','students'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    public function update(Request $request, Classroom $classroom, Student $student)
    {
        if (auth()->user()->can('edit classroom')) {
            try {
                $classroom->student()->updateExistingPivot($student->id, ['score' => (string) $request->score,'price' => (string) $request->price]);
            } catch (\Exception $e) {

            }
            return redirect()->route('classStudents.edit',$classroom->id)->with('success','دانشجوی کلاس‌ با موفقیت حذف شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom, Student $student)
    {
        if (auth()->user()->can('delete classStudent')) {
            $classroom->student()->detach($student->id);
            return redirect()->route('classStudents.edit',$classroom->id)->with('success','دانشجوی کلاس‌ با موفقیت حذف شد.');
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');
    }
    public function searchStudent(Request $request)
    {
        $search = $request->get('s');
        $students = Student::where('firstName', 'like', '%' . $search . '%')
            ->orWhere('lastName', 'like', '%' . $search . '%')->orWhere('mobile', 'like', '%' . $search . '%')
            ->select('id', DB::raw('CONCAT(firstName, " ", lastName) as text'))
            ->get();
        return response()->json($students);
    }
    public function searchClass(Request $request)
    {
        $search = $request->get('c');
        $classroom = Classroom::where('name', 'like', '%' . $search . '%')
            ->select('id', 'name')
            ->get();
        return response()->json($classroom);
    }
    public function exportExcel(Classroom $classroom)
    {
        return Excel::download(new ClassroomsExport($classroom->id), 'students.xlsx');
    }
}
