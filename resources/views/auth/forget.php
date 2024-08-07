<!DOCTYPE html>
<html lang="fa">
<head>
    <?php
    require "meta.php";
    ?>
    <link rel="apple-touch-icon" href="images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="images/ico/favicon.ico">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="vendors/css/extensions/dragula.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="css-rtl/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css-rtl/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="css-rtl/colors.css">
    <link rel="stylesheet" type="text/css" href="css-rtl/components.css">
    <link rel="stylesheet" type="text/css" href="css-rtl/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="css-rtl/themes/semi-dark-layout.css">
    <link rel="stylesheet" type="text/css" href="css-rtl/custom-rtl.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="css-rtl/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="css-rtl/pages/dashboard-analytics.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="css/style-rtl.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- END: Custom CSS-->
</head>

<body class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body login-bg">
            <!-- login page start -->
            <section id="auth-login" class="row flexbox-container">
                <div class="col-md-4 col-12 px-0">
                    <div class="card bg-authentication mb-0 opacity-low">
                        <div class="row m-0">
                            <!-- left section-login -->
                            <div class="col-12 px-0">
                                <div class="bg-none card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="text-center mb-2 white">فراموشی رمز ورود</h4>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="divider">
                                                <div class="divider-text text-uppercase text-muted bg-primary border-white">
                                                    <small class="white">
                                                        بازیابی رمز ورود - سامانه همیاران ملل
                                                    </small>
                                                </div>
                                            </div>
                                            <?php
                                            require "forget-c.php";
                                            if ($_SESSION['loginUserName']){
                                                @$form['userName'] = $_SESSION['loginUserName'];
                                            }
                                            if (isset($_SESSION['ForgetPasswordUserName'])):
                                                if ($uri[1][1]=="out"){
                                                    unset($_SESSION['ForgetPasswordUserName']);
                                                    unset($_SESSION['ForgetPasswordID']);
                                                    redirect("login");
                                                }
                                                if (isset($post['changePassword']) && isset($_SESSION['ForgetPasswordID'])){
                                                    if (strlen($post['password']) > 0){
                                                        $manager = new Manager($db);
                                                        $manager->set_object_byID($_SESSION['ForgetPasswordID']);
                                                        $manager->set_new_password($post['password']);
                                                        echo '<p class="alert alert-success">رمز شما با موفقیت تغییر یافت</p>';
                                                        unset($_SESSION['ForgetPasswordUserName']);
                                                        unset($_SESSION['ForgetPasswordID']);
                                                        $_SESSION['mid'] = $manager->ID;
                                                        redirect("",1);
                                                    }else{
                                                        echo '<p class="alert alert-danger">رمز عبور نمی‌تواند خالی باشد.</p>';
                                                    }
                                                }
                                                if (isset($post['code'])){
                                                    $manager = new Manager($db);
                                                    $manager->set_object_from_sql(array("userName"=>$_SESSION['ForgetPasswordUserName']));
                                                    if ($manager->lastLoginTime == "Forget-password-".$post['code']){
                                                        $changePassword = 1;
                                                        $_SESSION['ForgetPasswordID'] = $manager->ID;
                                                        echo '
                                                        <form method="post">
                                                            <p class="blockElement"> رمز جدید خود را وارد نمایید</p>
                                                            <div class="form-group mb-50">
                                                                <label class="text-bold-600 white" for="userName"> نام کاربری:</label>
                                                                <input type="text" name="userName" class="form-control dir-ltr" id="userName" value="'.$manager->userName.'" readonly>
                                                            </div>
                                                            <div class="form-group mb-50">
                                                                <label class="text-bold-600 white" for="code"> رمز جدید:</label>
                                                                <input type="password" name="password" class="form-control dir-ltr" id="password" placeholder="رمز جدید" required>
                                                            </div>
                                                            <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center"></div><br>
                                                            <button type="submit" name="changePassword" class="btn btn-primary glow w-100 position-relative">تایید<i id="icon-arrow" class="bx bx-lock"></i></button>
                                                            <hr>
                                                            <div class="text-center"><a href="'.baseDir.'/forget?out"><small class="white-link"f>انصراف</small></a></div>
                                                        </form>
                                                        ';
                                                    }else{
                                                        echo '<p class="alert alert-danger">کد وارد شده صحیح نمی‌باشد.</p>';
                                                    }
                                                }
                                                if (!@$changePassword):
                                            ?>
                                                <form method="post" autocomplete="off">
                                                    <p class="blockElement white">کد بازیابی رمز خود را وارد نمایید</p>
                                                    <div class="form-group mb-50">
                                                        <label class="text-bold-600 white" for="code">کد بازیابی رمز:</label>
                                                        <input type="text" name="code" class="form-control dir-ltr" id="code"placeholder="*****">
                                                    </div>

                                                    <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center"></div><br>
                                                    <button type="submit" name="submit" class="btn btn-primary glow w-100 position-relative">تایید<i id="icon-arrow" class="bx bx-lock"></i></button>
                                                    <hr>
                                                    <div class="text-center"><a href="<?=baseDir?>/forget?out"><small class="white-link">انصراف</small></a></div>
                                                </form>
                                            <?php
                                                endif;
                                            else:
                                            ?>
                                            <form method="post">
                                                <p class="blockElement white">نام کاربری یا ایمیل را وارد نمایید.</p>
                                                <div class="form-group mb-50" id="userNameBlock" onchange="setUsername()">
                                                    <label class="text-bold-600 white" for="userName">نام کاربری:</label>
                                                    <input type="text" name="userName" class="form-control dir-ltr" value="<?=@$form['userName']?>" id="userName" placeholder="username">
                                                </div>
                                                <div class="form-group mb-50" id="emailBlock" onchange="setEmail()">
                                                    <label class="text-bold-600 white" for="email">ایمیل:</label>
                                                    <input type="email" name="email" class="form-control dir-ltr" id="email" placeholder="email">
                                                </div>

                                                <script>
                                                    function setUsername() {
                                                        var userName = document.getElementById("userName");
                                                        if (userName.value.length>0){
                                                            document.getElementById("emailBlock").style.transition="1.2s";
                                                            document.getElementById("emailBlock").style.opacity = "0";
                                                            document.getElementById("emailBlock").style.visibility = "hidden";
                                                        }else {
                                                            document.getElementById("emailBlock").style.opacity = "1";
                                                            document.getElementById("emailBlock").style.visibility="visible";
                                                        }
                                                    }
                                                    function setEmail() {
                                                        var userName = document.getElementById("email");
                                                        if (userName.value.length>0){
                                                            document.getElementById("userNameBlock").style.transition="1.2s";
                                                            document.getElementById("userNameBlock").style.opacity = "0";
                                                            document.getElementById("userNameBlock").style.visibility = "hidden";
                                                        }else {
                                                            document.getElementById("userNameBlock").style.opacity = "1";
                                                            document.getElementById("userNameBlock").style.visibility="visible";
                                                        }
                                                    }
                                                    setUsername();

                                                </script>
                                                <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center"></div><br>
                                                <button type="submit" name="submit" class="btn btn-primary glow w-100 position-relative">بازیابی رمز<i id="icon-arrow" class="bx bx-lock"></i></button>
                                                <hr>
                                                <div class="text-center"><a href="<?=baseDir?>/login"><small class="white-link">ورود به سامانه</small></a></div>
                                            </form>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!-- login page ends -->

        </div>
    </div>
</div>
<!-- END: Content-->

<?php
require "footer.php";
?>

</body>
<!-- END: Body-->
</html>