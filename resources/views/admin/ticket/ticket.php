<div class="app-content content">
    <div class="content-area-wrapper">
        <div class="sidebar-left">
            <div class="sidebar">
                <!-- app chat user profile left sidebar start -->
                <div class="chat-user-profile">
                    <header class="chat-user-profile-header text-center border-bottom">
                            <span class="chat-profile-close">
                                <i class="bx bx-x"></i>
                            </span>
                        <div class="my-2">
                            <div class="avatar">
                                <img src="<?= ($manager->image ? $manager->image : "img/profile.png") ?>" alt="user_avatar" height="100" width="100">
                            </div>
                            <h5 class="mb-0"><?=$manager->name?></h5>
                            <span><?=$manager->level?></span>
                        </div>
                    </header>
                    <div class="chat-user-profile-content">
                        <div class="chat-user-profile-scroll">

                            <h6 class="text-uppercase mb-1">فعالیت‌ها</h6>
                            <ul class="list-unstyled">
                                <li class="mb-50 "><a href="javascript:void();" onclick="add_chat_form()" class="d-flex align-items-center">
                                        <i class="bx bx-add-to-queue mr-50"></i>ایجاد تیکت جدید</a></li>
                                <li class="mb-50 "><a href="<?=baseDir?>/ticket/" class="d-flex align-items-center">
                                        <i class="bx bx-loader mr-50"></i>بروزرسانی لیست تیکت‌ها</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- app chat user profile left sidebar ends -->
                <!-- app chat sidebar start -->
                <div class="chat-sidebar card">
                        <span class="chat-sidebar-close">
                            <i class="bx bx-x"></i>
                        </span>
                    <div class="chat-sidebar-search">
                        <div class="d-flex align-items-center">
                            <div class="chat-sidebar-profile-toggle">
                                <div class="avatar">
                                    <img src="<?= ($manager->image && file_exists('view/'.$manager->image) ? $manager->image : "img/profile.png") ?>" alt="user_avatar" height="36" width="36">
                                </div>
                            </div>
                            <fieldset class="form-group position-relative has-icon-left mx-75 mb-0">
                                <input type="text" class="form-control round" id="chat-search" placeholder="Search">
                                <div class="form-control-position">
                                    <i class="bx bx-search-alt text-dark"></i>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="chat-sidebar-list-wrapper pt-0">
                        <?php
                        $chatBy = new Manager($db);
                        $chatByItems = $chatBy->get_object_data();

                        $tkt = new Ticket($db);
                        $tkt->chat1 = $manager->ID;
                        $tkts = $tkt ->get_tickets();
                        ?>
                        <h6 class="px-2 pt-2 pb-25 mb-0">تیکت‌های من</h6>
                        <ul class="chat-sidebar-list">
                            <?php
                            foreach ($tkts[0] as $item){
                                $tkt->set_vars_from_array($item);
                                $chatBy->set_vars_from_array(search_2D_array('ID',$tkt->chat2,$chatByItems));
                                echo '
                                <a href="'.baseDir.'/ticket/'.$tkt->ID.'/#end_chat">
                                <li>
                                <div class="d-flex align-items-center">
                                    <div class="avatar m-0 mr-50"><img src="'.($chatBy->image ? $chatBy->image : "img/profile.png").'" height="36" width="36" alt="sidebar user image">
                                        <span class="avatar-status-online"></span>
                                    </div>
                                    <div class="chat-sidebar-name">
                                        <h6 class="mb-0">'.$tkt->title.'</h6>
                                        <span class="text-muted">'.$chatBy->name.'</span>
                                    </div>
                                </div>
                                </li>
                                </a>';
                            }
                            ?>
                        </ul>
                        <h6 class="px-2 pt-2 pb-25 mb-0">پاسخگویی من</h6>
                        <ul class="chat-sidebar-list">
                            <?php
                            foreach ($tkts[1] as $item){
                                $tkt->set_vars_from_array($item);
                                $chatBy->set_vars_from_array(search_2D_array('ID',$tkt->chat1,$chatByItems));
                                echo '
                                <a href="'.baseDir.'/ticket/'.$tkt->ID.'/#end_chat">
                                <li>
                                <div class="d-flex align-items-center">
                                    <div class="avatar m-0 mr-50"><img src="'.($chatBy->image ? $chatBy->image : "img/profile.png").'" height="36" width="36" alt="sidebar user image">
                                        <span class="avatar-status-away"></span>
                                    </div>
                                    <div class="chat-sidebar-name">
                                        <h6 class="mb-0">'.$tkt->title.'</h6>
                                        <span class="text-muted">'.$chatBy->name.'</span>
                                    </div>
                                </div>
                                </li>
                                </a>';
                            }
                            ?>
                        </ul>
                        <h6 class="px-2 pt-2 pb-25 mb-0">تیکت‌های بسته شده</h6>
                        <ul class="chat-sidebar-list">
                            <?php
                            foreach ($tkts[2] as $item){
                                $tkt->set_vars_from_array($item);
                                if ($tkt->chat1 == $manager->ID){
                                    $chatBy->set_object_byID($tkt->chat2);
                                }else{
                                    $chatBy->set_object_byID($tkt->chat1);
                                }
                                echo '
                                <a href="'.baseDir.'/ticket/'.$tkt->ID.'/#end_chat">
                                <li>
                                <div class="d-flex align-items-center">
                                    <div class="avatar m-0 mr-50"><img src="'.($chatBy->image ? $chatBy->image : "img/profile.png").'" height="36" width="36" alt="sidebar user image">
                                        <span class="avatar-status-offline"></span>
                                    </div>
                                    <div class="chat-sidebar-name">
                                        <h6 class="mb-0">'.$tkt->title.'</h6>
                                        <span class="text-muted">'.$chatBy->name.'</span>
                                    </div>
                                </div>
                                </li>
                                </a>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <!-- app chat sidebar ends -->
            </div>
        </div>
        <div class="content-right bg-white">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <!-- app chat overlay -->
                    <div class="chat-overlay"></div>
                    <?php
                    include "ticket-show.php";
                    include "ticket-add.php";
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>