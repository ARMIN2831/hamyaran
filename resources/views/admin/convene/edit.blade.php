@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0"> مجتمع‌ها </h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a> مدیریت مجتمع‌ها </a>
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش مجتمع
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

                                <form method="post" action="{{ route('convenes.update',$convene->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-header">
                                        <h4 class="card-title">مشخصات مجتمع:</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="name"> نام مجتمع </label>
                                                <input type="text" name="name" id="name" value="{{ $convene->name }}" class="form-control" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="country"> مدیر </label>
                                                <select style="width: 100%;margin-right: 0" name="user_id" id="user" class="select2 form-control">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($users as $user)
                                                        <option @if($user->id == $convene->user_id) selected="selected" @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="description"> جزئیات مجتمع </label>
                                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="در صورت نیاز، توضیحاتی را برای مجتمع وارد کنید...">{{ $convene->description }}</textarea>
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
