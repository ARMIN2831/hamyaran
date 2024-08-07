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
                                <li class="breadcrumb-item active">ویرایش اعضای کلاس
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (!$access['j']) {redirect(""); exit();}
        $classID = $uri[3][0];
        $class = new TeachClass($db);
        $class->set_object_byID($classID);
        if (!$class->ID) {
            echo '<p class="alert alert-warning">کلاس مدنظر یافت نشد</p>';
            exit();
        }
        if (!$class->access_to_class($manager->ID)) {
            echo '<p class="alert alert-warning">شما به این کلاس دسترسی ندارید
            <br> <a class="btn btn-primary" onclick="go_back()">بازگشت</a>
            </p>';
            exit();
        }

        if ($uri[4][0]=="delete"){
            include "classstudent-delete.php";
        }
        ?>
        <section id="basic-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">لیست دانشجویان کلاس <label class="text-primary"><?=$class->name?></label></h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table zero-configuration">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>نام</th>
                                            <th>نام خانوادگی</th>
                                            <th>شناسه</th>
                                            <th>زمان اضافه شدن</th>
                                            <th>عملکرد</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $classStudent = new ClassStudent($db);
                                        $classStudents = $classStudent->get_object_data(['teachClassID'=>$class->ID]);
                                        $student = new Student($db);

                                        foreach ($classStudents as $item){
                                            $classStudent->set_vars_from_array($item);
                                            $student->set_object_byID($classStudent->studentID);
                                            $available = 0;
                                            if ($manager->level == "مدیرکل"){$available = 1;}
                                            if ($manager->level == "پشتیبان"){if ($student->setBy==$manager->ID){$available=1;}}
                                            if ($manager->level == "مدیر"){
                                                if ($student->setBy == $manager->ID) {
                                                    $available = 1;
                                                } else {
                                                    $setter = new Manager($db);
                                                    $setter->set_object_byID($student->setBy);
                                                    $setter = json_decode($setter->access, 1);
                                                    if ($setter['convene'] == $access['convene']) {
                                                        $available = 1;
                                                    }
                                                }
                                            }
                                            if (1){
                                                echo '
                                                    <tr>
                                                        <td>' . ++$num.'</td>
                                                        <td>' . $student->firstName . '</td>
                                                        <td>' . $student->lastName . '</td>
                                                        <td>' . $student->ID . '</td>
                                                        <td>' . ($classStudent->ts?jdate("H:i Y/m/d",$classStudent->ts):null) . '</td>
                                                        <td>
                                                            '.($available?'<a href="' . baseDir . '/stu/edit/' . $student->ID . '/" title="ویرایش دانشجو" class="btn btn-small btn-primary"><i class="bx bx-edit"></i></a>':'').'
                                                            <a href="' . baseDir . '/classstudent/edit/' . $class->ID . '/delete/' . $student->ID . '/" title="حذف از کلاس" class="btn btn-small btn-danger"><i class="bx bx-x-circle"></i></a>
                                                        </td>
                                                    </tr>
                                                ';
                                            }
                                        }
                                        ?>

                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>