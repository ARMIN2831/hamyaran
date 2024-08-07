<?php
$form = $manager->get_object_vars();

if (@$post['submit']){
    $form = get_form_data();
    unset($form['submit']);
    $form['ID'] = $manager->ID;
    if (@$manager->image){$replace_file = "view/".$manager->image;}
    $upload_result = upload_image($_FILES['image'],"view/upload/manager-profile",@$replace_file,"",4);
    if(strlen($upload_result) > "1" | $upload_result == "a"){
        if (strlen($upload_result) > "1"){$form['image'] = str_replace("view/upload/manager-profile/","upload/manager-profile/",$upload_result);}
    }else{$error=1;
        switch ($upload_result){
            case "b":echo '<p class="alert alert-danger">حجم فایل بیش از حد مجاز (1مگابایت) است</p>';
            case "c":echo '<p class="alert alert-danger">پسوند فایل غیرمجاز است</p>';
        }
    }
    if (!@$error){
        $manager->set_vars_from_array($form);
        $manager->save_object_data();
        echo '<p class="alert alert-success">ثبت اطلاعات با موفقیت انجام شد.</p>';
    }

}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card px-2">
            <form method="post" enctype="multipart/form-data">
                <div class="card-header">
                    <h4 class="card-title">ویرایش پروفایل:</h4>
                </div>
                <div class="row">
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
                            <label for="image"> تصویر پروفایل </label>
                            <input type="file" name="image" id="image" value="<?= @$form['image'] ?>" class="form-control">
                            <input type="hidden" name="image"value="<?= @$form['image'] ?>">
                            <p>از عکس مربعی ترجیحاً 100x100 پیکسل استفاده نمایید.</p>
                            <?php
                            echo ($form['image']?'<img src="'.$form['image'].'" width="100" />':'');
                            ?>
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <input type="submit" name="submit" value="تایید" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>