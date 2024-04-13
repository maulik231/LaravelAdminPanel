@extends('admin.layouts.master')

@section('style')
    <style>
    </style>
@endsection
<!-- Content Wrapper. Contains page content -->
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $module->title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ $module->title }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <div class="row">
            <!-- Main content -->
            <section class="content col-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $module->table }}</h3>
    
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                          <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                                 src="{{ $data->profile != null ? $data->profile : asset('uploads/no-delete/no_image.jpg') }}"
                                                 alt="User profile picture">
                                          </div>
                          
                                          <h3 class="profile-username text-center">{{ $data->name }}</h3>
                          
                                          <p class="text-muted text-center">{{ $data->email }}</p>
                          
                                          <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                              <b>Date Of Birth</b> <a class="float-right">{{ $data->date_of_birth != null ? date('d M Y', strtotime($data->date_of_birth)) : '-' }}</a>
                                            </li>
                                            <li class="list-group-item">
                                              <b>Status</b> <a class="float-right">{{ Str::ucfirst(($data->status == 1) ? "Active" : "Inactive") }}</a>
                                            </li>
                                            <!-- <li class="list-group-item">
                                              <b>Friends</b> <a class="float-right">13,287</a>
                                            </li> -->
                                          </ul>
                          
                                          <a href="{{ route('user.index') }}" class="btn btn-primary btn-block"><b>Back</b></a>
                                        </div>
                                        <!-- /.card-body -->
                                      </div>
                                </div>
                                <!-- /.card-body -->
                                <!-- <div class="card-footer">
                                    <a href="{{ route('user.index') }}" class="btn btn-primary">Back</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    
    
            <section class="content col-9">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <h3>Appointments</h3>
                                    <table id="example2" class="table table-bordered table-hover" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">Sr. No.</th>
                                                <th style="width: 10%">Name</th>
                                                <th style="width: 20%">Email</th>
                                                <th style="width: 10%">Service</th>
                                                <th style="width: 10%">Appointment At</th>
                                                <th style="width: 10%">Payment Id</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @forelse($data->appointments as $key => $datas)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $datas->name }}</td>
                                                    <td>{{ $datas->email }}</td>
                                                    <td>{{ $datas->service }}</td>
                                                    <td>{{ $datas->appointment_date != null ? date('d M Y', strtotime($datas->appointment_date)) : '-' }} {{ $datas->appointment_time != null ? date('H:i A', strtotime($datas->appointment_time)) : '-' }}</td>
                                                    <td>{{ $datas->payment_id }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Data not found</td>
                                                </tr>
                                            @endforelse --}}
    
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('script')
<script>
    $(function() {

        var table = $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": true,
        
        });
    });
</script>
@endsection
