<div class="card-header col-12 bg-primary my-2">
    <h4 class="card-title white">پروفایل و مدارک:</h4>
</div>
<br>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="profileImg"> تصویر دانشجو </label>
        <input type="file" name="profileImg" id="profileImg" value="<?= @$form['profileImg'] ?>" class="form-control">
        <p>از عکس مربعی ترجیحاً 100x100 پیکسل استفاده نمایید.</p>
        <?php
        echo ($form['profileImg']?'<img src="'.$form['profileImg'].'" class="w-75" />':'');
        ?>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="passportImg"> تصویر کارت ملی/پاسپورت </label>
        <input type="file" name="passportImg" id="passportImg" value="<?= @$form['passportImg'] ?>" class="form-control">
        <?php
        echo ($form['passportImg']?'<img src="'.$form['passportImg'].'" class="w-75" />':'');
        ?>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="evidenceImg"> مدرک تحصیلی </label>
        <input type="file" name="evidenceImg" id="evidenceImg" value="<?= @$form['evidenceImg'] ?>" class="form-control">
        <?php
        echo ($form['evidenceImg']?'<img src="'.$form['evidenceImg'].'" class="w-75" />':'');
        ?>
    </fieldset>
</div>
<div class="card-header col-12 bg-primary my-2">
    <h4 class="card-title white">مشخصات تکمیلی:</h4>
</div>
<br>
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
        <label for="aboutStudent"> درباره دانشجو </label>
        <textarea type="text" name="aboutStudent" id="aboutStudent" class="form-control"><?= @$form['aboutStudent'] ?></textarea>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="character">  شخصیت دانشجو </label>
        <textarea type="text" name="character" id="character" class="form-control"><?= @$form['character'] ?></textarea>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="skill">  مهارت‌های دانشجو </label>
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