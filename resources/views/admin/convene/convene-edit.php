<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> مجتمع‌ها </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> مدیریت مجتمع‌ها </a>
                                </li>
                                <li class="breadcrumb-item active">ویرایش مجتمع
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
                            if (!$access['e']){redirect(""); exit();}
                            if ($uri[3][0]>0){
                                require "convene-form.php";}
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
                                <h4 class="card-title">لیست مجتمع‌ها</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table zero-configuration">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>نام مجتمع</th>
                                                <th>مدیران</th>
                                                <th>عملکرد</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $conveneItems = new Convene($db);
                                            $conveneItems = $conveneItems->get_object_data();
                                            foreach ($conveneItems as $conveneItem){
                                                $conveneRow = new Convene($db);
                                                $conveneRow->set_vars_from_array($conveneItem);
                                                $managersString="";
                                                $managers = new Manager($db);
                                                $managers = $managers->get_object_data();
                                                foreach ($managers as $managerItem){
                                                    $managerRow = new Manager($db);
                                                    $managerRow->set_vars_from_array($managerItem);
                                                    $managerAccess = json_decode($managerRow->access,1);
                                                    if ($managerRow->level=="مدیر" && $managerAccess['convene'] == $conveneRow->ID){
                                                        if ($manager->level == ("مدیرکل"||"مدیر") && $access['c']) {
                                                            $managersString .= '<a href="'.baseDir.'/manager/edit/'.$managerRow->ID.'">'.$managerRow->name.'</a>';
                                                        }else{
                                                            $managersString .= $managerRow->name.'<br>';
                                                        }
                                                    }
                                                }
                                                echo '
                                                    <tr>
                                                        <td>' . $conveneRow->ID . '</td>
                                                        <td>' . $conveneRow->name . '</td>
                                                        <td>' . $managersString . '</td>
                                                        <td>
                                                            <a href="' . baseDir . '/convene/edit/' . $conveneRow->ID . '" title="ویرایش" class="btn btn-small btn-primary"><i class="bx bx-edit"></i></a>
                                                            <a href="' . baseDir . '/convene/delete/' . $conveneRow->ID . '" title="حذف" class="btn btn-small btn-danger"><i class="bx bx-x-circle"></i></a>
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
