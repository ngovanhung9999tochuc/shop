@extends('back_end.layout.layout')
@section('content')
@section('css')


@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách sản phẩm',
    'name'=>'product','key'=>'list','route'=>route('product.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-success btn-sm" style="width: 100px;" href="{{route('product.create')}}"><i class="fas fa-plus"> Thêm mới</i></a>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá bán</th>
                                        <th>Khuyến mãi</th>
                                        <th>Hình ảnh</th>
                                        <th>Loại sản phẩm</th>
                                        <th>Nhập giá</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td>{{$product->name}}</td>
                                        <td>{{number_format($product->unit_price)}}</td>
                                        <td>{{$product->promotion_price}}%</td>
                                        <td><img src="{{$product->image}}" style="width:100px ; height: 100px;" /></td>
                                        <td>{{$product->productType->productTypeParent->name." ".$product->productType->name}}</td>
                                        <td><a class="btn btn-success btn-sm" style="width: 100px;" href=""><i class="fas fa-plus"> Nhập giá</i></a></td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{route('product.edit',$product->id)}}"><i class="fas fa-pencil-alt"></i></a>
                                            <button data-url="{{route('product.destroy',$product->id)}}" value="{{$product->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                {{$products->links()}}
            </div>

        </div>
        <!-- /.row (main row) -->
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('js')
<script src="{{asset('Admin/admin/delete.js')}}"></script>
@endsection