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

                            <form method="post" action="{{ route('classrooms.store') }}">
                                @csrf
                                <div class="card-header">
                                    <h4 class="card-title">تعریف کلاس:</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="name"> نام کلاس </label>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="description"> توضیحات کلاس </label>
                                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="در صورت نیاز، توضیحاتی را برای دوره وارد کنید...">{{ old('description') }}</textarea>
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
                                                        <option dir="rtl" value="{{ $user->id }}">{{ $user->name.' '. $i .'('.@$user->convene->name.')' }}</option>
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
                                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
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
                                                    <option value="{{ $setting }}">{{ $setting }}</option>
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
                                                    <option value="{{ $country->id }}">{{ $country->title }} - {{ $country->symbol }}</option>
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
                                                    <option @if($setting == $user->language_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            @foreach ($settings['sex'] as $setting)
                                                <label>{{ $setting }}
                                                    <input type="radio" name="sex_s" value="{{ $setting }}">
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                            @endforeach
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="startTS"> تاریخ شروع </label>
                                            <input type="text" name="startTS" id="startTS" value="" class="form-control">
                                            <script>
                                                var objCal1 = new AMIB.persianCalendar( 'startTS' );
                                            </script>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="endTS"> تاریخ پایان </label>
                                            <input type="text" name="endTS" id="endTS" value="" class="form-control">
                                            <script>
                                                var objCal1 = new AMIB.persianCalendar( 'endTS' );
                                            </script>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="spw"> تعداد جلسات در هفته </label>
                                            <input type="number" name="spw" id="spw" value="{{ old('spw') }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="state"> وضعیت کلاس</label>
                                            <select name="state_s" id="state_s" class="custom-select">
                                                <option value="">انتخاب کنید</option>
                                                @foreach ($settings['classState'] as $setting)
                                                    <option value="{{ $setting }}">{{ $setting }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" name="submit" value="تایید" class="btn btn-success">
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
