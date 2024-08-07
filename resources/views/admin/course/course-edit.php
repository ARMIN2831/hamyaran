<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> دوره‌ها </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> مدیریت دوره‌ها </a>
                                </li>
                                <li class="breadcrumb-item active">ویرایش دوره
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
                            if ($uri[3][0]>0){
                                require "course-form.php";}
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
                                <h4 class="card-title">لیست دوره‌ها</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table zero-configuration">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>نام دوره</th>
                                                <th>مجتمع‌ها</th>
                                                <th>عملکرد</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $courseItems = new Course($db);
                                            $courseItems = $courseItems->get_object_data();
                                            foreach ($courseItems as $courseItem){
                                                $courseRow = new Course($db);
                                                $courseRow->set_vars_from_array($courseItem);
                                                $availableFor = json_decode($courseRow->availableFor,1);
                                                $availableForSting="";
                                                foreach ($availableFor as $conveneID=>$value){
                                                    $convene = new Convene($db);
                                                    $convene->set_object_byID($conveneID);
                                                    $availableForSting .= $convene->name ."<br>";
                                                }
                                                echo '
                                                    <tr>
                                                        <td>' . $courseRow->ID . '</td>
                                                        <td>' . $courseRow->name . '</td>
                                                        <td>' . $availableForSting . '</td>
                                                        <td>
                                                            <a href="' . baseDir . '/course/edit/' . $courseRow->ID . '" title="ویرایش" class="btn btn-small btn-primary"><i class="bx bx-edit"></i></a>
                                                            <a href="' . baseDir . '/course/delete/' . $courseRow->ID . '" title="حذف" class="btn btn-small btn-danger"><i class="bx bx-x-circle"></i></a>
                                                        </td>
                                                    </tr>
                                                ';
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
