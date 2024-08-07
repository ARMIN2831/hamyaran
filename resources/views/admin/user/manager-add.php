<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">مدیران</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a > لفزودن مدیران/پشتیبانان</a>
                                </li>
                                <li class="breadcrumb-item active">ویرایش
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
                            if ($uri[3][0]=="admin" &&$manager->level=="مدیرکل" && $access['a'] && $access['b']){
                                require "manager-form-admin.php";
                            }

                            if ($uri[3][0]=="manager" && $manager->level=="مدیرکل" && $access['a']){
                                require "manager-form-manager.php";
                            }
                            if ($uri[3][0]=="supporter" && $manager->level==("مدیر"||"مدیرکل") && $access['a']){
                                require "manager-form-supporter.php";
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>