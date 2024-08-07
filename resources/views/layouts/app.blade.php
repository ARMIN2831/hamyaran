<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('public/img/favicon.ico') }}" type="image/x-icon">
    <meta name="title" content="{{ config('app.name', 'Laravel') }}">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Language" content="fa">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="language" content="fa">
    <script src="https://www.google.com/recaptcha/api.js?render=6Lf60MocAAAAALwypX7On5EBN8IzM0OUKllcrm5n"></script>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/img/favicon.ico') }}">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vendors/css/vendors-rtl.min.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vendors/css/charts/apexcharts.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vendors/css/extensions/dragula.min.css?v1.2.8') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/bootstrap.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/bootstrap-extended.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/colors.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/components.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/themes/dark-layout.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/themes/semi-dark-layout.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/select2.min.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/custom-rtl.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/pages/app-chat.css?v1.2.8') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/core/menu/menu-types/vertical-menu.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/pages/dashboard-analytics.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/vendors/css/tables/datatable/datatables.min.css?v1.2.8') }}">
    <!-- END: Page CSS-->
    <link rel="stylesheet" href="{{ asset('public/css/jalali-input/js-persian-cal.css?v1.2.8') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/core/menu/menu-types/vertical-menu.css?v1.2.8') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css-rtl/pages/app-chat.?v1.2.8') }}">

    <script src="{{ asset('public/js/world-map.js?v1.2.8') }}"></script>
    <link href="{{ asset('public/css/world-map.css?v1.2.8') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('public/style.css?v1.2.8') }}">
    <script src="{{ asset('public/js/scripts/jalali-input/js-persian-cal.min.js?v1.2.8') }}" type="text/javascript"></script>

</head>

<body class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow content-left-sidebar chat-application navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar">

<!-- BEGIN: Header-->
<div class="header-navbar-shadow"></div>
<!-- END: Header-->

<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ficon bx bx-menu"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{ env('APP_URL') }}/ticket/"
                                                                  data-toggle="tooltip" data-placement="top"
                                                                  title="پیام‌ها"><i class="ficon bx bx-chat"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <ul class="nav navbar-nav float-right">

                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                class="ficon bx bx-fullscreen"></i></a></li>

                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" data-toggle="dropdown">

                            <div class="user-nav d-sm-flex d-none"><span
                                    class="user-name">armin eslami</span><span
                                    class="user-status text-muted">modir</span>
                            </div>
                            <span>
                                <img class="round"
                                     src="{{ asset('public/img/profile.png') }}"
                                     alt="پروفایل شما" height="40" width="40"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pb-0">
                            <a class="dropdown-item" href="{{ env('APP_URL') }}/profile">
                                <i class="bx bx-user mr-50"></i> ویرایش پروفایل </a>
                            <a class="dropdown-item" href="{{ env('APP_URL') }}/ticket">
                                <i class="bx bx-envelope mr-50"></i> پیام‌های من</a>
                            <div class="dropdown-divider mb-0"></div>
                            <a class="dropdown-item" onclick="logout({{ env('APP_URL') }})"><i
                                    class="bx bx-power-off mr-50"></i> خروج</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>


