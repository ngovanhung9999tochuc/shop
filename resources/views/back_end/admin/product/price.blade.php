@extends('back_end.layout.layout')
@section('content')
@section('css')


@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Thêm giá sản phẩm',
    'name'=>'product','key'=>'price','route'=>route('product.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá nhập</th>
                                        <th>ngày nhập</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->



                </div>
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><b>Thêm giá bán</b></h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{route('product.price',$product->id)}}">
                                @csrf @method('post')
                                <h6 class="mt-3 "><b>Giá bán</b></h6>
                                <div class="input-group mb-3">
                                    <input type="number" min="0" class="form-control @error('unit_price') is-invalid @enderror" value="{{old('unit_price')}}" name="unit_price">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Đồng</span>
                                    </div>
                                    @error('unit_price')
                                    <br />
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h6 class="mt-3 "><b>Khuyến mãi</b></h6>
                                <div class="input-group mb-3">
                                    <input type="number" min="0" class="form-control @error('promotion_price') is-invalid @enderror" value="{{old('promotion_price')}}" name="promotion_price">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @error('promotion_price')
                                    <br />
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary" style="width: 100px; margin-left: 40%;">Gửi</button>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row (main row) -->
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('js')
@php
if(Session::has('message')){
echo Session::get('message');
}
@endphp
@endsection