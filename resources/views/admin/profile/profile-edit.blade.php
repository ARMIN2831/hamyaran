@extends('layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> پنل مدیریت </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> پروفایل </a>
                                </li>
                                <li class="breadcrumb-item active">ویرایش پروفایل کاربری
                                </li>
                            </ol>
                            @if(session('success'))
                                <div style="margin-top: 20px;margin-bottom: 0" class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php $user = auth()->user(); @endphp
        <div class="content-body">
            <!-- Basic Inputs start -->
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card px-2">
                            <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4 class="card-title">ویرایش پروفایل:</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="name"> نام </label>
                                            <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="email"> ایمیل </label>
                                            <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="image"> تصویر پروفایل </label>
                                            <input type="file" name="image" id="image" value="{{ @$user->image }}" class="form-control">
                                            <input type="hidden" name="image"value="{{ @$user->image }}">
                                            <p>از عکس مربعی ترجیحاً 100x100 پیکسل استفاده نمایید.</p>
                                            @if($user->image)<img src="{{ asset('publicuser/image/'.$user->image) }}" width="100" />@endif

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
                <div class="row">
                    <div class="col-sm-6 col-12 dashboard-users-success">
                        <a href="{{ route('profile.edit') }}">
                            <div class="card text-center hover-shadow ">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                            <i class="bx bx-edit font-medium-5"></i>
                                        </div>
                                        <h4 class="text-muted line-ellipsis">تغییر مشخصات من</h4>
                                        <p class="mb-0">ویرایش نام، ایمیل و تصویر پروفایل</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-12 dashboard-users-success">
                        <a href="{{ route('profile.password') }}">
                            <div class="card text-center hover-shadow">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto mb-50">
                                            <i class="bx bx-key font-medium-5"></i>
                                        </div>
                                        <h4 class="text-muted line-ellipsis">تغییر رمز ورود</h4>
                                        <p class="mb-0">ویرایش رمز ورود به سامانه</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </section>
        </div>
    </div>
</div>
@endsection
