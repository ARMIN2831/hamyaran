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

                                <form method="post" action="{{ route('users.update',$user->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-header">
                                        <h4 class="card-title">مشخصات مدیرکل:</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="userName"> نام کاربری </label>
                                                <input type="text" name="username" id="userName" value="{{ $user->username }}" class="form-control">
                                            </fieldset>
                                        </div>
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
                                                <label for="password"> رمز </label>
                                                <input type="password" name="password" id="password" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="level"> سطح </label>
                                                <select style="width: 100%;margin-right: 0" name="level" id="level" class="select2 form-control">
                                                    <option value="">انتخاب کنید</option>
                                                    <option @if('مدیرکل' == $user->level) selected="selected" @endif value="مدیرکل">مدیرکل</option>
                                                    <option @if('مدیر' == $user->level) selected="selected" @endif value="مدیر">مدیر</option>
                                                    <option @if('پشتیبان' == $user->level) selected="selected" @endif value="پشتیبان">پشتیبان</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-12" style="display: grid;grid-column: 4">
                                            <fieldset class="form-group">
                                                <label> دسترسی‌ها </label>
                                                <br>
                                                @foreach($permissions as $permission)
                                                    <label> <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                                                   @if(isset($userPermissions) && in_array($permission->title, $userPermissions)) checked @endif>
                                                        {{ $permission->title }}</label>
                                                @endforeach
                                            </fieldset>
                                        </div>

                                        <div class="card-header col-12 bg-primary my-2">
                                            <h4 class="card-title white">مشخصات اصلی:</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="country"> کشور </label>
                                                <select style="width: 100%;margin-right: 0" name="country_id" id="country" class="select2 form-control">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($countries as $country)
                                                        <option @if($country->id == $user->country_id) selected="selected" @endif value="{{ $user->country_id }}">{{ $country->name }} - {{ $country->symbol }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="city"> شهر </label>
                                                <input type="text" name="city" id="city" value="{{ $user->city }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="address"> آدرس </label>
                                                <input type="text" name="address" id="address" value="{{ $user->address }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="nationality"> ملیت </label>
                                                <select style="width: 100%;margin-right: 0" name="nationality" id="nationality" class="select2 form-control">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($countries as $country)
                                                        <option @if($country->id == $user->nationality_id) selected="selected" @endif value="{{ $user->nationality_id }}">{{ $country->name }} - {{ $country->symbol }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="language"> زبان‌ </label>
                                                <select name="language" id="language" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['language'] as $setting)
                                                        <option @if($setting == $user->language_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="birthYear"> سال تولد(میلادی) </label>
                                                <input type="number" name="birthYear" id="birthYear" min="1900" value="{{ $user->birthYear }}" class="form-control" placeholder="2010">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                @foreach ($settings['sex'] as $setting)
                                                    <label>{{ $setting }}
                                                        <input type="radio" name="sex_s" @if($setting == $user->sex_s) checked @endif value="{{ $setting }}">
                                                    </label>
                                                    &nbsp;&nbsp;&nbsp;
                                                @endforeach
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>متأهل
                                                    <input type="radio" name="isMarried" @if($user->isMarried == 1) checked @endif value="1">
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label>مجرد
                                                    <input type="radio" name="isMarried" @if($user->isMarried == 0) checked @endif value="0">
                                                </label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="job"> شغل </label>
                                                <input type="text" name="job" id="job" value="{{ $user->job }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="education"> تحصیلات‌ </label>
                                                <select name="education_s" id="education" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['education'] as $setting)
                                                        <option @if($setting == $user->education_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="mobile"> شماره موبایل </label>
                                                <span class="row w-100 mx-auto">
                    <input type="text" name="mobile1" id="mobile" value="{{ $user->mobile }}" placeholder="9123334455" class="form-control dir-ltr w-80">
                    <input type="text" name="mobile0" id="c_mobile" value="{{ $user->c_mobile }}" placeholder="+98" class="form-control dir-ltr w-20">
                </span>
                                            </fieldset>
                                        </div>

                                        <div class="card-header col-12 bg-primary my-2">
                                            <h4 class="card-title white">مشخصات تکمیلی:</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="religion1"> دین </label>
                                                <select name="religion1_s" id="religion1" class="custom-select" onchange="religious2()">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['religious'] as $setting)
                                                        <option @if($setting == $user->religion1_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6" id="religion1_box">
                                            <fieldset class="form-group">
                                                <label for="religion2"> مذهب </label>
                                                <input type="text" name="religion2_s" id="religion2" value="{{ $user->religion2_s }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6" id="religion2_box">
                                            <fieldset class="form-group">
                                                <label for="religion2"> مذهب </label>
                                                <select name="religion2_s" id="religion2" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['religion2'] as $setting)
                                                        <option @if($setting == $user->religion2_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <script>
                                            function religious2(){
                                                if (document.getElementById("religion1").value=="اسلام"){
                                                    document.getElementById("religion1_box").style.display="none";
                                                    document.getElementById("religion2_box").style.display="block";
                                                }else {
                                                    document.getElementById("religion2_box").style.display="none";
                                                    document.getElementById("religion1_box").style.display="block";
                                                }
                                            }
                                            religious2();
                                        </script>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="opinionAboutIran"> موضع نسبت به ایران </label>
                                                <select name="opinionAboutIran" id="opinionAboutIran" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['opinionAboutIran'] as $setting)
                                                        <option @if($setting == $user->opinionAboutIran_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label>توانمندی در مدیریت </label>
                                                <label>دارد
                                                    <input type="radio" name="isManageable" @if($user->isManageable == 1) checked @endif value="1">
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label>ندارد
                                                    <input type="radio" name="isManageable" @if($user->isManageable == 0) checked @endif value="0">
                                                </label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label>امکان واگذاری فعالیت </label>
                                                <label>دارد
                                                    <input type="radio" name="canDoAct" @if($user->canDoAct == 1) checked @endif value="1">
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label>ندارد
                                                    <input type="radio" name="canDoAct" @if($user->canDoAct == 0) checked @endif value="0">
                                                </label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label>روابط عمومی </label>
                                                <label>خوب
                                                    <input type="radio" name="publicRelation" @if($user->publicRelation == 1) checked @endif value="1">
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label>ضعیف
                                                    <input type="radio" name="publicRelation" @if($user->publicRelation == 1) checked @endif value="0">
                                                </label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="financialSituation"> وضعیت مالی </label>
                                                <select name="financialSituation_s" id="financialSituation" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['financialSituation'] as $setting)
                                                        <option @if($setting == $user->financialSituation_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="donation"> علاقه به حمایت مالی </label>
                                                <select name="donation_s" id="donation" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['donation'] as $setting)
                                                        <option @if($setting == $user->donation_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="aboutStudent"> درباره مدیر </label>
                                                <textarea type="text" name="aboutStudent" id="aboutStudent" class="form-control">{{ $user->aboutStudent }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="character">  شخصیت مدیر </label>
                                                <textarea type="text" name="character" id="character" class="form-control">{{ $user->character }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="skill">  مهارت‌های مدیر </label>
                                                <textarea type="text" name="skill" id="skill" class="form-control">{{ $user->skill }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="allergie">  حساسیت‌های ارتباطی </label>
                                                <textarea type="text" name="allergie" id="allergie" class="form-control">{{ $user->allergie }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="ext">  سایر موارد </label>
                                                <textarea type="text" name="ext" id="ext" class="form-control">{{ $user->ext }}</textarea>
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
