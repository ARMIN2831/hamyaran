<?php
if (isset($post['submit'])) {
    $form = get_form_data_html();
    unset($form['submit']);


    $replace_file = "view/upload/stage/".$manager->ID.".xlsx";
    $upload_result = upload_file($_FILES['file'],"view/upload/stage",@$replace_file,$manager->ID,"",array("xlsx"));
    if(strlen($upload_result) > "1" | $upload_result == "a"){
        if (strlen($upload_result) > "1"){$form['file'] = "view/upload/stage/".$manager->ID.".xlsx";}
    }else{$error=1;
        switch ($upload_result){
            case "b":echo '<p class="alert alert-danger">حجم فایل بیش از حد مجاز (1مگابایت) است</p>';
            case "c":echo '<p class="alert alert-danger">تنها پسوند .xlsx مورد قبول می‌باشد.</p>';
        }
    }
    if ($excel = read_excel($form['file'])){
        if (!is_array($excel)){
            $error = 1;
            echo '<p class="alert alert-danger">تجزیه فایل اکسل با خطا مواجه شد.</p>';
        }
    }else{
        $error=1;
        echo '<p class="alert alert-danger">خواندن فایل اکسل با مشکل مواجه شد</p>';
    }
    function arrange_excel_data_by_first(&$data){
        foreach ($data as $id=>$row){
            if ($id==0)continue;
            foreach ($row as $key=>$value){
                $data[$id][$data[0][$key]]=$value;
                unset($data[$id][$key]);
            }
        }
    }

    arrange_excel_data_by_first($excel);
    $setData = array();
    if (!@$error){
        foreach ($excel as $row){
            if ($row[0] == "firstName")continue;
            $row['log']="";
            if (!$row['firstName'] || !$row['lastName']){$row['log']="نام و نام خانوادگی نا معتبر \r";}
            if ($row['country']){
                $country = new Country($db);
                $country->set_object_from_sql(array("symbol"=>$row['country']));
                if ($country->ID){$row['country'] = $country->ID;}else{
                    $row['log'].="کشور نامعتبر \r";
                }
            }
            if ($row['nationality']){
                $country = new Country($db);
                $country->set_object_from_sql(array("symbol"=>$row['nationality']));
                if ($country->ID){$row['nationality'] = $country->ID;}else{
                    $row['log'].="ملیت نامعتبر \r";
                }
            }

            if ($row['setBy']){
                $supporter = new Manager($db);
                $supporter->set_object_from_sql(array("userName"=>$row['setBy']));

                if ($supporter->ID && $supporter->level=="پشتیبان"){
                    $row['setBy'] = $supporter->ID;
                }else{
                    $row['log'].="پشتیبان نامعتبر \r";
                }
            }
            if ($row['sex']){
                switch ($row['sex']){
                    case 'مرد': $row['sex']=1;break;
                    case 'زن': $row['sex']=0;break;
                    default: $row['sex'] = null; $row['log'].="جنسیت نامعتبر \r";
                }
            }
            if ($row['isMarried']){
                switch ($row['isMarried']){
                    case 'متأهل': $row['isMarried']=1;break;
                    case 'مجرد': $row['isMarried']=0;break;
                    default: $row['isMarried'] = null; $row['log'].="وضعیت تأهل نامعتبر \r";
                }
            }
            if ($row['language']){
                $setting = new Setting($db);
                $setting->set_object_from_sql(array("type"=>"setData","name"=>"language"));
                $items = determiner($setting->value);
                if (!in_array($row['language'],$items)){ $row['log'] .= "زبان نامعتبر \r";}
            }
            if ($row['religion1']){
                $setting = new Setting($db);
                $setting->set_object_from_sql(array("type"=>"setData","name"=>"religious"));
                $items = determiner($setting->value);
                if (!in_array($row['religion1'],$items)){ $row['log'] .= "دین نامعتبر \r";}
            }
            if (strlen($row['startTS']) > 3) {
                if (!$row['startTS'] = input_to_timestamp($row['startTS'], "0:0")){
                    $row['log'] .= "خطا در ثبت تاریخ ثبت نام \r";
                }
            } else {
                $row['startTS'] = time();
            }

            if ($form['error']=="notSetAll" && $row['log']){$error=1;}
            $setData[]=$row;
        }

        echo '<table class="table border-2">
        <tr>
        <th>نام</th>
        <th>نام خانوادگی</th>
        <th>شناسه ثبت</th>
        <th>وضعیت</th>
        </tr>';
        foreach ($setData as $stuData){
            if (!@$error){
                if ($form['error']=="notSetStu" && $stuData['log']){
                    //دانشجو ثبت نمیشود
                }else{
                    $stuData_forSet = $stuData;
                    unset($stuData_forSet['log']);
                    $student = new Student($db);
                    $student->set_vars_from_array($stuData_forSet);
                    if ($manager->level=="پشتیبان"){$student->setBy = $manager->ID;}
                    if ($manager->level!="پشتیبان" && !$student->setBy){$student->setBy = $manager->ID;}
                    $student->save_object_data();
                    $student->ID = end($student->get_object_data())['ID'];
                }
            }
            echo '
            <tr>
            <td>'.$stuData['firstName'].'</td>
            <td>'.$stuData['lastName'].'</td>
            <td class="'.(@$student->ID?'alert-success':'').'"><a href="'.baseDir.'/stu/edit/'.@$student->ID.'">'.@$student->ID.'</a></td>
            <td class="'.($stuData['log']?'alert-danger':'').'">'.enter_to_br($stuData['log']).'</td>
            </tr>
            ';
        }
        echo '</table>';
    }

    unlink($form['file']);



    if (strlen($form['startTS'])>3){$form['startTS'] = input_to_timestamp($form['startTS'],"0:0");}
    if (strlen($form['endTS'])>3){$form['endTS'] = input_to_timestamp($form['endTS'],"0:0");}else{$form['endTS']="";}
//    if ($form['spw']<0){$error=1; echo '<p class="warning danger">تعداد جلسات هر هفته نمی‌تواند کمتر از 0 باشد</p>';}
    if (!@$form['state']){
        if (time()<$form['startTS']){$form['state'] = "شروع نشده";}
        if (@$form['startTS']>0 && time()>$form['startTS']){$form['state'] = "درحال برگزاری";}
        if (@$form['endTS']>0 && time()>$form['endTS']){$form['state'] = "تمام شده";}
    }
    if (!@$class){$class = new TeachClass($db);}
    $class->set_vars_from_array($form);

    if (!@$error && 1==0){
        if ($class->save_object_data()) {
            echo '<p class="btn btn-success">ثبت اطلاعات با موفقیت انجام شد.</p>';
            redirect("teachClass/edit", 1);
        } else {
            echo '<p class="btn btn-warning">در ثبت اطلاعات مشکلی پیش آمد.</p>';
        }
    }

}

