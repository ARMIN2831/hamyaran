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
                                <li class="breadcrumb-item"><a> مالی </a>
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

            <section id="chartjs-charts">
                <form action="{{ route('report.finance') }}" method="get" id="filter_form">
                    <div class="card-header">
                        <h4 class="card-title">فیلترهای نمودارها:</h4>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="startTS"> ثبت نام از </label>
                                <input type="text" name="startTS" id="startTS"
                                       value="{{ request('startTS') }}"
                                       class="form-control">
                                <script>
                                    var objCal1 = new AMIB.persianCalendar('startTS');
                                </script>
                            </fieldset>
                        </div>
                        <div class="col-md-4">
                            <fieldset class="form-group">
                                <label for="endTS"> خروج از </label>
                                <input type="text" name="endTS" id="endTS"
                                       value="{{ request('endTS') }}"
                                       class="form-control">
                                <script>
                                    var objCal3 = new AMIB.persianCalendar('endTS');
                                </script>
                            </fieldset>
                        </div>

                        <div class="col-md-4">
                            <input type="submit" name="submit" value="تایید" class="btn btn-success">
                            <a href="{{ route('report.finance') }}" class="btn btn-primary">حذف فیلترها</a>
                        </div>
                    </div>
                </form>
            </section>

            <!-- line chart section start -->
            <section id="chartjs-charts">
                <!-- Line Chart -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">وضعیت مالی (نمودار)</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body pl-0">
                                    <div class="height-500">
                                        <canvas id="simple-pie-chart2"></canvas>
                                        <script>
                                            var chart9 = {
                                                label: <?= $chartData['commission']['commissionPercent'] ?>,
                                                data: <?= $chartData['commission']['data'] ?>
                                            };
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">وضعیت مالی (جدول)</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body pl-0">
                                    <div>
                                        <table class="table zero-configuration">
                                            <thead>
                                            <tr>
                                                <th>نام مدیر</th>
                                                <th>کمیسیون</th>
                                                <th>مبلغ دریافتی</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($totalUserPrice as $key => $row)
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ $totalUserCommission[$key] }} تومان</td>
                                                    <td>{{ $row }} تومان</td>
                                                </tr>
                                            @endforeach
                                        </table>
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
