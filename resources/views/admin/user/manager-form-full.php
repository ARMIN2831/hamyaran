<div class="card-header col-12 bg-primary my-2">
    <h4 class="card-title white">مشخصات اصلی:</h4>
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
        <label for="mobile"> شماره موبایل </label>
        <span class="row w-100 mx-auto">
                    <input type="text" name="mobile1" id="mobile" value="<?= @explode(" ",$form['mobile'])[1] ?>" placeholder="9123334455" class="form-control dir-ltr w-80">
                    <input type="text" name="mobile0" id="mobile" value="<?= @explode(" ",$form['mobile'])[0] ?>" placeholder="+98" class="form-control dir-ltr w-20">
                </span>
    </fieldset>
</div>

<div class="card-header col-12 bg-primary my-2">
    <h4 class="card-title white">مشخصات تکمیلی:</h4>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="religion1"> دین </label>
        <select name="religion1" id="religion1" class="custom-select" onchange="religious2()">
            <option value="">انتخاب کنید</option>
            <?php
            $setting = new Setting($db);
            $setting->set_object_from_sql(array("type"=>"setData","name"=>"religious"));
            $items = explode("\r\n",$setting->value);
            foreach ($items as $item) {
                echo '<option ' . ($form['religion1'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
            }
            ?>
        </select>
    </fieldset>
</div>
<div class="col-md-6" id="religion1_box">
    <fieldset class="form-group">
        <label for="religion2"> مذهب </label>
        <input type="text" name="religion2" id="religion2" value="<?= @$form['religion2'] ?>" class="form-control">
    </fieldset>
</div>
<div class="col-md-6" id="religion2_box">
    <fieldset class="form-group">
        <label for="religion2"> مذهب </label>
        <select name="religion2" id="religion2" class="custom-select">
            <option value="">انتخاب کنید</option>
            <?php
            $setting = new Setting($db);
            $setting->set_object_from_sql(array("type"=>"setData","name"=>"religion2"));
            $items = explode("\r\n",$setting->value);
            foreach ($items as $item) {
                echo '<option ' . ($form['religion2'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
            }
            ?>
        </select>
    </fieldset>
</div>
<script>
    function religious2(){
        if (document.getElementById("religion1").value=="اسلام"){
            document.getElementById("religion1_box").style.display="none";
            document.getElementById("religion2_box").style.display="block";
        }else {
            document.getElementById("religion2_box").style.display="none";
            document.getElementById("religion1_box").style.display="block";
        }
    }
    religious2();
</script>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="opinionAboutIran"> موضع نسبت به ایران </label>
        <select name="opinionAboutIran" id="opinionAboutIran" class="custom-select">
            <option value="">انتخاب کنید</option>
            <?php
            $setting = new Setting($db);
            $setting->set_object_from_sql(array("type"=>"setData","name"=>"opinionAboutIran"));
            $items = explode("\r\n",$setting->value);
            foreach ($items as $item) {
                echo '<option ' . ($form['opinionAboutIran'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
            }
            ?>
        </select>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label>توانمندی در مدیریت </label>
        <label>دارد
            <input type="radio" name="isManageable" <?= (($form['isManageable'] == "1") ? "checked" : "") ?> value="1">
        </label>
        &nbsp;&nbsp;&nbsp;
        <label>ندارد
            <input type="radio" name="isManageable" <?= (($form['isManageable'] == "0") ? "checked" : "") ?> value="0">
        </label>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label>امکان واگذاری فعالیت </label>
        <label>دارد
            <input type="radio" name="canDoAct" <?= (($form['canDoAct'] == "1") ? "checked" : "") ?> value="1">
        </label>
        &nbsp;&nbsp;&nbsp;
        <label>ندارد
            <input type="radio" name="canDoAct" <?= (($form['canDoAct'] == "0") ? "checked" : "") ?> value="0">
        </label>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label>روابط عمومی </label>
        <label>خوب
            <input type="radio" name="publicRelation" <?= (($form['publicRelation'] == "1") ? "checked" : "") ?> value="1">
        </label>
        &nbsp;&nbsp;&nbsp;
        <label>ضعیف
            <input type="radio" name="publicRelation" <?= (($form['publicRelation'] == "0") ? "checked" : "") ?> value="0">
        </label>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="financialSituation"> وضعیت مالی </label>
        <select name="financialSituation" id="financialSituation" class="custom-select">
            <option value="">انتخاب کنید</option>
            <?php
            $setting = new Setting($db);
            $setting->set_object_from_sql(array("type"=>"setData","name"=>"financialSituation"));
            $items = explode("\r\n",$setting->value);
            foreach ($items as $item) {
                echo '<option ' . ($form['financialSituation'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
            }
            ?>
        </select>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="donation"> علاقه به حمایت مالی </label>
        <select name="donation" id="donation" class="custom-select">
            <option value="">انتخاب کنید</option>
            <?php
            $setting = new Setting($db);
            $setting->set_object_from_sql(array("type"=>"setData","name"=>"donation"));
            $items = explode("\r\n",$setting->value);
            foreach ($items as $item) {
                echo '<option ' . ($form['donation'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
            }
            ?>
        </select>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="aboutStudent"> درباره مدیر </label>
        <textarea type="text" name="aboutStudent" id="aboutStudent" class="form-control"><?= @$form['aboutStudent'] ?></textarea>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="character">  شخصیت مدیر </label>
        <textarea type="text" name="character" id="character" class="form-control"><?= @$form['character'] ?></textarea>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="skill">  مهارت‌های مدیر </label>
        <textarea type="text" name="skill" id="skill" class="form-control"><?= @$form['skill'] ?></textarea>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="allergie">  حساسیت‌های ارتباطی </label>
        <textarea type="text" name="allergie" id="allergie" class="form-control"><?= @$form['allergie'] ?></textarea>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="ext">  سایر موارد </label>
        <textarea type="text" name="ext" id="ext" class="form-control"><?= @$form['ext'] ?></textarea>
    </fieldset>
</div>