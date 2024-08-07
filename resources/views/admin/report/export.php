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
                                <li class="breadcrumb-item"><a> اطلاعات دانشجویان </a>
                                </li>
                                <li class="breadcrumb-item active">دریافت گزارشات
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <?php
            $access['n'] || redirect("");

            $setting = new Setting($db);
            $setting = $setting->get_object_data(["type"=>"setData"]);
            $student = new Student($db);
            $student = $student->get_object_data();
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

            if (isset($post['submit'])){
                $form = get_form_data();
            }else{$form = [];}

            if ($manager->level == "مدیر"){$form['convene'] = $access['convene'];}
            if ($manager->level == "پشتیبان"){$form['setBy'] = $manager->ID;}

            if (strlen($form['startTS-from'])>3){$form['startTS-from'] = input_to_timestamp($form['startTS-from'],"0:0");}else{$form['startTS-from'] = "";}
            if (strlen($form['startTS-to'])>3){$form['startTS-to'] = input_to_timestamp($form['startTS-to'],"0:0");}else{$form['startTS-to'] = "";}
            if (strlen($form['endTS-from'])>3){$form['endTS-from'] = input_to_timestamp($form['endTS-from'],"0:0");}else{$form['endTS-from']="";}
            if (strlen($form['endTS-to'])>3){$form['endTS-to'] = input_to_timestamp($form['endTS-to'],"0:0");}else{$form['endTS-to']="";}

            function selection_filter($form,&$entryData,...$type){
                foreach ($type as $filter){
                    if (@$form[$filter]){
                        foreach ($entryData as $key=>$item){
                            if ($item[$filter] != $form[$filter]) {unset($entryData[$key]);}
                        }
                    }
                }
            }
            function selection_search($form,&$entryData,...$type){
                foreach ($type as $filter){
                    if (@$form[$filter]){
                        foreach ($entryData as $key=>$item){
                            if ($form[$filter][-1]=='*'){
                                if (!str_contains($item[$filter],substr($form[$filter],0,-1))) {unset($entryData[$key]);}
                            }else{
                                if ($item[$filter]!=$form[$filter]) {unset($entryData[$key]);}
                            }
                        }
                    }
                }
            }

            selection_filter($form,$student,'country','language','education','religion1','setBy');
            selection_search($form,$student,'firstName','lastName','city','job');

            if ($form['convene']){
                foreach ($student as $key=>$item){
                    $setter = search_2D_array('ID',$item['setBy'],$setters);
                    if ($form['convene'] != json_decode($setter['access'],1)['convene']) {unset($student[$key]);}
                }
            }
            if ($form['course']){
                $classStudent = new ClassStudent($db);
                $classStudent = $classStudent->get_object_data();
                $teachClasses = new TeachClass($db);
                $teachClasses = $teachClasses->get_object_data();

                foreach ($student as $key=>$item){
                    $del=1;
                    $studentClasses = search_2D_array('studentID',$item['ID'],$classStudent,1);
                    foreach ($studentClasses as $studentClass){
                        $teachClass = search_2D_array('ID',$studentClass['teachClassID'],$teachClasses);
                        if ($form['course'] ==$teachClass['course']){$del=0;}
                    }
                    if ($del){unset($student[$key]);}
                }
            }
            if ($form['class']){
                $teachClass = new TeachClass($db);
                $teachClass->set_object_byID($form['class']);
                $classStudent = new ClassStudent($db);
                $classStudent = $classStudent->get_object_data(['teachClassID'=>$teachClass->ID]);

                foreach ($student as $key=>$item){
                    $del=1;
                    if (search_2D_array('studentID',$item['ID'],$classStudent)){
                        $del=0;
                    }
                    if ($del){unset($student[$key]);}
                }
            }
            if ($form['startTS-from']){
                foreach ($student as $key=>$item){
                    if ($form['startTS-from']>$item['startTS']) {unset($student[$key]);}
                }
            }
            if ($form['startTS-to']){
                foreach ($student as $key=>$item){
                    if ($form['startTS-to']<$item['startTS']) {unset($student[$key]);}
                }
            }
            if ($form['endTS-from']){
                foreach ($student as $key=>$item){
                    if ($item['endTS']){
                        if ($form['endTS-from']>$item['endTS']) {unset($student[$key]);}
                    }
                }
            }
            if ($form['endTS-to']){
                foreach ($student as $key=>$item){
                    if ($item['endTS']){
                        if ($form['endTS-to']<$item['endTS']) {unset($student[$key]);}
                    }
                }
            }

            if ($form['age-from']>0){
                foreach ($student as $key=>$item){
                    if (is_numeric($item['birthYear'])){
                        if ($form['age-from']>date("Y")-$item['birthYear']) {unset($student[$key]);}
                    }else{
                        unset($student[$key]);
                    }
                }
            }
            if ($form['age-to']>0){
                foreach ($student as $key=>$item){
                    if (is_numeric($item['birthYear'])){
                        if ($form['age-to']<date("Y")-$item['birthYear']) {unset($student[$key]);}
                    }else{
                        unset($student[$key]);
                    }
                }
            }

            if ($form['sex'] ==="1" || $form['sex'] ==="0"){
                foreach ($student as $key=>$item){
                    if ($item['sex'] !== null){
                        if ($form['sex']!=$item['sex']){ unset($student[$key]);}
                    }else{
                        unset($student[$key]);
                    }
                }
            }

            echo 'شامل '.count($student).' دانشجو';
            ?>
            <section id="chartjs-charts">
                <form method="post" id="filter_form">
                    <div class="card-header">
                        <div class="row">
                            <h4 class="card-title">فیلترهای گزارش</h4>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?=baseDir?>/export/#table" class="btn btn-primary">هدایت به جدول</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="<?=baseDir?>/export/excel" class="btn btn-outline-warning">دریافت گزارش اکسل</a>
                        </div>
                        <p>برای جست‌وجوی مشابه در ورودی‌های متنی در پایان متن، علامت * را وارد نمایید.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="firstName"> نام </label>
                                <input type="text" name="firstName" id="firstName" value="<?= @$form['firstName'] ?>" class="form-control">
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="lastName"> نام خانوادگی </label>
                                <input type="text" name="lastName" id="lastName" value="<?= @$form['lastName'] ?>" class="form-control">
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="country"> کشور </label>
                                <select name="country" id="country" class="select2 form-control">
                                    <option value="">انتخاب کنید</option>
                                    <?php
                                    foreach ($countries as $country) {
                                        echo '<option ' . ($form['country'] == $country['ID'] ? "selected" : "") . ' value="' . $country['ID'] . '">' . $country['name'] . ' - ' . $country['symbol'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="city"> شهر </label>
                                <input type="text" name="city" id="city" value="<?= @$form['city'] ?>" class="form-control">
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="language"> زبان‌ </label>
                                <select name="language" id="language" class="custom-select">
                                    <option value="">انتخاب کنید</option>
                                    <?php
                                    $language = search_2D_array('name','language',$setting)['value'];
                                    $language = determiner($language);
                                    foreach ($language as $item) {
                                        echo '<option ' . ($form['language'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="education"> تحصیلات‌ </label>
                                <select name="education" id="education" class="custom-select">
                                    <option value="">انتخاب کنید</option>
                                    <?php
                                    $education = search_2D_array('name','education',$setting)['value'];
                                    $education = determiner($education);
                                    foreach ($education as $item) {
                                        echo '<option ' . ($form['education'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="religion1"> دین </label>
                                <select name="religion1" id="religion1" class="custom-select" onchange="religious2()">
                                    <option value="">انتخاب کنید</option>
                                    <?php
                                    $religion1 = search_2D_array('name','religious',$setting)['value'];
                                    $religion1 = determiner($religion1);
                                    foreach ($religion1 as $item) {
                                        echo '<option ' . ($form['religion1'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-4" <?=($manager->level=="مدیر" || $manager->level=="پشتیبان"?' style="display: none;"':'')?>>
                            <fieldset class="form-group">
                                <label for="convene"> مجتمع </label>
                                <select name="convene" id="convene" class="custom-select">
                                    <option value="">انتخاب کنید</option>
                                    <?php
                                    foreach ($convenes as $convene) {
                                        echo '<option ' . (($manager->level=="مدیر" || $manager->level=="پشتیبان")?($access['convene'] == $convene['ID'] ? "selected" :' style="display: none;"'):"") . ' ' . ($form['convene'] == $convene['ID'] ? "selected" : "") . ' value="' . $convene['ID'] . '">' . $convene['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-4" <?=($manager->level=="پشتیبان"?' style="display: none;"':'')?> >
                            <fieldset class="form-group">
                                <label for="setBy"> پشتیبان </label>
                                <select name="setBy" id="setBy" class="select2 form-control">
                                    <option value="">انتخاب کنید</option>
                                    <?php
                                    foreach ($setters as $setter) {
                                        $setter['access'] = json_decode($setter['access'],1);
                                        if ($setter['access']['convene']){
                                            $convene = search_2D_array('ID',$setter['access']['convene'],$convenes);
                                        }
                                        if (($setter['level'] == "پشتیبان" || ($manager->level=="مدیرکل" && $setter['level'] == "مدیر")) && ($manager->level!="مدیر" || $setter['access']['convene']==$access['convene']))echo '<option dir="rtl" value="' . $setter['ID'] . '">' . $setter['name'].' '.($setter['level'] == "مدیر"?'*':'').'('.$convene['name']. ')</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="job"> شغل </label>
                                <input type="text" name="job" id="job" value="<?= @$form['job'] ?>" class="form-control">
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="mobile"> شماره موبایل </label>
                                <input type="text" name="mobile" id="mobile" value="<?= @$form['mobile'] ?>" placeholder="+989123334455" class="form-control dir-ltr">
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="course"> دوره </label>
                                <select name="course" id="course" class="select2 form-control">
                                    <option value="">انتخاب کنید</option>
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
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="class"> کلاس </label>
                                <select name="class" id="class" class="select2 form-control">
                                    <option value="">انتخاب کنید</option>
                                    <?php
                                    $class = new TeachClass($db);
                                    $classes = $class->get_object_data();
                                    foreach ($classes as $class) {
                                        if (($manager->level=="مدیر" || $manager->level=="پشتیبان")) {
                                            $course = new Course($db);
                                            $course->set_object_byID($class['course']);
                                            $availableFor = json_decode($course->availableFor, 1);
                                            if ($availableFor[$access['convene']]){
                                                $available = 1;
                                            }
                                            else{
                                                $available = 0;
                                            }
                                        }else{
                                            $available = 1;
                                        }
                                        echo '<option  ' . (@$available?"":'style="display: none;"') . ' ' . ($form['class'] == $class['ID'] ? "selected" : "") . ' value="' . $class['ID'] . '">' . $class['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="startTS-from"> ثبت نام از </label>
                                <input type="text" name="startTS-from" id="startTS-from" value="<?= @$form['startTS-from']?@jdate("Y/m/d",@$form['startTS-from']):'' ?>" class="form-control">
                                <script>
                                    var objCal1 = new AMIB.persianCalendar( 'startTS-from' );
                                </script>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="startTS-to"> ثبت نام تا </label>
                                <input type="text" name="startTS-to" id="startTS-to" value="<?= @$form['startTS-to']?@jdate("Y/m/d",@$form['startTS-to']):'' ?>" class="form-control">
                                <script>
                                    var objCal2 = new AMIB.persianCalendar( 'startTS-to' );
                                </script>
                            </fieldset>
                        </div>

                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="endTS-from"> خروج از </label>
                                <input type="text" name="endTS-from" id="endTS-from" value="<?= @$form['endTS-from']?@jdate("Y/m/d",@$form['endTS-from']):'' ?>" class="form-control">
                                <script>
                                    var objCal3 = new AMIB.persianCalendar( 'endTS-from' );
                                </script>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="endTS-to"> خروج تا </label>
                                <input type="text" name="endTS-to" id="endTS-to" value="<?= @$form['endTS-to']?@jdate("Y/m/d",@$form['endTS-to']):'' ?>" class="form-control">
                                <script>
                                    var objCal4 = new AMIB.persianCalendar( 'endTS-to' );
                                </script>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label>سن </label>
                                <span class="row w-100 mx-auto">
                                <input type="number" name="age-from" id="age-from" value="<?= @$form['age-from']?>" placeholder="از" class="col-6 form-control">
                                <input type="number" name="age-to" id="age-to" value="<?= @$form['age-to']?>" placeholder="تا" class="col-6 form-control">
                                </span>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label>جنسیت</label>
                                <br>
                                <label>بدون فیلتر
                                    <input type="radio" name="sex" <?=(($form['sex']==="noFilter")?"checked":"")?> value="noFilter">
                                    &nbsp;&nbsp;&nbsp;
                                </label>
                                <label>آقا
                                    <input type="radio" name="sex" <?=(($form['sex']=="1")?"checked":"")?> value="1">
                                    &nbsp;&nbsp;&nbsp;
                                </label>
                                <label>خانم
                                    <input type="radio" name="sex" <?=(($form['sex']=="0")?"checked":"")?> value="0">
                                    &nbsp;&nbsp;&nbsp;
                                </label>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <input type="submit" name="submit" value="تایید" class="btn btn-success">
                            <a href="<?=baseDir?>/export/" class="btn btn-primary">حذف فیلترها</a>
                        </div>
                    </div>
                </form>
            </section>
            <?php
            include 'export-show.php';
            ?>
        </div>
    </div>
</div>