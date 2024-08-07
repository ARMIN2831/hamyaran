<?php
if ($newManager){
    $form = $newManager->get_object_vars();
    $managerAccess = json_decode($newManager->access,1);
}

if (isset($post['submit'])) {
    $form = get_form_data_html();
    unset($form['submit']);
    if ($newManager){$form['userName'] = $newManager->userName;}
    $form['access'] = json_encode($form['access']);
    $form['setBy'] = $mid;
    $form['level'] = "مدیرکل";
    $newManager = new Manager($db);
    if ($uri[2][0]=="add"){
        if ($newManager->add($form)) {
            echo '<p class="btn btn-success">ثبت مدیرکل با موفقیت انجام شد.</p>';
            redirect("manager/add/admin", 2);
        } else {
            echo '<p class="btn btn-warning">مدیر دیگری با این نام کاربری موجود می‌باشد.</p>';
        }
    }
    if ($uri[2][0]=="edit"){
        if ($newManager->edit($form)) {
            echo '<p class="btn btn-success">ویرایش مشخصات مدیرکل با موفقیت انجام شد.</p>';
            redirect("manager/edit", 2);
        } else {
            echo '<p class="btn btn-warning">ویرایش مشخصات مدیرکل ناموفق بود.</p>';
        }
    }

}

?>
<form method="post">
    <div class="card-header">
        <h4 class="card-title">مشخصات مدیرکل:</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="userName"> نام کاربری </label>
                <input type="text" name="userName" id="userName" value="<?= @$form['userName'] ?>" <?=@$newManager?'readonly':''?> class="form-control"
                       required>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="name"> نام </label>
                <input type="text" name="name" id="name" value="<?= @$form['name'] ?>" class="form-control">
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
                <label for="password"> رمز </label>
                <input type="password" name="password" id="password" class="form-control">
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label> دسترسی‌ها </label>
                <br>
                <label> <input type="checkbox" name="access[a]" value="1" <?=($managerAccess['a']?'checked':'')?> class="form-check-inline"> افزودن مدیر/پشتیبان</label>
                <label> <input type="checkbox" name="access[b]" value="1" <?=($managerAccess['b']?'checked':'')?> class="form-check-inline"> افزودن مدیرکل</label>
                <label> <input type="checkbox" name="access[c]" value="1" <?=($managerAccess['c']?'checked':'')?> class="form-check-inline"> ویرایش مدیر/پشتیبان</label>
                <label> <input type="checkbox" name="access[d]" value="1" <?=($managerAccess['d']?'checked':'')?> class="form-check-inline"> ویرایش مدیرکل </label>
                <label> <input type="checkbox" name="access[e]" value="1" <?=($managerAccess['e']?'checked':'')?> class="form-check-inline"> مجتمع‌ها </label>
                <label> <input type="checkbox" name="access[f]" value="1" <?=($managerAccess['f']?'checked':'')?> class="form-check-inline"> دوره‌ها </label>
                <label> <input type="checkbox" name="access[g]" value="1" <?=($managerAccess['g']?'checked':'')?> class="form-check-inline"> کلاس‌ها </label>
                <label> <input type="checkbox" name="access[h]" value="1" <?=($managerAccess['h']?'checked':'')?> class="form-check-inline"> افزودن دانشجویان</label>
                <label> <input type="checkbox" name="access[i]" value="1" <?=($managerAccess['i']?'checked':'')?> class="form-check-inline"> ویرایش دانشجوبان</label>
                <label> <input type="checkbox" name="access[j]" value="1" <?=($managerAccess['j']?'checked':'')?> class="form-check-inline"> افزودن دانشجو به کلاس</label>
                <label> <input type="checkbox" name="access[k]" value="1" <?=($managerAccess['k']?'checked':'')?> class="form-check-inline"> فعالت‌های دانشجویان</label>
                <label> <input type="checkbox" name="access[l]" value="1" <?=($managerAccess['l']?'checked':'')?> class="form-check-inline"> نمودارها</label>
                <label> <input type="checkbox" name="access[m]" value="1" <?=($managerAccess['m']?'checked':'')?> class="form-check-inline"> نقشه جهان</label>
                <label> <input type="checkbox" name="access[n]" value="1" <?=($managerAccess['n']?'checked':'')?> class="form-check-inline"> گزارش‌گیری</label>
                <label> <input type="checkbox" name="access[o]" value="1" <?=($managerAccess['o']?'checked':'')?> class="form-check-inline"> گزارشا سامانه</label>
                <label> <input type="checkbox" name="access[p]" value="1" <?=($managerAccess['p']?'checked':'')?> class="form-check-inline"> مدیریت تیکت‌ها</label>
                <label> <input type="checkbox" name="access[q]" value="1" <?=($managerAccess['q']?'checked':'')?> class="form-check-inline"> تنظیمات سامانه</label>
            </fieldset>
        </div>
        <?PHP
        if ($newManager->ID && $uri[4][0]=="full"){
            include "manager-form-full.php";}
        ?>
        <div class="col-md-6">
            <?=($newManager->ID && $uri[4][0]!="full"?'<a href="'.baseDir.'/manager/edit/'.$newManager->ID.'/full" class="btn btn-primary white">مشخصات تکمیلی</a>':"")?>
            <input type="submit" name="submit" value="تایید" class="btn btn-success">
        </div>
    </div>
</form>
