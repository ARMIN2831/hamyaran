<div class="row">
    <div class="col-12">
        <p>
            می‌توانید فیلتر های دلخواه خود را روی داده‌ها اعمال نمایید.
            <a class="btn btn-primary white" onclick="unhide_form()"><i class="bx bxs-filter-alt"></i><span
                        id="filter_btn">نمایش فیلترها</span></a>
            <?php
            $setting = new Setting($db);
            $setting = $setting->get_object_data(["type" => "setData"]);
            $student = new Student($db);
            $student = $student->get_object_data();

            $countryItem = new Country($db);
            $countries = $countryItem->get_object_data();

            $convene = new Convene($db);
            $convenes = $convene->get_object_data();

            $setter = new Manager($db);
            $setters = $setter->get_object_data();

            include "chart-show-filter.blade.php";

            ?>
        </p>
    </div>
</div>
<?php
if (count($student)>0):
?>
<!-- line chart section start -->
<section id="chartjs-charts">
    <!-- Line Chart -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">تعداد دانشجویان(سال)</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        <div class="height-300">
                            <canvas id="line-chart"></canvas>
                            <?php
                            $sumStu=[];
                            $addStu=[];
                            $delStu=[];
                            foreach ($student as $item){
                                if ($item['startTS'] && @($regYear=jdate("Y",$item['startTS'],'','','en'))>1348){
                                    if (key_exists($regYear,$sumStu)){
                                        $sumStu[$regYear]++;
                                        $addStu[$regYear]++;
                                    }else{
                                        $sumStu[$regYear]=1;
                                        $addStu[$regYear]=1;
                                    }
                                }
                            }

                            ksort($sumStu);
                            ksort($addStu);

                            foreach ($student as $item){
                                if ($item['endTS'] && @($endYear=jdate("Y",$item['endTS'],'','','en'))>1348){
                                    @$sumStu[$endYear]--;
                                    if (key_exists($endYear,$delStu)){
                                        $delStu[$endYear]++;
                                    }else{
                                        $delStu[$endYear]=1;
                                    }

                                }
                            }
                            function set_year_nullData_zero($base,&$data){
                                for ($i=array_keys($base)[0];$i<=end(array_keys($base));$i++){
                                    if (!key_exists($i,$data)){
                                        $data[$i]=0;
                                    }
                                }
                            }
                            set_year_nullData_zero($sumStu,$sumStu);
                            set_year_nullData_zero($sumStu,$addStu);
                            set_year_nullData_zero($sumStu,$delStu);

                            $last=0;
                            foreach ($sumStu as &$count){
                                $count += $last;
                                $last = $count;
                            }

                            ksort($sumStu);
                            ksort($addStu);
                            ksort($delStu);

