@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('Admin/admin/supplier/index/index.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/supplier/index/index2.css')}}" rel="stylesheet" />

@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách nhà cung cấp',
    'name'=>'Nhà cung cấp','key'=>'Danh sách','route'=>route('supplier.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!--  <div class="card-header">
                            <button id="btn-add-supplier" class="btn btn-success btn-sm" style="width: 100px;"><i class="fas fa-plus"> Thêm mới</i></button>
                            <div class="card-tools">
                                <form method="POST" action="{{route('supplier.search')}}">
                                    @csrf @method('post')
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm mã hoặc tên nhà cung cấp">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> -->
                        <!-- /.card-header -->
                        <div style="margin-top: 5px;" class="card-body table-responsive p-0">
                            <button id="btn-add-supplier" class="btn btn-success btn-sm float-right" style="width: 100px; margin: 0px 20px;"><i class="fas fa-plus"> Thêm mới</i></button>
                            <table id="table-supplier" class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên nhà cung cấp</th>
                                        <th>Email</th>
                                        <th>Địa chỉ</th>
                                        <th>Số điện thoại</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="trbody">
                                    @foreach($suppliers as $supplier)
                                    <tr>
                                        <td id="id-{{$supplier->id}}">{{$supplier->id}}</td>
                                        <td id="name-{{$supplier->id}}">{{$supplier->name}}</td>
                                        <td id="email-{{$supplier->id}}">{{$supplier->email}}</td>
                                        <td id="address-{{$supplier->id}}">{{$supplier->address}}</td>
                                        <td id="phone-{{$supplier->id}}">{{$supplier->phone}}</td>
                                        <td>
                                            <button id="btn-edit-{{$supplier->id}}" title="Sửa nhà cung cấp" onclick="editSupplier(this)" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>

                                            <button title="Xóa" data-url="{{route('supplier.destroy',$supplier->id)}}" value="{{$supplier->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                                            <h3 class="card-title"><b>Thêm nhà cung cấp</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-supplier" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Tên nhà cung cấp</label>
                                                    <input type="text" id="name" name="name" class="form-control" value="" placeholder="nhập tên nhà cung cấp">
                                                    <div id="validation-name"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" id="email" name="email" class="form-control" value="" placeholder="nhập email">
                                                    <div id="validation-email"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Địa chỉ</label>
                                                    <input type="text" id="address" name="address" class="form-control" value="" placeholder="nhập địa chỉ">
                                                    <div id="validation-address"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Số điện thoại</label>
                                                    <input type="text" id="phone" name="phone" class="form-control" value="" placeholder="nhập số điện thoại">
                                                    <div id="validation-phone"></div>
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
                                            <h3 class="card-title"><b>Sửa nhà cung cấp</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-supplier-edit" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="" />
                                                <div class="form-group">
                                                    <label>Tên nhà cung cấp</label>
                                                    <input type="text" name="name" class="form-control" value="" placeholder="nhập tên nhà cung cấp">
                                                    <div id="validation-edit-name"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control" value="" placeholder="nhập email">
                                                    <div id="validation-edit-email"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Địa chỉ</label>
                                                    <input type="text" name="address" class="form-control" value="" placeholder="nhập địa chỉ">
                                                    <div id="validation-edit-address"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Số điện thoại</label>
                                                    <input type="text" name="phone" class="form-control" value="" placeholder="nhập số điện thoại">
                                                    <div id="validation-edit-phone"></div>
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
    </section>
</div>
@endsection
@section('js')
<script>
    $('#table-supplier').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });
</script>
<script src="{{asset('vendor/jquery-2.2.0.min.js')}}"></script>
<script src="{{asset('Admin/admin/delete.js')}}"></script>
<script src="{{asset('Admin/admin/supplier/index/index.js')}}"></script>
@endsection