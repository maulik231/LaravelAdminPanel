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
                        <h1 class="m-0">Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Product</h3>
                                <a href="{{ route('product.create') }}" class="btn btn-primary float-right">Add Product</a>
                                <a href="{{ route('productExport') }}" class="mr-2 btn btn-primary float-right">Export Product</a>
                                <a href="{{ route('productTemplate') }}" class="mr-2 btn btn-primary float-right">Download Template</a>
                                <a href="{{ route('productImport') }}" class="mr-2 btn btn-primary float-right">Import Product</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <hr>
                                <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Video</th>
                                            <th>Shop Name</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data as $key=> $datas)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <video controls height="150" width="300" alt="">
                                                        <source src="{{ url($datas->video) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </td>
                                                <td>{{ $datas->shop->name }}</td>
                                                <td>{{ $datas->name }}</td>
                                                <td>{{ $datas->price }}</td>
                                                <td>{{ $datas->stock }}</td>
                                                <td  >
                                                    <a href="{{ route('product.edit', [$datas->id]) }}"
                                                        class="btn btn-success m-1 btn-sm">Edit</a>
                                                    <form action="{{ route('product.destroy', [$datas->id]) }}"
                                                        method="post">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure, Do you want to delete?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Data not found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
        });
    </script>
@endsection
