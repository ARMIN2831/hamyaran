<?php
if (($id = $uri[5][0]) > 0) {
    $classStudent = new ClassStudent($db);
    $classStudent->set_object_from_sql(['teachClassID'=>$class->ID,'studentID'=>$id]);

    $student = new Student($db);
    $student->set_object_byID($id);
    if (!$classStudent->ID) {
        $error=1;
        echo '<p class="alert alert-warning">این دانشجو در این کلاس عضو نیست
                <br> <a class="btn btn-primary" onclick="go_back()">بازگشت</a>
                </p>';
    }
    if (!$student->ID) {
        echo '<p class="alert alert-warning">به نظر می‌رسد این دانشجو قبلا حذف شده است. با این حال همچنان می‌توانید آن را از کلاس حذف نمایید.
              </p>';
    }

    if (!$error){
        if ($uri[6][0] == "yes") {
            if ($classStudent->delete_object_data()) {
                echo '<p class="alert alert-success">حذف دانشجو از کلاس با موفقیت انجام شد.</p>';
            } else {
                echo '<p class="alert alert-danger"> حذف دانشجو از کلاس با شکست مواجه شد.</p>';
            }

        } else {
            echo '
    <script>
        if (confirm("آیا از حذف دانشجو ('.$student->firstName." ".$student->lastName.') از این کلاس اطمینان دارید؟")) {
            location.href = "' . baseDir . '"+"/classstudent/edit/'.$class->ID.'/delete/'.$id.'/yes/";
        }else {
            location.href = "' . baseDir . '"+"/classstudent/edit/'.$class->ID.'/";
        }
    </script>
    ';
        }
    }

}
?>