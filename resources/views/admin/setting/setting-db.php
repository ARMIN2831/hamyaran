<?php
if (!$access['q']) {redirect(""); exit();}
?>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> مدیریت </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> تنظیمات سامانه </a>
                                </li>
                                <li class="breadcrumb-item active">مدیریت پایگاه داده
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic Inputs start -->
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card px-2">
                            <div class="row">
                                <a href="<?=baseDir?>/setting/db/set" class="btn btn-success w-auto"> پشتیبان گیری</a>
                                <a href="<?=baseDir?>/setting/db/upload" class="btn btn-info"> بارگزاری پشتیبان </a>
                            </div>
                            <?php
                            if ($uri[3][0] == 'upload'){
                                if (@$post['submit']){
                                    $form = get_form_data();
                                    $upload_result = upload_file($_FILES['file'],"backup-database");
                                    if(strlen($upload_result) > "1" | $upload_result == "a"){
                                        if (strlen($upload_result) > "1"){
                                        }
                                    }else{$error=1;
                                        switch ($upload_result){
                                            case "b":echo '<p class="alert alert-danger">حجم فایل بیش از حد مجاز است</p>';
                                            case "c":echo '<p class="alert alert-danger">پسوند فایل غیرمجاز است</p>';
                                        }
                                    }
                                    if (!$error){
                                        echo '<p class="alert alert-success">بارگزاری فایل پشتیبان موفقیت آمیز بود.
                                        </p>';
                                        redirect("setting/db/",2.5);
                                    }
                                }
                                echo '
                                <form method="post" enctype="multipart/form-data">
                                    <div class="card-header">
                                        <h4 class="card-title">بارگزاری فایل پشتیبان:</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset class="form-group">
                                            <label for="image"> فایل پشتیبان </label>
                                            <input type="file" name="file" id="file" class="form-control">
                                            <p>با بارگزاری فایل پشتیبان، به صورت خودکار بازگرانی <u>نمی‌شود</u>.</p>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" name="submit" value="تایید" class="btn btn-success">
                                    </div>
                                 </form>
                                ';
                            }
                            if ($uri[3][0] == 'set'){
                                if ($db->backupDatabase("backup-database")){
                                    echo '<p class="alert alert-success">پشتیبان‌گیری موفقیت آمیز بود.</p>';
                                    redirect("setting/db/",1.5);
                                }else{
                                    echo '<p class="alert alert-warning">ایجاد فایل پشتیبان ناموفق بود.</p>';
                                }
                            }
                            if ($get['restore']){
                                if (isset($get['yes'])){
                                    $file = "backup-database/".$get['restore'];
                                    if (file_exists($file)){
                                        if ($db->RestoreBackupDatabase($file)){
                                            echo '<p class="alert alert-success">بازگردانی فایل پشتیبان موفقیت آمیز بود.</p>';
                                            redirect("setting/db/",1.5);
                                        }else{
                                            echo '<p class="alert alert-danger">بازگردانی فایل پشتیبان شکست خورد. ممکن است فایل خراب یا ناسازگار باشد.
                                        <br> ممکن است این اتفاق موجب خرابی یا از کار افتادن سامانه شود.
                                        </p>';
                                        }
                                    }else{
                                        echo '<p class="alert alert-warning">فایل پشتیبان مشکل دارد.</p>';
                                    }
                                }else{
                                    echo '<script>
                                    if (confirm("آیا از بازیابی فایل پشتیبان ' . $get['restore'] . ' اطمینان دارید؟")) {
                                        location.href = "' . baseDir . '"+"/setting/db/?restore=' . $get['restore'] . '&yes";
                                        }else {
                                        location.href = "' . baseDir . '"+"/setting/db/";
                                        }
                                    </script>';
                                }
                            }
                            if ($get['delete']){
                                if (isset($get['yes'])){
                                    $file = "backup-database/".$get['delete'];
                                    if (file_exists($file)){
                                        if (unlink($file)){
                                            echo '<p class="alert alert-primary">حذف فایل پشتیبان موفقیت آمیز بود.</p>';
                                            redirect("setting/db/",1.5);
                                        }else{
                                            echo '<p class="alert alert-danger">حذف فایل پشتیبان شکست خورد.</p>';
                                        }
                                    }else{
                                        echo '<p class="alert alert-warning">فایل پشتیبان وجود ندارد.</p>';
                                    }
                                }else{
                                    echo '<script>
                                    if (confirm("آیا از حذف فایل پشتیبان ' . $get['delete'] . ' اطمینان دارید؟")) {
                                        location.href = "' . baseDir . '"+"/setting/db/?delete=' . $get['delete'] . '&yes";
                                        }else {
                                        location.href = "' . baseDir . '"+"/setting/db/";
                                        }
                                    </script>';
                                }
                            }
                            $backupDir = scandir("backup-database");
                            array_shift($backupDir);
                            array_shift($backupDir);
                            rsort($backupDir);
                            echo '<hr><br><table>';
                            $n=count($backupDir)-1;
                            foreach ($backupDir as $backup){
                                $time = (explode(".",$backup))[0];
                                echo '<tr>
                                <td>'.$backup.' &nbsp;&nbsp;&nbsp;</td>
                                <td>'.@jdate("H:i - Y/m/d",$time).'</td>
                                <td>
                                    <a class="btn btn-warning" href="/backup-database/'.$backup.'">دانلود</a>
                                    <a class="btn btn-primary" href="'.baseDir.'/setting/db/?restore='.$backup.'">بازیابی</a>
                                    <a class="btn btn-danger" href="'.baseDir.'/setting/db/?delete='.$backup.'">حذف</a>
                                </td>';
                            }
                            echo '</table>';
                            ?>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>