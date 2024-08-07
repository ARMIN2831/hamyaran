<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <?php
        if (!$access['g']) {
            redirect("");
            exit();
        }
        if ($id = $uri[3][0] > 0) {
            $class = new TeachClass($db);
            $class->set_object_byID($uri[3][0]);
            $form = $class->get_object_vars();
            if (!$class->ID) {
                redirect("teachClass/edit");
                exit();
            }

            if ($uri[4][0] == "yes") {
                if ($class->delete_object_data()) {
                    echo '<p class="alert alert-success">عملیات حذف با موفقیت انجام شد.</p>';
                    redirect("class/edit", 1);
                } else {
                    echo '<p class="alert alert-danger">عملیات حذف با شکست مواجه شد.</p>';
                }

            } else {
                echo '
                <script>
                    if (confirm("آیا از حذف ' . $class->name . ' اطمینان دارید؟")) {
                        location.href = "' . baseDir . '"+"/teachClass/delete/'.$class->ID.'/yes";
                    }else {
                        location.href = "' . baseDir . '"+"/teachClass/edit";
                    }
                </script>
                ';
            }
        }
        ?>
    </div>
</div>

