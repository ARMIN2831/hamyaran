<?php
if (!$access['q']) {redirect(""); exit();}
?>
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> مدیریت </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> تنظیمات سامانه </a>
                                </li>
                                <li class="breadcrumb-item active">تنظیمات ایمیل
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
                            <form method="post">
                                <div class="card-header">
                                    <h4 class="card-title">تنظیمات ارسال ایمیل (SMTP):</h4>
                                </div>
                                <div class="row">
                                    <?php
                                    $setting = new Setting($db);
                                    $settings = $setting->get_object_data(['type'=>'email']);

                                    if ($post['submit']){
                                        $form = get_form_data_html();
                                        unset($form['submit']);
                                        foreach ($form as $item=>$value){
                                            $row = search_2D_array('name',$item,$settings);
                                            $setting->set_vars_from_array($row);
                                            $setting->value = $value;
                                            $setting->save_object_data();
                                        }

                                        echo '
                                        <div class="col-md-12">
                                            <p class="alert alert-success">ثبت اطلاعات انجام شد.</p>
                                        </div>';
                                        $settings = $setting->get_object_data(['type'=>'email']);
                                    }

                                    foreach ($settings as list('name'=>$name,'value'=>$value)){
                                        echo '
                                        <div class="col-md-6">
                                            <fieldset class="form-group">
                                                <label for="'.$name.'"> '.$name.' </label>
                                                <input type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'" class="form-control">
                                            </fieldset>
                                        </div>';
                                    }
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <input type="submit" name="submit" value="تایید" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>