?>
<form method="post" enctype="multipart/form-data">
    <div class="card-header">
        <h4 class="card-title">افزودن دانشجو از اکسل:</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <fieldset class="form-group">
                <p>
                    برای افزودن دانشجویان، فایل نمونه را دانلود و بر اساس همین ساختار، مشخصات موجود را تکمیل نمایید.
                    <br>
                    <?php
                    if ($manager->level=="مدیرکل" || $manager->level=="مدیر"){
                        echo '<a href="'.baseDir.'/view/upload/example-manager.xlsx">دریافت فایل example.xlsx</a>';
                    }else{
                        echo '<a href="'.baseDir.'/view/upload/example-supporter.xlsx">دریافت فایل example.xlsx</a>';
                    }
                    ?>

                </p>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label for="file"> بارگزاری فایل </label>
                <input type="file" class="form-control" name="file" id="file"/>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <label> مدیریت خطا </label>
                <br>
                <label class="w-100 alert-success">
                    <input type="radio" class="radio" name="error" checked id="error" value="notSetAll"/> عدم ثبت مشخصات همه‌ی دانشجویان در صورت وجود خطا
                </label>
                <label class="w-100 alert-warning">
                    <input type="radio" class="radio" name="error" <?=$form['error']=='notSetStu'?'checked':''?> id="error" value="notSetStu"/> عدم ثبت مشخصات دانشجوی دارای خطا
                </label>
                <label class="w-100 alert-danger">
                    <input type="radio" class="radio" name="error" <?=$form['error']=='set'?'checked':''?> id="error" value="set"/> عدم ثبت فیلد دارای خطا
                </label>
            </fieldset>
        </div>
        <div class="col-md-6">
            <input type="submit" name="submit" value="تایید" class="btn btn-success">
        </div>
    </div>
</form>