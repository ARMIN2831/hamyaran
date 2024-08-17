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

                            <form method="post" action="{{ route('convenes.store') }}">
                                @csrf
                                <div class="card-header">
                                    <h4 class="card-title">افزودن دانشجو به کلاس:</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="classID"> کلاس </label>
                                            <select name="classID" id="classID" class="select2 form-control">
                                                <option value="">انتخاب کنید</option>
                                                <?php
                                                $items = new TeachClass($db);
                                                $items = $items->get_object_data();
                                                foreach ($items as $item) {
                                                    $class = $item;
                                                    $available = 0;
                                                    $supporer = new Manager($db);
                                                    $supporer->set_object_byID($class['supporter']);
                                                    $supporerAccess = json_decode($supporer->access,1);

                                                    if ($manager->level == "مدیرکل"){
                                                        $available = 1;
                                                    }elseif ($manager->level == "مدیر"){
                                                        $supporerAccess['convene'] == $access['convene']?$available=1:$available=0;
                                                    }else{
                                                        $class['supporter'] == $manager->ID?$available=1:$available=0;
                                                    }

                                                    if ($available)echo '<option '.($classID == $class['ID'] ? "selected" : "") . ' value="' .$class['ID'] . '">' . $class['name'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="studentID"> دانشجو </label>
                                            <select name="studentID" id="studentID" class="select2 form-control">
                                                <option value="">انتخاب کنید</option>
                                                <?php
                                                $items = new Student($db);
                                                $items = $items->get_object_data();
                                                foreach ($items as $item) {
                                                    $student = new Student($db);
                                                    $student->set_vars_from_array($item);
                                                    $available = 0;
                                                    if ($manager->level == "مدیرکل"){$available = 1;}
                                                    if ($manager->level == "پشتیبان"){if ($student->setBy==$manager->ID){$available=1;}}
                                                    if ($manager->level == "مدیر"){
                                                        if ($student->setBy == $manager->ID) {
                                                            $available = 1;
                                                        } else {
                                                            $setter = new Manager($db);
                                                            $setter->set_object_byID($student->setBy);
                                                            $setterAccess = json_decode($setter->access, 1);
                                                            if ($setterAccess['convene'] == $access['convene']) {
                                                                $available = 1;
                                                            }
                                                        }
                                                    }
                                                    $student = (array)$student;
                                                    if ($available)echo '<option '.($studentID == $student['ID'] ? "selected" : "") . ' value="' .$student['ID'] . '">' . $student['firstName']." ". $student['lastName']." - ". $student['ID'] . '</option>';
                                                }
                                                ?>
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
