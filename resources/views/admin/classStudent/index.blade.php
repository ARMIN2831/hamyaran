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
                                    <li class="breadcrumb-item active">افزودن دانشجو
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

                                <form method="post" action="{{ route('classStudents.store') }}">
                                    @csrf
                                    <div class="card-header">
                                        <h4 class="card-title">افزودن دانشجو به کلاس:</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="classroom_id"> کلاس </label>
                                                <select style="width: 100%;margin-right: 0" name="classroom_id" id="classroom_id" class="select2 form-control classStudent-class-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @if($classroom) <option selected="selected" value="{{ $classroom->id }}">{{ $classroom->name }}</option> @endif
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="student_id"> دانشجو </label>
                                                <select style="width: 100%;margin-right: 0" name="student_id" id="student_id" class="select2 form-control classStudent-student-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @if($student) <option selected="selected" value="{{ $student->id }}">{{ $student->text }}</option> @endif
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <input type="submit" name="submit" value="افزودن" class="btn btn-success">
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
