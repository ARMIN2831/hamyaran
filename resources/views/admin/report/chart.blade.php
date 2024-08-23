@extends('layouts.app')

@section('content')
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
                                <li class="breadcrumb-item active">نمودارها
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <div class="row">
                <div class="col-12">
                    <p>
                        می‌توانید فیلتر های دلخواه خود را روی داده‌ها اعمال نمایید.
                        <a class="btn btn-primary white" onclick="unhide_form()"><i class="bx bxs-filter-alt"></i><span
                                id="filter_btn">نمایش فیلترها</span></a>
                        @include('admin.report.chart-show-filter',['countries'=>$countries, 'convenes'=>$convenes, 'users'=>$users, 'courses'=>$courses, 'classrooms'=>$classrooms, 'settings'=>$settings, 'students' => $students])
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
                                <h4 class="card-title">تعداد دانشجویان(سال)</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body pl-0">
                                    <div class="height-300">
                                        <canvas id="line-chart"></canvas>
                                        <script>
                                            var chart6 = {
                                                label: <?= $chartData['year'][0] ?>,
                                                data0: <?= $chartData['year'][1] ?>,
                                                data1: <?= $chartData['year'][2] ?>,
                                                data2: <?= $chartData['year'][3] ?>,
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
                                        <script>
                                            var chart8 = {
                                                label: <?= $chartData['month'][0] ?>,
                                                data0: <?= $chartData['month'][1] ?>,
                                                data1: <?= $chartData['month'][2] ?>,
                                                data2: <?= $chartData['month'][3] ?>,
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
                                        <script>
                                            var chart3 = {
                                                label: ["خانم (<?= $chartData['sex']['sexPercent'][0] ?>%)", "آقا (<?= $chartData['sex']['sexPercent'][1] ?>%)", "نامشخص (<?= $chartData['sex']['sexPercent'][2] ?>%)"],
                                                data: <?= $chartData['sex']['data'] ?>
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
                                        <script>
                                            var chart7 = {
                                                label: <?= $chartData['convene']['key'] ?>,
                                                data: <?= $chartData['convene']['data'] ?>
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
                                <h4 class="card-title">سن دانشجویان</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body pl-0">
                                    <div class="height-300">
                                        <canvas id="bar-chart2"></canvas>
                                        <script>
                                            var chart5 = {
                                                label: <?= $chartData['age']['key'] ?>,
                                                data: <?= $chartData['age']['data'] ?>
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
                                        <script>
                                            var chart1 = {
                                                label: <?= $chartData['education']['key'] ?>,
                                                data: <?= $chartData['education']['data'] ?>
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
                                <h4 class="card-title">زبان دانشجویان</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body pl-0">
                                    <div class="height-300">
                                        <canvas id="horizontal-bar"></canvas>
                                        <script>
                                            var chart2 = {
                                                label: <?= $chartData['language']['key'] ?>,
                                                data: <?= $chartData['language']['data'] ?>
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
                                        <script>
                                            var chart4 = {
                                                label: <?= $chartData['countries']['key'] ?>,
                                                data: <?= $chartData['countries']['data'] ?>
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
                                        <script>
                                            var chart9 = {
                                                label: <?= $chartData['religious']['religiousPercent'] ?>,
                                                data: <?= $chartData['religious']['data'] ?>
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
                                        <script>
                                            var chart10 = {
                                                label: <?= $chartData['religion2']['religion2Percent'] ?>,
                                                data: <?= $chartData['religion2']['data'] ?>
                                            };
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </section>



        </div>
    </div>
</div>
@endsection
