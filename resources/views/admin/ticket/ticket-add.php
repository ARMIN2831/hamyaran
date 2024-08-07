<?php
$form = get_form_data();
if ($form['title'] && $form['chat2']){
    $tkt = new Ticket($db);
    $tkt->set_vars_from_array($form);
    $tkt->chat1 = $manager->ID;
    $tkt->startTS = time();
    $tkt->active = 1;

    if ($tkt->save_object_data()){
        echo '<p class="alert alert-success"> تیکت جدید ایجاد شد. </p>';
        $tkt->set_object_from_sql(['title'=>$tkt->title,'startTS'=>$tkt->startTS]);

        redirect("ticket/".$tkt->ID."/",1.5);
    }

}

?>
<section class="chat-window-wrapper" id="add_chat">
    <form method="post">
        <div class="card-header">
            <h4 class="card-title">ایجاد تیکت جدید:</h4>
        </div>
        <div class="row">
            <div class="col-md-6" >
                <fieldset class="form-group">
                    <label for="chat2"> ارسال به </label>
                    <select name="chat2" id="chat2" class="select2 form-control">
                        <option value="">انتخاب کنید</option>
                        <?php
                        $setters = new Manager($db);
                        $setters = $setters->get_object_data();
                        foreach ($setters as $setter) {
                            $available=0;
                            if ($manager->level == "مدیرکل"){
                                $available=1;
                            }elseif ($manager->level=="مدیر"){
                                if ($setter['level']=="مدیرکل"){
                                    $available=1;
                                }else{
                                    $setter['access'] = json_decode($setter['access'],1);
                                    if ($access['convene'] == $setter['access']['convene']){
                                        $available=1;
                                    }
                                }
                            }else{
                                $setter['access'] = json_decode($setter['access'],1);
                                if ($access['convene'] == $setter['access']['convene']){
                                    $available=1;
                                }
                            }
                            if ($available && $setter['ID']!=$manager->ID)echo '<option ' . ($form['chat2'] == $setter['ID'] ? "selected" : "") . ' value="' . $setter['ID'] . '">' . $setter['name']. '</option>';
                        }
                        ?>
                    </select>
                </fieldset>
            </div>

            <div class="col-md-6">
                <fieldset class="form-group">
                    <label for="title"> عنوان تیکت </label>
                    <input type="text" name="title" id="title" value="<?= @$form['title'] ?>" class="form-control" required>
                </fieldset>
            </div>

            <div class="col-md-6">
                <input type="submit" value="ایجاد" class="btn btn-success">
            </div>
        </div>
    </form>
</section>

<script>
    function add_chat_form(){
        var x = document.getElementById('add_chat');
        var y = document.getElementById('show_chat');
        if (x.style.display == '') {
            x.style.display = 'none';
            y.style.display = '';
        } else {
            x.style.display = '';
            y.style.display = 'none';
        }
    }
    add_chat_form('add_chat');

    <?=(($form['title'])?"add_chat_form('add_chat');":"")?>
    <?=($uri[2][0]=="add" && !$form['title'])?"add_chat_form('add_chat');":""?>
</script>