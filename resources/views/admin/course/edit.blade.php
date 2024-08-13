@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0"> دوره‌ها </h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a> مدیریت دوره‌ها </a>
                                    </li>
                                    <li class="breadcrumb-item active">افزودن دوره
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
                                <form method="post" action="{{ route('courses.update',$course->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-header">
                                        <h4 class="card-title">تعریف دوره:</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="name"> نام دوره </label>
                                                <input type="text" name="name" id="name" value="{{ $course->name }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="description"> توضیحات دوره </label>
                                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="در صورت نیاز، توضیحاتی را برای دوره وارد کنید...">{{ $course->description }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label> در دسترس برای مجتمع‌های </label>
                                                <br>
                                                @foreach($convenes as $convene)
                                                    <label><input @if(isset($ids[$convene->id])) checked @endif type="checkbox" name="convene[{{ $convene->id }}]" value="{{ $convene->id }}" class="form-check-inline">{{ $convene->name }}</label>
                                                @endforeach
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
