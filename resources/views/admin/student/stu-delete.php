<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <?php
        if (!$access['i']) {
            redirect("");
            exit();
        }
        if ($id = $uri[3][0] > 0) {
            $student = new Student($db);
            $student->set_object_byID($uri[3][0]);
            $form = $student->get_object_vars();
            if (!$student->ID) {
                redirect("stu/edit");
                exit();
            }

            if ($uri[4][0] == "yes") {
                if ($student->delete_object_data()) {
                    echo '<p class="alert alert-success">عملیات حذف با موفقیت انجام شد.</p>';
                    redirect("stu/edit", 1);
                } else {
                    echo '<p class="alert alert-danger">عملیات حذف با شکست مواجه شد.</p>';
                }

            } else {
                echo '
    <script>
        if (confirm("آیا از حذف ' . $student->firstName ." ".$student->lastName .' اطمینان دارید؟")) {
            location.href = "' . baseDir . '"+"/stu/delete/'.$student->ID.'/yes";
        }else {
            location.href = "' . baseDir . '"+"/stu/edit";
        }
    </script>
    ';
            }
        }
        ?>
    </div>
</div>

