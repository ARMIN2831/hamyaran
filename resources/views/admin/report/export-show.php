<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">لیست دانشجویان</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <p>فیلدهای گزارش</p>
                        <label > <input type="checkbox" onclick="show_column('ID_')" checked> شناسه</label>
                        <label > <input type="checkbox" onclick="show_column('firstName_')" checked> نام</label>
                        <label > <input type="checkbox" onclick="show_column('lastName_')" checked> نام خانوادگی</label>
                        <label > <input type="checkbox" onclick="show_column('country_')" checked> کشور</label>
                        <label > <input type="checkbox" onclick="show_column('city_')"> شهر</label>
                        <label > <input type="checkbox" onclick="show_column('nationality_')"> ملیت</label>
                        <label > <input type="checkbox" onclick="show_column('language_')"> زبان</label>
                        <label > <input type="checkbox" onclick="show_column('birthYear_')"> سال تولد</label>
                        <label > <input type="checkbox" onclick="show_column('sex_')"> جنسیت</label>
                        <label > <input type="checkbox" onclick="show_column('isMarried_')"> وضعیت تأهل</label>
                        <label > <input type="checkbox" onclick="show_column('job_')"> شغل</label>
                        <label > <input type="checkbox" onclick="show_column('education_')"> تحصیلات</label>
                        <label > <input type="checkbox" onclick="show_column('email_')"> ایمیل</label>
                        <label > <input type="checkbox" onclick="show_column('mobile_')"> موبایل</label>
                        <label > <input type="checkbox" onclick="show_column('religion1_')"> دین</label>
                        <label > <input type="checkbox" onclick="show_column('religion2_')"> مذهب</label>
                        <label > <input type="checkbox" onclick="show_column('setBy_')" checked> پشتیبان</label>
                        <label > <input type="checkbox" onclick="show_column('convene_')"> مجتمع</label>
                        <label > <input type="checkbox" onclick="show_column('address_')"> آدرس</label>
                        <label > <input type="checkbox" onclick="show_column('canDoAct_')"> قابل انجام فعالیت</label>
                        <label > <input type="checkbox" onclick="show_column('startTS_')" checked> زمان ثبت‌نام</label>
                        <label > <input type="checkbox" onclick="show_column('endTS_')" checked> زمان خروج</label>
                        <label > <input type="checkbox" onclick="show_column('action_')" checked> فعالیت‌ها</label>
                        <label > <input type="checkbox" onclick="show_column('class_')" checked> کلاس‌ها</label>
                        <label > <input type="checkbox" onclick="show_column('course_')"> دوره‌ها</label>
                        <div class="table-responsive" id="table">
                            <table class="table zero-configuration">
                                <thead>
                                <tr>
                                    <th name="ID_">#</th>
                                    <th name="firstName_">نام</th>
                                    <th name="lastName_">نام خانوادگی</th>
                                    <th name="country_">کشور</th>
                                    <th name="city_">شهر</th>
                                    <th name="nationality_">ملیت</th>
                                    <th name="language_">زبان</th>
                                    <th name="birthYear_">سال تولد</th>
                                    <th name="sex_">جنسیت</th>
                                    <th name="isMarried_">وضعیت تأهل</th>
                                    <th name="job_">شغل</th>
                                    <th name="education_">تحصیلات</th>
                                    <th name="email_">ایمیل</th>
                                    <th name="mobile_">موبایل</th>
                                    <th name="religion1_">دین</th>
                                    <th name="religion2_">مذهب</th>
                                    <th name="setBy_">پشتیبان</th>
                                    <th name="convene_">مجتمع</th>
                                    <th name="address_">آدرس</th>
                                    <th name="canDoAct_">قابل انجام فعالیت</th>
                                    <th name="startTS_">زمان ثبت‌نام</th>
                                    <th name="endTS_">زمان خروج</th>
                                    <th name="action_">فعالیت‌ها</th>
                                    <th name="class_">کلاس‌ها</th>
                                    <th name="course_">دوره‌ها</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $students = $student;
                                $student = new Student($db);
                                foreach ($students as &$item){
                                    $student = new Student($db);
                                    $student->set_vars_from_array($item);
                                    $available = 0;
                                    if ($manager->level == "مدیرکل"){$available = 1;}
                                    if ($manager->level == "پشتیبان"){if ($student->setBy==$manager->ID){$available=1;}}
                                    if ($manager->level == "مدیر"){
                                        if ($student->setBy == $manager->ID) {
                                            $available = 1;
                                        } else {
                                            $setter = search_2D_array('ID',$student->setBy,$setters);
                                            $setter = json_decode($setter['access'], 1);
                                            if ($setter['convene'] == $access['convene']) {
                                                $available = 1;
                                            }
                                        }
                                    }
                                    if ($available){
                                        //فعالیت‌ها
                                        $r = search_2D_array('studentID',$item["ID"],$actions,1);
                                        $item['action'] = join("\r\n",array_column($r,'title'));
                                        foreach ($r as $i){
                                            if ($access['k']){
                                                @$show['action'] .= '<a target="_blank" href="'.baseDir.'/act/Edit/'.$i['ID'].'/">'.$i['title'].'</a><br>';
                                            }else{
                                                @$show['action'] .= $i['action'].'<br>';
                                            }

                                        }
                                        //کلاس‌ها
                                        $r = search_2D_array('studentID',$item["ID"],$classStudents,1);
                                        foreach ($r as $i){
                                            $t = search_2D_array('ID',$i['teachClassID'],$teachClasses);
                                            if ($access['g']){
                                                @$show['class'] .= '<a target="_blank" href="'.baseDir.'/teachClass/edit/'.$t['ID'].'/">'.$t['name'].'</a><br>';
                                            }else{
                                                @$show['class'] .= $t['name'].'<br>';
                                            }
                                            $item['class'] .= $t['name']."\r\n";

                                            //دوره‌ها

                                            $y = search_2D_array('ID',$t['course'],$courses);
                                            if (!str_contains($item['course'],$y['name'])){
                                                if ($access['f']){
                                                    @$show['course'] .= '<a target="_blank" href="'.baseDir.'/course/edit/'.$y['ID'].'/">'.$y['name'].'</a><br>';
                                                }else{
                                                    @$show['course'] .= $y['name'].'<br>';
                                                }
                                                $item['course'] .= $y['name']."\r\n";
                                            }
                                        }

                                        echo '
                                                    <tr>
                                                        <td name="ID_">' . ($access['i']?'<a target="_blank" href="'.baseDir.'/stu/edit/'.$student->ID.'/">'.$student->ID.'</a>':$student->ID) . '</td>
                                                        <td name="firstName_">' . $student->firstName . '</td>
                                                        <td name="lastName_">' . $student->lastName . '</td>
                                                        <td name="country_">'. ($item['country']=search_2D_array('ID',$student->country,$countries)['name']).'</td>
                                                        <td name="city_">' . $student->city . '</td>
                                                        <td name="nationality_">'. ($item['country']=search_2D_array('ID',$student->nationality,$countries)['name']).'</td>
                                                        <td name="language_">' . $student->language . '</td>
                                                        <td name="birthYear_">' . $student->birthYear . '</td>
                                                        <td name="sex_">' . ($student->sex!==null?($student->sex?$item['sex']="آقا":$item['sex']="خانم"):$item['sex']="") . '</td>
                                                        <td name="isMarried_">' . ($student->isMarried!==null?($student->isMarried?$item['isMarried']="متأهل":$item['isMarried']="مجرد"):$item['isMarried']="") . '</td>
                                                        <td name="job_">' . $student->job . '</td>
                                                        <td name="education_">' . $student->education . '</td>
                                                        <td name="email_">' . $student->email . '</td>
                                                        <td name="mobile_">' . $student->mobile . '</td>
                                                        <td name="religion1_">' . $student->religion1 . '</td>
                                                        <td name="religion2_">' . $student->religion2 . '</td>
                                                        <td name="setBy_">'. ($item['setBy'] = ($r=search_2D_array('ID',$student->setBy,$setters))['name']).'</td>
                                                        <td name="convene_">'. ($item['convene'] = ($r=search_2D_array('ID',json_decode($r['access'],1)['convene'],$convenes))['name']).'</td>
                                                        <td name="address_">' . $student->address . '</td>
                                                        <td name="canDoAct_">' . ($student->canDoAct!==null?($student->canDoAct?$item['canDoAct']="دارد":$item['canDoAct']="ندارد"):$item['canDoAct']="") . '</td>
                                                        <td name="startTS_">' . ($item['startTS']=@jdate("Y/m/d",$student-> startTS,0,0,'en')) . '</td>
                                                        <td name="endTS_">' . ($item['endTS']=@jdate("Y/m/d",$student->endTS,0,0,'en')) . '</td>
                                                        <td name="action_">' .$show['action']. '</td>
                                                        <td name="class_">' .$show['class']. '</td>
                                                        <td name="course_">' .$show['course']. '</td>
                                                    </tr>
                                                ';
                                        unset($show);
                                    }
                                }
                                ?>

                                </tfoot>
                            </table>
                            <script>
                                function show_column(name){
                                    var x = document.getElementsByName(name);
                                    x.forEach(function(v){
                                        if (v.style.display == ''){
                                            v.style.display = 'none';
                                        }else {
                                            v.style.display = '';
                                        }
                                    })
                                }

                                show_column("city_");
                                show_column("nationality_");
                                show_column("language_");
                                show_column("birthYear_");
                                show_column("sex_");
                                show_column("isMarried_");
                                show_column("job_");
                                show_column("education_");
                                show_column("email_");
                                show_column("mobile_");
                                show_column("religion1_");
                                show_column("religion2_");
                                show_column("convene_");
                                show_column("address_");
                                show_column("canDoAct_");
                                show_column("course_");
                            </script>
                            <?php
                            write_suf($students,$manager->ID);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>