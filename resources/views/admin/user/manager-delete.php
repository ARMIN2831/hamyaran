<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <?php
        if ($id = $uri[3][0] > 0) {
            $managerRow = new Manager($db);
            $managerRow->set_object_byID($uri[3][0]);
            $form = $managerRow->get_object_vars();
            if (!$managerRow->ID) {
                redirect("manager/edit");
                exit();
            }

            if ($manager->level == "مدیرکل" && $access['c'] && $managerRow->level==("پشتیبان"||"مدیر")) {
                $available = 1;
            }
            if ($manager->level == "مدیرکل" && $access['c'] && $access['d'] && $managerRow->level =="مدیرکل") {
                $available = 1;
            }
            if ($manager->level == "مدیر" && $access['c'] && $managerRow->level=="پشتیبان" && $access['convene']==json_decode($managerRow->access,1)['convene']) {
                $available = 1;
            }
            if (!$available) {
                redirect("manager/edit");
                exit();
            }


            if ($uri[4][0] == "yes") {
                if ($managerRow->delete_object_data()) {
                    echo '<p class="alert alert-success">عملیات حذف با موفقیت انجام شد.</p>';
                    redirect("manager/edit", 1);
                } else {
                    echo '<p class="alert alert-danger">عملیات حذف با شکست مواجه شد.</p>';
                }

            } else {
                echo '
    <script>
        if (confirm("آیا از حذف ' . $managerRow->name . ' اطمینان دارید؟")) {
            location.href = "' . baseDir . '"+"/manager/delete/'.$managerRow->ID.'/yes";
        }else {
            location.href = "' . baseDir . '"+"/manager/edit";
        }
    </script>
    ';
            }
        }
        ?>
    </div>
</div>

