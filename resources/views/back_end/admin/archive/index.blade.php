@extends('back_end.layout.layout')
@section('content')
@section('css')

<link href="{{asset('Admin/admin/bill/index/index.css')}}" rel="stylesheet" />
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách sản phẩm tồn kho',
    'name'=>'Kho','key'=>'Danh sách','route'=>route('archive.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-barcode"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Tổng sản phẩm</span>
                            <span class="info-box-number">
                                {{$archives['quantity_product']}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-tag blue"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Tổng số lượng tồn kho</span>
                            <span class="info-box-number">{{$archives['inventory']}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-sync-alt"></i></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tổng vốn tồn kho</span>
                            <span class="info-box-number">{{number_format($archives['total_original_price'])}}đ</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Tổng giá trị tồn kho</span>
                            <span class="info-box-number">{{number_format($archives['total_unit_price'])}}đ</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-tools row">
                                        <form class="col-md-4" method="POST" action="{{route('archive.producttype')}}">
                                            @csrf @method('post')
                                            <div class=" input-group input-group-sm">
                                                <select name="product_type" class="form-control">
                                                    <option value="0">Tìm kiếm danh mục</option>
                                                    {!!$archives['htmlOption']!!}
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                      
                                        <form method="POST" class=" col-md-4 float-right" action="{{route('archive.search')}}">
                                            @csrf @method('post')
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-sm" style="width: 250px;">
                                                        <input type="text" name="product_id" class="form-control float-right" value="" placeholder="Tìm mã sản phẩm">
                                                        <div class="input-group-append">
                                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="col-md-4">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng tồn</th>
                                        <th>Vốn tồn kho</th>
                                        <th>Giá trị tồn kho</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($archives['archive'] as $product)
                                    <tr>
                                        <td>{{$product->product_id}}</td>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->quantity}}</td>
                                        <td>{{number_format($product->total_original_price)}}đ</td>
                                        <td>{{number_format($product->total_unit_price)}}đ</td>
                                    </tr>
                                    @endforeach
                                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('js')

@endsection