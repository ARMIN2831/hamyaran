@extends('layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> فعالیت‌ها </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> تعیین فعالیت برای دانشجو </a>
                                </li>
                                <li class="breadcrumb-item active">افزودن فعالیت
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

                            <form enctype="multipart/form-data" method="post" action="{{ route('activities.store') }}">
                                @csrf
                                <div class="card-header">
                                    <h4 class="card-title"> ثبت فعالیت:</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="student_id"> دانشجو </label>
                                            <select style="width: 300px;" dir="rtl" name="student_id" id="student_id" class="select2 form-control activity-select">
                                                <option value="">همه‌ی دانشجویان</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="title"> عنوان فعالیت </label>
                                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" required>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="description"> توضیحات فعالیت </label>
                                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="">{{ old('description') }}</textarea>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="studentComment"> نظر دانشجو </label>
                                            <textarea class="form-control" name="studentComment" id="studentComment" rows="3" placeholder="">{{ old('studentComment') }}</textarea>
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
                                    <div class="col-md-12">
                                        <fieldset class="form-group">
                                            <label for="report"> گزارش متنی </label>
                                            <textarea class="form-control" name="report" id="report" rows="3" placeholder="">{{ old('report') }}</textarea>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="image"> فایل گزارش </label>
                                            <input type="file" name="image" id="image" value="" class="form-control">
                                            <p>می‌توانید عکس، سند PDF یا فایل فشرده بارگزاری نمایید.</p>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="actionState_s"> وضعیت فعالیت </label>
                                            <select name="actionState_s" id="actionState_s" class="custom-select">
                                                <option value="">انتخاب کنید</option>
                                                @foreach ($settings['actionState'] as $setting)
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