<!--<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">-->
<div class="main-menu menu-fixed menu-dark  menu-accordion menu-shadow" data-scroll-to-active="true" style="margin: 15px 15px 15px auto; border-radius: 1.5rem; height: calc(-30px + 100vh); touch-action: none; user-select: none;">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" onclick="reload()">
                    <div class="brand-logo"><img class="logo" src="{{ asset('public/img/logo.png') }}" /></div>
                    <h2 class="brand-text mb-0">همیاران ملل</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 white toggle-icon"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon white" data-ticon="bx-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">

                <li class="nav-item"><a href="{{ env('APP_URL') }}/#"><i class="bx bx-pie-chart"></i><span class="menu-title" data-i18n="Dashboard">گزارشات</span>
                    </a>
                    <ul class="menu-content">
                        <li><a href="{{ env('APP_URL') }}/chart/"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="eCommerce">نمودار دانشجویان</span></a></li>
                        <li><a href="{{ env('APP_URL') }}/world-map/"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="eCommerce">توزیع پراکندگی</span></a></li>
                        <li><a href="{{ env('APP_URL') }}/export/"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="eCommerce">گزارش‌گیری</span></a></li>
                        <li><a href="{{ env('APP_URL') }}/report/"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="eCommerce">گزارشات سامانه</span></a></li>
                    </ul>
                </li>
            <li class=" navigation-header"><span>دسترسی‌ها</span></li>
                    <li class="nav-item"><a href="#"><i class="bx bxs-bulb"></i><span class="menu-title" data-i18n="Invoice">فعالیت‌های دانشجویان</span></a>
                        <ul class="menu-content">
                            <li><a href="{{ env('APP_URL') }}/act/add"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن فعالیت</span></a></li>
                            <li><a href="{{ env('APP_URL') }}/act/edit"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">ویرایش فعالیت‌ها</span></a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a href="#"><i class="bx bxs-user"></i><span class="menu-title" data-i18n="Invoice">دانشجویان</span></a>
                        <ul class="menu-content">
                    <li><a href="{{ env('APP_URL') }}/stu/add"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن دانشجو</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/stu/excel"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن دانشجو از اکسل</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/stu/edit"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">ویرایش دانشجویان</span></a></li>
                    </ul>
                    </li>

                    <li class="nav-item"><a href="#"><i class="bx bxs-bank"></i><span class="menu-title" data-i18n="Invoice">موسسات</span></a>
                        <ul class="menu-content">
                            <li><a href="{{ env('APP_URL') }}/ins/add"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن موسسه</span></a></li>
                            <li><a href="{{ env('APP_URL') }}/ins/excel"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن موسسه از اکسل</span></a></li>
                            <li><a href="{{ env('APP_URL') }}/ins/edit"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">ویرایش موسسات</span></a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a href="#"><i class="bx bxs-group"></i><span class="menu-title" data-i18n="Invoice">کلاس‌ها</span></a>
                        <ul class="menu-content">
                            <li><a href="{{ env('APP_URL') }}/teachClass/add"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن کلاس</span></a></li>
                            <li><a href="{{ env('APP_URL') }}/teachClass/edit"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">ویرایش کلاس</span></a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a href="#"><i class="bx bxs-book"></i><span class="menu-title" data-i18n="Invoice">دوره‌ها</span></a>
                        <ul class="menu-content">
                            <li><a href="{{ env('APP_URL') }}/course/add"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن دوره</span></a></li>
                            <li><a href="{{ env('APP_URL') }}/course/edit"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">ویرایش دوره</span></a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a href="#"><i class="bx bxs-school"></i><span class="menu-title" data-i18n="Invoice">مجتمع‌ها</span></a>
                        <ul class="menu-content">
                            <li><a href="{{ env('APP_URL') }}/convene/add"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن مجتمع</span></a></li>
                            <li><a href="{{ env('APP_URL') }}/convene/edit"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">ویرایش مجتمع</span></a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a href="#"><i class="bx bx-user-plus"></i><span class="menu-title" data-i18n="Invoice">مدیریت کاربران</span></a>
                        <ul class="menu-content">

                        <li><a href="{{ env('APP_URL') }}/manager/add/admin"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن مدیرکل</span></a></li>
                            <li><a href="{{ env('APP_URL') }}/manager/add/manager"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن مدیر</span></a></li>
                            <li><a href="{{ env('APP_URL') }}/manager/add/supporter"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن پشتیبان</span></a></li>
                            <li><a href="{{ env('APP_URL') }}/manager/add/supporter"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن پشتیبان</span></a></li>

                        <li class="nav-item"><a href="'.baseDir.'/manager/edit"><i class="bx bx-user-check"></i><span class="menu-title" data-i18n="Chat">ویرایش مدیر/پشتیبان</span></a>
                        </li>
                    </ul>
                    </li>

            <li class=" navigation-header"><span>امکانات</span></li>
            <li class="nav-item"><a href="#"><i class="bx bxs-chat"></i><span class="menu-title" data-i18n="Invoice">تیکت‌های پشتیبانی</span>
                    <?php
                    //$ticket = new Ticket($db);
                    //$newTicket = $ticket->count_open_ticket($manager->ID);
                    //if ($newTicket) {
                    //    echo '<span class="badge badge-primary badge-pill badge-round float-right mr-2">' . $newTicket . '</span>';
                    //}
                    ?>
                </a>
                <ul class="menu-content">
                    <li><a href="{{ env('APP_URL') }}/ticket/add/"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">ایجاد تیکت</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/ticket/"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">مشاهده پیام‌ها</span></a></li>
                    <li><a href="'.baseDir.'/ticket-manage/"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">مدیریت تیکت‌ها</span></a></li>
                </ul>
            </li>
            <li class="nav-item"><a href="#"><i class="bx bx-user-circle"></i><span class="menu-title" data-i18n="Invoice">پروفایل کاربر</span></a>
                <ul class="menu-content">
                    <li><a href="{{ env('APP_URL') }}/profile/edit/"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">ویرایش مشخصات</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/profile/change-password/"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">تغییر رمز ورود</span></a></li>
                </ul>
            </li>

            <li class="nav-item"><a href="#"><i class="bx bxs-wrench"></i><span class="menu-title" data-i18n="Invoice">تنظیمات سامانه</span></a>
                <ul class="menu-content">
                    <li><a href="{{ env('APP_URL') }}/setting/db/"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">پایگاه داده</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/setting/setdata/"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">ورودی اطلاعات</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/setting/email/"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">ایمیل</span></a></li>
                </ul>
            </li>

        </ul>
    </div>
