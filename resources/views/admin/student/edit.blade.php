@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0"> دانشجویان </h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a> مدیریت دانشجویان </a>
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش دانشجو
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
                                <form enctype="multipart/form-data" method="post" action="{{ route('students.update',$student->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-header">
                                        <h4 class="card-title">مشخصات اصلی:</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="firstName"> نام </label>
                                                <input type="text" name="firstName" id="firstName" value="{{ $student->firstName }}" class="form-control" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="lastName"> نام خانوادگی </label>
                                                <input type="text" name="lastName" id="lastName" value="{{ $student->lastName }}" class="form-control" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="country_id"> کشور </label>
                                                <select style="width: 100%;margin-right: 0" name="country_id" id="country_id" class="select2 form-control">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->title }} - {{ $country->symbol }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="city"> شهر </label>
                                                <input type="text" name="city" id="city" value="{{ $student->city }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="address"> آدرس </label>
                                                <input type="text" name="address" id="address" value="{{ $student->address }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="nationality_id"> ملیت </label>
                                                <select style="width: 100%;margin-right: 0;" name="nationality_id" id="nationality_id" class="select2 form-control">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->title }} - {{ $country->symbol }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="language_s"> زبان‌ </label>
                                                <select name="language_s" id="language_s" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['language'] as $setting)
                                                        <option @if($setting == $student->language_s)  @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="birthYear"> سال تولد(میلادی) </label>
                                                <input type="number" name="birthYear" id="birthYear" min="1900" value="{{ $student->birthYear }}" class="form-control" placeholder="2010">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                @foreach ($settings['sex'] as $setting)
                                                    <label>{{ $setting }}
                                                        <input @if($setting == $student->sex_s) checked @endif type="radio" name="sex_s" value="{{ $setting }}">
                                                    </label>
                                                    &nbsp;&nbsp;&nbsp;
                                                @endforeach
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>متأهل
                                                    <input @if($student->isMarried == 1) checked @endif type="radio" name="isMarried" value="1">
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label>مجرد
                                                    <input @if($student->isMarried == 0) checked @endif type="radio" name="isMarried" value="0">
                                                </label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="job"> شغل </label>
                                                <input type="text" name="job" id="job" value="{{ $student->job }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="education"> تحصیلات‌ </label>
                                                <select name="education_s" id="education" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['education'] as $setting)
                                                        <option @if($setting == $student->education_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="email"> ایمیل </label>
                                                <input type="email" name="email" id="email" value="{{ $student->email }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="mobile"> شماره موبایل </label>
                                                <span class="row w-100 mx-auto">
                    <input type="text" name="mobile" id="mobile" value="{{ @explode('-',$student->mobile,2)[1] }}" placeholder="9123334455" class="form-control dir-ltr w-80">
                    <input type="text" name="c_mobile" id="c_mobile" value="{{ @explode('-',$student->mobile)[0] }}" placeholder="+98" class="form-control dir-ltr w-20">
                </span>
                                            </fieldset>
                                        </div>
                                        @if(!auth()->user()->can('one user'))
                                            <div class="col-md-6">
                                                <fieldset class="form-group">
                                                    <label for="user_id"> پشتیبان </label>
                                                    <select style="width: 100%;margin-right: 0" name="user_id" id="user_id" class="select2 form-control">
                                                        <option value="">انتخاب کنید</option>
                                                        @foreach($users as $user)
                                                            @php $i = ''; if($user->can('some user')) $i = '*'; @endphp
                                                            <option @if($user->id == $student->user_id) selected="selected" @endif dir="rtl" value="{{ $user->id }}">{{ $user->name.' '. $i .'('.@$user->convene->name.')' }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="startTS"> تاریخ ثبت نام </label>
                                                <input type="text" name="startTS" id="startTS" value="{{ \Morilog\Jalali\Jalalian::forge($student->startTS)->format('Y/m/d H:i:s') }}" placeholder="اگر وارد نشود زمان حال ثبت می‌شود" class="form-control">
                                                <script>
                                                    var objCal1 = new AMIB.persianCalendar( 'startTS' );
                                                </script>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="endTS"> تاریخ خروج </label>
                                                <input type="text" name="endTS" id="endTS" value="{{ \Morilog\Jalali\Jalalian::forge($student->endTS)->format('Y/m/d H:i:s') }}" class="form-control">
                                                <script>
                                                    var objCal1 = new AMIB.persianCalendar( 'endTS' );
                                                </script>
                                            </fieldset>
                                        </div>

                                        <div class="card-header col-12 bg-primary my-2">
                                            <h4 class="card-title white">پروفایل و مدارک:</h4>
                                        </div>
                                        <br>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="profileImg"> تصویر دانشجو </label>
                                                <input type="file" name="profileImg" id="profileImg" class="form-control">
                                                <p>از عکس مربعی ترجیحاً 100x100 پیکسل استفاده نمایید.</p>
                                                @if($student->profileImg) <img src="{{ asset('students/profileImg/'.$student->profileImg) }}" class="w-75" /> @endif
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="passportImg"> تصویر کارت ملی/پاسپورت </label>
                                                <input type="file" name="passportImg" id="passportImg" value="{{ $student->passportImg }}" class="form-control">
                                                @if($student->passportImg) <img src="{{ asset('students/passportImg/'.$student->passportImg) }}" class="w-75" /> @endif
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="evidenceImg"> مدرک تحصیلی </label>
                                                <input type="file" name="evidenceImg" id="evidenceImg" value="{{ $student->evidenceImg }}" class="form-control">
                                                @if($student->evidenceImg) <img src="{{ asset('students/evidenceImg/'.$student->evidenceImg) }}" class="w-75" /> @endif
                                            </fieldset>
                                        </div>
                                        <div class="card-header col-12 bg-primary my-2">
                                            <h4 class="card-title white">مشخصات تکمیلی:</h4>
                                        </div>
                                        <br>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="religious_s"> دین </label>
                                                <select name="religious_s" id="religious_s" class="custom-select" onchange="religious2()">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['religious'] as $setting)
                                                        <option @if($setting == $student->religious_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6" id="religion1_box">
                                            <fieldset class="form-group">
                                                <label for="religion2"> مذهب </label>
                                                <input type="text" name="religion2" id="religion2" value="{{ $student->religion2_s }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6" id="religion2_box">
                                            <fieldset class="form-group">
                                                <label for="religion2_s"> مذهب </label>
                                                <select name="religion2_s" id="religion2_s" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['religion2'] as $setting)
                                                        <option @if($setting == $student->religion2_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <script>
                                            function religious2(){
                                                if (document.getElementById("religious_s").value=="اسلام"){
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
                                                <label for="opinionAboutIran_s"> موضع نسبت به ایران </label>
                                                <select name="opinionAboutIran_s" id="opinionAboutIran_s" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['opinionAboutIran'] as $setting)
                                                        <option @if($setting == $student->opinionAboutIran_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label>توانمندی در مدیریت </label>
                                                <label>دارد
                                                    <input type="radio" name="isManageable" @if($student->isManageable == 1) checked @endif value="1">
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label>ندارد
                                                    <input type="radio" name="isManageable" @if($student->isManageable == 0) checked @endif value="0">
                                                </label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label>امکان واگذاری فعالیت </label>
                                                <label>دارد
                                                    <input type="radio" name="canDoAct" @if($student->canDoAct == 1) checked @endif value="1">
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label>ندارد
                                                    <input type="radio" name="canDoAct" @if($student->canDoAct == 0) checked @endif value="0">
                                                </label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label>روابط عمومی </label>
                                                <label>خوب
                                                    <input type="radio" name="publicRelation" @if($student->publicRelation == 1) checked @endif value="1">
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label>ضعیف
                                                    <input type="radio" name="publicRelation" @if($student->publicRelation == 0) checked @endif value="0">
                                                </label>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="financialSituation_s"> وضعیت مالی </label>
                                                <select name="financialSituation_s" id="financialSituation_s" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['financialSituation'] as $setting)
                                                        <option @if($setting == $student->financialSituation_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="donation_s"> علاقه به حمایت مالی </label>
                                                <select name="donation_s" id="donation_s" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['donation'] as $setting)
                                                        <option @if($setting == $student->donation_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="aboutStudent"> درباره دانشجو </label>
                                                <textarea type="text" name="aboutStudent" id="aboutStudent" class="form-control">{{ $student->aboutStudent }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="character">  شخصیت دانشجو </label>
                                                <textarea type="text" name="character" id="character" class="form-control">{{ $student->character }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="skill">  مهارت‌های دانشجو </label>
                                                <textarea type="text" name="skill" id="skill" class="form-control">{{ $student->skill }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="allergie">  حساسیت‌های ارتباطی </label>
                                                <textarea type="text" name="allergie" id="allergie" class="form-control">{{ $student->allergie }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="ext">  سایر موارد </label>
                                                <textarea type="text" name="ext" id="ext" class="form-control">{{ $student->ext }}</textarea>
                                            </fieldset>
                                        </div>

                                        <div class="col-12 row">
                                            <input type="submit" name="submit" value="تایید" class="btn btn-success">
                                            @if(auth()->user()->can('view classStudent')) <a href="{{ route('classStudents.index', ['student_id' => $student->id]) }}" class="btn btn-primary">افزودن دانشجو به کلاس</a> @endif
                                        </div>
                                    </div>
                                </form>
                                @if(auth()->user()->can('view activity'))
                                    <a href="{{ route('activities.index') }}?student_id={{ $student->id }}" class="btn btn-warning">نمایش فعالیت‌های دانشجو</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection
