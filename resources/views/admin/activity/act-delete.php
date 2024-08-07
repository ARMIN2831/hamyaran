<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <?php
        if (!$access['k']) {
            redirect("");
            exit();
        }
        if ($id = $uri[3][0] > 0) {
            $action = new Action($db);
            $action->set_object_byID($uri[3][0]);
            $form = $action->get_object_vars();
            if (!$action->ID) {
                redirect("act/edit");
                exit();
            }

            if ($uri[4][0] == "yes") {
                if ($action->delete_object_data()) {
                    echo '<p class="alert alert-success">عملیات حذف با موفقیت انجام شد.</p>';
                    redirect("act/edit", 1);
                } else {
                    echo '<p class="alert alert-danger">عملیات حذف با شکست مواجه شد.</p>';
                }

            } else {
                echo '
    <script>
        if (confirm("آیا از حذف این فعالیت اطمینان دارید؟")) {
            location.href = "' . baseDir . '"+"/act/delete/'.$action->ID.'/yes";
        }else {
            location.href = "' . baseDir . '"+"/act/edit";
        }
    </script>
    ';
            }
        }
        ?>
    </div>
</div>

