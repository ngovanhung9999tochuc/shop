@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('Admin/admin/producttype/index/index.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/producttype/index/index2.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/producttype/index/index3.css')}}" rel="stylesheet" />
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách danh mục',
    'name'=>'Danh mục','key'=>'Danh sách','route'=>route('producttype.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <button id="btn-add-type" class="btn btn-success btn-sm" style="width: 100px;"><i class="fas fa-plus"> Thêm mới</i></button>
                            <div class="card-tools">
                               <form method="POST" action="{{route('producttype.search')}}">
                                    @csrf @method('post')
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm mã hoặc tên danh mục">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form> 
                            </div>
                        </div> -->

                        <div style="margin-top: 5px;" class="card-body table-responsive p-0">
                            <button id="btn-add-type" class="btn btn-success btn-sm float-right " style="width: 100px; margin: 0px 20px;"><i class="fas fa-plus"> Thêm mới</i></button>
                            <table id="table-product-type" class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên danh mục</th>
                                        <th>Hình ảnh</th>
                                        <th>Danh mục cha</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="trbody">
                                    @foreach($productTypes as $productType)
                                    <tr>
                                        <td id="id-{{$productType->id}}">{{$productType->id}}</td>
                                        @php
                                            $text='';
                                            if($productType->parent_id==0){
                                                $text=' ('.$productType->productTypeChildrents->count().' danh mục con)';
                                            }else{
                                                $text=' ('.$productType->products->count().' sản phẩm)';
                                            }
                                        @endphp
                                        <td id="name-{{$productType->id}}">{{$productType->name}}{{$text}}</td>
                                        <td id="icon-{{$productType->id}}">
                                            @if($productType->icon)
                                            <img src="{{$productType->icon}}" alt="icon" style="width:200px ; height: 50px;" />
                                            @endif
                                        </td>
                                        <td id="parent-{{$productType->id}}">{{optional($productType->productTypeParent)->name}}</td>
                                        <td>
                                            <button id="btn-edit-{{$productType->id}}" title="Sửa" onclick="editProductType(this)" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>
                                            <button title="Xóa" data-url="{{route('producttype.destroy',$productType->id)}}" value="{{$productType->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
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
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                <div id="id01" class="modal col-md-12">
                    <div class="modal-content animate">
                        <div class="imgcontainer">
                            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                        </div>

                        <div class="container">
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="card card-info">
                                        <div class="card-header" style="background-color: #28a745;">
                                            <h3 class="card-title"><b>Thêm danh mục</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-add-type" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Tên danh mục*</label>
                                                    <input type="text" name="name" class="form-control" value="" placeholder="nhập tên danh mục">
                                                    <div style="margin-top: 5px;" id="validation-add-name"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Danh mục cha</label>
                                                    <select id="parent_id" class="form-control" name="parent_id">

                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Hình ảnh danh mục</label>
                                                    <input type="file" id="image" name="image_file" class="form-control-file" value="">
                                                    <img id="output-image" />
                                                    <div style="margin-top: 10px;" id="validation-add-image_file"></div>
                                                </div>

                                                <button style="width: 100px; margin-left: 40%;" type="submit" class="btn btn-primary">Lưu</button>
                                            </form>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div id="id02" class="modal col-md-12">
                    <div class="modal-content animate">
                        <div class="imgcontainer">
                            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                        </div>

                        <div class="container">
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="card card-info">
                                        <div class="card-header" style="background-color: #28a745;">
                                            <h3 class="card-title"><b>Sửa danh mục</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-edit-type" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="" />
                                                <div class="form-group">
                                                    <label>Tên danh mục*</label>
                                                    <input type="text" name="name" class="form-control" value="" placeholder="nhập tên danh mục">
                                                    <div style="margin-top: 5px;" id="validation-edit-name"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label>danh mục cha</label>
                                                    <select id="parent-edit" class="form-control" name="parent_id">

                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Hình ảnh danh mục</label>
                                                    <input type="file" id="image-edit" name="image_file" class="form-control-file" value="">
                                                    <img id="output-image-edit" />
                                                    <div style="margin-top: 10px;" id="validation-edit-image_file"></div>
                                                </div>
                                                <button style="width: 150px; margin-left: 37%;" type="submit" class="btn btn-primary">Cập Nhật</button>
                                            </form>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="id03" class="modal col-md-12">

                    <div class="modal-content animate">
                        <div class="imgcontainer">
                            <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
                        </div>

                        <div class="container">
                            <div class="container">
                                <div class="main-body">
                                    <div class="row">
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Tên</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-product-or-product-type">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<script src="{{asset('Admin/admin/producttype/index/delete.js')}}"></script>
<script src="{{asset('Admin/admin/producttype/index/index.js')}}"></script>
<script>
    $(function() {
        $('#table-product-type').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "order": [],
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection