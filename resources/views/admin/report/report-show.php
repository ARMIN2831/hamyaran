<div class="row">
    <div class="col-12">
        <p>
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
            //            var_export($student);

            ?>
        </p>
    </div>
</div>
<!-- line chart section start -->
<section id="chartjs-charts">
    <!-- Line Chart -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">وضعیت کلاس‌ها</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        <div class="height-300">
                            <canvas id="simple-pie-chart2"></canvas>
                            <?php
                            $classState = search_2D_array('name', 'classState', $setting)['value'];
                            $classState = determiner($classState);
                            foreach ($classState as $key => $item) {
                                $classState[$item] = 0;
                                unset($classState[$key]);
                            }
                            foreach ($teachClasses as $item) {
                                if ($item['state'] && key_exists($item['state'], $classState)) {
                                    @$classState[$item['state']]++;
                                }
                            }

                            foreach ($classState as $key=>$value){
                                $classState[$key."(".round($value / sum($classState) * 100)."%)"] = $value;
                                unset($classState[$key]);
                            }
                            ?>
                            <script>
                                var chart9 = {
                                    label: <?=array_to_JS_list(array_keys($classState))?>,
                                    data: <?=array_to_JS_list($classState)?>
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
                    <h4 class="card-title">وضعیت‌فعالیت‌ها</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="height-300">
                            <canvas id="simple-doughnut-chart"></canvas>
                            <?php
                            $actionState = search_2D_array('name', 'actionState', $setting)['value'];
                            $actionState = determiner($actionState);
                            foreach ($actionState as $key => $item) {
                                $actionState[$item] = 0;
                                unset($actionState[$key]);
                            }
                            foreach ($actions as $item) {
                                if ($item['state'] && key_exists($item['state'], $actionState)) {
                                    @$actionState[$item['state']]++;
                                }
                            }

                            foreach ($actionState as $key=>$value){
                                $actionState[$key."(".round($value / sum($actionState) * 100)."%)"] = $value;
                                unset($actionState[$key]);
                            }
                            ?>
                            <script>
                                var chart7 = {
                                    label: <?=array_to_JS_list(array_keys($actionState))?>,
                                    data: <?=array_to_JS_list($actionState)?>
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
                    <h4 class="card-title">زبان کلاس‌ها</h4>
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
                            foreach ($teachClasses as $item) {
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
                    <h4 class="card-title">کشور کلاس‌ها</h4>
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

                            foreach ($teachClasses as $item) {
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
                    <h4 class="card-title">وضعیت تیکت‌ها</h4>
                </div>
                <div class="card-content">
                    <div class="card-body pl-0">
                        <div class="height-300">
                            <canvas id="simple-pie-chart"></canvas>
                            <?php
                            $ticketState = [0, 0];   //0:disactive   1:active
                            foreach ($tickets as $item) {
                                if ($item['active']) {
                                    $ticketState[1]++;
                                }else{
                                    $ticketState[0]++;
                                }
                            }
                            ?>
                            <script>
                                var chart3 = {
                                    label: ["بسته (<?=round($ticketState[0] / sum($ticketState) * 100)?>%)", "باز (<?=round($ticketState[1] / sum($ticketState) * 100)?>%)"],
                                    data: <?=array_to_JS_list($ticketState)?>
                                };
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


</section>