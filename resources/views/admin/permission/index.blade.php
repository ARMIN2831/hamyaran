@extends('layouts.app')

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">پرمیشن ها</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a> ویرایش پرمیشن</a>
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



                                <form method="get" action="{{ route('permissions.index') }}" id="filterForm">
                                    <div class="card-header">
                                        <h4 class="card-title">لیست پرمیشن ها</h4>
                                        <br>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div style="margin-right: 40px" class="dataTables_length" id="DataTables_Table_0_length">
                                                <label style="display: flex; flex-direction: row; align-items: center">
                                                    نمایش
                                                    <select name="pagesize" aria-controls="DataTables_Table_0" class="custom-select custom-select-sm form-control form-control-sm" onchange="submitForm()">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                    ردیف
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                                <label style="display: flex; flex-direction: row; align-items: center">
                                                    جست‌وجو:
                                                    <input name="search" style="width: 120px; margin: 0 10px" type="search" class="form-control form-control-sm" placeholder="" aria-controls="DataTables_Table_0" oninput="submitForm()">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <script>
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
                                                    <th>نام</th>
                                                    <th>عملکرد</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($permissions as $row)
                                                    <tr>
                                                        <td>{{ $row->id }}</td>
                                                        <td>{{ $row->title }}</td>
                                                        <td>
                                                            <a href="{{ route('permissions.edit',$row->id) }}" title="ویرایش" class="btn btn-small btn-primary"><i
                                                                    class="bx bx-edit"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        {{ $permissions->appends(request()->query())->links() }}
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
