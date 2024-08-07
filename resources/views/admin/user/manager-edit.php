<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">مدیران</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a > ویرایش مدیران/پشتیبانان</a>
                                </li>
                                <li class="breadcrumb-item active">ویرایش
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
                                $newManager = new Manager($db);
                                $newManager->set_object_byID($uri[3][0]);
                            }
                            if ($newManager->level=="مدیرکل" && $manager->level=="مدیرکل" && $access['c'] && $access['d']){
                                require "manager-form-admin.php";
                            }

                            if ($newManager->level=="مدیر" && $manager->level=="مدیرکل" && $access['c']){
                                require "manager-form-manager.php";
                            }
                            if ($newManager->level=="پشتیبان" && $manager->level=="مدیرکل" && $access['c']){
                                require "manager-form-supporter.php";
                            }
                            if ($newManager->level=="پشتیبان" && $manager->level=="مدیر" &&$access['convene']==json_decode($newManager->access,1)['convene'] && $access['c']){
                                require "manager-form-supporter.php";
                            }

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
                                <h4 class="card-title">لیست مدیران/پشتیبانان</h4>
                                <br>
                                <div class="col-12">
                                    <fieldset class="form-group">
                                        <label for="type"> نوع مدیران </label>
                                        <select name="type" id="type" onchange="filter_type()" class="custom-select">
                                            <option value="">همه مدیران</option>
                                            <option value="مدیرکل">مدیرکل</option>
                                            <option value="مدیر">مدیر</option>
                                            <option value="پشتیبان">پشتیبان</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <script>
                                    function filter_type(){
                                        var type = document.getElementById('type').value;
                                        var trs = document.getElementsByTagName('tr');
                                        if (type){
                                            for (i=1;i<trs.length;i++){
                                                var tr = trs[i];
                                                var tds = tr.getElementsByTagName('td');

                                                if (tds[3].innerText != type){
                                                    tr.style.display = "none";
                                                }else {
                                                    tr.style.display = "";
                                                }
                                            }
                                        }else {
                                            for (i=1;i<trs.length;i++){
                                                var tr = trs[i];
                                                tr.style.display = "";
                                            }
                                        }

                                    }
                                </script>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table zero-configuration">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>نام کاربری</th>
                                                <th>نام</th>
                                                <th>سطح</th>
                                                <th>ثبت توسط</th>
                                                <th>آخرین ورود</th>
                                                <th>عملکرد</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $managerItems = new Manager($db);
                                            $managerItems = $managerItems->get_object_data();
                                            foreach ($managerItems as $managerItem){
                                                $available = 0;
                                                $managerRow = new Manager($db);
                                                $managerRow->set_vars_from_array($managerItem);
                                                if ($managerRow->userName){
                                                    if ($manager->level == "مدیرکل" && $access['c'] && $managerRow->level==("پشتیبان"||"مدیر")) {
                                                        $available = 1;
                                                    }
                                                    if ($manager->level == "مدیرکل" && $access['c'] && $access['d'] && $managerRow->level =="مدیرکل") {
                                                        $available = 1;
                                                    }
                                                    if ($manager->level == "مدیر" && $access['c'] && $managerRow->level=="پشتیبان" && $access['convene']==json_decode($managerRow->access,1)['convene']) {
                                                        $available = 1;
                                                    }
                                                    if ($available){
                                                        echo '
                                                    <tr>
                                                        <td>'.$managerRow->ID.'</td>
                                                        <td>'.$managerRow->userName.'</td>
                                                        <td>'.$managerRow->name.'</td>
                                                        <td>'.$managerRow->level.'</td>
                                                        <td>'.($r = new Manager($db))->set_object_byID($managerRow->setBy).$r->name.'</td>
                                                        <td>'.jdate("Y-m-d H:i").'</td>
                                                        <td>
                                                            <a href="'.baseDir.'/manager/edit/'.$managerRow->ID.'" title="ویرایش" class="btn btn-small btn-primary"><i class="bx bx-edit"></i></a>
                                                            <a href="' . baseDir . '/manager/delete/' . $managerRow->ID . '" title="حذف" class="btn btn-small btn-danger"><i class="bx bx-x-circle"></i></a>
                                                            
                                                        </td>
                                                    </tr>
                                                    ';
                                                    }

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