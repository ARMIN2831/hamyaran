<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <?php
        if (!$access['r']) {
            redirect("");
            exit();
        }
        if ($id = $uri[3][0] > 0) {
            $institute = new Institute($db);
            $institute->set_object_byID($uri[3][0]);
            $form = $institute->get_object_vars();
            if (!$institute->ID) {
                redirect("ins/edit");
                exit();
            }

            if ($uri[4][0] == "yes") {
                if ($institute->delete_object_data()) {
                    echo '<p class="alert alert-success">عملیات حذف با موفقیت انجام شد.</p>';
                    redirect("ins/edit", 1);
                } else {
                    echo '<p class="alert alert-danger">عملیات حذف با شکست مواجه شد.</p>';
                }

            } else {
                echo '
    <script>
        if (confirm("آیا از حذف ' . $institute->NameInstitute .' اطمینان دارید؟")) {
            location.href = "' . baseDir . '"+"/ins/delete/'.$institute->ID.'/yes";
        }else {
            location.href = "' . baseDir . '"+"/ins/edit";
        }
    </script>
    ';
            }
        }
        ?>
    </div>
</div>

