<?php
if (@$_SESSION['mid'] > "0"){
    $manager = new Manager($db);
    $manager->set_object_byID($_SESSION['mid']);
}
if (@$_COOKIE['mid-userName'] && @$_COOKIE['mid-password'] && !isset($_SESSION['mid'])){
    $manager = new Manager($db);
    if ($manager->login_by_cookie($_COOKIE['mid-userName'],$_COOKIE['mid-password'])){
        $_SESSION['mid'] = $manager->ID;
        setcookie("mid-userName",$manager->userName,time()+2592000);
        setcookie("mid-password",$manager->password,time()+2592000);
        if ($_SESSION['loginUserName']){unset($_SESSION['loginUserName']);}
    }else{
        setcookie("mid-userName","",0);
        setcookie("mid-password","",0);
    }
}
if (!@$manager->ID && !($uri[1][0]=="login"||$uri[1][0]=="forget")){redirect("login");}
if (@$manager->ID && $uri[1][0]=="login"){redirect("");}


if (!$manager->userName && !($uri[1][0]=="login"||$uri[1][0]=="forget")){
    $manager->logout();
    redirect("login");
}
$access = json_decode($manager->access,1);
//var_dump($manager);

//$manager = new Manager($db);
//$manager->set_object_byID(4);
//exit();

?>