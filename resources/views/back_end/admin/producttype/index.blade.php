@extends('back_end.layout.layout')
@section('content')
@section('css')


@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách loại sản phẩm',
    'name'=>'producttype','key'=>'list','route'=>route('producttype.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-success btn-sm" style="width: 100px;" href="{{route('producttype.create')}}"><i class="fas fa-plus"> Thêm mới</i></a>
                            <div class="card-tools">
                                <form method="POST" action="{{route('producttype.search')}}">
                                    @csrf @method('post')
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên loại</th>
                                        <th>Hình ảnh</th>
                                        <th>Loại cha</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productTypes as $productType)
                                    <tr>
                                        <td>{{$productType->id}}</td>
                                        <td>{{$productType->name}}</td>
                                        <td>
                                            @if($productType->icon)
                                                <img src="{{$productType->icon}}" alt="icon" style="width:200px ; height: 50px;" />
                                            @endif
                                        </td>
                                        <td>{{optional($productType->productTypeParent)->name}}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{route('producttype.edit',$productType->id)}}"><i class="fas fa-pencil-alt"></i></a>
                                            <button data-url="{{route('producttype.destroy',$productType->id)}}" value="{{$productType->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
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
                {{$productTypes->links()}}
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