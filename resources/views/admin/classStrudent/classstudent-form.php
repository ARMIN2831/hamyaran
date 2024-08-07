<?php
if (strlen($uri[2][0])>0){
    $u3 = explode("-",$uri[2][0]);
    $classID = $u3[0];
    $studentID = $u3[1];
    $referer = $_SERVER['HTTP_REFERER'];
    if ($classID) {
        $class = new TeachClass($db);
        $class->set_object_byID($classID);
        if (!$class->ID) {
            $error=1;
            echo '<p class="alert alert-warning">
            کلاس مدنظر یافت نشد<br> <a class="btn btn-primary" onclick="go_back()">بازگشت</a>
            </p>';
        }
        if (!$class->access_to_class($manager->ID)) {
            $error=1;
            echo '<p class="alert alert-warning">شما به این کلاس دسترسی ندارید
        <br> <a class="btn btn-primary" onclick="go_back()">بازگشت</a>
        </p>';
        }
    }
    if ($studentID){
        $student = new Student($db);
        $student->set_object_byID($studentID);
        if (!$student->ID){
            $error=1;
            echo '<p class="alert alert-warning">
            دانشجوی مدنظر یافت نشد<br> <a class="btn btn-primary" onclick="go_back()">بازگشت</a>
            </p>';
        }
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
        if (!$available) {
            $error=1;
            echo '<p class="alert alert-warning">شما به این دانشجو دسترسی ندارید
        <br> <a class="btn btn-primary" onclick="go_back()">بازگشت</a>
        </p>';
        }
    }
}


if (isset($post['submit'])) {
    $classID = $post['classID'];
    $studentID = $post['studentID'];
    if (!$classID || !$studentID){
        $submitError=1;
        echo '<p class="warning alert-danger">کلاس و دانشجو باید انتخاب شوند.</p>';
    }
    $class = new TeachClass($db);
    $class->set_object_byID($classID);
    if (!$class->ID) {
        $submitError=1;
        echo '<p class="alert alert-warning">کلاس مدنظر یافت نشد</p>';
    }
    if (!$class->access_to_class($manager->ID)) {
        $submitError=1;
        echo '<p class="alert alert-warning">شما به این کلاس دسترسی ندارید</p>';
    }
    $student = new Student($db);
    $student->set_object_byID($studentID);
    if (!$student->ID){
        $submitError=1;
        echo '<p class="alert alert-warning">دانشجوی مدنظر یافت نشد</p>';
    }
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
    if (!$available) {
        $submitError=1;
        echo '<p class="alert alert-warning">شما به این دانشجو دسترسی ندارید</p>';
    }
    $classStudent = new ClassStudent($db);

    if ($classStudent->add_student_to_class($studentID,$classID)) {
        echo '<p class="btn btn-success">افزودن دانشجو با موفقیت انجام شد.
        <br> <a class="btn btn-primary" onclick="go_back()">بازگشت</a>
        </p>';
    } else {
        echo '<p class="btn btn-warning">دانشجو از قبل عضو این کلاس می‌باشد.</p>';
    }
}
if (!@$error):
?>
<form method="post">
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
<?php
endif;