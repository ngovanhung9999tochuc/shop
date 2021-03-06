@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('Admin/admin/menu/index/index.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/menu/index/index2.css')}}" rel="stylesheet" />
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách menu',
    'name'=>'menu','key'=>'list','route'=>route('menu.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <button id="btn-add-menu" class="btn btn-success btn-sm" style="width: 100px;"><i class="fas fa-plus"> Thêm mới</i></button>
                            <div class="card-tools">
                                <form method="POST" action="{{route('menu.search')}}">
                                    @csrf @method('post')
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm mã hoặc tên menu">
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
                                        <th>Tên menu</th>
                                        <th>Thuộc menu</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="trbody">
                                    @foreach($menus as $menu)
                                    <tr>
                                        <td id="id-{{$menu->id}}">{{$menu->id}}</td>
                                        <td id="name-{{$menu->id}}">{{$menu->name}}</td>
                                        <td id="parent-{{$menu->id}}">{{optional($menu->menuParent)->name}}</td>
                                        <td>
                                            <button id="btn-edit-{{$menu->id}}" title="Sửa" onclick="editMenu(this)"  class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>
                                            <button title="Xóa" data-url="{{route('menu.destroy',$menu->id)}}" value="{{$menu->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
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
                {{$menus->links()}}
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
                                            <h3 class="card-title"><b>Thêm menu</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-add-menu" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Tên menu</label>
                                                    <input type="text" name="name" class="form-control" value="" placeholder="nhập tên menu">
                                                    <div style="margin-top: 5px;" id="validation-add-name"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Thuộc menu</label>
                                                    <select id="parent-add" class="form-control" name="parent_id">

                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label> Liên kết loại sản phẩm</label>
                                                    <select id="product-type-link-add" class="form-control" name="product_type_link">
                                                    </select>
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
                                            <h3 class="card-title"><b>Sửa menu</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-edit-menu" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value=""/>
                                                <div class="form-group">
                                                    <label>Tên menu</label>
                                                    <input type="text" name="name" class="form-control" value="" placeholder="nhập tên menu">
                                                    <div style="margin-top: 5px;" id="validation-edit-name"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Thuộc menu</label>
                                                    <select id="parent-edit" class="form-control" name="parent_id">

                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Liên kết loại sản phẩm</label>
                                                    <select id="product-type-link-edit" class="form-control" name="product_type_link">
                                                    </select>
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
<script src="{{asset('Admin/admin/menu/index/index.js')}}"></script>
@endsection