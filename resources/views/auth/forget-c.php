<?php
if (isset($post['submit']) && (isset($post['userName']) || isset($post['email']))){
    $form = get_form_data();
    $manager = new Manager($db);
    if (!empty(@$post['userName'])){
        unset($_SESSION['loginUserName']);
        $manager->set_object_from_sql(array("userName"=>$form['userName']));
        if (!$manager->ID){
            $error = 1;
            echo '<p class="alert alert-danger">کاربری با این نام کاربری یافت نشد.</p>';
        }
    }
    if (!empty(@$post['email'])){
        $manager->set_object_from_sql(array("email"=>$form['email']));
        if (!$manager->ID){
            $error = 1;
            echo '<p class="alert alert-danger">کاربری با این ایمیل کاربری یافت نشد.</p>';
        }
    }
    if (!@$error){
        if (!$manager->email){
            $error = 1;
            echo '<p class="alert alert-danger">ایمیلی برای شما ثبت نشده است. برای بازیابی رمز خود باید با مدیر سامانه ارتباط بگیرید.</p>';
        }
    }
    if (!@$error){
        $code = rand(10000,99999);
        $message='<h1>سامانه همیاران ملل</h1><br><font dir="rtl" size="6" face="b nazanin">
        <img src="'.siteAddress.'/view/img/logo.png" alt="همیاران ملل-RFP" width="150"><br><br>
        کد بازیابی رمز عبور شما:
        <br>
        '.$code.'<br>
        جهت حفظ امنیت حساب خود، این کد را در اختیار دیگران قرار ندهید.
        <br>
        <hr></font>
        <font dir="ltr" size="6" face="b nazanin">
        Your verification code:'.$code.'<br>
        To keep your account secure, do not share this code with others.
        <br>
        <a href="'.$_SERVER['REQUEST_SCHEME'].'://'.siteAddress.'/">سامانه همیاران ملل</a>
        <br>
        </font>
         ';

        $mail = new Email($db);
        $result = $mail->send($manager->email, "Forget Password", $message,1);
        if (!$result){
            echo '<p class="alert alert-success">ارسال کد بازیابی رمز به ایمیل شما با موفقیت انجام شد. در صورتی که ایمیل در صندوق ورودی شما یافت نشد، هرزنامه‌ها را نیز برسی نمایید و یا اندکی صبر کنید.</p>';
            $manager->save_one_value("lastLoginTime","Forget-password-".$code);
            $_SESSION['ForgetPasswordUserName'] = $manager->userName;
        }else{
            switch ($result){
                case "Canceled by timeLimit":
                echo '<p class="alert alert-warning">ایمیل بازیابی رمز ارسال نشد. زیرا شما به تازگی درخواست دریافت ایمیل بازیابی رمز ارسال کرده‌اید.</p>'; break;
                case "Invalid receiver email":
                echo '<p class="alert alert-danger">ایمیل شما نامعتبر است. جهت بازیابی رمز خود با مدیر سامانه ارتباط بگیرید.</p>'; break;
                case "Send email failed":
                echo '<p class="alert alert-danger">ارسال ایمیل با خطا مواجه شد. لطفا دقایقی بعد دوباره تلاش کنید و یا در صورت عدم رفع مشکل با مدیر سامانه ارتباط بگیرید.</p>'; break;
            }
        }
    }

}

?>