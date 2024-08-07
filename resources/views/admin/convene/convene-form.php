<?php
if ($id = $uri[3][0]>0){
    $convene = new Convene($db);
    $convene->set_object_byID($uri[3][0]);
    $form = $convene->get_object_vars();
    if (!$convene->ID){redirect("convene/edit");}
}
if (isset($post['submit'])) {
    $form = get_form_data_html();
    unset($form['submit']);
    if (!@$convene){$convene = new Convene($db);}
    $convene->set_vars_from_array($form);

    if ($convene->save_object_data()) {
        echo '<p class="btn btn-success">ثبت اطلاعات با موفقیت انجام شد.</p>';
        redirect("convene/edit", 1);
    } else {
        echo '<p class="btn btn-warning">در ثبت اطلاعات مشکلی پیش آمد.</p>';
    }
}

?>
<form method="post">
    <div class="card-header">
        <h4 class="card-title">مشخصات مجتمع:</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="name"> نام مجتمع </label>
                <input type="text" name="name" id="name" value="<?= @$form['name'] ?>" class="form-control" required>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="description"> جزئیات مجتمع </label>
                <textarea class="form-control" name="description" id="description" rows="3" placeholder="در صورت نیاز، توضیحاتی را برای مجتمع وارد کنید..."><?= @$form['description'] ?></textarea>
            </fieldset>
        </div>
        <div class="col-md-6">
            <input type="submit" name="submit" value="تایید" class="btn btn-success">
        </div>
    </div>
</form>