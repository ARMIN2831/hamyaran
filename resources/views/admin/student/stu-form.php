<?php
if ($id = $uri[3][0]>0){
    $student = new Student($db);
    $student->set_object_byID($uri[3][0]);
    $form = $student->get_object_vars();
    if (!$student->ID){redirect("stu/edit");}
    if ($manager->level == "پشتیبان" && $student->setBy!=$manager->ID){redirect("convene/edit");}
    if ($manager->level == "مدیر"){
        if (! $student->setBy == $manager->ID){
            $setter = new Manager($db);
            $setter->set_object_byID($student->setBy);
            $setter = json_decode($setter->access,1);
            if ($setter['convene']!=$access['convene']){redirect("stu/edit");}}
    }
}
if (isset($post['submit'])) {
    $form = get_form_data_html();
    unset($form['submit']);
    $form['mobile'] = $form['mobile0']." ".$form['mobile1'];
    unset($form['mobile0']);
    unset($form['mobile1']);
    if (strlen($form['startTS'])>3){$form['startTS'] = input_to_timestamp($form['startTS'],"0:0");}else{$form['startTS'] = time();}
    if (strlen($form['endTS'])>3){$form['endTS'] = input_to_timestamp($form['endTS'],"0:0");}else{$form['endTS']="";}

    include "stu-form-submit-img.php";
    if (!@$student){$student = new Student($db);}
    $student->set_vars_from_array($form);
    if ($manager->level=="پشتیبان"){$student->setBy = $manager->ID;}
    if ($manager->level!="پشتیبان" && !$student->setBy){$student->setBy = $manager->ID;}
    if ($student->save_object_data()) {
        echo '<p class="btn btn-success">ثبت اطلاعات با موفقیت انجام شد.
        <br>
        شناسه این دانشجو '.$student->ID.' می‌باشد.
        </p>';
        redirect("stu/edit/".$student->ID, 1);
    } else {
        echo '<p class="btn btn-warning">در ثبت اطلاعات مشکلی پیش آمد.</p>';
    }
}

