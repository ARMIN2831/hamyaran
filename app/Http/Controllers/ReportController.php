<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use App\Models\Activity;
use App\Models\Classroom;
use App\Models\Convene;
use App\Models\Country;
use App\Models\Course;
use App\Models\Student;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Morilog\Jalali\Jalalian;

class ReportController extends Controller
{
    public function student(Request $request)
    {
        $countries = Country::get();

        $convenes = Convene::get();

        $user = auth()->user();
        $users = [];
        if ($user->can('all user')) $users = User::with('convene')->get();
        if ($user->can('some user')) $users = User::whereHas('conveneB', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        $courses = Course::query();
        if ($user->can('all user')) {
            $courses = $courses->get();
        }else{
            $courses = $courses->whereHas('convenes', function($query) use ($user) {
                $query->where('id', $user->convene_id);
            })->get();
        }

        $classrooms = Classroom::query();
        if ($user->can('all user')) {
            $classrooms = Classroom::get();
        } elseif ($user->can('some user')) {
            $classrooms = Classroom::whereHas('course.convenes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } elseif ($user->can('one user')) {
            $classrooms = Classroom::whereHas('course.convenes', function ($query) use ($user) {
                $query->where('convene_id', $user->convene_id);
            })->get();
        }
        $settings = $this->loadSetting(['language', 'sex', 'religious', 'education', 'religion2']);

        //////////////////////////

        $students = Student::query();
        if ($request->country_id) $students->where('country_id',$request->country_id);
        if ($request->language) $students->where('language_s',$request->language);
        if ($request->education) $students->where('education_s',$request->education);
        if ($request->religious) $students->where('religious_s',$request->religious);
        if ($request->convene_id) {
            $students->whereHas('user.convenes', function ($query) use ($request) {
                $query->where('convene_id', $request->convene_id);
            });
        }
        if ($request->user_id) $students->where('user_id',$request->user_id);
        if ($request->course_id) {
            $students->whereHas('user.convene.courses', function ($query) use ($request) {
                $query->where('course_id', $request->course_id);
            });
        }
        if ($request->classroom_id) {
            $students->whereHas('classroom', function ($query) use ($request) {
                $query->where('classroom_id', $request->classroom_id);
            });
        }
        if ($time = $request->input('startTS-from')){
            if (strpos($time, ':') !== false) $startTS = Jalalian::fromFormat('Y/n/j H:i:s', $time)->getTimestamp();
            else $startTS = Jalalian::fromFormat('Y/n/j', $time)->getTimestamp();
            $students->where('startTS','>',$startTS);
        }
        if ($time = $request->input('startTS-to')){
            if (strpos($time, ':') !== false) $startTS = Jalalian::fromFormat('Y/n/j H:i:s', $time)->getTimestamp();
            else $startTS = Jalalian::fromFormat('Y/n/j', $time)->getTimestamp();
            $students->where('startTS','<',$startTS);
        }
        if ($time = $request->input('endTS-from')){
            if (strpos($time, ':') !== false) $endTS = Jalalian::fromFormat('Y/n/j H:i:s', $time)->getTimestamp();
            else $endTS = Jalalian::fromFormat('Y/n/j', $time)->getTimestamp();
            $students->where('endTS','>',$endTS);
        }
        if ($time = $request->input('endTS-to')){
            if (strpos($time, ':') !== false) $endTS = Jalalian::fromFormat('Y/n/j H:i:s', $time)->getTimestamp();
            else $endTS = Jalalian::fromFormat('Y/n/j', $time)->getTimestamp();
            $students->where('endTS','<',$endTS);
        }
        if ($request->sex) $students->where('sex_s',$request->sex);
        $students = $students->get();
        $chartData = $this->chartData($students, $settings);


        return view('admin.report.chart', compact('countries', 'convenes' , 'students', 'users', 'courses', 'classrooms', 'settings', 'chartData'));
    }
    public function chartData($students, $settings)
    {
        $sumStudentMonth = [];
        $addStudentMonth = [];
        $delStudentMonth = [];

        $sumStudentYear = [];
        $addStudentYear = [];
        $delStudentYear = [];

        $sex = [0, 0, 0];
        $sexPercent = [0, 0, 0];

        $minYear = PHP_INT_MAX;
        $maxYear = PHP_INT_MIN;

        $ages = [];

        $education = array_fill_keys($settings['education'], 0);
        $language = array_fill_keys($settings['language'], 0);
        $religious = array_fill_keys($settings['religious'], 0);
        $religion2 = array_fill_keys($settings['religion2'], 0);

        $countriesID = [];

        foreach ($students as $student) {
            $startDate = $student['startTS'] ? Jalalian::forge($student['startTS']) : null;
            $endDate = $student['endTS'] ? Jalalian::forge($student['endTS']) : null;

            if ($startDate) {
                $regYear = $startDate->format('Y');
                $regMonth = $startDate->format('Y/m');

                if ($regYear > 1348 && $regYear < 2000) {
                    $minYear = min($minYear, $regYear);
                    $maxYear = max($maxYear, $regYear);

                    $sumStudentYear[$regYear] = ($sumStudentYear[$regYear] ?? 0) + 1;
                    $addStudentYear[$regYear] = ($addStudentYear[$regYear] ?? 0) + 1;

                    $sumStudentMonth[$regMonth] = ($sumStudentMonth[$regMonth] ?? 0) + 1;
                    $addStudentMonth[$regMonth] = ($addStudentMonth[$regMonth] ?? 0) + 1;
                }
            }

            if ($endDate) {
                $endYear = $endDate->format('Y');
                $endMonth = $endDate->format('Y/m');

                if ($endYear > 1348 && $endYear < 2000) {
                    $minYear = min($minYear, $endYear);
                    $maxYear = max($maxYear, $endYear);

                    $sumStudentYear[$endYear] = ($sumStudentYear[$endYear] ?? 0) - 1;
                    $delStudentYear[$endYear] = ($delStudentYear[$endYear] ?? 0) + 1;

                    $sumStudentMonth[$endMonth] = ($sumStudentMonth[$endMonth] ?? 0) - 1;
                    $delStudentMonth[$endMonth] = ($delStudentMonth[$endMonth] ?? 0) + 1;
                }
            }

            switch ($student->sex_s) {
                case 'زن': $sex[0]++; break;
                case 'مرد': $sex[1]++; break;
                default: $sex[2]++;
            }

            if ($student->education_s) {
                $education[$student->education_s] = ($education[$student->education_s] ?? 0) + 1;
            }

            if ($student->language_s) {
                $language[$student->language_s] = ($language[$student->language_s] ?? 0) + 1;
            }

            if ($student->religious_s) {
                $religious[$student->religious_s] = ($religious[$student->religious_s] ?? 0) + 1;
            }

            if ($student->religion2_s) {
                $religion2[$student->religion2_s] = ($religion2[$student->religion2_s] ?? 0) + 1;
            }

            if ($student->country_id && $student->country_id != 0) {
                $countriesID[$student->country_id] = ($countriesID[$student->country_id] ?? 0) + 1;
            }

            if (is_numeric($student->birthYear) && $student->birthYear > 0) {
                $birthYear = $student->birthYear;
                $currentYear = Jalalian::fromCarbon(Carbon::now())->getYear();
                if ($birthYear < 150) {
                    $age = $birthYear;
                } else {
                    if ($birthYear > 1500) {
                        try {
                            $birthYear = Jalalian::fromCarbon(Carbon::createFromDate($birthYear, 1, 1))->getYear();
                        } catch (Exception $e) {
                            continue;
                        }
                    }
                    $age = $currentYear - $birthYear;
                }
                if ($age < 0 || $age > 200) continue;
                $ageRange = (floor($age / 10)) * 10;
                $ageRange = "$ageRange تا " . ($ageRange + 9) . " سال";
                $ages[$ageRange] = ($ages[$ageRange] ?? 0) + 1;
            }
        }

        $sum = array_sum($sex);
        $sexPercent = array_map(fn($count) => round(($count / $sum) * 100), $sex);

        $sum = array_sum($religious);
        $religiousPercent = array_map(fn($count) => round(($count / $sum) * 100) . "%", $religious);

        $sum = array_sum($religion2);
        $religion2Percent = array_map(fn($count) => round(($count / $sum) * 100) . "%", $religion2);

        if ($minYear !== PHP_INT_MAX && $maxYear !== PHP_INT_MIN) {
            for ($i = $minYear; $i <= $maxYear; $i++) {
                $sumStudentYear[$i] = $sumStudentYear[$i] ?? 0;
                $addStudentYear[$i] = $addStudentYear[$i] ?? 0;
                $delStudentYear[$i] = $delStudentYear[$i] ?? 0;

                for ($j = 1; $j <= 12; $j++) {
                    $monthKey = sprintf("%d/%02d", $i, $j);
                    $sumStudentMonth[$monthKey] = $sumStudentMonth[$monthKey] ?? 0;
                    $addStudentMonth[$monthKey] = $addStudentMonth[$monthKey] ?? 0;
                    $delStudentMonth[$monthKey] = $delStudentMonth[$monthKey] ?? 0;
                }
            }
        }

        ksort($sumStudentYear);
        ksort($addStudentYear);
        ksort($delStudentYear);
        ksort($sumStudentMonth);
        ksort($addStudentMonth);
        ksort($delStudentMonth);

        $last = 0;
        foreach ($sumStudentYear as &$count) {
            $count += $last;
            $last = $count;
        }

        $last = 0;
        foreach ($sumStudentMonth as &$count) {
            $count += $last;
            $last = $count;
        }

        $conveneCounts = Convene::with('users.students')->get();
        $conveneResult = [];
        foreach ($conveneCounts as $convene) {
            $studentCount = $convene->users->flatMap->students->count();
            $conveneResult[$convene->name] = $studentCount;
        }
        $yearChart = [$this->jslist(array_keys($sumStudentYear)), $this->jslist($sumStudentYear), $this->jslist($addStudentYear), $this->jslist($delStudentYear)];
        $monthChart = [$this->jslist(array_keys($sumStudentMonth)), $this->jslist($sumStudentMonth), $this->jslist($addStudentMonth), $this->jslist($delStudentMonth)];

        uksort($ages, fn($a, $b) => (int)explode(" تا ", $a)[0] - (int)explode(" تا ", $b)[0]);

        $countries = Country::whereIn('id', array_keys($countriesID))->get();
        $countriesArr = $countries->filter(fn($row) => $countriesID[$row->id] >= 1000)
            ->sortByDesc(fn($row) => $countriesID[$row->id])
            ->mapWithKeys(fn($row) => [$row->title => $countriesID[$row->id]])
            ->toArray();
        return [
            'year' => $yearChart,
            'month' => $monthChart,
            'sex' => ['data' => $this->jslist($sex), 'sexPercent' => $sexPercent],
            'convene' => ['data' => $this->jslist($conveneResult), 'key' => $this->jslist(array_keys($conveneResult))],
            'age' => ['data' => $this->jslist($ages), 'key' => $this->jslist(array_keys($ages))],
            'education' => ['data' => $this->jslist($education), 'key' => $this->jslist(array_keys($education))],
            'language' => ['data' => $this->jslist($language), 'key' => $this->jslist(array_keys($language))],
            'religious' => ['data' => $this->jslist($religious), 'religiousPercent' => $this->jslist($religiousPercent)],
            'religion2' => ['data' => $this->jslist($religion2), 'religion2Percent' => $this->jslist($religion2Percent)],
            'countries' => ['data' => $this->jslist($countriesArr), 'key' => $this->jslist(array_keys($countriesArr))],
        ];
    }



    function jslist(array $data=array() , $mark = '"' ){
        $str = '[';
        foreach ($data as $item){
            $str .= $mark.$item.$mark.', ';
        }
        $str = substr($str, 0, -1);
        $str .= ']';
        return $str;
    }
    public function worldMap()
    {

        $user = auth()->user();
        $students = Student::query();
        if ($user->can('some user')) {
            $convene = Convene::where('user_id',$user->id)->first();
            $ids = User::where('convene_id',$convene->id)->pluck('id');
            $students->whereIn('user_id',$ids);
        } elseif ($user->can('one user')) {
            $students->where('user_id',$user->id);
        }
        $students = $students->get();
        $countriesID = [];
        foreach ($students as $student){
            if ($student->country_id and $student->country_id != 0){
                if (isset($countriesID[$student->country_id])) $countriesID[$student->country_id]++;
                else $countriesID[$student->country_id] = 1;
            }
        }
        $countries = Country::get();
        $countriesArr = [];
        foreach ($countries as $row) {
            if (!isset($countriesID[$row->id])) continue;
            $countriesArr[$row->ISO2] = $countriesID[$row->id];
        }
        return view('admin.report.chart-world', compact('countriesArr'));
    }
    public function export(Request $request)
    {
        $user = auth()->user();

        $countries = Country::get();

        $convenes = Convene::get();

        $users = [];
        if ($user->can('all user')) $users = User::with('convene')->get();
        if ($user->can('some user')) $users = User::whereHas('conveneB', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        $courses = Course::query();
        if ($user->can('all user')) {
            $courses = $courses->get();
        }else{
            $courses = $courses->whereHas('convenes', function($query) use ($user) {
                $query->where('id', $user->convene_id);
            })->get();
        }

        $classrooms = Classroom::query();
        if ($user->can('all user')) {
            $classrooms = Classroom::get();
        } elseif ($user->can('some user')) {
            $classrooms = Classroom::whereHas('course.convenes', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } elseif ($user->can('one user')) {
            $classrooms = Classroom::whereHas('course.convenes', function ($query) use ($user) {
                $query->where('convene_id', $user->convene_id);
            })->get();
        }
        $settings = $this->loadSetting(['language', 'sex', 'religious', 'education', 'religion2', 'opinionAboutIran', 'financialSituation', 'donation']);

        //////////////////////////

        $students = Student::query();

        if ($request->language) $students->where('language_s',$request->language);
        if ($request->sex) $students->where('sex_s',$request->sex);
        if ($request->religious) $students->where('religious_s',$request->religious);
        if ($request->education) $students->where('education_s',$request->education);
        if ($request->religion2) $students->where('religion2_s',$request->religion2);
        if ($request->opinionAboutIran) $students->where('opinionAboutIran_s',$request->opinionAboutIran);
        if ($request->financialSituation) $students->where('financialSituation_s',$request->financialSituation);
        if ($request->donation) $students->where('donation_s',$request->donation);
        if ($request->publicRelation) $students->where('publicRelation_s',$request->publicRelation);

        if ($request->country_id) $students->where('country_id',$request->country_id);
        if ($request->firstName) $students->where('firstName',$request->firstName);
        if ($request->lastName) $students->where('lastName',$request->lastName);
        if ($request->city) $students->where('city',$request->city);
        if ($request->job) $students->where('job',$request->job);
        if ($request->mobile) $students->where('mobile',$request->mobile);
        if ($request->email) $students->where('email',$request->email);
        if ($request->address) $students->where('address',$request->address);
        if ($request->aboutStudent) $students->where('aboutStudent',$request->aboutStudent);
        if ($request->character) $students->where('character',$request->character);
        if ($request->skill) $students->where('skill',$request->skill);
        if ($request->allergie) $students->where('allergie',$request->allergie);
        if ($request->ext) $students->where('ext',$request->ext);
        if ($request->isManageable) $students->where('isManageable',$request->isManageable);
        if ($request->canDoAct) $students->where('canDoAct',$request->canDoAct);

        if ($request->convene_id) {
            $students->whereHas('user.convenes', function ($query) use ($request) {
                $query->where('convene_id', $request->convene_id);
            });
        }
        if ($request->user_id) $students->where('user_id',$request->user_id);
        if ($request->course_id) {
            $students->whereHas('courses', function ($query) use ($request) {
                $query->where('course_id', $request->course_id);
            });
        }
        if ($request->classroom_id) {
            $students->whereHas('classroom', function ($query) use ($request) {
                $query->where('classroom_id', $request->classroom_id);
            });
        }
        if ($time = $request->input('startTS-from')){
            if (strpos($time, ':') !== false) $startTS = Jalalian::fromFormat('Y/n/j H:i:s', $time)->getTimestamp();
            else $startTS = Jalalian::fromFormat('Y/n/j', $time)->getTimestamp();
            $students->where('startTS','>',$startTS);
        }
        if ($time = $request->input('startTS-to')){
            if (strpos($time, ':') !== false) $startTS = Jalalian::fromFormat('Y/n/j H:i:s', $time)->getTimestamp();
            else $startTS = Jalalian::fromFormat('Y/n/j', $time)->getTimestamp();
            $students->where('startTS','<',$startTS);
        }
        if ($time = $request->input('endTS-from')){
            if (strpos($time, ':') !== false) $endTS = Jalalian::fromFormat('Y/n/j H:i:s', $time)->getTimestamp();
            else $endTS = Jalalian::fromFormat('Y/n/j', $time)->getTimestamp();
            $students->where('endTS','>',$endTS);
        }
        if ($time = $request->input('endTS-to')){
            if (strpos($time, ':') !== false) $endTS = Jalalian::fromFormat('Y/n/j H:i:s', $time)->getTimestamp();
            else $endTS = Jalalian::fromFormat('Y/n/j', $time)->getTimestamp();
            $students->where('endTS','<',$endTS);
        }
        $ageFrom = $request->input('age-from');
        $ageTo = $request->input('age-to');
        if ($ageFrom !== null && $ageTo !== null) {
            $currentYearGregorian = date('Y');
            $currentYearShamsi = Jalalian::now()->getYear();

            $birthYearFromShamsi = $currentYearShamsi - $ageTo;
            $birthYearToShamsi = $currentYearShamsi - $ageFrom;

            $birthYearFromGregorian = $currentYearGregorian - $ageTo;
            $birthYearToGregorian = $currentYearGregorian - $ageFrom;
            $students->whereBetween('birthYear', [$birthYearFromShamsi, $birthYearToShamsi])->OrWhereBetween('birthYear', [$birthYearFromGregorian, $birthYearToGregorian])->get();
        }

        if($request->excel == 1){
            $students = $students->get();
            $fileName = 'studentExport/' . now()->format('Y_m_d_H_i_s') . '_students.xlsx';
            Excel::store(new StudentsExport($students), $fileName, 'public');
            return view('admin.report.export-excel', compact('fileName'));
        }

        $students->with('courses','nationality','country');
        if ($request->exportCount) $paginate = $request->exportCount;
        else $paginate = 10;
        $students = $students->paginate($paginate);
        return view('admin.report.export', compact('countries', 'convenes' , 'students', 'users', 'courses', 'classrooms', 'settings'));
    }

    public function system()
    {
        $user = auth()->user();
        $students = Student::get()->count();
        $activities = Activity::get();
        $classrooms = Classroom::get();
        $tickets = Ticket::get();
        $convenes = Convene::get()->count();
        $users = User::get()->count();

        $settings = $this->loadSetting(['classState', 'actionState', 'language']);


        $classState = [];
        $classStatePercent = [];
        foreach ($settings['classState'] as $setting) $classState[$setting] = 0;

        $countriesID = [];

        $language = [];
        foreach ($settings['language'] as $setting) $language[$setting] = 0;

        foreach ($classrooms as $classroom){
            if ($classroom->state_s)
                if (isset($classState[$classroom->state_s]))
                    $classState[$classroom->state_s]++;

            if ($classroom->country_id and $classroom->country_id != 0){
                if (isset($countriesID[$classroom->country_id])) $countriesID[$classroom->country_id]++;
                else $countriesID[$classroom->country_id] = 1;
            }

            if ($classroom->language_s)
                if (isset($language[$classroom->language_s]))
                    $language[$classroom->language_s]++;
        }
        $sum = array_sum($classState);
        foreach ($classState as $key => $row) $classStatePercent [$key."(".round(($row/$sum)*100)."%)"] = $row;


        $actionState = [];
        $actionStatePercent = [];
        foreach ($settings['actionState'] as $setting) $actionState[$setting] = 0;
        foreach ($activities as $activity){
            if ($activity->actionState_s)
                if (isset($actionState[$activity->actionState_s]))
                    $actionState[$activity->actionState_s]++;
        }
        $sum = array_sum($actionState);
        foreach ($actionState as $key => $row) $actionStatePercent [$key."(".round(($row/$sum)*100)."%)"] = $row;


        $ticketState = ['باز' => 0, 'بسته' => 0];
        $ticketStatePercent = [];
        foreach ($tickets as $ticket){
            if ($ticket->acitve == 1) $ticketState['باز']++;
            else $ticketState['بسته']++;
        }
        $sum = array_sum($ticketState);
        foreach ($ticketState as $key => $row) $ticketStatePercent [$key."(".round(($row/$sum)*100)."%)"] = $row;



        $countries = Country::whereIn('id',array_keys($countriesID))->get();
        $countriesArr = [];
        foreach ($countries as $row) $countriesArr[$row->title] = $countriesID[$row->id];

        arsort($countriesArr);
        arsort($language);
        $activities = $activities->count();
        $classrooms = $classrooms->count();
        $tickets = $tickets->count();
        $chartData = [
            'classState' => ['data' => $this->jslist($classState), 'classPercent' => $this->jslist(array_keys($classStatePercent))],
            'actionState' => ['data' => $this->jslist($actionState), 'actionPercent' => $this->jslist(array_keys($actionStatePercent))],
            'ticketState' => ['data' => $this->jslist($ticketState), 'ticketPercent' => $this->jslist(array_keys($ticketStatePercent))],
            'countries' => ['data' => $this->jslist($countriesArr), 'key' => $this->jslist(array_keys($countriesArr))],
            'language' => ['data' => $this->jslist($language), 'key' => $this->jslist(array_keys($language))],
        ];
        return view('admin.report.report', compact('students', 'activities' ,'classrooms', 'tickets', 'convenes', 'users', 'chartData'));
    }
}
