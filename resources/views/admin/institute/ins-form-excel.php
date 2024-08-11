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
            if ($row[0] == "NameInstitute")continue;
            $row['log']="";
            if (!$row['NameInstitute']){$row['log']="نام موسسه نا معتبر \r";}
            if ($row['country']){
                $country = new Country($db);
                $country->set_object_from_sql(array("symbol"=>$row['country']));
                if ($country->ID){$row['country'] = $country->ID;}else{
                    $row['log'].="کشور نامعتبر \r";
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
            if ($row['language']){
                $setting = new Setting($db);
                $setting->set_object_from_sql(array("type"=>"setData","name"=>"language"));
                $items = determiner($setting->value);
                if (!in_array($row['language'],$items)){ $row['log'] .= "زبان نامعتبر \r";}
            }
            if ($row['religion']){
                $setting = new Setting($db);
                $setting->set_object_from_sql(array("type"=>"setData","name"=>"religious"));
                $items = determiner($setting->value);
                if (!in_array($row['religion'],$items)){ $row['log'] .= "دین نامعتبر \r";}
            }
            if ($row['classInstituteType']){
                $setting = new Setting($db);
                $setting->set_object_from_sql(array("type"=>"setData","name"=>"classInstituteType"));
                $items = determiner($setting->value);
                if (!in_array($row['classInstituteType'],$items)){ $row['log'] .= " نوع موسسه نامعتبر \r";}
            }
			if ($row['ActivityInstitute']){
                $setting = new Setting($db);
                $setting->set_object_from_sql(array("type"=>"setData","name"=>"ActivityInstitute"));
                $items = determiner($setting->value);
                if (!in_array($row['ActivityInstitute'],$items)){ $row['log'] .= "فعالیت موسسه نامعتبر \r";}
            }
			if ($row['AssessmentInstitute']){
                $setting = new Setting($db);
                $setting->set_object_from_sql(array("type"=>"setData","name"=>"AssessmentInstitute"));
                $items = determiner($setting->value);
                if (!in_array($row['AssessmentInstitute'],$items)){ $row['log'] .= "فعالیت موسسه نامعتبر \r";}
            }
            if (strlen($row['startTS']) > 3) {
                if (!$row['startTS'] = input_to_timestamp($row['startTS'], "0:0")){
                    $row['log'] .= "خطا در ثبت تاریخ ثبت نام \r";
                }
            } else {
                $row['startTS'] = time();
            }
 if (strlen($row['timeinterface']) > 3) {
                if (!$row['timeinterface'] = input_to_timestamp($row['timeinterface'], "0:0")){
                    $row['log'] .= "خطا در ثبت تاریخ ارتباط \r";
                }
            } else {
                $row['timeinterface'] = time();
            }
            if ($form['error']=="notSetAll" && $row['log']){$error=1;}
            $setData[]=$row;
        }
        $submitedinstitutesID=[];
        echo '<table class="table border-2">
        <tr>
        <th>نام موسسه</th>
        <th>کشور</th>
        <th>شناسه ثبت</th>
        <th>وضعیت</th>
        </tr>';
        foreach ($setData as $stuData){
            if (!@$error){
                if ($form['error']=="notSetStu" && $stuData['log']){
                    //موسسه ثبت نمیشود
                }else{
                    $stuData_forSet = $stuData;
                    unset($stuData_forSet['log']);
                    $institute = new Institute($db);
                    $institute->set_vars_from_array($stuData_forSet);
                    if ($manager->level=="پشتیبان"){$institute->setBy = $manager->ID;}
                    if ($manager->level!="پشتیبان" && !$institute->setBy){$institute->setBy = $manager->ID;}
                    $institute->save_object_data();
                    $institute->ID = end($institute->get_object_data())['ID'];
                    $submitedinstitutesID[] = $institute->ID;
                }
            }
            echo '
            <tr>
            <td>'.$stuData['NameInstitute'].'</td>
            <td>'.$stuData['country'].'</td>
            <td class="'.(@$institute->ID?'alert-success':'').'"><a href="'.baseDir.'/ins/edit/'.@$institute->ID.'">'.@$institute->ID.'</a></td>
            <td class="'.($stuData['log']?'alert-danger':'').'">'.enter_to_br($stuData['log']).'</td>
            </tr>
            ';
        }
        echo '</table>';
        write_suf($submitedinstitutesID,$manager->ID."-last-excel-add");
    }
    unlink($form['file']);


    if (strlen($form['startTS'])>3){$form['startTS'] = input_to_timestamp($form['startTS'],"0:0");}
    if (strlen($form['timeinterface'])>3){$form['timeinterface'] = input_to_timestamp($form['timeinterface'],"0:0");}else{$form['timeinterface']="";}
//    if ($form['spw']<0){$error=1; echo '<p class="warning danger">تعداد جلسات هر هفته نمی‌تواند کمتر از 0 باشد</p>';}
    if (!@$form['state']){
        if (time()<$form['startTS']){$form['state'] = "شروع نشده";}
        if (@$form['startTS']>0 && time()>$form['startTS']){$form['state'] = "تاریخ ثبت";}
        if (@$form['timeinterface']>0 && time()>$form['timeinterface']){$form['state'] = "ارتباط گرفته شده";}
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
if ($uri[3][0] == 'restore'){
    $submitedinstitutesID = @read_suf($manager->ID."-last-excel-add");
    if ($submitedinstitutesID){
        $institute = new Institute($db);
        foreach ($submitedinstitutesID as $id){
            $institute->set_object_byID($id);
            $institute->delete_object_data();
        }
        delete_suf($manager->ID."-last-excel-add");
        echo '<p class="alert alert-primary">حذف اعضای اضافه شده‌ی اخیر با موفقیت انجام شد.</p>';
    }else{
        echo '<p class="alert alert-danger">دریافت لیست اعضای اخیر با خطا مواجه شد. به نظر می‌رسد قبلاً بار آن‌ها را حذف کرده‌اید.</p>';
    }
}
?>
<p class="alert alert-warning">
    آیا اخیراً اطلاعاتی را اشتباه ثبت کرده اید؟
    <br>
    <a href="<?=baseDir?>/ins/excel/restore">بازگردانی</a>
</p>
<form method="post" enctype="multipart/form-data">
    <div class="card-header">
        <h4 class="card-title">افزودن موسسه از اکسل:</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <fieldset class="form-group">
                <p>
                    برای افزودن موسسات، فایل نمونه را دانلود و بر اساس همین ساختار، مشخصات موجود را تکمیل نمایید.
                    <br>
                    <?php
                    if ($manager->level=="مدیرکل" || $manager->level=="مدیر"){
                        echo '<a href="'.baseDir.'/view/upload/example-manager2.xlsx">دریافت فایل example.xlsx</a>';
                    }else{
                        echo '<a href="'.baseDir.'/view/upload/example-supporter2.xlsx">دریافت فایل example.xlsx</a>';
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
                    <input type="radio" class="radio" name="error" checked id="error" value="notSetAll"/> عدم ثبت مشخصات همه‌ی موسسات در صورت وجود خطا
                </label>
                <label class="w-100 alert-warning">
                    <input type="radio" class="radio" name="error" <?=$form['error']=='notSetStu'?'checked':''?> id="error" value="notSetStu"/> عدم ثبت مشخصات موسسه ی دارای خطا
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