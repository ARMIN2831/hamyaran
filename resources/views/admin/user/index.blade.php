@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">مدیران</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a> ویرایش مدیران/پشتیبانان</a>
                                    </li>
                                    <li class="breadcrumb-item active">ویرایش
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



                                <form method="get" action="{{ route('users.index') }}" id="filterForm">
                                    <div class="card-header">
                                        <h4 class="card-title">لیست مدیران/پشتیبانان</h4>
                                        <br>
                                        <div class="col-12">
                                            <fieldset class="form-group">
                                                <label for="type"> نوع مدیران </label>
                                                <select name="level" id="type" class="custom-select" onchange="submitForm()">
                                                    <option value="" {{ request('level') == '' ? 'selected' : '' }}>همه مدیران</option>
                                                    <option value="مدیرکل" {{ request('level') == 'مدیرکل' ? 'selected' : '' }}>مدیرکل</option>
                                                    <option value="مدیر" {{ request('level') == 'مدیر' ? 'selected' : '' }}>مدیر</option>
                                                    <option value="پشتیبان" {{ request('level') == 'پشتیبان' ? 'selected' : '' }}>پشتیبان</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>

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
                                                    <th>نام کاربری</th>
                                                    <th>نام</th>
                                                    <th>سطح</th>
                                                    <th>ثبت توسط</th>
                                                    <th>آخرین ورود</th>
                                                    <th>عملکرد</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($user as $row)
                                                    <tr>
                                                        <td>{{ $row->id }}</td>
                                                        <td>{{ $row->username }}</td>
                                                        <td>{{ $row->name }}</td>
                                                        <td>{{ $row->id }}</td>
                                                        <td>{{ @$row->owner->name }}</td>
                                                        <td>{{ \Morilog\Jalali\Jalalian::forge($row->lastLoginTime)->format('Y/m/d H:i:s') }}</td>
                                                        <td>
                                                            <a href="{{ route('users.edit',$row->id) }}" title="ویرایش" class="btn btn-small btn-primary"><i
                                                                    class="bx bx-edit"></i></a>
                                                            <form method="post" action="{{ route('users.destroy',$row->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button style="padding: 3px;margin-top: 2px;" type="submit" title="حذف" class="btn btn-small btn-danger"><i class="bx bx-x-circle"></i></button>
                                                            </form>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        {{ $user->appends(request()->query())->links('pagination::bootstrap-4') }}
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
