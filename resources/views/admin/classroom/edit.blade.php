@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0"> کلاس‌ها </h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a> مدیریت کلاس‌ها </a>
                                    </li>
                                    <li class="breadcrumb-item active">افزودن کلاس
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic Inputs start -->
                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card px-2">
                                <form method="post" action="{{ route('classrooms.update',$classroom->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-header">
                                        <h4 class="card-title">تعریف کلاس:</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="name"> نام کلاس </label>
                                                <input type="text" name="name" id="name" value="{{ $classroom->name }}" class="form-control" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="description"> توضیحات کلاس </label>
                                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="در صورت نیاز، توضیحاتی را برای دوره وارد کنید...">{{ $classroom->description }}</textarea>
                                            </fieldset>
                                        </div>
                                        @if(!auth()->user()->can('one user'))
                                            <div class="col-md-6">
                                                <fieldset class="form-group">
                                                    <label for="user_id"> پشتیبان </label>
                                                    <select style="width: 100%;margin-right: 0" name="user_id" id="user_id" class="select2 form-control">
                                                        <option value="">انتخاب کنید</option>
                                                        @foreach($users as $user)
                                                            @php $i = ''; if($user->can('some user')) $i = '*'; @endphp
                                                            <option @if($user->id == $classroom->user_id) selected="selected" @endif dir="rtl" value="{{ $user->id }}">{{ $user->name.' '. $i .'('.@$user->convene->name.')' }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="course_id"> دوره </label>
                                                <select name="course_id" id="course_id" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach($courses as $course)
                                                        <option @if($course->id == $classroom->course_id) selected="selected" @endif value="{{ $course->id }}">{{ $course->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="platform_s"> محل برگزاری </label>
                                                <select name="platform_s" id="platform_s" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['platforms'] as $setting)
                                                        <option @if($setting == $classroom->platform_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="country_id"> کشور </label>
                                                <select style="width: 100%; margin-right: 0;" name="country_id" id="country_id" class="select2 form-control">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($countries as $country)
                                                        <option @if($country->id == $classroom->country_id) selected="selected" @endif value="{{ $country->id }}">{{ $country->title }} - {{ $country->symbol }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="language"> زبان‌ </label>
                                                <select name="language_s" id="language" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['language'] as $setting)
                                                        <option @if($setting == $classroom->language_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                @foreach ($settings['sex'] as $setting)
                                                    <label>{{ $setting }}
                                                        <input @if($setting == $classroom->sex_s) checked @endif type="radio" name="sex_s" value="{{ $setting }}">
                                                    </label>
                                                    &nbsp;&nbsp;&nbsp;
                                                @endforeach
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="startTS"> تاریخ شروع </label>
                                                <input type="text" name="startTS" id="startTS" value="{{ \Morilog\Jalali\Jalalian::forge($classroom->startTS)->format('Y/m/d H:i:s') }}" class="form-control">
                                                <script>
                                                    var objCal1 = new AMIB.persianCalendar( 'startTS' );
                                                </script>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="endTS"> تاریخ پایان </label>
                                                <input type="text" name="endTS" id="endTS" value="{{ \Morilog\Jalali\Jalalian::forge($classroom->endTS)->format('Y/m/d H:i:s') }}" class="form-control">
                                                <script>
                                                    var objCal1 = new AMIB.persianCalendar( 'endTS' );
                                                </script>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="spw"> تعداد جلسات در هفته </label>
                                                <input type="number" name="spw" id="spw" value="{{ $classroom->spw }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="state_s"> وضعیت کلاس</label>
                                                <select name="state_s" id="state_s" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['classState'] as $setting)
                                                        <option @if($setting == $classroom->state_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            @if(auth()->user()->can('view classStudent')) <a href="{{ route('classStudents.index', ['class_id' => $classroom->id]) }}" class="btn btn-primary">افزودن دانشجو به کلاس</a> @endif
                                            <input type="submit" name="submit" value="تایید" class="btn btn-success">
                                            @if(auth()->user()->can('edit classStudent')) <a href="{{ route('classStudents.edit', $classroom->id) }}" class="btn btn-warning">لیست دانشجویان کلاس</a> @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection
