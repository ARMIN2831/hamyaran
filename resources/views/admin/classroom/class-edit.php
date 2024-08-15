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
                                <li class="breadcrumb-item active">ویرایش کلاس
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
                            <?php
                            if (!$access['g']){redirect(""); exit();}
                            if ($uri[3][0]>0){
                                require "class-form.php";}
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php if (!$uri[3][0]): ?>
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">لیست کلاس‌ها</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table zero-configuration">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>نام کلاس</th>
                                                <th>دوره</th>
                                                <th>مجتمع‌</th>
                                                <th>بستر</th>
                                                <th>کشور</th>
                                                <th>تعداد دانشجویان</th>
                                                <th>جنسیت</th>
                                                <th>وضعیت</th>
                                                <th>عملکرد</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $classItems = new TeachClass($db);
                                            $classItems = $classItems->get_object_data();
                                            foreach ($classItems as $classItem){
                                                $classRow = new TeachClass($db);
                                                $classRow->set_vars_from_array($classItem);
                                                $available = 0;
                                                $supporer = new Manager($db);
                                                $supporer->set_object_byID($classRow->supporter);
                                                $supporerAccess = json_decode($supporer->access,1);

                                                if ($manager->level == "مدیرکل"){
                                                    $available = 1;
                                                }elseif ($manager->level == "مدیر"){
                                                    $supporerAccess['convene'] == $access['convene']?$available=1:$available=0;
                                                }else{
                                                    $classRow->supporter == $manager->ID?$available=1:$available=0;
                                                }
                                                if ($available){
                                                    echo '
                                                    <tr>
                                                        <td>' . $classRow->ID . '</td>
                                                        <td>' . $classRow->name . '</td>
                                                        <td>'.($r = new Course($db))->set_object_byID($classRow->course).$r->name.'</td>
                                                        <td>'.@($r = new Convene($db))->set_object_byID($supporerAccess['convene']).@$r->name.'</td>
                                                        <td>' . $classRow->platform . '</td>
                                                        <td>'.($r = new Country($db))->set_object_byID($classRow->country).$r->name.'</td>
                                                        <td>'.($access['j']?'<a href="'.baseDir.'/classstudent/edit/'.$classRow->ID.'/">'.$classRow->count_students().'</a>':$classRow->count_students()).'</td>
                                                        <td>' . $classRow->sex . '</td>
                                                        <td>' . $classRow->state . '</td>
                                                        <td>
                                                            <a href="' . baseDir . '/teachClass/edit/' . $classRow->ID . '" title="ویرایش" class="btn btn-small btn-primary"><i class="bx bx-edit"></i></a>
                                                            <a href="' . baseDir . '/teachClass/delete/' . $classRow->ID . '" title="حذف" class="btn btn-small btn-danger"><i class="bx bx-x-circle"></i></a>
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
            <?php endif; ?>
        </div>
    </div>
</div>
