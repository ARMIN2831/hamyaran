<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <?php
        if (!$access['f']) {
            redirect("");
            exit();
        }
        if ($id = $uri[3][0] > 0) {
            $course = new Course($db);
            $course->set_object_byID($uri[3][0]);
            $form = $course->get_object_vars();
            if (!$course->ID) {
                redirect("course/edit");
                exit();
            }

            if ($uri[4][0] == "yes") {
                if ($course->delete_object_data()) {
                    echo '<p class="alert alert-success">عملیات حذف با موفقیت انجام شد.</p>';
                    redirect("course/edit", 1);
                } else {
                    echo '<p class="alert alert-danger">عملیات حذف با شکست مواجه شد.</p>';
                }

            } else {
                echo '
    <script>
        if (confirm("آیا از حذف ' . $course->name . ' اطمینان دارید؟")) {
            location.href = "' . baseDir . '"+"/course/delete/'.$course->ID.'/yes";
        }else {
            location.href = "' . baseDir . '"+"/course/edit";
        }
    </script>
    ';
            }
        }
        ?>
    </div>
</div>

