@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0"> گزارشات </h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a> اطلاعات دانشجویان </a>
                                    </li>
                                    <li class="breadcrumb-item active">دریافت گزارشات
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="chartjs-charts">
                    <form method="get" name="filter_form" id="filter_form" action="{{ route('report.export') }}">
                        <div class="card-header">
                            <div class="row">
                                <h4 class="card-title">فیلترهای گزارش</h4>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="{{ route('report.export') }}/#table" class="btn btn-primary">هدایت به جدول</a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a id="excel-button" class="btn btn-outline-warning">دریافت گزارش اکسل</a>
                            </div>
                            <p>برای جست‌وجوی مشابه در ورودی‌های متنی در پایان متن، علامت * را وارد نمایید.</p>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="firstName"> نام </label>
                                    <input type="text" name="firstName" id="firstName" value="{{ request('firstName') }}" class="form-control">
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="lastName"> نام خانوادگی </label>
                                    <input type="text" name="lastName" id="lastName" value="{{ request('lastName') }}" class="form-control">
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="country_d"> کشور </label>
                                    <select style="width: 100%;margin-right: 0" name="country_d" id="country_d" class="select2 form-control">
                                        <option value="">انتخاب کنید</option>
                                        @foreach ($countries as $country)
                                            <option @if($country->id == request('country_d')) selected="selected"
                                                    @endif  value="{{ $country->id }}">{{ $country->name.' '.$country->symbol }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="city"> شهر </label>
                                    <input type="text" name="city" id="city" value="{{ request('city') }}" class="form-control">
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="language"> زبان‌ </label>
                                    <select name="language" id="language" class="custom-select">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($settings['language'] as $setting)
                                            <option @if($setting == request('language')) selected="selected"
                                                    @endif value="{{ $setting }}">{{ $setting }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="education"> تحصیلات‌ </label>
                                    <select name="education" id="education" class="custom-select">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($settings['education'] as $setting)
                                            <option @if($setting == request('education')) selected="selected"
                                                    @endif value="{{ $setting }}">{{ $setting }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="religious"> دین </label>
                                    <select name="religious" id="religious" class="custom-select" onchange="religious2()">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($settings['religious'] as $setting)
                                            <option @if($setting == request('religious')) selected="selected"
                                                    @endif value="{{ $setting }}">{{ $setting }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="religion2"> مذهب </label>
                                    <select name="religion2" id="religion2" class="custom-select" onchange="religious2()">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($settings['religion2'] as $setting)
                                            <option @if($setting == request('religion2')) selected="selected"
                                                    @endif value="{{ $setting }}">{{ $setting }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            @if(auth()->user()->can('all user'))
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label for="convene_id"> مجتمع </label>
                                        <select name="convene_id" id="convene_id" class="custom-select">
                                            <option value="">انتخاب کنید</option>
                                            @foreach ($convenes as $convene)
                                                <option @if($convene->id == request('convene_id')) selected="selected"
                                                        @endif value="{{ $convene->id }}">{{ $convene->name }}</option>
                                            @endforeach

                                        </select>
                                    </fieldset>
                                </div>
                            @endif
                            @if(!auth()->user()->can('one user'))
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <label for="user_id"> پشتیبان </label>
                                        <select style="width: 100%;margin-right: 0" name="user_id" id="user_id" class="select2 form-control">
                                            <option value="">انتخاب کنید</option>
                                            @foreach($users as $user)
                                                @php $i = ''; if($user->can('some user')) $i = '*'; @endphp
                                                <option dir="rtl" @if($user->id == request('user_id')) selected="selected"
                                                        @endif value="{{ $user->id }}">{{ $user->name.' '. $i .'('.@$user->convene->name.')' }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="job"> شغل </label>
                                    <input type="text" name="job" id="job" value="{{ request('job') }}" class="form-control">
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="mobile"> شماره موبایل </label>
                                    <input type="text" name="mobile" id="mobile" value="{{ request('mobile') }}" placeholder="+98-9123334455" class="form-control dir-ltr">
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="email"> ایمیل </label>
                                    <input type="text" name="email" id="email" value="{{ request('email') }}" class="form-control">
                                </fieldset>
                            </div>
                            <div class="col-md-8">
                                <fieldset class="form-group">
                                    <label for="address"> آدرس </label>
                                    <input type="text" name="address" id="address" value="{{ request('address') }}" class="form-control">
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="course_id"> دوره </label>
                                    <select style="width: 100%;margin-right: 0" name="course_id" id="course_id" class="select2 form-control">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($courses as $course)
                                            <option @if($course->id == request('course_id')) selected="selected"
                                                    @endif value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="classroom_id"> کلاس </label>
                                    <select style="width: 100%;margin-right: 0" name="classroom_id" id="classroom_id" class="select2 form-control">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($classrooms as $classroom)
                                            <option @if($classroom->id == request('classroom_id')) selected="selected"
                                                    @endif value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="opinionAboutIran"> موضع نسبت به ایران </label>
                                    <select name="opinionAboutIran" id="opinionAboutIran" class="custom-select" onchange="religious2()">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($settings['opinionAboutIran'] as $setting)
                                            <option @if($setting == request('opinionAboutIran')) selected="selected"
                                                    @endif value="{{ $setting }}">{{ $setting }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="financialSituation"> وضعیت مالی </label>
                                    <select name="financialSituation" id="financialSituation" class="custom-select" onchange="religious2()">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($settings['financialSituation'] as $setting)
                                            <option @if($setting == request('financialSituation')) selected="selected"
                                                    @endif value="{{ $setting }}">{{ $setting }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="donation"> علاقه به حمایت مالی </label>
                                    <select name="donation" id="donation" class="custom-select" onchange="religious2()">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($settings['donation'] as $setting)
                                            <option @if($setting == request('donation')) selected="selected"
                                                    @endif value="{{ $setting }}">{{ $setting }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="startTS-from"> ثبت نام از </label>
                                    <input type="text" name="startTS-from" id="startTS-from"
                                           value="{{ request('startTS-from') }}"
                                           class="form-control">
                                    <script>
                                        var objCal1 = new AMIB.persianCalendar('startTS-from');
                                    </script>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="startTS-to"> ثبت نام تا </label>
                                    <input type="text" name="startTS-to" id="startTS-to"
                                           value="{{ request('startTS-to') }}"
                                           class="form-control">
                                    <script>
                                        var objCal2 = new AMIB.persianCalendar('startTS-to');
                                    </script>
                                </fieldset>
                            </div>

                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="endTS-from"> خروج از </label>
                                    <input type="text" name="endTS-from" id="endTS-from"
                                           value="{{ request('endTS-from') }}"
                                           class="form-control">
                                    <script>
                                        var objCal3 = new AMIB.persianCalendar('endTS-from');
                                    </script>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="endTS-to"> خروج تا </label>
                                    <input type="text" name="endTS-to" id="endTS-to"
                                           value="{{ request('startTS-from') }}"
                                           class="form-control">
                                    <script>
                                        var objCal4 = new AMIB.persianCalendar('endTS-to');
                                    </script>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label>سن </label>
                                    <span class="row w-100 mx-auto">
                                <input type="number" name="age-from" id="age-from" value="{{ request('age-from') }}" placeholder="از" class="col-6 form-control">
                                <input type="number" name="age-to" id="age-to" value="{{ request('age-to') }}" placeholder="تا" class="col-6 form-control">
                                </span>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label>جنسیت</label>
                                    <br>
                                    @foreach ($settings['sex'] as $setting)
                                        <label>{{ $setting }}
                                            <input @if($setting == request('sex')) checked @endif type="radio" name="sex" value="{{ $setting }}">
                                        </label>
                                        &nbsp;&nbsp;&nbsp;
                                    @endforeach
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label>توانمندی در مدیریت</label>
                                    <br>
                                    <label>بدون فیلتر
                                        <input type="radio" name="isManageable" @if(request('isManageable') == 'noFilter') checked @endif value="noFilter">
                                        &nbsp;&nbsp;&nbsp;
                                    </label>
                                    <label>دارد
                                        <input type="radio" name="isManageable" @if(request('isManageable') == 1) checked @endif value="1">
                                    </label>
                                    &nbsp;&nbsp;&nbsp;
                                    <label>ندارد
                                        <input type="radio" name="isManageable" @if(request('isManageable') == 0) checked @endif value="0">
                                    </label>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label>امکان واگذاری فعالیت</label>
                                    <br>
                                    <label>بدون فیلتر
                                        <input type="radio" name="canDoAct" @if(request('canDoAct') == 'noFilter') checked @endif value="noFilter">
                                        &nbsp;&nbsp;&nbsp;
                                    </label>
                                    <label>دارد
                                        <input type="radio" name="canDoAct" @if(request('canDoAct') == 1) checked @endif value="1">
                                    </label>
                                    &nbsp;&nbsp;&nbsp;
                                    <label>ندارد
                                        <input type="radio" name="canDoAct" @if(request('canDoAct') == 0) checked @endif value="0">
                                    </label>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label>روابط عمومی</label>
                                    <br>
                                    <label>بدون فیلتر
                                        <input type="radio" name="publicRelation" @if(request('publicRelation') == 'noFilter') checked @endif value="noFilter">
                                        &nbsp;&nbsp;&nbsp;
                                    </label>
                                    <label>خوب
                                        <input type="radio" name="publicRelation" @if(request('publicRelation') == 1) checked @endif value="1">
                                    </label>
                                    &nbsp;&nbsp;&nbsp;
                                    <label>ضعیف
                                        <input type="radio" name="publicRelation" @if(request('publicRelation') == 0) checked @endif value="0">
                                    </label>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label>دارای مشخصات</label><br>
                                    <label> <input type="checkbox" name="aboutStudent" value="1" @if(request('aboutStudent') == 1) checked @endif class="form-check-inline"> درباره</label><br>
                                    <label> <input type="checkbox" name="character" value="1" @if(request('character') == 1) checked @endif class="form-check-inline"> مشخصات</label><br>
                                    <label> <input type="checkbox" name="skill" value="1" @if(request('skill') == 1) checked @endif class="form-check-inline"> مهارت‌ها</label><br>
                                    <label> <input type="checkbox" name="allergie" value="1" @if(request('allergie') == 1) checked @endif class="form-check-inline"> حساسیت‌ها</label><br>
                                    <label> <input type="checkbox" name="ext" value="1" @if(request('ext') == 1) checked @endif class="form-check-inline"> سایر</label><br>
                                </fieldset>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="exportCount">تعداد ردیف هر صفحه </label>
                                    <span class="row w-100 mx-auto">
                                <input type="number" name="exportCount" id="exportCount" min="1" onchange="document.getElementById('submit').click();" value="{{ @$user->exportCount }}" placeholder="تعداد ردیف" class="col-6 form-control">
                                     از   <label id="maxStudent">{{ $students->total() }}</label>
                                </span>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="form-group">
                                    <label for="page">صفحه گزارش </label>
                                    <span class="row w-100 mx-auto">
                                <input type="number" name="page" id="page" onchange="document.getElementById('submit').click();" value="{{ request('page') }}" max="{{ $students->lastPage() }}" placeholder="صفحه" class="col-6 form-control">
                                     از   <label id="maxPage">{{ $students->lastPage() }}</label>
                                </span>
                                </fieldset>
                            </div>
                            <div class="col-md-4" style="display: none">
                                <fieldset class="form-group">
                                    <label>
                                        <input id="excel" name="excel" value="0">
                                    </label>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <a name="submit" id="submit-button" class="btn btn-success">تایید</a>
                                <!--                            <button name="submit">تایید</button>-->
                                <a href="{{ route('report.export') }}" class="btn btn-primary">حذف فیلترها</a>
                            </div>
                        </div>
                    </form>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var form = document.getElementById('filter_form');
                            var excel = document.getElementById('excel');
                            var submitButton = document.getElementById('submit-button');
                            var excelButton = document.getElementById('excel-button');
                            submitButton.addEventListener('click', function(event) {
                                excel.value = 0;
                                form.submit();
                            });
                            excelButton.addEventListener('click', function() {
                                excel.value = 1;
                                form.submit();
                            });
                        });
                    </script>
                </section>
                @include('admin.report.export-show',['students' => $students])
            </div>
        </div>
    </div>
@endsection
