
<div class="card-header col-12 bg-primary my-2">
    <h4 class="card-title white">مشخصات تکمیلی:</h4>
</div>
<br>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="AboutInstitute"> درباره موسسه </label>
        <textarea type="text" name="AboutInstitute" id="AboutInstitute" class="form-control"><?= @$form['AboutInstitute'] ?></textarea>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="description"> توضیحات بیشتر موسسه </label>
        <textarea type="text" name="description" id="description" class="form-control"><?= @$form['description'] ?></textarea>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="modelinstitute"> نوع موسسه </label>
        <select name="modelinstitute" id="modelinstitute" class="custom-select">
            <option value="">انتخاب کنید</option>
            <?php
            $setting = new Setting($db);
            $setting->set_object_from_sql(array("type"=>"setData","name"=>"classInstituteType"));
            $items = explode("\r\n",$setting->value);
            foreach ($items as $item) {
                echo '<option ' . ($form['modelinstitute'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
            }
            ?>
        </select>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="religion"> دین </label>
        <select name="religion" id="religion1" class="custom-select" onchange="religious2()">
            <option value="">انتخاب کنید</option>
            <?php
            $setting = new Setting($db);
            $setting->set_object_from_sql(array("type"=>"setData","name"=>"religious"));
            $items = explode("\r\n",$setting->value);
            foreach ($items as $item) {
                echo '<option ' . ($form['religion'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
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
        <label for="activity"> فعالیت های موسسه </label>
        <select name="activity" id="activity" class="custom-select">
            <option value="">انتخاب کنید</option>
            <?php
            $setting = new Setting($db);
            $setting->set_object_from_sql(array("type"=>"setData","name"=>"ActivityInstitute"));
            $items = explode("\r\n",$setting->value);
            foreach ($items as $item) {
                echo '<option ' . ($form['activity'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
            }
            ?>
        </select>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="contacts"> مخاطبین موسسه </label>
        <textarea type="text" name="contacts" id="contacts" class="form-control"><?= @$form['contacts'] ?></textarea>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="assessment"> ارزیابی موسسه </label>
        <select name="assessment" id="assessment" class="custom-select">
            <option value="">انتخاب کنید</option>
            <?php
            $setting = new Setting($db);
            $setting->set_object_from_sql(array("type"=>"setData","name"=>"AssessmentInstitute"));
            $items = explode("\r\n",$setting->value);
            foreach ($items as $item) {
                echo '<option ' . ($form['assessment'] == $item ? "selected" : "") . ' value="' . $item . '">' . $item . '</option>';
            }
            ?>
        </select>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="support">  پشتیبان رابط </label>
        <textarea type="text" name="support" id="support" class="form-control"><?= @$form['support'] ?></textarea>
    </fieldset>
</div>
<div class="col-md-6">
    <fieldset class="form-group">
        <label for="resultinterface"> نتیجه ارتباط </label>
        <textarea type="text" name="resultinterface" id="resultinterface" class="form-control"><?= @$form['resultinterface'] ?></textarea>
    </fieldset>
</div>