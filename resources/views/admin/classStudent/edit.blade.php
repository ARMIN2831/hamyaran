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
                                    <li class="breadcrumb-item"><a> مدیریت اعضای کلاس‌ها </a>
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش اعضای کلاس
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">لیست دانشجویان کلاس <label class="text-primary">{{ $classroom->name }}</label></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table zero-configuration">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>نام</th>
                                                <th>نام خانوادگی</th>
                                                <th>شناسه</th>
                                                <th>زمان اضافه شدن</th>
                                                <th>نمره</th>
                                                <th>عملکرد</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach($students as $row)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $row->firstName }}</td>
                                                    <td>{{ $row->lastName }}</td>
                                                    <td>{{ $row->id }}</td>
                                                    <td>{{ \Morilog\Jalali\Jalalian::forge($row->startTS)->format('Y/m/d H:i:s') }}</td>
                                                    <td>
                                                        <form id="scoreForm_{{ $row->id }}" action="{{ route('classStudents.update',[$classroom->id,$row->id]) }}" method="post">
                                                            @csrf
                                                            <div class="col-md-6">
                                                                <fieldset class="form-group">
                                                                    <label for="score"></label>
                                                                    <select onchange="doSubmit('scoreForm_{{ $row->id }}')" style="width: 100%;margin-right: 0" name="score" id="score" class="select2 form-control classStudent-class-select">
                                                                        <option value="">انتخاب کنید</option>
                                                                        <option @if($row->pivot->score == 'عالی') selected="selected" @endif value="عالی">عالی</option>
                                                                        <option @if($row->pivot->score == 'خوب') selected="selected" @endif value="خوب">خوب</option>
                                                                        <option @if($row->pivot->score == 'متوسط') selected="selected" @endif value="متوسط">متوسط</option>
                                                                        <option @if($row->pivot->score == 'ضعیف') selected="selected" @endif value="ضعیف">ضعیف</option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        @if(auth()->user()->can('edit student'))
                                                            <a href="{{ route('students.edit', $row->id) }}" title="ویرایش دانشجو" class="btn btn-small btn-primary">
                                                                <i class="bx bx-edit"></i>
                                                            </a>
                                                        @endif
                                                        @if(auth()->user()->can('delete classStudent'))
                                                            <form method="post" action="{{ route('classStudents.destroy',[$classroom->id,$row->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button style="padding: 3px;margin-top: 2px;" type="submit" title="حذف از کلاس" class="btn btn-small btn-danger">
                                                                    <i class="bx bx-x-circle"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <script>
                                            function doSubmit(formId){
                                                document.getElementById(formId).submit();
                                            }
                                        </script>
                                    </div>
                                    {{ $students->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
