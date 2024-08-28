<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Convene;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class ApplicationController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['username'=>$request->username,'password'=>$request->password])){
            $user = User::where('username',$request->username)->first();
            return response()->json([
                'status' => 'success',
                'data' => $user,
            ]);
        }
        return response()->json([
            'status' => 'failed',
            'error' => 'email or password is wrong!'
        ],419);
    }
    public function courseList(User $user)
    {
        $course = Course::query();
        if ($user->can('some user')){
            $convene = Convene::where('user_id',$user->id)->first();
            $course->wherehas('convenes',function ($query) use ($convene) {
                $query->where('convene_id',$convene->id);
            });
        }
        if ($user->can('one user')){
            $convene = Convene::where('id',$user->convene_id)->first();
            $course->wherehas('convenes',function ($query) use ($convene) {
                $query->where('convene_id',$convene->id);
            });
        }
        $course = $course->get();
        return response()->json([
            'status' => 'success',
            'data' => $course,
        ]);
    }
    public function userList(User $user)
    {
        $users = User::query();
        if ($user->can('some user')){
            $convene = User::where('user_id',$user->id)->first();
            $users->where('convene_id',$convene->id);
        }
        if ($user->can('one user')){
            $users->where('id',$user->id);
        }
        $users = $users->get();
        return response()->json([
            'status' => 'success',
            'data' => $users,
        ]);
    }
    public function classroomList(User $user)
    {
        $classroom = Classroom::query();
        if ($user->can('some user')){
            $convene = Convene::where('user_id',$user->id)->first();
            $ids = User::where('convene_id',$convene->id)->pluck('id');
            $classroom->whereIn('user_id',$ids);
        }
        if ($user->can('one user')){
            $classroom->where('user_id',$user->id);
        }
        $classroom = $classroom->orderBy('id','desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $classroom,
        ]);
    }
    public function studentList(Request $request)
    {
        $classroom_id = $request->classroom_id;
        $students = Student::whereHas('classroom', function ($query) use ($classroom_id) {
            $query->where('classroom_id', $classroom_id);
        })->with(['classroom' => function ($query) use ($classroom_id) {
            $query->where('classroom_id', $classroom_id)->select('classroom_student.score');
        }])->orderBy('id','desc')->get();

        $students->each(function ($student) use ($classroom_id) {
            $classroom = $student->classroom[0];
            if ($classroom) {
                $student->score = $classroom->score;
            } else {
                $student->score = null;
            }
            unset($student->classroom);
        });



        return response()->json([
            'status' => 'success',
            'data' => $students,
        ]);
    }
    public function classroomStore(Request $request)
    {
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
        Classroom::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'name' => $request->name,
            'description' => $request->description,
            'language_s' => $request->language,
            'commission' => $request->commission,
            'startTS' => $request->startTS,
            'endTS' => $request->endTS,
        ]);
        return response()->json([
            'status' => 'success',
        ]);
    }
    public function classroomUpdate(Request $request)
    {
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
        Classroom::where('id',$request->classroom_id)->update([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'name' => $request->name,
            'description' => $request->description,
            'language_s' => $request->language,
            'commission' => $request->commission,
            'startTS' => $request->startTS,
            'endTS' => $request->endTS,
        ]);
        return response()->json([
            'status' => 'success',
        ]);
    }
    public function studentStore(Request $request, User $user)
    {
        $classroom = Classroom::where('id',$request->classroom_id)->first();
        $student = Student::where('mobile',$request->mobile)->first();
        if ($student && $request->mobile != null){
            $student->update([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'birthDate' => $request->birthDate,
                'commissionAttraction' => $request->commissionAttraction,
            ]);
            try {
                $row = DB::table('classroom_student')->where('student_id',$student->id)->where('classroom_id',$classroom->id)->first();
                $classroom->student()->detach($student->id);
                $classroom->student()->attach($student->id, [
                    'price' => (string) $request->price,
                    'score' => (string) $row->score,
                    'ts' => (string) $row->ts,
                ]);
            } catch (\Exception $e) {

            }
        }else{
            $student = Student::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'birthDate' => $request->birthDate,
                'mobile' => $request->mobile,
                'user_id' => $user->id,
                'commissionAttraction' => $request->commissionAttraction,
            ]);
            $classroom->student()->attach($student->id, ['ts' => time(),'price' => (string) $request->price]);
        }
        return response()->json([
            'status' => 'success',
        ]);
    }
    public function studentScore(Request $request)
    {
        $classroom = Classroom::where('id',$request->classroom_id)->first();
        $student = Student::where('id',$request->student_id)->first();
        try {
            $row = DB::table('classroom_student')->where('student_id',$student->id)->where('classroom_id',$classroom->id)->first();
            $classroom->student()->detach($student->id);
            $classroom->student()->attach($student->id, [
                'price' => (string) $row->price,
                'score' => (string) $request->score,
                'ts' => (string) $row->ts,
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
        return response()->json([
            'status' => 'success',
        ]);
    }
    public function changePassword(Request $request, User $user)
    {
        $user->update([
            'password' => bcrypt($request->password),
        ]);
        return response()->json([
            'status' => 'success',
        ]);
    }
    public function changeProfile(Request $request, User $user)
    {
        $image = null;
        if ($request->image){
            $image = $this->uploadFile($request,'image',$user,'user/image');
        }
        $user->update([
            'name' => $request->name,
            'image' => $image,
        ]);
        return response()->json([
            'status' => 'success',
        ]);
    }
    public function languageList()
    {
        $settings = $this->loadSetting(['language']);
        return response()->json([
            'status' => 'success',
            'data' => $settings,
        ]);
    }
    public function getClassroom(Request $request)
    {
        $classroom = Classroom::where('id',$request->classroom_id)->first();
        if ($classroom->startTS) $classroom->startTS = @Jalalian::forge($classroom->endTS)->format('Y/m/d H:i:s');
        if ($classroom->endTS) $classroom->endTS = @Jalalian::forge($classroom->endTS)->format('Y/m/d H:i:s');
        return response()->json([
            'status' => 'success',
            'data' => $classroom,
        ]);
    }
    public function getStudent(Request $request)
    {
        $classroom_id = $request->classroom_id;
        $student = Student::where('id',$request->student_id)->with(['classroom' => function ($query) use ($classroom_id) {
            $query->where('classroom_id', $classroom_id)->select('classroom_student.price');
        }])->first();
        $classroom = $student->classroom[0];
        if ($classroom) {
            $student->price = $classroom->price;
        } else {
            $student->price = null;
        }
        unset($student->classroom);

        if ($student->startTS) $student->startTS = @Jalalian::forge($student->endTS)->format('Y/m/d H:i:s');
        if ($student->endTS) $student->endTS = @Jalalian::forge($student->endTS)->format('Y/m/d H:i:s');

        return response()->json([
            'status' => 'success',
            'data' => $student,
        ]);
    }
    public function searchClassroom(Request $request, User $user)
    {
        $classroom = Classroom::query();
        if ($user->can('some user')){
            $convene = Convene::where('user_id',$user->id)->first();
            $ids = User::where('convene_id',$convene->id)->pluck('id');
            $classroom->whereIn('user_id',$ids);
        }
        if ($user->can('one user')){
            $classroom->where('user_id',$user->id);
        }
        $classroom->where('name','LIKE', "%{$request->search}%");
        $classroom = $classroom->get();
        return response()->json([
            'status' => 'success',
            'data' => $classroom,
        ]);
    }
    public function searchStudent(Request $request)
    {
        $classroom_id = $request->classroom_id;

        $students = Student::whereHas('classroom', function($query) use ($classroom_id) {
            $query->where('classroom_id', $classroom_id);
        })
            ->where(function($query) use ($request) {
                $query->where('firstName', 'like', '%' . $request->search . '%')
                    ->orWhere('lastName', 'like', '%' . $request->search . '%')
                    ->orWhere('mobile', 'like', '%' . $request->search . '%');
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $students,
        ]);
    }

}
