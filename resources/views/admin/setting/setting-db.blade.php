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
                                    <li class="breadcrumb-item active">مدیریت پایگاه داده
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
                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card px-2">
                                <div class="row">
                                    <a href="{{ route('backup.create') }}" class="btn btn-success w-auto"> پشتیبان گیری</a>
                                    <a href="#" onclick="document.getElementById('uploadForm').style.display='block'" class="btn btn-info"> بارگزاری پشتیبان </a>
                                </div>

                                <form id="uploadForm" method="post" action="{{ route('backup.upload') }}" enctype="multipart/form-data" style="display:none;">
                                    @csrf
                                    <div class="card-header">
                                        <h4 class="card-title">بارگزاری فایل پشتیبان:</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="file"> فایل پشتیبان </label>
                                            <input type="file" name="file" id="file" class="form-control">
                                            <p>با بارگزاری فایل پشتیبان، به صورت خودکار بازگرانی <u>نمی‌شود</u>.</p>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" name="submit" value="تایید" class="btn btn-success">
                                    </div>
                                </form>
                                <hr><br>
                                <table class="table">
                                    @foreach($backups as $backup)
                                        <tr>
                                            <td>{{ $backup['name'] }} &nbsp;&nbsp;&nbsp;</td>
                                            <td>{{ $backup['time']->format('H:i - Y/m/d') }}</td>
                                            <td>
                                                <a class="btn btn-warning" href="{{ route('backup.download', $backup['name']) }}">دانلود</a>
                                                <a class="btn btn-primary" href="{{ route('backup.restore', $backup['name']) }}">بازیابی</a>
                                                <a class="btn btn-danger" href="{{ route('backup.delete', $backup['name']) }}">حذف</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