?>
<form method="post" enctype="multipart/form-data">
    <div class="card-header">
        <h4 class="card-title">مشخصات اصلی:</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <fieldset class="form-group">
                <?= (@$form['ID']>0 ? '<p> شناسه دانشجو: <label class="alert alert-success small py-0 px-1">'.$form['ID'].'</label></p>' :'') ?>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="firstName"> نام </label>
                <input type="text" name="firstName" id="firstName" value="<?= @$form['firstName'] ?>" class="form-control" required>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="lastName"> نام خانوادگی </label>
                <input type="text" name="lastName" id="lastName" value="<?= @$form['lastName'] ?>" class="form-control" required>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="country"> کشور </label>
                <select name="country" id="country" class="select2 form-control">
                    <option value="">انتخاب کنید</option>
                    <?php
                    $country = new Country($db);
                    $countries = $country->get_object_data();
                    foreach ($countries as $country) {
                        echo '<option ' . ($form['country'] == $country['ID'] ? "selected" : "") . ' value="' . $country['ID'] . '">' . $country['name'] . ' - ' . $country['symbol'] . '</option>';
                    }
                    ?>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="city"> شهر </label>
                <input type="text" name="city" id="city" value="<?= @$form['city'] ?>" class="form-control">
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="address"> آدرس </label>
                <input type="text" name="address" id="address" value="<?= @$form['address'] ?>" class="form-control">
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="nationality"> ملیت </label>
                <select name="nationality" id="nationality" class="select2 form-control">
                    <option value="">انتخاب کنید</option>
                    <?php
                    $country = new Country($db);
                    $countries = $country->get_object_data();
                    foreach ($countries as $country) {
                        echo '<option ' . ($form['nationality'] == $country['ID'] ? "selected" : "") . ' value="' . $country['ID'] . '">' . $country['name'] . ' - ' . $country['symbol'] . '</option>';
                    }
                    ?>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="language"> زبان‌ </label>
                <select name="language" id="language" class="custom-select">
                    <option value="">انتخاب کنید</option>
                    <?php
                    $setting = new Setting($db);
                    $setting->set_object_from_sql(array("type"=>"setData","name"=>"language"));
                    $items = determiner($setting->value);
                    foreach ($items as $item) {
                        echo '<option ' . ($form['language'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
                    }
                    ?>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="birthYear"> سال تولد(میلادی) </label>
                <input type="number" name="birthYear" id="birthYear" min="1900" value="<?= @$form['birthYear'] ?>" class="form-control" placeholder="2010">
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label>آقا
                    <input type="radio" name="sex" <?=(($form['sex']=="1")?"checked":"")?> value="1">
                </label>
                &nbsp;&nbsp;&nbsp;
                <label>خانم
                    <input type="radio" name="sex" <?=(($form['sex']=="0")?"checked":"")?> value="0">
                </label>
            </fieldset>
            <fieldset class="form-group">
                <label>متأهل
                    <input type="radio" name="isMarried" <?=(($form['isMarried']=="1")?"checked":"")?> value="1">
                </label>
                &nbsp;&nbsp;&nbsp;
                <label>مجرد
                    <input type="radio" name="isMarried" <?=(($form['isMarried']=="0")?"checked":"")?> value="0">
                </label>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="job"> شغل </label>
                <input type="text" name="job" id="job" value="<?= @$form['job'] ?>" class="form-control">
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="education"> تحصیلات‌ </label>
                <select name="education" id="education" class="custom-select">
                    <option value="">انتخاب کنید</option>
                    <?php
                    $setting = new Setting($db);
                    $setting->set_object_from_sql(array("type"=>"setData","name"=>"education"));
                    $items = explode("\r\n",$setting->value);
                    foreach ($items as $item) {
                        echo '<option ' . ($form['education'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
                    }
                    ?>
                </select>
            </fieldset>
        </div>

        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="email"> ایمیل </label>
                <input type="email" name="email" id="email" value="<?= @$form['email'] ?>" class="form-control">
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="mobile"> شماره موبایل </label>
                <span class="row w-100 mx-auto">
                    <input type="text" name="mobile1" id="mobile" value="<?= @explode(" ",$form['mobile'])[1] ?>" placeholder="9123334455" class="form-control dir-ltr w-80">
                    <input type="text" name="mobile0" id="mobile" value="<?= @explode(" ",$form['mobile'])[0] ?>" placeholder="+98" class="form-control dir-ltr w-20">
                </span>
            </fieldset>
        </div>
        <div class="col-md-6" <?=($manager->level=="پشتیبان"?' style="display: none;"':'')?> >
            <fieldset class="form-group">
                <label for="setBy"> پشتیبان </label>
                <select name="setBy" id="setBy" class="select2 form-control">
                    <option value="">انتخاب کنید</option>
                    <?php
                    $convene = new Convene($db);
                    $setters = new Manager($db);
                    $setters = $setters->get_object_data();
                    foreach ($setters as $setter) {
                        $setter['access'] = json_decode($setter['access'],1);
                        if ($setter['access']['convene']){
                            $convene->set_object_byID($setter['access']['convene']);
                        }
                        if (($setter['level'] == "پشتیبان" || ($manager->level=="مدیرکل" && $setter['level'] == "مدیر")) && ($manager->level!="مدیر" || $setter['access']['convene']==$access['convene']))echo '<option dir="rtl" ' . ($form['setBy'] == $setter['ID'] ? "selected" : "") . ' value="' . $setter['ID'] . '">' . $setter['name'].' '.($setter['level'] == "مدیر"?'*':'').'('.$convene->name. ')</option>';
                    }
                    ?>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="startTS"> تاریخ ثبت نام </label>
                <input type="text" name="startTS" id="startTS" value="<?= @jdate("Y/m/d",@$form['startTS']) ?>" placeholder="اگر وارد نشود زمان حال ثبت می‌شود" class="form-control">
                <script>
                    var objCal1 = new AMIB.persianCalendar( 'startTS' );
                </script>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="endTS"> تاریخ خروج </label>
                <input type="text" name="endTS" id="endTS" value="<?= @$form['endTS']?@jdate("Y/m/d",@$form['endTS']):'' ?>" class="form-control">
                <script>
                    var objCal1 = new AMIB.persianCalendar( 'endTS' );
                </script>
            </fieldset>
        </div>
        <?PHP
        if ($student->ID && $uri[4][0]=="full"){
            include "stu-form-full.php";}
        ?>
        <div class="col-12 row">
            <?=($student->ID && $uri[4][0]!="full"?'<a href="'.baseDir.'/stu/edit/'.$student->ID.'/full" class="btn btn-primary white">مشخصات تکمیلی</a>':"")?>
            <input type="submit" name="submit" value="تایید" class="btn btn-success">
            <?=($uri[3][0] && $access['j'])?'<a href="'.baseDir.'/classstudent/-'.$student->ID .'/" class="btn btn-primary">افزودن دانشجو به کلاس</a>':''?>
        </div>
    </div>
</form>

<?php if($uri[3][0] && $access['k'])
    echo '  <br> &nbsp;
            <form method="post" action="'.baseDir.'/act/edit/" class="w-25">
                <input type="hidden" name="studentID" value="'.$student->ID .'">
                <input type="submit" name="submit" value="نمایش فعالیت‌های دانشجو" class="btn btn-warning">
            </form>'
?>
