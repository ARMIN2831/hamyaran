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
                            <?php
                            if (!$access['r']) {redirect(""); exit();}
                            if ($uri[3][0] > 0) {require "ins-form.php";}
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
                                <h4 class="card-title">لیست موسسات</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table zero-configuration">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>نام موسسه</th>
                                                <th>کشور</th>
                                                <th>شهر</th>
                                                <th>شماره تماس</th>
                                                <th>ایمیل</th>
                                                <th>نوع</th>
                                                <th>پشتیبان</th>
                                                <th>عملکرد</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $institutes = new Institute($db);
                                            $institutes = $institutes->get_object_data();
                                            foreach ($institutes as $item){
                                                $institute = new Institute($db);
                                                $institute->set_vars_from_array($item);
                                                $available = 0;
                                                if ($manager->level == "مدیرکل"){$available = 1;}
                                                if ($manager->level == "پشتیبان"){if ($institute->setBy==$manager->ID){$available=1;}}
                                                if ($manager->level == "مدیر"){
                                                    if ($institute->setBy == $manager->ID) {
                                                        $available = 1;
                                                    } else {
                                                        $setter = new Manager($db);
                                                        $setter->set_object_byID($institute->setBy);
                                                        $setter = json_decode($setter->access, 1);
                                                        if ($setter['convene'] == $access['convene']) {
                                                            $available = 1;
                                                        }
                                                    }
                                                }
                                                if ($available){
                                                    echo '
                                                    <tr>
                                                        <td>' . $institute->ID . '</td>
                                                        <td>' . $institute->NameInstitute . '</td>
                                                        <td>'.($r = new Country($db))->set_object_byID($institute->country).$r->name.'</td>
														<td>' . $institute->city . '</td>
														<td class="dir-ltr">' . $institute->mobile . '</td>
                                                        <td>' . $institute->email . '</td>
                                                        <td>' . $institute->typeinstitute . '</td>
                                                        <td>'.($r = new Manager($db))->set_object_byID($institute->setBy).$r->name.'</td>
                                                        <td>
                                                            <a href="' . baseDir . '/ins/edit/' . $institute->ID . '" title="ویرایش" class="btn btn-small btn-primary"><i class="bx bx-edit"></i></a>
                                                            <a href="' . baseDir . '/ins/delete/' . $institute->ID . '" title="حذف" class="btn btn-small btn-danger"><i class="bx bx-x-circle"></i></a>
                                                        </td>
                                                    </tr>
                                                ';
                                                }
                                            }
                                            ?>

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