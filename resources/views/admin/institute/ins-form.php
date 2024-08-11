<?php
if ($id = $uri[3][0]>0){
    $institute = new Institute($db);
    $institute->set_object_byID($uri[3][0]);
    $form = $institute->get_object_vars();
    if (!$institute->ID){redirect("ins/edit");}
    if ($manager->level == "پشتیبان" && $institute->setBy!=$manager->ID){redirect("convene/edit");}
    if ($manager->level == "مدیر"){
        if (! $institute->setBy == $manager->ID){
            $setter = new Manager($db);
            $setter->set_object_byID($institute->setBy);
            $setter = json_decode($setter->access,1);
            if ($setter['convene']!=$access['convene']){redirect("ins/edit");}}
    }
}
if (isset($post['submit'])) {
    $form = get_form_data_html();
    unset($form['submit']);
    $form['mobile'] = $form['mobile0']."-".$form['mobile1'];
    unset($form['mobile0']);
    unset($form['mobile1']);
    $form['whatsapp'] = $form['whatsapp0']."-".$form['whatsapp1'];
    unset($form['whatsapp0']);
    unset($form['whatsapp1']);
    if (strlen($form['startTS'])>3){$form['startTS'] = input_to_timestamp($form['startTS'],"0:0");}else{$form['startTS'] = time();}
    if (strlen($form['timeinterface'])>3){$form['timeinterface'] = input_to_timestamp($form['timeinterface'],"0:0");}else{$form['timeinterface']="";}

    include "ins-form-submit-img.php";
    if (!@$institute){$institute = new Institute($db);}
    $institute->set_vars_from_array($form);
    if ($manager->level=="پشتیبان"){$institute->setBy = $manager->ID;}
    if ($manager->level!="پشتیبان" && !$institute->setBy){$institute->setBy = $manager->ID;}
    if ($institute->save_object_data()) {
        echo '<p class="btn btn-success">ثبت اطلاعات با موفقیت انجام شد.
        <br>
        شناسه این موسسه '.$institute->ID.' می‌باشد.
        </p>';
        redirect("ins/edit/".$institute->ID, 1);
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
                <?= (@$form['ID']>0 ? '<p> شناسه موسسه: <label class="alert alert-success small py-0 px-1">'.$form['ID'].'</label></p>' :'') ?>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="NameInstitute"> نام موسسه </label>
                <input type="text" name="NameInstitute" id="NameInstitute" value="<?= @$form['NameInstitute'] ?>" class="form-control" required>
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
                <label for="mobile"> شماره موبایل </label>
                <span class="row w-100 mx-auto">
                    <input type="text" name="mobile1" id="mobile" value="<?= @explode("-",$form['mobile'])[1] ?>" placeholder="9123334455" class="form-control dir-ltr w-80">
                    <input type="text" name="mobile0" id="mobile" value="<?= @explode("-",$form['mobile'])[0] ?>" placeholder="+98" class="form-control dir-ltr w-20">
                </span>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="whatsapp"> شماره واتساپ </label>
                <span class="row w-100 mx-auto">
                    <input type="text" name="whatsapp1" id="whatsapp" value="<?= @explode("-",$form['whatsapp'])[1] ?>" placeholder="9123334455" class="form-control dir-ltr w-80">
                    <input type="text" name="whatsapp0" id="whatsapp" value="<?= @explode("-",$form['whatsapp'])[0] ?>" placeholder="+98" class="form-control dir-ltr w-20">
                </span>
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
                <label for="email"> ایمیل </label>
                <input type="email" name="email" id="email" value="<?= @$form['email'] ?>" class="form-control">
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
                <label for="admin"> نام مدیر </label>
                <input type="text" name="admin" id="admin" value="<?= @$form['admin'] ?>" class="form-control">
            </fieldset>
        </div>
		      <div class="col-md-6">
            <fieldset class="form-group">
                <label for="adminmail"> ایمیل / تلفن مدیر </label>
                <input type="text" name="adminmail" id="adminmail" value="<?= @$form['adminmail'] ?>" class="form-control">
            </fieldset>
        </div>
				         <div class="col-md-6">
            <fieldset class="form-group">
                <label for="interface"> نام رابط </label>
                <input type="text" name="interface" id="interface" value="<?= @$form['interface'] ?>" class="form-control">
            </fieldset>
        </div>
		      <div class="col-md-6">
            <fieldset class="form-group">
                <label for="interfacemail"> ایمیل / تلفن رابط </label>
                <input type="text" name="interfacemail" id="interfacemail" value="<?= @$form['interfacemail'] ?>" class="form-control">
            </fieldset>
        </div>
		  
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="startTS"> تاریخ ثبت  </label>
                <input type="text" name="startTS" id="startTS" value="<?= @jdate("Y/m/d",@$form['startTS']) ?>" placeholder="اگر وارد نشود زمان حال ثبت می‌شود" class="form-control">
                <script>
                    var objCal1 = new AMIB.persianCalendar( 'startTS' );
                </script>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="timeinterface"> تاریخ ارتباط </label>
                <input type="text" name="timeinterface" id="timeinterface" value="<?= @$form['timeinterface']?@jdate("Y/m/d",@$form['timeinterface']):'' ?>" class="form-control">
                <script>
                    var objCal1 = new AMIB.persianCalendar( 'timeinterface' );
                </script>
            </fieldset>
        </div>
        <?PHP
        if ($institute->ID && $uri[4][0]=="full"){include "ins-form-full.php";}
        ?>
        <div class="col-12 row">
            <?=($institute->ID && $uri[4][0]!="full"?'<a href="'.baseDir.'/ins/edit/'.$institute->ID.'/full" class="btn btn-primary white">مشخصات تکمیلی</a>':"")?>
            <input type="submit" name="submit" value="تایید" class="btn btn-success">
     
        </div>
    </div>
</form>
