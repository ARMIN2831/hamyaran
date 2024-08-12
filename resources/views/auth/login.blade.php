@include('layouts.header')
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
                                            <h4 class="text-center mb-2 white">ورود به سامانه</h4>
                                        </div>
                                    </div>
                                    @if(session('failed'))
                                        <div style="margin-top: 20px;margin-bottom: 0" class="alert alert-danger">
                                            {{ session('failed') }}
                                        </div>
                                    @endif
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="divider">
                                                <div class="divider-text text-uppercase text-muted bg-primary border-white">
                                                    <small class="white">
                                                        ورود به سامانه همیاران ملل
                                                    </small>
                                                </div>
                                            <form action="{{ route('loginIndex') }}" method="post">
                                                @csrf
                                                <div class="form-group mb-50">
                                                    <label class="text-bold-600 white" for="userName">نام کاربری </label>
                                                    <input type="text" name="username" class="form-control dir-ltr" id="userName" placeholder="username" required></div>
                                                <div class="form-group">
                                                    <label class="text-bold-600 white" for="password">رمز ورود </label>
                                                    <input type="password" name="password" class="form-control dir-ltr" id="password" placeholder="Password" required>
                                                </div>
                                                <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                                    <div class="text-left">
                                                        <div class="checkbox checkbox-sm">
                                                            <input type="checkbox" name="rememberMe" class="form-check-input" id="exampleCheck1">
                                                            <label class="checkboxsmall" for="exampleCheck1">
                                                                <small class="white-link">مرا به خاطر بسپار!</small>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="text-right"><a href="" class="card-link white-link"><small>فراموشی رمز ورود</small></a></div>
                                                </div>
                                                <button type="submit" name="submit" class="btn btn-primary glow w-100 position-relative white-link">ورود<i id="icon-arrow" class="bx bx-left-arrow-alt"></i></button>
                                            </form>
                                            <hr>
                                            <div class="text-center"><small class="mr-25 white">برای ورود به سامانه مشکل دارید؟</small><a href="" class="white-link"><small>بازیابی رمز ورود</small></a></div>
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
@include('layouts.footer')
