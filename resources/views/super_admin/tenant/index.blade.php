@extends('layouts.admin')
@section('title', 'E-Raport | Tenant')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tenant List</h3>
            </div>

            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NPSN</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tenants as $tenant)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tenant->npsn }}</td>
                            <td>{{ $tenant->name }}</td>
                            <td>{{ $tenant->level }}</td>
                            <td>{{ $tenant->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>



    </div>
    <!-- /.col -->
</div>
@endsection