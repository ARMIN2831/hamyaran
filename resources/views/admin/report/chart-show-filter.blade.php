{{ 'شامل '.count($students).' دانشجو' }}
<section id="chartjs-charts">
    <form action="{{ route('report.student') }}" method="get" id="filter_form">
        <div class="card-header">
            <h4 class="card-title">فیلترهای نمودارها:</h4>
        </div>
        <div class="row">
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="country_d"> کشور </label>
                    <select style="width: 100%;margin-right: 0" name="country_d" id="country_d" class="select2 form-control">
                        <option value="">انتخاب کنید</option>
                        @foreach ($countries as $country)
                            <option @if($country->id == request('country_d')) selected="selected"
                                    @endif  value="{{ $country->id }}">{{ $country->name.' '.$country->symbol }}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="language"> زبان‌ </label>
                    <select name="language" id="language" class="custom-select">
                        <option value="">انتخاب کنید</option>
                        @foreach($settings['language'] as $setting)
                            <option @if($setting == request('language')) selected="selected"
                                    @endif value="{{ $setting }}">{{ $setting }}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="education"> تحصیلات‌ </label>
                    <select name="education" id="education" class="custom-select">
                        <option value="">انتخاب کنید</option>
                        @foreach($settings['education'] as $setting)
                            <option @if($setting == request('education')) selected="selected"
                                    @endif value="{{ $setting }}">{{ $setting }}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="religious"> دین </label>
                    <select name="religious" id="religious" class="custom-select" onchange="religious2()">
                        <option value="">انتخاب کنید</option>
                        @foreach($settings['religious'] as $setting)
                            <option @if($setting == request('religious')) selected="selected"
                                    @endif value="{{ $setting }}">{{ $setting }}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
            @if(auth()->user()->can('all user'))
                <div class="col-md-4">
                    <fieldset class="form-group">
                        <label for="convene_id"> مجتمع </label>
                        <select name="convene_id" id="convene_id" class="custom-select">
                            <option value="">انتخاب کنید</option>
                            @foreach ($convenes as $convene)
                                <option @if($convene->id == request('convene_id')) selected="selected"
                                        @endif value="{{ $convene->id }}">{{ $convene->name }}</option>
                            @endforeach

                        </select>
                    </fieldset>
                </div>
            @endif
            @if(!auth()->user()->can('one user'))
                <div class="col-md-4">
                    <fieldset class="form-group">
                        <label for="user_id"> پشتیبان </label>
                        <select style="width: 100%;margin-right: 0" name="user_id" id="user_id" class="select2 form-control">
                            <option value="">انتخاب کنید</option>
                            @foreach($users as $user)
                                @php $i = ''; if($user->can('some user')) $i = '*'; @endphp
                                <option dir="rtl" @if($user->id == request('user_id')) selected="selected"
                                        @endif value="{{ $user->id }}">{{ $user->name.' '. $i .'('.@$user->convene->name.')' }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>
            @endif
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="course_id"> دوره </label>
                    <select style="width: 100%;margin-right: 0" name="course_id" id="course_id" class="select2 form-control">
                        <option value="">انتخاب کنید</option>
                        @foreach($courses as $course)
                            <option @if($course->id == request('course_id')) selected="selected"
                                    @endif value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="classroom_id"> کلاس </label>
                    <select style="width: 100%;margin-right: 0" name="classroom_id" id="classroom_id" class="select2 form-control">
                        <option value="">انتخاب کنید</option>
                        @foreach($classrooms as $classroom)
                            <option @if($classroom->id == request('classroom_id')) selected="selected"
                                    @endif value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="startTS-from"> ثبت نام از </label>
                    <input type="text" name="startTS-from" id="startTS-from"
                           value="{{ request('startTS-from') }}"
                           class="form-control">
                    <script>
                        var objCal1 = new AMIB.persianCalendar('startTS-from');
                    </script>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="startTS-to"> ثبت نام تا </label>
                    <input type="text" name="startTS-to" id="startTS-to"
                           value="{{ request('startTS-to') }}"
                           class="form-control">
                    <script>
                        var objCal2 = new AMIB.persianCalendar('startTS-to');
                    </script>
                </fieldset>
            </div>

            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="endTS-from"> خروج از </label>
                    <input type="text" name="endTS-from" id="endTS-from"
                           value="{{ request('endTS-from') }}"
                           class="form-control">
                    <script>
                        var objCal3 = new AMIB.persianCalendar('endTS-from');
                    </script>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label for="endTS-to"> خروج تا </label>
                    <input type="text" name="endTS-to" id="endTS-to"
                           value="{{ request('startTS-from') }}"
                           class="form-control">
                    <script>
                        var objCal4 = new AMIB.persianCalendar('endTS-to');
                    </script>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label>سن </label>
                    <span class="row">
                        <input type="number" name="age-from" id="age-from" value="{{ request('age-from') }}"
                               placeholder="از" class="col-6 form-control">
                        <input type="number" name="age-to" id="age-to" value="{{ request('age-to') }}" placeholder="تا"
                               class="col-6 form-control">
                    </span>
                </fieldset>
            </div>
            <div class="col-md-4">
                <fieldset class="form-group">
                    <label>جنسیت</label>
                    <br>
                    @foreach ($settings['sex'] as $setting)
                        <label>{{ $setting }}
                            <input @if($setting == request('sex')) checked @endif type="radio" name="sex" value="{{ $setting }}">
                        </label>
                        &nbsp;&nbsp;&nbsp;
                    @endforeach
                </fieldset>
            </div>
            <div class="col-md-4">
                <input type="submit" name="submit" value="تایید" class="btn btn-success">
                <a href="{{ route('report.student') }}" class="btn btn-primary">حذف فیلترها</a>
            </div>
        </div>
    </form>
</section>

<script>
    function unhide_form() {
        var el = document.getElementById("filter_form");
        var btn = document.getElementById("filter_btn");
        if (el.style.display == "none") {
            el.style.display = "";
            btn.innerText = "نمایش فیلترها";
        } else {
            el.style.display = "none";
            btn.innerText = "نمایش فیلترها";
        }
    }

    unhide_form();
</script>
