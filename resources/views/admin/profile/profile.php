<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> پنل مدیریت </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> پروفایل </a>
                                </li>
                                <li class="breadcrumb-item active">ویرایش پروفایل کاربری
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic Inputs start -->
            <section id="basic-input">
                <?php
                if ($uri[2][0]=="edit"):
                    include "profile-edit.php";
                endif;
                ?>

                <?php
                if ($uri[2][0]=="change-password"):
                    include "profile-password.php";
                endif;
                ?>
                <div class="row">
                    <div class="col-sm-6 col-12 dashboard-users-success">
                        <a href="<?= baseDir ?>/profile/edit">
                            <div class="card text-center hover-shadow ">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                                            <i class="bx bx-edit font-medium-5"></i>
                                        </div>
                                        <h4 class="text-muted line-ellipsis">تغییر مشخصات من</h4>
                                        <p class="mb-0">ویرایش نام، ایمیل و تصویر پروفایل</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-12 dashboard-users-success">
                        <a href="<?= baseDir ?>/profile/change-password">
                            <div class="card text-center hover-shadow">
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto mb-50">
                                            <i class="bx bx-key font-medium-5"></i>
                                        </div>
                                        <h4 class="text-muted line-ellipsis">تغییر رمز ورود</h4>
                                        <p class="mb-0">ویرایش رمز ورود به سامانه</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </section>
        </div>
    </div>
</div>