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
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            @endif

                            <form action="{{ route('product.update', [$data->id]) }}" method="post"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ $data->name }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="price">Price</label>
                                            <input type="number" name="price" class="form-control" id="price" placeholder="0.00" step="0.01" value="{{ $data->price }}">
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="stock">Stock</label>
                                            <input type="number" name="stock" class="form-control" id="stock" placeholder="Enter Stock" value="{{ $data->stock }}">
                                            @error('stock')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="shop_id">Shop</label>
                                            <select class="form-control" name="shop_id" id="shop_id">
                                                <option value="" disabled selected>Select Shop</option>
                                                @foreach($shops as $shop)
                                                    <option value="{{$shop->id}}" {{ ($data->shop_id == $shop->id) ? 'selected' : '' }}>{{$shop->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('shop_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="video">Video</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="video" class="custom-file-input" id="video" accept="video/mp4, video/x-m4v, video/*">
                                                    <label class="custom-file-label" for="video">Choose file</label>
                                                </div>
                                            </div>
                                            <video class="mt-2" id="video_preview" src="{{ url($data->video) }}" height="150" width="300" controls></video>
                                            @error('video')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
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
        $("#video").change(function() {
            readVideo(this);
        });

        function readVideo(input) {
            if (input.files && input.files[0]) {
                var url = URL.createObjectURL(input.files[0]);
                $('#video_preview').attr('src', url);
            }
        }
    </script>
@endsection