</div>


<main>
    @yield('content')
</main>

<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0"><span class="float-left d-inline-block">
            2021-<script>var d = new Date();
                document.write(d.getFullYear());
            </script>
            &copy; سامانه‌ی همیاران </span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>
    </p>
</footer>


<script src="{{ asset('public/vendors/js/vendors.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/fonts/LivIconsEvo/js/LivIconsEvo.tools.js?v1.2.8') }}"></script>
<script src="{{ asset('public/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js?v1.2.8') }}"></script>
<script src="{{ asset('public/fonts/LivIconsEvo/js/LivIconsEvo.min.js?v1.2.8') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('public/vendors/js/charts/apexcharts.min.js?v1.2.8') }}"></script>

<script src="{{ asset('public/vendors/js/extensions/dragula.min.js?v1.2.8') }}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('public/js/core/app-menu.js?v1.2.8') }}"></script>
<script src="{{ asset('public/js/core/app.js?v1.2.8') }}"></script>
<script src="{{ asset('public/js/scripts/components.js?v1.2.8') }}"></script>
<script src="{{ asset('public/js/scripts/footer.js?v1.2.8') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ asset('public/js/scripts/datatables/datatable.js?v1.2.8') }}"></script>
<script src="{{ asset('public/js/scripts/pages/app-chat.js?v1.2.8') }}"></script>

<script src="{{ asset('public/js/scripts/pages/dashboard-analytics.js?v1.2.8') }}"></script>
<script src="{{ asset('public/main.js?v1.2.8') }}"></script>


<!-- END: Page JS-->


<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('public/vendors/js/tables/datatable/datatables.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/dataTables.bootstrap4.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/dataTables.buttons.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/buttons.html5.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/buttons.print.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/buttons.bootstrap.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/pdfmake.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/tables/datatable/vfs_fonts.js?v1.2.8') }}"></script>
<!-- END: Page Vendor JS-->

<script src="{{ asset('public/js/scripts/select2.full.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/js/scripts/form-select2.min.js?v1.2.8') }}"></script>


<script src="{{ asset('public/vendors/js/charts/chart.min.js?v1.2.8') }}"></script>
<script src="{{ asset('public/vendors/js/charts/chart-chartjs.js?v1.2.8') }}"></script>



</body>

</html>
