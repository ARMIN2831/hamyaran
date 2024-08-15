@extends('layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> موسسات </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> مدیریت موسسات </a>
                                </li>
                                <li class="breadcrumb-item active">افزودن موسسه
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

                            <form method="post" action="{{ route('students.store') }}">
                                @csrf
                                <div class="card-header">
                                    <h4 class="card-title">مشخصات اصلی:</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="firstName"> نام </label>
                                            <input type="text" name="firstName" id="firstName" value="{{ old('firstName') }}" class="form-control" required>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="lastName"> نام خانوادگی </label>
                                            <input type="text" name="lastName" id="lastName" value="{{ old('lastName') }}" class="form-control" required>
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
                                            <input type="text" name="city" id="city" value="{{ old('city') }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="address"> آدرس </label>
                                            <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-control">
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
                                            <label for="language"> زبان‌ </label>
                                            <select name="language" id="language" class="custom-select">
                                                <option value="">انتخاب کنید</option>
                                                @foreach ($settings['language'] as $setting)
                                                    <option value="{{ $setting }}">{{ $setting }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="birthYear"> سال تولد(میلادی) </label>
                                            <input type="number" name="birthYear" id="birthYear" min="1900" value="{{ old('birthYear') }}" class="form-control" placeholder="2010">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            @foreach ($settings['sex'] as $setting)
                                                <label>{{ $setting }}
                                                    <input type="radio" name="sex_s" value="{{ $setting }}">
                                                </label>
                                                &nbsp;&nbsp;&nbsp;
                                            @endforeach
                                        </fieldset>
                                        <fieldset class="form-group">
                                            <label>متأهل
                                                <input type="radio" name="isMarried" value="1">
                                            </label>
                                            &nbsp;&nbsp;&nbsp;
                                            <label>مجرد
                                                <input type="radio" name="isMarried" value="0">
                                            </label>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="job"> شغل </label>
                                            <input type="text" name="job" id="job" value="{{ old('job') }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="education"> تحصیلات‌ </label>
                                            <select name="education_s" id="education" class="custom-select">
                                                <option value="">انتخاب کنید</option>
                                                @foreach ($settings['education'] as $setting)
                                                    <option value="{{ $setting }}">{{ $setting }}</option>
                                                @endforeach
                                            </select>
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
                                            <label for="mobile"> شماره موبایل </label>
                                            <span class="row w-100 mx-auto">
                    <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" placeholder="9123334455" class="form-control dir-ltr w-80">
                    <input type="text" name="c_mobile" id="c_mobile" value="{{ old('c_mobile') }}" placeholder="+98" class="form-control dir-ltr w-20">
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
                                                        <option dir="rtl" value="{{ $user->id }}">{{ $user->name.' '. $i .'('.@$user->convene->name.')' }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="startTS"> تاریخ ثبت نام </label>
                                            <input type="text" name="startTS" id="startTS" placeholder="اگر وارد نشود زمان حال ثبت می‌شود" class="form-control">
                                            <script>
                                                var objCal1 = new AMIB.persianCalendar( 'startTS' );
                                            </script>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="endTS"> تاریخ خروج </label>
                                            <input type="text" name="endTS" id="endTS" class="form-control">
                                            <script>
                                                var objCal1 = new AMIB.persianCalendar( 'endTS' );
                                            </script>
                                        </fieldset>
                                    </div>
                                    <div class="col-12 row">
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
