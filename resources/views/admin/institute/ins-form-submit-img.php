<?php
if (@$institute->profileImg){$replace_file = "view/".$institute->profileImg;}
$upload_result = upload_image($_FILES['profileImg'],"view/upload/institute-profile",@$replace_file,"",4);
if(strlen($upload_result) > "1" | $upload_result == "a"){
    if (strlen($upload_result) > "1"){$form['profileImg'] = str_replace("view/upload/institute-profile/","upload/institute-profile/",$upload_result);}
}else{$error=1;
    switch ($upload_result){
        case "b":echo '<p class="alert alert-danger">حجم فایل بیش از حد مجاز (1مگابایت) است</p>';
        case "c":echo '<p class="alert alert-danger">پسوند فایل غیرمجاز است</p>';
    }
}
//////////////
if (@$institute->passportImg){$replace_file = "view/".$institute->passportImg;}
$upload_result = upload_image($_FILES['passportImg'],"view/upload/institute-passport",@$replace_file,"",4);
if(strlen($upload_result) > "1" | $upload_result == "a"){
    if (strlen($upload_result) > "1"){$form['passportImg'] = str_replace("view/upload/institute-passport/","upload/institute-passport/",$upload_result);}
}else{$error=1;
    switch ($upload_result){
        case "b":echo '<p class="alert alert-danger">حجم فایل بیش از حد مجاز (1مگابایت) است</p>';
        case "c":echo '<p class="alert alert-danger">پسوند فایل غیرمجاز است</p>';
    }
}
//////////////
if (@$institute->evidenceImg){$replace_file = "view/".$institute->evidenceImg;}
$upload_result = upload_image($_FILES['evidenceImg'],"view/upload/institute-evidence",@$replace_file,"",4);
if(strlen($upload_result) > "1" | $upload_result == "a"){
    if (strlen($upload_result) > "1"){$form['evidenceImg'] = str_replace("view/upload/institute-evidence/","upload/institute-evidence/",$upload_result);}
}else{$error=1;
    switch ($upload_result){
        case "b":echo '<p class="alert alert-danger">حجم فایل بیش از حد مجاز (1مگابایت) است</p>';
        case "c":echo '<p class="alert alert-danger">پسوند فایل غیرمجاز است</p>';
    }
}