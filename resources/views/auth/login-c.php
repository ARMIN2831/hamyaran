<?php
if (isset($post['submit']) && isset($post['userName'])){
    $form = get_form_data();
    $manager = new Manager($db);

    if ($mid = $manager->login($form)){
        $_SESSION['mid'] = $mid;
        if ($post['rememberMe']){
            setcookie("mid-userName",$manager->userName,time()+2592000);
            setcookie("mid-password",$manager->password,time()+2592000);
        }
        if ($_SESSION['loginUserName']){unset($_SESSION['loginUserName']);}
        echo '<p class="alert alert-success">ورود به سامانه موفقیت‌آمیز بود.</p>';
        redirect("",1.5);
    }else{
        $_SESSION['loginUserName'] = $form['userName'];
        echo '<p class="alert alert-danger">نام کاربری یا رمز ورود اشتباه است.
              <br>
              <a class="ql-bg-yellow" href="'.baseDir.'/forget">جهت بازیابی رمز ورود کلیک نمایید</a>
              </p>';
    }

}

?>