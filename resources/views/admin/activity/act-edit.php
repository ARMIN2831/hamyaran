<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> فعالیت‌ها </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> تعیین فعالیت برای دانشجو </a>
                                </li>
                                <li class="breadcrumb-item active">ویرایش فعالیت
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
                            if (!$access['k']){redirect(""); exit();}
                            if ($uri[3][0]>0){
                                require "act-form.blade.php";}
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
                                <h4 class="card-title">لیست فعالیت‌ها</h4>
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label for="type"> دانشجو: </label>
                                        <select dir="rtl" name="type" id="type" onchange="filter_type()" class="select2 form-control">
                                            <option value="">همه‌ی دانشجویان</option>
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
                                                        $setter = json_decode($setter->access, 1);
                                                        if ($setter['convene'] == $access['convene']) {
                                                            $available = 1;
                                                        }
                                                    }
                                                }
                                                $student = (array)$student;
                                                if ($available)echo '<option '.($post['studentID'] == $student['ID'] ? "selected" : "") . ' value="' .$student['ID'] . '">' . $student['firstName']." ". $student['lastName']." - ". $student['ID'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </fieldset>
                                </div>
                                <script>
                                    function filter_type(search){
                                        var type = document.getElementById('type').value;
                                        var trs = document.getElementsByTagName('tr');
                                        if (search){type = search;}

                                        if (type){
                                            for (i=1;i<trs.length;i++){
                                                var tr = trs[i];
                                                var tds = tr.getElementsByTagName('td');

                                                if (tds[2].innerText != type){
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
                                                <th>نام دانشجو</th>
                                                <th>شناسه دانشجو</th>
                                                <th>فعالیت</th>
                                                <th>توضیحات</th>
                                                <th>وضعیت</th>
                                                <th>عملکرد</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $items = new Action($db);
                                            $items = $items->get_object_data();
                                            foreach ($items as $item){
                                                $action = new Action($db);
                                                $action->set_vars_from_array($item);
                                                $student = new Student($db);
                                                $student->set_object_byID($action->studentID);
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
                                                if ($available){
                                                    echo '
                                                    <tr>
                                                        <td>' . $action->ID . '</td>
                                                        <td>' . $student->firstName ." ".$student->lastName . '</td>
                                                        <td>' . $student->ID . '</td>
                                                        <td>' . $action->title . '</td>
                                                        <td>' . enter_to_br($action->description) . '</td>
                                                        <td>' . $action->state . '</td>
                                                        <td>
                                                            <a href="' . baseDir . '/act/edit/' . $action->ID . '" title="ویرایش" class="btn btn-small btn-primary"><i class="bx bx-edit"></i></a>
                                                            <a href="' . baseDir . '/act/delete/' . $action->ID . '" title="حذف" class="btn btn-small btn-danger"><i class="bx bx-x-circle"></i></a>
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
                            <script>
                                <?php
                                if ($post['studentID']){
                                    echo "filter_type(".$post['studentID'].");";
                                }
                                ?>
                            </script>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        </div>
    </div>
</div>
