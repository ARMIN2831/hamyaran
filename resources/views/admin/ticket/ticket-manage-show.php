<?php
$ticketID = (int)$uri[2][0];
?>
<section class="chat-window-wrapper" id="show_chat">
    <?php if (!$ticketID): ?>
    <div class="chat-start">
        <span class="bx bx-message chat-sidebar-toggle chat-start-icon font-large-3 p-3 mb-1"></span>
        <h4 class="d-none d-lg-block py-50 text-bold-500">یک گفت‌وگو را انتخاب نمایید!</h4>
        <button class="btn btn-light-primary chat-start-text chat-sidebar-toggle d-block d-lg-none py-50 px-1">Start
            Conversation!</button>
    </div>
    <?php else:

        $tkt->clear_object_vars();
        $tkt->set_object_byID($ticketID);

        if (!$tkt->ID) {
            redirect("ticket-manage/");
            exit();
        }

        $chatBy->set_object_byID($tkt->chat1);
        $chatBy2->set_object_byID($tkt->chat2);
    ?>
    <div class="chat-area">
        <div class="chat-header">
            <header class="d-flex justify-content-between align-items-center border-bottom px-1 py-75">
                <div class="d-flex align-items-center">
                    <div class="chat-sidebar-toggle d-block d-lg-none mr-1"><i class="bx bx-menu font-large-1 cursor-pointer"></i>
                    </div>
                    <div class="avatar chat-profile-toggle m-0 mr-1">
                        <img src="<?=($chatBy->image ? $chatBy->image : "img/profile.png")?>" alt="avatar" height="36" width="36" />
                    </div>
                    <h6 class="mb-0"><?=$chatBy->name?></h6>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="avatar chat-profile-toggle m-0 mr-1">
                        <img src="<?=($chatBy2->image ? $chatBy2->image : "img/profile.png")?>" alt="avatar" height="36" width="36" />
                    </div>
                    <h6 class="mb-0"><?=$chatBy2->name?></h6>
                </div>
                <div class="chat-header-icons">
                    <span class="dropdown">
                        <?php
                        if ($tkt->active){
                            echo '
                            <i class="bx bx-dots-vertical-rounded font-medium-4 ml-25 cursor-pointer dropdown-toggle nav-hide-arrow cursor-pointer" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></i>
                            <span class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="'.baseDir.'/ticket-manage/'.$ticketID.'/close/"><i class="bx bx-trash mr-25"></i> بستن تیکت</a>
                            </span>
                            ';
                        }
                        if (@$uri[3][0] == "close"){
                            $tkt->close_ticket($manager->ID);
                            redirect("ticket-manage/");
                        }
                        ?>
                    </span>
                </div>
            </header>
        </div>
        <!-- chat card start -->
        <div class="card chat-wrapper shadow-none">
            <div class="card-content">
                <div class="card-body chat-container">
                    <div class="chat-content">
                        <?php
                        if ($post['text']){ //ارسال پیام
                            $form = get_form_data();
                            $tkt->add_message($form['text'],$manager->ID);
                            redirect("ticket-manage/".$ticketID."/#end_chat");
                        }

                        $msg = new TicketMessage($db);
                        $msgs = $tkt->get_ticket_messages();
                        $sender = new Manager($db);

                        foreach ($msgs as $item){
                            $msg->set_vars_from_array($item);
                            if (!$msg->text)continue;
                            $sender->set_vars_from_array(search_2D_array('ID',$msg->sender,$chatByItems));
                            if ($msg->text == "<end/>"){
                                echo '<div class="badge badge-pill badge-light-secondary my-1">
                                تیکت توسط  	
                                &quot;'.$sender->name.'&quot;
                                بسته شد
                                </div>';
                            }else{
                                echo '
                                <div class="chat '.($sender->ID == $manager->ID?'':'chat-left').'">
                                    <div class="chat-avatar">
                                        <a class="avatar m-0">
                                            <img src="'.($sender->image ? $sender->image : "img/profile.png").'" alt="avatar" height="36" width="36" />
                                        </a>
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-message">
                                            <i class="small">'.$sender->name.':</i>
                                            <p class="rtl">'.enter_to_br($msg->text).'</p>
                                            <span class="chat-time">'.($msg->TS?@jdate("h:i m/d",$msg->TS):"").'</span>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }

                        ?>
<!--                        <span id="end_chat"></span>-->
                    </div>
                </div>
            </div>
            <div class="card-footer chat-footer border-top px-2 pt-0 pb-0 mb-1">
                <form id="form" class="d-flex align-items-center" method="post">
                    <textarea onkeydown="submitFormsWithCtrlEnter()" name="text" class="form-control mx-1" placeholder="پیام خود را بنویسید..."></textarea>
                    <button type="submit" class="btn btn-primary glow send d-lg-flex"><i class="bx bx-paper-plane"></i>
                        <span class="d-none d-lg-block ml-1">ارسال</span></button>
                </form>
                <script>
                    function submitFormsWithCtrlEnter() {
                        $('form').keydown(function(event) {
                            if (event.ctrlKey && event.keyCode === 13) {
                                $(this).trigger('submit');
                            }
                        })
                    }
                </script>
            </div>
        </div>
        <!-- chat card ends -->
    </div>
    <section class="chat-profile">
            <header class="chat-profile-header text-center border-bottom">
                                <span class="chat-profile-close">
                                    <i class="bx bx-x"></i>
                                </span>
                <div class="my-2">
                    <div class="avatar">
                        <img src="<?=($chatBy->image ? $chatBy->image : "img/profile.png")?>" alt="chat avatar" height="100" width="100">
                    </div>
                    <h5 class="app-chat-user-name mb-0"><?=$chatBy->name?></h5>
                    <span>آخرین ورود <?=jdate("H:i m/d",$chatBy->lastLoginTime)?> </span>
                        <h6 class="mt-1">سطح: <?=$chatBy->level?></h6>
                </div>
                <div class="my-2">
                    <div class="avatar">
                        <img src="<?=($chatBy2->image ? $chatBy2->image : "img/profile.png")?>" alt="chat avatar" height="100" width="100">
                    </div>
                    <h5 class="app-chat-user-name mb-0"><?=$chatBy2->name?></h5>
                    <span>آخرین ورود <?=jdate("H:i m/d",$chatBy2->lastLoginTime)?> </span>
                        <h6 class="mt-1">سطح: <?=$chatBy2->level?></h6>
                </div>
            </header>
            
        </section>
    <?php
    endif;
    ?>
</section>