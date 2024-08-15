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
                                    <li class="breadcrumb-item active">ویرایش موسسه
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
                                <form method="post" action="{{ route('institutes.update',$institute->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-header">
                                        <h4 class="card-title">مشخصات اصلی:</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <fieldset class="form-group">
                                                <p> شناسه موسسه: <label class="alert alert-success small py-0 px-1">{{ $institute->id }}</label></p>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="name"> نام موسسه </label>
                                                <input type="text" name="name" id="name" value="{{ $institute->name }}" class="form-control" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="country"> کشور </label>
                                                <select style="width: 100%;margin-right: 0" name="country" id="country" class="select2 form-control">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach($countries as $country)
                                                        <option @if($country->id == $institute->country_id) selected="selected" @endif value="{{ $country->id }}">{{ $country->title }} - {{ $country->symbol }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="city"> شهر </label>
                                                <input type="text" name="city" id="city" value="{{ $institute->city }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="address"> آدرس </label>
                                                <input type="text" name="address" id="address" value="{{ $institute->address }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="mobile"> شماره موبایل </label>
                                                <span class="row w-100 mx-auto">
                    <input type="text" name="mobile" id="mobile" value="{{ $institute->mobile }}" placeholder="9123334455" class="form-control dir-ltr w-80">
                    <input type="text" name="c_mobile" id="c_mobile" value="{{ $institute->c_mobile }}" placeholder="+98" class="form-control dir-ltr w-20">
                </span>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="whatsapp"> شماره واتساپ </label>
                                                <span class="row w-100 mx-auto">
                    <input type="text" name="whatsapp" id="whatsapp" value="{{ $institute->whatsapp }}" placeholder="9123334455" class="form-control dir-ltr w-80">
                    <input type="text" name="c_whatsapp" id="whatsapp" value="{{ $institute->c_whatsapp }}" placeholder="+98" class="form-control dir-ltr w-20">
                </span>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="language"> زبان‌ </label>
                                                <select name="language" id="language" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['language'] as $setting)
                                                        <option @if($setting == $institute->language_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="email"> ایمیل </label>
                                                <input type="email" name="email" id="email" value="{{ $institute->email }}" class="form-control">
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
                                                            <option dir="rtl" @if($institute->supporter == $user->id) selected="selected" @endif value="{{ $user->id }}">{{ $user->name.' '. $i .'('.@$user->convene->name.')' }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="admin"> نام مدیر </label>
                                                <input type="text" name="admin" id="admin" value="{{ $institute->admin }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="adminmail"> ایمیل / تلفن مدیر </label>
                                                <input type="text" name="adminmail" id="adminmail" value="{{ $institute->adminmail }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="interface"> نام رابط </label>
                                                <input type="text" name="interface" id="interface" value="{{ $institute->interface }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="interfacemail"> ایمیل / تلفن رابط </label>
                                                <input type="text" name="interfacemail" id="interfacemail" value="{{ $institute->interfacemail }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="startTS"> تاریخ ثبت  </label>
                                                <input type="text" name="startTS" id="startTS" value="{{ \Morilog\Jalali\Jalalian::forge($institute->startTS)->format('Y/m/d H:i:s') }}" placeholder="اگر وارد نشود زمان حال ثبت می‌شود" class="form-control">
                                                <script>
                                                    var objCal1 = new AMIB.persianCalendar( 'startTS' );
                                                </script>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="timeinterface"> تاریخ ارتباط </label>
                                                <input type="text" name="timeinterface" id="timeinterface" value="{{ \Morilog\Jalali\Jalalian::forge($institute->timeinterface)->format('Y/m/d H:i:s') }}" class="form-control">
                                                <script>
                                                    var objCal1 = new AMIB.persianCalendar( 'timeinterface' );
                                                </script>
                                            </fieldset>
                                        </div>


                                        <div class="card-header col-12 bg-primary my-2">
                                            <h4 class="card-title white">مشخصات تکمیلی:</h4>
                                        </div>
                                        <br>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="AboutInstitute"> درباره موسسه </label>
                                                <textarea type="text" name="AboutInstitute" id="AboutInstitute" class="form-control">{{ $institute->AboutInstitute }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="description"> توضیحات بیشتر موسسه </label>
                                                <textarea type="text" name="description" id="description" class="form-control">{{ $institute->description }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="classInstituteType_s"> نوع موسسه </label>
                                                <select name="classInstituteType_s" id="classInstituteType_s" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['classInstituteType'] as $setting)
                                                        <option @if($setting == $institute->classInstituteType_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="religious_s"> دین </label>
                                                <select name="religious_s" id="religious_s" class="custom-select" onchange="religious2()">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['religious'] as $setting)
                                                        <option @if($setting == $institute->religious_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6" id="religion1_box">
                                            <fieldset class="form-group">
                                                <label for="religion2"> مذهب </label>
                                                <input type="text" name="religion2" id="religion2" value="{{ $institute->religion2 }}" class="form-control">
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6" id="religion2_box">
                                            <fieldset class="form-group">
                                                <label for="religion2_s"> مذهب </label>
                                                <select name="religion2_s" id="religion2_s" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['religion2'] as $setting)
                                                        <option @if($setting == $institute->religion2_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
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
                                                <label for="ActivityInstitute"> فعالیت های موسسه </label>
                                                <select name="ActivityInstitute" id="ActivityInstitute" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['ActivityInstitute'] as $setting)
                                                        <option @if($setting == $institute->ActivityInstitute_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="contacts"> مخاطبین موسسه </label>
                                                <textarea type="text" name="contacts" id="contacts" class="form-control">{{ $institute->contacts }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="AssessmentInstitute"> ارزیابی موسسه </label>
                                                <select name="AssessmentInstitute" id="AssessmentInstitute" class="custom-select">
                                                    <option value="">انتخاب کنید</option>
                                                    @foreach ($settings['AssessmentInstitute'] as $setting)
                                                        <option @if($setting == $institute->AssessmentInstitute_s) selected="selected" @endif value="{{ $setting }}">{{ $setting }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="support">  پشتیبان رابط </label>
                                                <textarea type="text" name="support" id="support" class="form-control">{{ $institute->support }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="resultinterface"> نتیجه ارتباط </label>
                                                <textarea type="text" name="resultinterface" id="resultinterface" class="form-control">{{ $institute->resultinterface }}</textarea>
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
