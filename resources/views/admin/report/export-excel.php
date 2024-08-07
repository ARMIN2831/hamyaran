<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> گزارشات </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> اطلاعات دانشجویان </a>
                                </li>
                                <li class="breadcrumb-item active">گزارش اکسل
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
        <?php
        $access['n'] || redirect("");
        $students = read_suf($manager->ID);
        sort($students);    //اگر کلیدهایی خالی باشد د رگزاش اکسل نمی‌آید. لذا باید سورت بدون کلید انجام شود
/*        var_export($students[array_key_first($students)]);
        foreach ($students as $k=>$v){
            echo $k . "<br>";
        }*/
        if (write_excel("view/upload/stage/".$manager->ID.".xlsx",$students,array_keys($students[array_key_first($students)]))){
            echo '<p class="alert alert-success">فایل گزارش با موفقیت ایجاد شد
            <br>
            (جهت نمایش صحیح ستون‌های دارای چند مقدار در فایل خروجی گزینه‌ی wrap text را در برنامه excel فعال نمایید.)
            <br>
            <a href="'.baseDir.'/view/upload/stage/'.$manager->ID.'.xlsx" class="btn-primary">دریافت فایل</a>
            <br><br>
            <a href="'.baseDir.'/export/" class="btn-warning">گزارش جدید</a></p>';
        }else{
            echo '<p class="alert alert-warning">امکان ایجاد فایل گزارش وجود ندارد. ممکن است درخواست دریافت گزارش دیگری را ثبت کرده باشید.
            <br>توجه فرمایید که امکان دریافت چند گزارش اکسل به صورت همزمان وجود ندارد.
            </p>';
        }

        ?>
        </div>
    </div>
</div>

