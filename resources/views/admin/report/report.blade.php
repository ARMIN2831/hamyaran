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
                                <li class="breadcrumb-item"><a> اطلاعات سامانه </a>
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
            <section id="widgets-Statistics">
                <div class="row">
                    <div class="col-12 mt-1 mb-2">
                        <h4>آمار سامانه</h4>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                                        <i class="bx bxs-user-circle font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">تعداد دانشجویان</p>
                                    <h2 class="mb-0">{{ $students }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                                        <i class="bx bx-edit-alt font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">کل فعالیت‌ها</p>
                                    <h2 class="mb-0">{{ $activities }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                                        <i class="bx bx-file font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">تعداد کلاس‌ها</p>
                                    <h2 class="mb-0">{{ $classrooms }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                                        <i class="bx bx-message font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">تیکت‌ها</p>
                                    <h2 class="mb-0">{{ $tickets }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1">
                                        <i class="bx bxs-school font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">تعداد مجتمع‌ها</p>
                                    <h2 class="mb-0">{{ $convenes }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-1">
                                        <i class="bx bx-group font-medium-5"></i>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">مدیران</p>
                                    <h2 class="mb-0">{{ $users }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <div class="row">
                <div class="col-12">
                    <p>

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
                                        <script>
                                            var chart9 = {
                                                label: <?= $chartData['classState']['classPercent'] ?>,
                                                data: <?= $chartData['classState']['data'] ?>
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
                                        <script>
                                            var chart7 = {
                                                label: <?= $chartData['actionState']['actionPercent'] ?>,
                                                data: <?= $chartData['actionState']['data'] ?>
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
                                <h4 class="card-title">کشور کلاس‌ها</h4>
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
                                <h4 class="card-title">وضعیت تیکت‌ها</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body pl-0">
                                    <div class="height-300">
                                        <canvas id="simple-pie-chart"></canvas>
                                        <script>
                                            var chart3 = {
                                                label: <?= $chartData['ticketState']['ticketPercent'] ?>,
                                                data: <?= $chartData['ticketState']['data'] ?>
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
