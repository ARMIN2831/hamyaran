<?php
if (@$student->profileImg){$replace_file = "view/".$student->profileImg;}
$upload_result = upload_image($_FILES['profileImg'],"view/upload/student-profile",@$replace_file,"",4);
if(strlen($upload_result) > "1" | $upload_result == "a"){
    if (strlen($upload_result) > "1"){$form['profileImg'] = str_replace("view/upload/student-profile/","upload/student-profile/",$upload_result);}
}else{$error=1;
    switch ($upload_result){
        case "b":echo '<p class="alert alert-danger">حجم فایل بیش از حد مجاز (1مگابایت) است</p>';
        case "c":echo '<p class="alert alert-danger">پسوند فایل غیرمجاز است</p>';
    }
}
//////////////
if (@$student->passportImg){$replace_file = "view/".$student->passportImg;}
$upload_result = upload_image($_FILES['passportImg'],"view/upload/student-passport",@$replace_file,"",4);
if(strlen($upload_result) > "1" | $upload_result == "a"){
    if (strlen($upload_result) > "1"){$form['passportImg'] = str_replace("view/upload/student-passport/","upload/student-passport/",$upload_result);}
}else{$error=1;
    switch ($upload_result){
        case "b":echo '<p class="alert alert-danger">حجم فایل بیش از حد مجاز (1مگابایت) است</p>';
        case "c":echo '<p class="alert alert-danger">پسوند فایل غیرمجاز است</p>';
    }
}
//////////////
if (@$student->evidenceImg){$replace_file = "view/".$student->evidenceImg;}
$upload_result = upload_image($_FILES['evidenceImg'],"view/upload/student-evidence",@$replace_file,"",4);
if(strlen($upload_result) > "1" | $upload_result == "a"){
    if (strlen($upload_result) > "1"){$form['evidenceImg'] = str_replace("view/upload/student-evidence/","upload/student-evidence/",$upload_result);}
}else{$error=1;
    switch ($upload_result){
        case "b":echo '<p class="alert alert-danger">حجم فایل بیش از حد مجاز (1مگابایت) است</p>';
        case "c":echo '<p class="alert alert-danger">پسوند فایل غیرمجاز است</p>';
    }
}