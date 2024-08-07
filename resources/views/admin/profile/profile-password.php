<?php
if (isset($post['submit'])){
    $form = get_form_data();
    unset($form['submit']);
    if ($form['newPassword'] != $form['retypeNewPassword']){
        $error=1;
        echo '<p class="alert alert-warning">رمز جدید و تکرار آن همسان نیستند.</p>';
    }

    if (!@$error){
        if ($manager->change_password($form)){
            echo '<p class="alert alert-success">تغییر رمز با موفقیت انجام شد.</p>';
        }else{
            echo '<p class="alert alert-danger">رمز وارد شده اشتباه است.</p>';
        }

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
                            <label for="password"> رمز قبلی </label>
                            <input type="password" name="password" id="password" class="form-control">
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                            <label for="newPassword"> رمز جدید </label>
                            <input type="password" name="newPassword" id="newPassword" class="form-control">
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="form-group">
                            <label for="retypeNewPassword">تکرار رمز جدید </label>
                            <input type="password" name="retypeNewPassword" id="retypeNewPassword" class="form-control">
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