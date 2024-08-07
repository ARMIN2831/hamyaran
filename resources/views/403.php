<!DOCTYPE html>
<html lang="fa">
<head>
    <?php
    require "meta.php";
    include "login-check.php";
    ?>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="vendors/css/vendors-rtl.min.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="vendors/css/charts/apexcharts.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="vendors/css/extensions/dragula.min.css?<?=siteVersion?>">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="css-rtl/bootstrap.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="css-rtl/bootstrap-extended.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="css-rtl/colors.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="css-rtl/components.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="css-rtl/themes/dark-layout.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="css-rtl/themes/semi-dark-layout.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="css-rtl/select2.min.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="css-rtl/custom-rtl.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="css-rtl/pages/app-chat.css?<?=siteVersion?>">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="css-rtl/core/menu/menu-types/vertical-menu.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="css-rtl/pages/dashboard-analytics.css?<?=siteVersion?>">
    <link rel="stylesheet" type="text/css" href="vendors/css/tables/datatable/datatables.min.css?<?=siteVersion?>">
    <!-- END: Page CSS-->
    <link rel="stylesheet" href="css/jalali-input/js-persian-cal.css">


    <link rel="stylesheet" type="text/css" href="css-rtl/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="css-rtl/pages/app-chat.css">

    <script src="js/world-map.js"></script>
    <link href="css/world-map.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="style.css?<?=siteVersion?>">
    <script src="js/scripts/jalali-input/js-persian-cal.min.js" type="text/javascript"></script>
</head>

<body class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow content-left-sidebar chat-application navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar">

<!-- BEGIN: Header-->
<div class="header-navbar-shadow"></div>

<div class="app-content mx-auto">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- error 404 -->
            <section class="row flexbox-container  text-center">
                <div class="col-12">
                    <div class="card bg-transparent shadow-none">
                        <div class="card-content">
                            <div class="card-body text-center bg-transparent miscellaneous">
                                <h1 class="error-title">دسترسی غیر مجاز !!!</h1>
                                <img class="img-fluid" src="img/500.png" alt="404 error">
                                <a href="<?=baseDir?>/" class="btn btn-primary round glow mt-3">بازگشت به خانه</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- error 404 end -->
        </div>
    </div>
</div>


<?php
require "footer.php";
?>
</body>

</html>