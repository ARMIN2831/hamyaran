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

                            <form method="post" action="{{ route('institutes.store') }}">
                                @csrf
                                <div class="card-header">
                                    <h4 class="card-title">مشخصات اصلی:</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="name"> نام موسسه </label>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
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
                                            <label for="mobile"> شماره موبایل </label>
                                            <span class="row w-100 mx-auto">
                    <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" placeholder="9123334455" class="form-control dir-ltr w-80">
                    <input type="text" name="c_mobile" id="c_mobile" value="{{ old('c_mobile') }}" placeholder="+98" class="form-control dir-ltr w-20">
                </span>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="whatsapp"> شماره واتساپ </label>
                                            <span class="row w-100 mx-auto">
                    <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}" placeholder="9123334455" class="form-control dir-ltr w-80">
                    <input type="text" name="c_whatsapp" id="whatsapp" value="{{ old('c_whatsapp') }}" placeholder="+98" class="form-control dir-ltr w-20">
                </span>
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
                                            <label for="email"> ایمیل </label>
                                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
                                        </fieldset>
                                    </div>

                                    @if(!auth()->user()->can('one user'))
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="supporter"> پشتیبان </label>
                                                <select style="width: 100%;margin-right: 0" name="supporter" id="supporter" class="select2 form-control">
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
                                            <label for="admin"> نام مدیر </label>
                                            <input type="text" name="admin" id="admin" value="{{ old('admin') }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="adminmail"> ایمیل / تلفن مدیر </label>
                                            <input type="text" name="adminmail" id="adminmail" value="{{ old('adminmail') }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="interface"> نام رابط </label>
                                            <input type="text" name="interface" id="interface" value="{{ old('interface') }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="interfacemail"> ایمیل / تلفن رابط </label>
                                            <input type="text" name="interfacemail" id="interfacemail" value="{{ old('interfacemail') }}" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="startTS"> تاریخ ثبت  </label>
                                            <input type="text" name="startTS" id="startTS" placeholder="اگر وارد نشود زمان حال ثبت می‌شود" class="form-control">
                                            <script>
                                                var objCal1 = new AMIB.persianCalendar( 'startTS' );
                                            </script>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="timeinterface"> تاریخ ارتباط </label>
                                            <input type="text" name="timeinterface" id="timeinterface" class="form-control">
                                            <script>
                                                var objCal1 = new AMIB.persianCalendar( 'timeinterface' );
                                            </script>
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
