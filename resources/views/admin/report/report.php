<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> گزارشات </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> اطلاعات سامانه </a>
                                </li>
                                <li class="breadcrumb-item active">نمودارها
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $access['o'] || redirect("");

        $setting = new Setting($db);
        $setting = $setting->get_object_data(["type" => "setData"]);
        $student = new Student($db);
        $students = $student->get_object_data();
        $countryItem = new Country($db);
        $countries = $countryItem->get_object_data();
        $convene = new Convene($db);
        $convenes = $convene->get_object_data();
        $action = new Action($db);
        $actions = $action->get_object_data();
        $setter = new Manager($db);
        $setters = $setter->get_object_data();
        $teachClass = new TeachClass($db);
        $teachClasses = $teachClass->get_object_data();
        $classStudent = new ClassStudent($db);
        $classStudents = $classStudent->get_object_data();
        $course = new Course($db);
        $courses = $course->get_object_data();
        $ticket = new Ticket($db);
        $tickets = $ticket->get_object_data();
        ?>
        <div class="content-body">
            <section id="widgets-Statistics">
                <div class="row">
                    <div class="col-12 mt-1 mb-2">
                        <h4>آمار سامانه</h4>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                                        <i class="bx bxs-user-circle font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">تعداد دانشجویان</p>
                                    <h2 class="mb-0"><?=$student->count_actives()?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                                        <i class="bx bx-edit-alt font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">کل فعالیت‌ها</p>
                                    <h2 class="mb-0"><?=count($actions)?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                                        <i class="bx bx-file font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">تعداد کلاس‌ها</p>
                                    <h2 class="mb-0"><?=count($teachClasses)?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                                        <i class="bx bx-message font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">تیکت‌ها</p>
                                    <h2 class="mb-0"><?=count($tickets)?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1">
                                        <i class="bx bxs-school font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">تعداد مجتمع‌ها</p>
                                    <h2 class="mb-0"><?=count($convenes)?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-1">
                                        <i class="bx bx-group font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">مدیران</p>
                                    <h2 class="mb-0"><?=count($setters)?></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        <?php
            require "report-show.php";
        ?>


        </div>
    </div>
</div>