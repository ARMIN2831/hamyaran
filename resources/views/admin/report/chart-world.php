<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> گزارشات </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> اطلاعات دانشجویان </a>
                                </li>
                                <li class="breadcrumb-item active">توزیع پراکندگی
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
        <?php
        $access['m'] || redirect("");
        ?>

            <div id="svgMap"></div>
            <?php
            $student = new Student($db);
            $students = $student->get_object_data();
            $setter = new Manager($db);
            $setters = $setter->get_object_data();

            $countryItem = new Country($db);
            $countries = $countryItem->get_object_data();
            $country = [];
            foreach ($countries as $key=>$item){
                $country[$item['symbol']] = 0;
            }
            array_unshift($countries,['ID'=>0]);

            foreach ($students as $item){
                $available = 0;
                if ($manager->level == "مدیرکل"){$available = 1;}
                if ($manager->level == "پشتیبان"){if ($item['setBy']==$manager->ID){$available=1;}}
                if ($manager->level == "مدیر"){
                    if ($item['setBy'] == $manager->ID) {
                        $available = 1;
                    } else {
                        $setter = search_2D_array("ID",$item['setBy'],$setters);
                        $setter = json_decode($setter['access'], 1);
                        if ($setter['convene'] == $access['convene']) {
                            $available = 1;
                        }
                    }
                }

                if ($item['country'] && $available){
                    $countryItem->set_vars_from_array(search_2D_array("ID",$item['country'],$countries));
                    if ($countryItem->symbol){
                        @$country[$countryItem->symbol]++;
                    }
                }
            }
            arsort($country);
            $count=0;

            ?>
            <script>
                new svgMap({
                    targetElementID: 'svgMap',
                    data: {
                        data: {
                            gdp: {
                                name: 'تعداد دانشجویان',
                                format: '{0} نفر',
                                thousandSeparator: ',',
                                // thresholdMax: 100000,
                                // thresholdMin: 0
                            },
                        },
                        applyData: 'gdp',
                        values: {
                            <?php
                            foreach ($country as $symbol=>$count){
                                if ($count>0){
                                    echo $symbol.': { gdp: '.($count).'},';
                                }else{break;}
                            }
                            ?>
                        }
                    }
                });

            </script>
        </div>
    </div>
</div>