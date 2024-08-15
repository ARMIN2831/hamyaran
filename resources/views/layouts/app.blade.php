
@include('layouts.header')
<body
    class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow content-left-sidebar chat-application navbar-sticky footer-static  "
    data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar">

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
                            <a class="dropdown-item" href="{{ route('logout') }}"><i
                                    class="bx bx-power-off mr-50"></i> خروج</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

@if ($errors->any())
    <div style="position: fixed; z-index: 10000; margin-right: 260px; margin-top: 15px; padding-right: 2.2rem;">
        <div id="error-alert">
            <div>
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger fade-in">{{ $error }}</div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        /* انیمیشن برای محو شدن خطاها */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        .fade-out {
            animation: fadeOut 1s ease-in-out;
            opacity: 0;
        }

        .alert {
            margin-bottom: 0;
            margin-top: 10px;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('#error-alert .alert').addClass('fade-out');
            }, 3000); // شروع انیمیشن محو شدن بعد از 3 ثانیه

            setTimeout(function () {
                $('#error-alert').remove(); // حذف کامل بعد از اتمام انیمیشن
            }, 4000); // 1 ثانیه زمان برای انیمیشن محو شدن
        });
    </script>
@endif

<!--<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">-->
<div class="main-menu menu-fixed menu-dark  menu-accordion menu-shadow" data-scroll-to-active="true"
     style="margin: 15px 15px 15px auto; border-radius: 1.5rem; height: calc(-30px + 100vh); touch-action: none; user-select: none;">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" onclick="reload()">
                    <div class="brand-logo"><img class="logo" src="{{ asset('public/img/logo.png') }}"/></div>
                    <h2 class="brand-text mb-0">همیاران ملل</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="bx bx-x d-block d-xl-none font-medium-4 white toggle-icon"></i><i
                        class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon white"
                        data-ticon="bx-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">

            <li class="nav-item"><a href="{{ env('APP_URL') }}/#"><i class="bx bx-pie-chart"></i><span
                        class="menu-title" data-i18n="Dashboard">گزارشات</span>
                </a>
                <ul class="menu-content">
                    <li><a href="{{ env('APP_URL') }}/chart/"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="eCommerce">نمودار دانشجویان</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/world-map/"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="eCommerce">توزیع پراکندگی</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/export/"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="eCommerce">گزارش‌گیری</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/report/"><i class="bx bx-right-arrow-alt"></i><span
                                class="menu-item" data-i18n="eCommerce">گزارشات سامانه</span></a></li>
                </ul>
            </li>
            <li class=" navigation-header"><span>دسترسی‌ها</span></li>
            <li class="nav-item"><a href="#"><i class="bx bxs-bulb"></i><span class="menu-title" data-i18n="Invoice">فعالیت‌های دانشجویان</span></a>
                <ul class="menu-content">
                    <li><a href="{{ env('APP_URL') }}/act/add"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">افزودن فعالیت</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/act/edit"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">ویرایش فعالیت‌ها</span></a></li>
                </ul>
            </li>

            <li class="nav-item"><a href="#"><i class="bx bxs-user"></i><span class="menu-title" data-i18n="Invoice">دانشجویان</span></a>
                <ul class="menu-content">
                    <li><a href="{{ route('students.create') }}"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">افزودن دانشجو</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/stu/excel"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">افزودن دانشجو از اکسل</span></a></li>
                    <li><a href="{{ route('students.index') }}"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">ویرایش دانشجویان</span></a></li>
                </ul>
            </li>

            <li class="nav-item"><a href="#"><i class="bx bxs-bank"></i><span class="menu-title" data-i18n="Invoice">موسسات</span></a>
                <ul class="menu-content">
                    <li><a href="{{ route('institutes.create') }}"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">افزودن موسسه</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/ins/excel"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">افزودن موسسه از اکسل</span></a></li>
                    <li><a href="{{ route('institutes.index') }}"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">ویرایش موسسات</span></a></li>
                </ul>
            </li>

            <li class="nav-item"><a href="#"><i class="bx bxs-group"></i><span class="menu-title" data-i18n="Invoice">کلاس‌ها</span></a>
                <ul class="menu-content">
                    <li><a href="{{ route('classrooms.create') }}"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">افزودن کلاس</span></a></li>
                    <li><a href="{{ route('classrooms.index') }}"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">ویرایش کلاس</span></a></li>
                </ul>
            </li>

            <li class="nav-item"><a href="#"><i class="bx bxs-book"></i><span class="menu-title" data-i18n="Invoice">دوره‌ها</span></a>
                <ul class="menu-content">
                    <li><a href="{{ route('courses.create') }}"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">افزودن دوره</span></a></li>
                    <li><a href="{{ route('courses.index') }}"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">ویرایش دوره</span></a></li>
                </ul>
            </li>

            <li class="nav-item"><a href="#"><i class="bx bxs-school"></i><span class="menu-title" data-i18n="Invoice">مجتمع‌ها</span></a>
                <ul class="menu-content">
                    <li><a href="{{ route('convenes.create') }}"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">افزودن مجتمع</span></a></li>
                    <li><a href="{{ route('convenes.index') }}"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">ویرایش مجتمع</span></a></li>
                </ul>
            </li>

            <li class="nav-item"><a href="#"><i class="bx bx-user-plus"></i><span class="menu-title"
                                                                                  data-i18n="Invoice">مدیریت کاربران</span></a>
                <ul class="menu-content">

                    <li><a href="{{ route('users.create') }}"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">افزودن کاربر</span></a></li>

                    <li class="nav-item"><a href="{{ route('users.index') }}"><i class="bx bx-user-check"></i><span
                                class="menu-title" data-i18n="Chat">ویرایش مدیر/پشتیبان</span></a>
                    </li>
                </ul>
            </li>


            <li class="nav-item"><a href="#"><i class="bx bx-user-plus"></i><span class="menu-title" data-i18n="Invoice">مدیریت نقش ها</span></a>
                <ul class="menu-content">

                    <li><a href="{{ route('roles.create') }}"><i class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">افزودن نقش</span></a></li>

                    <li class="nav-item"><a href="{{ route('roles.index') }}"><i class="bx bx-user-check"></i><span class="menu-title" data-i18n="Chat">ویرایش نقش</span></a>
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
                    <li><a href="{{ env('APP_URL') }}/ticket/add/"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">ایجاد تیکت</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/ticket/"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">مشاهده پیام‌ها</span></a></li>
                    <li><a href="'.baseDir.'/ticket-manage/"><i class="bx bx-left-arrow-alt"></i><span class="menu-item"
                                                                                                       data-i18n="Invoice List">مدیریت تیکت‌ها</span></a>
                    </li>
                </ul>
            </li>
            <li class="nav-item"><a href="#"><i class="bx bx-user-circle"></i><span class="menu-title"
                                                                                    data-i18n="Invoice">پروفایل کاربر</span></a>
                <ul class="menu-content">
                    <li><a href="{{ env('APP_URL') }}/profile/edit/"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">ویرایش مشخصات</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/profile/change-password/"><i
                                class="bx bx-left-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">تغییر رمز ورود</span></a>
                    </li>
                </ul>
            </li>

            <li class="nav-item"><a href="#"><i class="bx bxs-wrench"></i><span class="menu-title" data-i18n="Invoice">تنظیمات سامانه</span></a>
                <ul class="menu-content">
                    <li><a href="{{ env('APP_URL') }}/setting/db/"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">پایگاه داده</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/setting/setdata/"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">ورودی اطلاعات</span></a></li>
                    <li><a href="{{ env('APP_URL') }}/setting/email/"><i class="bx bx-left-arrow-alt"></i><span
                                class="menu-item" data-i18n="Invoice List">ایمیل</span></a></li>
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

@include('layouts.footer')
