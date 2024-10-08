@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">فعالیت‌ها</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a> تعیین فعالیت برای دانشجو </a>
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش فعالیت
                                    </li>
                                </ol>
                                @if(session('success'))
                                    <div style="margin-top: 20px;margin-bottom: 0" class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">




                                <div class="card-header">
                                    <h4 class="card-title">لیست فعالیت‌ها</h4>
                                    <div class="col-md-12 col-md-6">
                                        <fieldset class="form-group">
                                            <label for="student_id"> دانشجو: </label>
                                            <select style="width: 50%;" dir="rtl" name="student_id" id="student_id" class="select2 form-control activity-select activity-select-2">
                                                <option value="">همه‌ی دانشجویان</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>




                                <form method="get" action="{{ route('activities.index') }}" id="filterForm">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div style="margin-right: 40px" class="dataTables_length" id="DataTables_Table_0_length">
                                                <label style="display: flex; flex-direction: row; align-items: center">
                                                    نمایش
                                                    <select name="pagesize" aria-controls="DataTables_Table_0" class="custom-select custom-select-sm form-control form-control-sm" onchange="submitForm()">
                                                        <option value="10" {{ request('pagesize') == '10' ? 'selected' : '' }}>10</option>
                                                        <option value="25" {{ request('pagesize') == '25' ? 'selected' : '' }}>25</option>
                                                        <option value="50" {{ request('pagesize') == '50' ? 'selected' : '' }}>50</option>
                                                        <option value="100" {{ request('pagesize') == '100' ? 'selected' : '' }}>100</option>
                                                    </select>
                                                    ردیف
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                                <label style="display: flex; flex-direction: row; align-items: center">
                                                    جست‌وجو:
                                                    <input name="search" style="width: 120px; margin: 0 10px" type="search" class="form-control form-control-sm" placeholder="" aria-controls="DataTables_Table_0" value="{{ request('search') }}">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <script>
                                    let timeout = null;
                                    document.getElementById('searchInput').addEventListener('input', function () {
                                        clearTimeout(timeout);
                                        timeout = setTimeout(function () {
                                            document.getElementById('filterForm').submit();
                                        }, 1000);
                                    });
                                    function submitForm() {
                                        document.getElementById('filterForm').submit();
                                    }
                                </script>




                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>نام دانشجو</th>
                                                    <th>شناسه دانشجو</th>
                                                    <th>فعالیت</th>
                                                    <th>توضیحات</th>
                                                    <th>وضعیت</th>
                                                    <th>عملکرد</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($activities as $row)
                                                    <tr>
                                                        <td>{{ $row->id }}</td>
                                                        <td>{{ @$row->student->firstName.' '.$row->student->lastName }}</td>
                                                        <td>{{ @$row->student->id }}</td>
                                                        <td>{{ $row->description }}</td>
                                                        <td>{{ $row->state }}</td>
                                                        <td>
                                                            <a href="{{ route('activities.edit',$row->id) }}" title="ویرایش" class="btn btn-small btn-primary"><i class="bx bx-edit"></i></a>
                                                            <form method="post" action="{{ route('activities.destroy',$row->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button style="padding: 3px;margin-top: 2px;" type="submit" title="حذف" class="btn btn-small btn-danger"><i class="bx bx-x-circle"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        {{ $activities->appends(request()->query())->links('pagination::bootstrap-4') }}
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
