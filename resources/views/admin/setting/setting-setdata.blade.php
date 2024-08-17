@extends('layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> مدیریت </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> تنظیمات سامانه </a>
                                </li>
                                <li class="breadcrumb-item active">ورودی اطلاعات
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
        <div class="content-body">
            <!-- Basic Inputs start -->
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card px-2">
                            <form action="{{ route('setting.update') }}" method="post">
                                @csrf
                                <div class="card-header">
                                    <h4 class="card-title">تعریف اطلاعات ورودی فرم‌ها:</h4>
                                </div>
                                <div class="row">
                                    @foreach($settings as $setting)
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="{{ $setting->name }}">{{ $setting->name }}</label>
                                                <textarea class="form-control" name="{{ $setting->name }}" id="{{ $setting->name }}" rows="3">{{ $setting->value }}</textarea>
                                            </fieldset>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="col-md-6">
                                    <input type="submit" name="submit" value="تایید" class="btn btn-success">
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
