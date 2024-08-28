@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0"> دانشجویان </h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a> مدیریت دانشجویان </a>
                                    </li>
                                    <li class="breadcrumb-item active">افزودن دانشجویان از اکسل
                                    </li>
                                </ol>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
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

                                <div class="col-md-6">
                                    <form action="{{ route('students.rollback') }}" method="post" class="mt-4">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">بازگردانی آخرین آپلود</button>
                                    </form>
                                </div>
                                <form action="{{ route('students.upload') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-header">
                                        <h4 class="card-title">افزودن دانشجویان از اکسل:</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <p>
                                                    برای افزودن دانشجویان، فایل نمونه را دانلود و بر اساس همین ساختار، مشخصات موجود را تکمیل نمایید.
                                                    <br>
                                                    @if(auth()->user()->can('one user'))
                                                        <a href="{{ asset('public/upload/example-supporter.xlsx') }}">دریافت فایل example.xlsx</a>
                                                    @else
                                                        <a href="{{ asset('public/upload/example-manager.xlsx') }}">دریافت فایل example.xlsx</a>
                                                    @endif
                                                </p>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="file"> بارگزاری فایل </label>
                                                <input type="file" class="form-control" name="file" id="file"/>
                                            </fieldset>
                                        </div>


                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label> مدیریت خطا </label>
                                                <br>
                                                <label class="w-100 alert-success">
                                                    <input type="radio" class="radio" name="error" checked id="error" value="notSetAll"/> عدم ثبت مشخصات همه‌ی دانشجویان در صورت وجود خطا
                                                </label>
                                                <label class="w-100 alert-warning">
                                                    <input type="radio" class="radio" name="error" @if(old('error' == 'notSetStu')) checked @endif id="error" value="notSetStu"/> عدم ثبت مشخصات دانشجویان دارای خطا
                                                </label>
                                                <label class="w-100 alert-danger">
                                                    <input type="radio" class="radio" name="error" @if(old('error' == 'set')) checked @endif id="error" value="set"/> عدم ثبت فیلد دارای خطا
                                                </label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="submit" name="submit" value="تایید" class="btn btn-success">
                                        </div>
                                    </div>
                                </form>
                                @if ($log)
                                    <h3 class="mt-5">لاگ‌ها</h3>
                                    <pre style="overflow-y: scroll;height: 500px;">{{ $log }}</pre>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection
