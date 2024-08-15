@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">نقش ها</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a > افزودن نقش</a>
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

                                <form method="post" action="{{ route('roles.update',$role->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-header">
                                        <h4 class="card-title">مشخصات نقش:</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="userName"> نام  </label>
                                                <input type="text" name="name" id="name" value="{{ $role->name }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-12" style="display: grid;grid-column: 4">
                                            <fieldset class="form-group">
                                                <label> دسترسی‌ها </label>
                                                <br>
                                                @foreach($permissions as $permission)
                                                    @if($permission->name == 'all user' || $permission->name == 'some user' || $permission->name == 'one user')
                                                        <label> <input type="radio" name="permissions[]" @if(isset($rolePermissions) && in_array($permission->name, $rolePermissions)) checked @endif value="{{ $permission->name }}">
                                                            {{ $permission->title }}</label>
                                                    @else
                                                        <label> <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                                       @if(isset($rolePermissions) && in_array($permission->name, $rolePermissions)) checked @endif>
                                                            {{ $permission->title }}</label>
                                                    @endif
                                                @endforeach
                                            </fieldset>
                                        </div>
                                        <div style="text-align: left;padding: 10px" class="col-md-12">
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
