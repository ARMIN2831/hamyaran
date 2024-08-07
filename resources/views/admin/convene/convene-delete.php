<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <?php
        if (!$access['e']) {
            redirect("");
            exit();
        }
        if ($id = $uri[3][0] > 0) {
            $convene = new Convene($db);
            $convene->set_object_byID($uri[3][0]);
            $form = $convene->get_object_vars();
            if (!$convene->ID) {
                redirect("convene/edit");
                exit();
            }

            if ($uri[4][0] == "yes") {
                if ($convene->delete_object_data()) {
                    echo '<p class="alert alert-success">عملیات حذف با موفقیت انجام شد.</p>';
                    redirect("convene/edit", 1);
                } else {
                    echo '<p class="alert alert-danger">عملیات حذف با شکست مواجه شد.</p>';
                }

            } else {
                echo '
    <script>
        if (confirm("آیا از حذف ' . $convene->name . ' اطمینان دارید؟")) {
            location.href = "' . baseDir . '"+"/convene/delete/'.$convene->ID.'/yes";
        }else {
            location.href = "' . baseDir . '"+"/convene/edit";
        }
    </script>
    ';
            }
        }
        ?>
    </div>
</div>

