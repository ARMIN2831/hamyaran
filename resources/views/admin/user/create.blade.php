@extends('layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">مدیران</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a > لفزودن مدیران/پشتیبانان</a>
                                </li>
                                <li class="breadcrumb-item active">ویرایش
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

                            <form method="post" action="{{ route('users.store') }}">
                                @csrf
                                <div class="card-header">
                                    <h4 class="card-title">مشخصات کاربر:</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="userName"> نام کاربری </label>
                                            <input type="text" name="username" id="userName" value="{{ old('username') }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="name"> نام </label>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="email"> ایمیل </label>
                                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="password"> رمز </label>
                                            <input type="password" name="password" id="password" class="form-control">
                                        </fieldset>
                                    </div>
                                    @if(auth()->user()->can('view role'))
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="role"> نقش </label>
                                            <select style="width: 100%;margin-right: 0" name="role" id="role" class="select2 form-control">
                                                <option value="">انتخاب کنید</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                    @endif
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
