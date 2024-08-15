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
                                <li class="breadcrumb-item"><a> مدیریت کلاس‌ها </a>
                                </li>
                                <li class="breadcrumb-item active">افزودن کلاس
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

                            <form method="post" action="{{ route('classrooms.store') }}">
                                @csrf
                                <div class="card-header">
                                    <h4 class="card-title">تعریف کلاس:</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="name"> نام کلاس </label>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="description"> توضیحات کلاس </label>
                                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="در صورت نیاز، توضیحاتی را برای دوره وارد کنید...">{{ old('description') }}</textarea>
                                        </fieldset>
                                    </div>
                                    @if(!auth()->user()->can('one user'))
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="supporter"> پشتیبان </label>
                                            <select name="supporter" id="supporter" class="select2 form-control">
                                                <option value="">انتخاب کنید</option>
                                                @foreach($users as $user)
                                                    <option dir="rtl" value="{{ $user->id }}">{{ $user->name.' '.$user->can('some user')? '*':' ' .'('.@$user->convene->name.')' }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                    @endif
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="course"> دوره </label>
                                            <select name="course" id="course" class="custom-select">
                                                <option <?=(($manager->level=="مدیر" || $manager->level=="پشتیبان")?"disabled":"")?> value="">انتخاب کنید</option>
                                                <?php
                                                $course = new Course($db);
                                                $courses = $course->get_object_data();
                                                foreach ($courses as $course) {

                                                    if (($manager->level=="مدیر" || $manager->level=="پشتیبان")) {
                                                        $availableFor = json_decode($course['availableFor'], 1);
                                                        if ($availableFor[$access['convene']]){
                                                            $available = 1;
                                                        }
                                                        else{
                                                            $available = 0;
                                                        }
                                                    }else{
                                                        $available = 1;
                                                    }
                                                    echo '<option  ' . (@$available?"":'style="display: none;"') . ' ' . ($form['course'] == $course['ID'] ? "selected" : "") . ' value="' . $course['ID'] . '">' . $course['name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="platform"> محل برگزاری </label>
                                            <select name="platform" id="platform" class="custom-select">
                                                <option value="">انتخاب کنید</option>
                                                <?php
                                                $setting = new Setting($db);
                                                $setting->set_object_from_sql(array("type"=>"setData","name"=>"platforms"));
                                                $platforms = explode("\r\n",$setting->value);
                                                foreach ($platforms as $platform) {
                                                    echo '<option ' . ($form['platform'] == $platform ? "selected" : "") . ' value="' . $platform . '">' . $platform . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="country"> کشور </label>
                                            <select name="country" id="country" class="select2 form-control">
                                                <option value="">انتخاب کنید</option>
                                                <?php
                                                $country = new Country($db);
                                                $countries = $country->get_object_data();
                                                foreach ($countries as $country) {
                                                    echo '<option ' . ($form['country'] == $country['ID'] ? "selected" : "") . ' value="' . $country['ID'] . '">' . $country['name'] . ' - ' . $country['symbol'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="language"> زبان‌ </label>
                                            <select name="language" id="language" class="custom-select">
                                                <option value="">انتخاب کنید</option>
                                                <?php
                                                $setting = new Setting($db);
                                                $setting->set_object_from_sql(array("type"=>"setData","name"=>"language"));
                                                $languages = explode("\r\n",$setting->value);
                                                foreach ($languages as $language) {
                                                    echo '<option ' . ($form['language'] == $language ? "selected" : "") . ' value="' . $language . '">' . $language . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="sex"> جنسیت شرکت‌کنندگان </label>
                                            <select name="sex" id="sex" class="custom-select">
                                                <option value="">انتخاب کنید</option>
                                                <?php
                                                $setting = new Setting($db);
                                                $setting->set_object_from_sql(array("type"=>"setData","name"=>"sex"));
                                                $sexes = explode("\r\n",$setting->value);
                                                foreach ($sexes as $sex) {
                                                    echo '<option ' . ($form['sex'] == $sex ? "selected" : "") . ' value="' . $sex . '">' . $sex . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="startTS"> تاریخ شروع </label>
                                            <input type="text" name="startTS" id="startTS" value="<?= @jdate("Y/m/d",@$form['startTS']) ?>" class="form-control">
                                            <script>
                                                var objCal1 = new AMIB.persianCalendar( 'startTS' );
                                            </script>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="endTS"> تاریخ پایان </label>
                                            <input type="text" name="endTS" id="endTS" value="<?= @$form['endTS']?@jdate("Y/m/d",@$form['endTS']):'' ?>" class="form-control">
                                            <script>
                                                var objCal1 = new AMIB.persianCalendar( 'endTS' );
                                            </script>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="spw"> تعداد جلسات در هفته </label>
                                            <input type="number" name="spw" id="spw" value="<?= @$form['spw'] ?>" class="form-control">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="state"> وضعیت کلاس</label>
                                            <select name="state" id="state" class="custom-select">
                                                <option value="">انتخاب کنید</option>
                                                <?php
                                                $setting = new Setting($db);
                                                $setting->set_object_from_sql(array("type"=>"setData","name"=>"classState"));
                                                $states = explode("\r\n",$setting->value);
                                                foreach ($states as $state) {
                                                    echo '<option ' . ($form['state'] == $state ? "selected" : "") . ' value="' . $state . '">' . $state . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <?=($uri[3][0] && $access['j'])?'<a href="'.baseDir.'/classstudent/'.$class->ID .'-/" class="btn btn-primary">افزودن دانشجو به کلاس</a>':''?>
                                        <input type="submit" name="submit" value="تایید" class="btn btn-success">
                                        <?=($uri[3][0] && $access['j'])?'<a href="'.baseDir.'/classstudent/edit/'.$class->ID .'/" class="btn btn-warning">لیست دانشجویان کلاس</a>':''?>
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
