<?php
if ($id = $uri[3][0]>0){
    $course = new Course($db);
    $course->set_object_byID($uri[3][0]);
    $form = $course->get_object_vars();
    $availableFor = json_decode($form['availableFor'],1);
    if (!$course->ID){redirect("course/edit");}
}
if (isset($post['submit'])) {
    $form = get_form_data_html();
    unset($form['submit']);
    if (!@$course){$course = new Course($db);}
    $form['availableFor'] = json_encode($form['availableFor']);
    $course->set_vars_from_array($form);

    if ($course->save_object_data()) {
        echo '<p class="alert alert-success">ثبت اطلاعات با موفقیت انجام شد.</p>';
        redirect("course/edit", 1);
    } else {
        echo '<p class="alert alert-warning">در ثبت اطلاعات مشکلی پیش آمد.</p>';
    }
}

?>
<form method="post">
    <div class="card-header">
        <h4 class="card-title">تعریف دوره:</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="name"> نام دوره </label>
                <input type="text" name="name" id="name" value="<?= @$form['name'] ?>" class="form-control">
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="description"> توضیحات دوره </label>
                <textarea class="form-control" name="description" id="description" rows="3" placeholder="در صورت نیاز، توضیحاتی را برای دوره وارد کنید..."><?= @$form['description'] ?></textarea>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label> در دسترس برای مجتمع‌های </label>
                <br>
                <?php
                $convene = new Convene($db);
                $convenes = $convene->get_object_data();
                foreach ($convenes as $convene){
                    echo '<label><input type="checkbox" name="availableFor['.$convene['ID'].']" value="1" '.(@$availableFor[$convene['ID']]?"checked":"").' class="form-check-inline"> '.$convene['name'].'</label>';
                }
                ?>
            </fieldset>
        </div>
        <div class="col-md-6">
            <input type="submit" name="submit" value="تایید" class="btn btn-success">
        </div>
    </div>
</form>