//                            print_r($sumStu);
                            ?>
                            <script>
                                var chart6 = {
                                    label: <?=array_to_JS_list(array_keys($sumStu))?>,
                                    data0: <?=array_to_JS_list($sumStu)?>,
                                    data1: <?=array_to_JS_list($addStu)?>,
                                    data2: <?=array_to_JS_list($delStu)?>
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">تعداد دانشجویان(ماه)</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        <div class="height-300">
                            <canvas id="line-chart2"></canvas>
                            <?php
                            $sumStu=[];
                            $addStu=[];
                            $delStu=[];
                            foreach ($student as $item){
                                if ($item['startTS'] && @($regMonth=jdate("Y/n",$item['startTS'],'','','en'))>1348){
                                    if (key_exists($regMonth,$sumStu)){
                                        $sumStu[$regMonth]++;
                                        $addStu[$regMonth]++;
                                    }else{
                                        $sumStu[$regMonth]=1;
                                        $addStu[$regMonth]=1;
                                    }
                                }
                            }

                            ksort($sumStu);
                            ksort($addStu);

                            foreach ($student as $item){
                                if ($item['endTS'] && @($endYear=jdate("Y/n",$item['endTS'],'','','en'))>1348){
                                    @$sumStu[$endYear]--;
                                    if (key_exists($endYear,$delStu)){
                                        $delStu[$endYear]++;
                                    }else{
                                        $delStu[$endYear]=1;
                                    }

                                }
                            }

                            function set_month_nullData_zero($base,$data){
                                $result = [];
                                for ($i=(int)array_keys($base)[0];$i<=(int)end(array_keys($base));$i++){
                                    for ($j=1;$j<=12;$j++){
                                        if (!key_exists($i."/".$j,$data)){
                                            $result[$i."/".$j]=0;
                                        }else{
                                            $result[$i."/".$j] = $data[$i."/".$j];
                                        }
                                    }
                                }
                                return $result;
                            }

                            $sumStu = set_month_nullData_zero($sumStu,$sumStu);
                            $addStu = set_month_nullData_zero($sumStu,$addStu);
                            $delStu = set_month_nullData_zero($sumStu,$delStu);

                            $last=0;
                            foreach ($sumStu as &$count){
                                $count += $last;
                                $last = $count;
                            }


                            ?>
                            <script>
                                var chart8 = {
                                    label: <?=array_to_JS_list(array_keys($sumStu))?>,
                                    data0: <?=array_to_JS_list($sumStu)?>,
                                    data1: <?=array_to_JS_list($addStu)?>,
                                    data2: <?=array_to_JS_list($delStu)?>
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">جنسیت دانشجویان</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        <div class="height-300">
                            <canvas id="simple-pie-chart"></canvas>
                            <?php
                            $sex = [0, 0, 0];   //0:woman   1:man
                            foreach ($student as $item) {
                                switch ($item['sex']) {
                                    case null:
                                        $sex[2]++;
                                        break;
                                    case 0:
                                        $sex[0]++;
                                        break;
                                    case 1:
                                        $sex[1]++;
                                        break;
                                }
                            }
                            ?>
                            <script>
                                var chart3 = {
                                    label: ["خانم (<?=round($sex[0] / sum($sex) * 100)?>%)", "آقا (<?=round($sex[1] / sum($sex) * 100)?>%)", "نامشخص (<?=round($sex[2] / sum($sex) * 100)?>%)"],
                                    data: <?=array_to_JS_list($sex)?>
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">مجتمع‌ها</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="height-300">
                            <canvas id="simple-doughnut-chart"></canvas>
                            <?php
                            $convene = [];
                            foreach ($convenes as $key => $item) {
                                $convene[$item['name']] = 0;
                            }

                            foreach ($student as $item) {
                                if ($item['setBy']) {
                                    $setter = search_2D_array('ID', $item['setBy'], $setters);
                                    $conveneItem = json_decode($setter['access'], 1)['convene'];
                                    $conveneItem = search_2D_array('ID', $conveneItem, $convenes);

                                    if ($conveneItem['name']) {
                                        @$convene[$conveneItem['name']]++;
                                    }
                                }
                            }
                            arsort($convene);
                            $count = 0;
                            foreach ($convene as $item) {
                                if ($item > 0) {
                                    $count++;
                                } else {
                                    break;
                                }
                            }
                            $convene = array_slice($convene, 0, $count);
                            ?>
                            <script>
                                var chart7 = {
                                    label: <?=array_to_JS_list(array_keys($convene))?>,
                                    data: <?=array_to_JS_list($convene)?>
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bar Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">سن دانشجویان</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        <div class="height-300">
                            <canvas id="bar-chart2"></canvas>
                            <?php
                            $ages = [];
                            foreach ($student as $item) {
                                if (is_numeric($item['birthYear']) && @(date("Y") - $item['birthYear']) > 0) {
                                    $ageRange = (ceil((date("Y") - $item['birthYear']) / 10)) * 10;
                                    $ageRange = $ageRange - 10 . "تا" . $ageRange;
                                    if (key_exists($ageRange . " سال", $ages)) {
                                        $ages[$ageRange]++;
                                    } else {
                                        $ages[$ageRange] = 1;
                                    }
                                }
                            }
                            ksort($ages);
                            ?>
                            <script>
                                var chart5 = {
                                    label: <?=array_to_JS_list(array_keys($ages))?>,
                                    data: <?=array_to_JS_list($ages)?>
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">تحصیلات دانشجویان</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        <div class="height-300">
                            <canvas id="bar-chart"></canvas>
                            <?php
                            $religious1 = search_2D_array('name', 'education', $setting)['value'];
                            $religious1 = determiner($religious1);
                            foreach ($religious1 as $key => $item) {
                                $religious1[$item] = 0;
                                unset($religious1[$key]);
                            }
                            foreach ($student as $item) {
                                if ($item['education'] && key_exists($item['education'], $religious1)) {
                                    @$religious1[$item['education']]++;
                                }
                            }
                            ?>
                            <script>
                                var chart1 = {
                                    label: <?=array_to_JS_list(array_keys($religious1))?>,
                                    data: <?=array_to_JS_list($religious1)?>
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">زبان دانشجویان</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        <div class="height-300">
                            <canvas id="horizontal-bar"></canvas>
                            <?php
                            $language = search_2D_array('name', 'language', $setting)['value'];
                            $language = determiner($language);
                            foreach ($language as $key => $item) {
                                $language[$item] = 0;
                                unset($language[$key]);
                            }
                            foreach ($student as $item) {
                                if ($item['language'] && key_exists($item['language'], $language)) {
                                    @$language[$item['language']]++;
                                }
                            }
                            arsort($language);
                            ?>
                            <script>
                                var chart2 = {
                                    label: <?=array_to_JS_list(array_keys($language))?>,
                                    data: <?=array_to_JS_list($language)?>
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">کشور دانشجویان</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        <div class="height-300">
                            <canvas id="horizontal-bar2"></canvas>
                            <?php
                            $country = [];
                            foreach ($countries as $key => $item) {
                                $country[$item['name']] = 0;
                            }

                            foreach ($student as $item) {
                                if ($item['country']) {
                                    $countryItem->name = null;    //حذف اثر قبلی در حلقه
                                    $countryItem->set_vars_from_array(search_2D_array("ID", $item['country'], $countries));

                                    if ($countryItem->name) {
                                        @$country[$countryItem->name]++;
                                    }
                                }
                            }
                            arsort($country);
                            $count = 0;
                            foreach ($country as $item) {
                                if ($item > 0) {
                                    $count++;
                                } else {
                                    break;
                                }
                            }
                            $country = array_slice($country, 0, $count);
                            ?>
                            <script>
                                var chart4 = {
                                    label: <?=array_to_JS_list(array_keys($country))?>,
                                    data: <?=array_to_JS_list($country)?>
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">دین دانشجویان</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        <div class="height-300">
                            <canvas id="simple-pie-chart2"></canvas>
                            <?php
                            $religious1 = search_2D_array('name', 'religious', $setting)['value'];
                            $religious1 = determiner($religious1);
                            foreach ($religious1 as $key => $item) {
                                $religious1[$item] = 0;
                                unset($religious1[$key]);
                            }
                            foreach ($student as $item) {
                                if ($item['religion1'] && key_exists($item['religion1'], $religious1)) {
                                    @$religious1[$item['religion1']]++;
                                }
                            }

                            foreach ($religious1 as $key=>$value){
                            $religious1[$key."(".round($value / sum($religious1) * 100)."%)"] = $value;
                            unset($religious1[$key]);
                            }
                            ?>
                            <script>
                                var chart9 = {
                                    label: <?=array_to_JS_list(array_keys($religious1))?>,
                                    data: <?=array_to_JS_list($religious1)?>
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">مذهب دانشجویان</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        <div class="height-300">
                            <canvas id="simple-pie-chart3"></canvas>
                            <?php
                            $religious2 = [];

                            foreach ($student as $item) {
                                if ($item['religion2']) {
                                    if (key_exists($item['religion2'],$religious2)){
                                        $religious2[$item['religion2']]++;
                                    }else{
                                        $religious2[$item['religion2']]=1;
                                    }
                                }
                            }

                            arsort($religious2);
                            foreach ($religious2 as $key=>$value){
                                $religious2[$key."(".round($value / sum($religious2) * 100)."%)"] = $value;
                                unset($religious2[$key]);
                            }
                            ?>
                            <script>
                                var chart10 = {
                                    label: <?=array_to_JS_list(array_keys($religious2))?>,
                                    data: <?=array_to_JS_list($religious2)?>
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</section>
<?php
endif;
