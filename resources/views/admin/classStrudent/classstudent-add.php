<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> کلاس‌ها </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> مدیریت اعضای کلاس‌ها </a>
                                </li>
                                <li class="breadcrumb-item active">افزودن دانشجو
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card px-2">
                            <?php
                            if ($access['j']) {
                                require "classstudent-form.php";
                            }
                            else{
                                echo '<p class="alert alert-danger">شما دسترسی مدیریت اعضای کلاس را ندارید.
                                <br> <a class="btn btn-primary" onclick="go_back()">بازگشت</a>
                                </p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>