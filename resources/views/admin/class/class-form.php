<?php
if (($id = $uri[3][0])>0){
    $class = new TeachClass($db);
    $class->set_object_byID($id);
    $form = $class->get_object_vars();
    if (!$class->ID){redirect("teachClass/edit");}
    $supporter = new Manager($db);
    $supporter->set_object_byID($class->supporter);
    $classConvene = json_decode($supporter->access,1)['convene'];
    if ($manager->level != "مدیرکل" && $access['convene']!=$classConvene){redirect("teachClass/edit");}
}
if (isset($post['submit'])) {
    $form = get_form_data_html();
    unset($form['submit']);
    if (strlen($form['startTS'])>3){$form['startTS'] = input_to_timestamp($form['startTS'],"0:0");}
    if (strlen($form['endTS'])>3){$form['endTS'] = input_to_timestamp($form['endTS'],"0:0");}else{$form['endTS']="";}
    if ((int)$form['spw']<0){$error=1; echo '<p class="warning danger">تعداد جلسات هر هفته نمی‌تواند کمتر از 0 باشد</p>';}
    if (!@$form['state']){
        if (time()<$form['startTS']){$form['state'] = "شروع نشده";}
        if (@$form['startTS']>0 && time()>$form['startTS']){$form['state'] = "درحال برگزاری";}
        if (@$form['endTS']>0 && time()>$form['endTS']){$form['state'] = "تمام شده";}
    }
    if (!@$class){$class = new TeachClass($db);}
    $class->set_vars_from_array($form);
    if ($manager->level=="پشتیبان"){$class->supporter = $manager->ID;}
    if ($manager->level!="پشتیبان" && !$class->supporter){$class->supporter = $manager->ID;}
    if (!@$error){
        if ($class->save_object_data()) {
            echo '<p class="btn btn-success">ثبت اطلاعات با موفقیت انجام شد.</p>';
            redirect("teachClass/edit", 1);
        } else {
            echo '<p class="btn btn-warning">در ثبت اطلاعات مشکلی پیش آمد.</p>';
        }
    }

}

?>
<form method="post">
    <div class="card-header">
        <h4 class="card-title">تعریف کلاس:</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="name"> نام کلاس </label>
                <input type="text" name="name" id="name" value="<?= @$form['name'] ?>" class="form-control" required>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="description"> توضیحات کلاس </label>
                <textarea class="form-control" name="description" id="description" rows="3" placeholder="در صورت نیاز، توضیحاتی را برای دوره وارد کنید..."><?= @$form['description'] ?></textarea>
            </fieldset>
        </div>
        <div class="col-md-6" <?=($manager->level=="پشتیبان"?' style="display: none;"':'')?> >
            <fieldset class="form-group">
                <label for="supporter"> پشتیبان </label>
                <select name="supporter" id="supporter" class="select2 form-control">
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
                        if (($setter['level'] == "پشتیبان" || ($manager->level=="مدیرکل" && $setter['level'] == "مدیر")) && ($manager->level!="مدیر" || $setter['access']['convene']==$access['convene']))echo '<option dir="rtl" ' . ($form['supporter'] == $setter['ID'] ? "selected" : "") . ' value="' . $setter['ID'] . '">' . $setter['name'].' '.($setter['level'] == "مدیر"?'*':'').'('.$convene->name. ')</option>';
                    }
                    ?>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="course"> دوره </label>
                <select name="course" id="course" class="custom-select">
                    <option <?=(($manager->level=="مدیر" || $manager->level=="پشتیبان")?"disabled":"")?> value="">انتخاب کنید</option>
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
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="platform"> محل برگزاری </label>
                <select name="platform" id="platform" class="custom-select">
                    <option value="">انتخاب کنید</option>
                    <?php
                    $setting = new Setting($db);
                    $setting->set_object_from_sql(array("type"=>"setData","name"=>"platforms"));
                    $platforms = explode("\r\n",$setting->value);
                    foreach ($platforms as $platform) {
                        echo '<option ' . ($form['platform'] == $platform ? "selected" : "") . ' value="' . $platform . '">' . $platform . '</option>';
                    }
                    ?>
                </select>
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
                <label for="language"> زبان‌ </label>
                <select name="language" id="language" class="custom-select">
                    <option value="">انتخاب کنید</option>
                    <?php
                    $setting = new Setting($db);
                    $setting->set_object_from_sql(array("type"=>"setData","name"=>"language"));
                    $languages = explode("\r\n",$setting->value);
                    foreach ($languages as $language) {
                        echo '<option ' . ($form['language'] == $language ? "selected" : "") . ' value="' . $language . '">' . $language . '</option>';
                    }
                    ?>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="sex"> جنسیت شرکت‌کنندگان </label>
                <select name="sex" id="sex" class="custom-select">
                    <option value="">انتخاب کنید</option>
                    <?php
                    $setting = new Setting($db);
                    $setting->set_object_from_sql(array("type"=>"setData","name"=>"sex"));
                    $sexes = explode("\r\n",$setting->value);
                    foreach ($sexes as $sex) {
                        echo '<option ' . ($form['sex'] == $sex ? "selected" : "") . ' value="' . $sex . '">' . $sex . '</option>';
                    }
                    ?>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="startTS"> تاریخ شروع </label>
                <input type="text" name="startTS" id="startTS" value="<?= @jdate("Y/m/d",@$form['startTS']) ?>" class="form-control">
                <script>
                    var objCal1 = new AMIB.persianCalendar( 'startTS' );
                </script>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="endTS"> تاریخ پایان </label>
                <input type="text" name="endTS" id="endTS" value="<?= @$form['endTS']?@jdate("Y/m/d",@$form['endTS']):'' ?>" class="form-control">
                <script>
                    var objCal1 = new AMIB.persianCalendar( 'endTS' );
                </script>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="spw"> تعداد جلسات در هفته </label>
                <input type="number" name="spw" id="spw" value="<?= @$form['spw'] ?>" class="form-control">
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="state"> وضعیت کلاس</label>
                <select name="state" id="state" class="custom-select">
                    <option value="">انتخاب کنید</option>
                    <?php
                    $setting = new Setting($db);
                    $setting->set_object_from_sql(array("type"=>"setData","name"=>"classState"));
                    $states = explode("\r\n",$setting->value);
                    foreach ($states as $state) {
                        echo '<option ' . ($form['state'] == $state ? "selected" : "") . ' value="' . $state . '">' . $state . '</option>';
                    }
                    ?>
                </select>
            </fieldset>
        </div>
        <div class="col-md-6">
            <?=($uri[3][0] && $access['j'])?'<a href="'.baseDir.'/classstudent/'.$class->ID .'-/" class="btn btn-primary">افزودن دانشجو به کلاس</a>':''?>
            <input type="submit" name="submit" value="تایید" class="btn btn-success">
            <?=($uri[3][0] && $access['j'])?'<a href="'.baseDir.'/classstudent/edit/'.$class->ID .'/" class="btn btn-warning">لیست دانشجویان کلاس</a>':''?>
        </div>
    </div>
</form>