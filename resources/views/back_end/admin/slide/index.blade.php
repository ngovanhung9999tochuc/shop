@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('Admin/admin/slide/index/index.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/slide/index/index2.css')}}" rel="stylesheet" />
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách khuyến mãi',
    'name'=>'khuyến mãi','key'=>'Danh sách','route'=>route('slide.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <button id="btn-add-slide" class="btn btn-success btn-sm" style="width: 100px;"><i class="fas fa-plus"> Thêm mới</i></button>
                            <div class="card-tools">
                                <form method="POST" action="{{route('slide.search')}}">
                                    @csrf @method('post')
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm mã hoặc tiêu đề khuyến mãi">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> -->
                        <!-- /.card-header -->
                        <div style="margin-top: 5px;" class="card-body table-responsive p-0">
                            <button id="btn-add-slide" class="btn btn-success btn-sm float-right" style="width: 100px; margin: 0px 20px;"><i class="fas fa-plus"> Thêm mới</i></button>
                            <table id="table-slide" class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Miêu tả</th>
                                        <th>Hình ảnh</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="trbody">
                                    @foreach($slides as $slide)
                                    <tr>
                                        <td id="id-{{$slide->id}}">{{$slide->id}}</td>
                                        <td id="title-{{$slide->id}}">{{$slide->title}}</td>
                                        <td id="description-{{$slide->id}}">{{$slide->description}}</td>
                                        <td><img id="image-{{$slide->id}}" src="{{$slide->image}}" alt="image" style="width:250px ; height: 80px;" /></td>
                                        <td>
                                            <button id="btn-edit-{{$slide->id}}" title="Sửa khuyến mãi" onclick="editSlide(this)" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>
                                            <button title="Xóa" data-url="{{route('slide.destroy',$slide->id)}}" value="{{$slide->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
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
                                            <h3 class="card-title"><b>Thêm khuyến mãi</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-add-slide" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Tiêu đề</label>
                                                    <input type="text" name="title" class="form-control" value="" placeholder="nhập tiêu đề">
                                                    <div style="margin-top: 5px;" id="validation-add-title"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Hình ảnh</label>
                                                    <input type="file" id="image" name="image" class="form-control-file" value="">
                                                    <div style="margin-top: 10px;" id="validation-add-image"></div>
                                                    <img id="output-image" />
                                                </div>

                                                <div class="form-group">
                                                    <label>Miêu tả</label>
                                                    <textarea class="form-control" name="description" placeholder="nhập miêu tả"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Link</label>
                                                    <input type="text" name="link" class="form-control" value="" placeholder="nhập link khuyến mãi">
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
                                            <h3 class="card-title"><b>Sửa khuyến mãi</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-edit-slide" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="" />
                                                <div class="form-group">
                                                    <label>Tiêu đề</label>
                                                    <input type="text" name="title" class="form-control" value="" placeholder="nhập tiêu đề">
                                                    <div style="margin-top: 5px;" id="validation-edit-title"></div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Hình ảnh</label>
                                                    <input type="file" id="image-edit" name="image" class="form-control-file" value="">
                                                    <div style="margin-top: 10px;" id="validation-edit-image"></div>
                                                    <img id="output-image-edit" />
                                                </div>

                                                <div class="form-group">
                                                    <label>Miêu tả</label>
                                                    <textarea class="form-control" name="description" placeholder="nhập miêu tả"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Link</label>
                                                    <input type="text" name="link" class="form-control" value="" placeholder="nhập link khuyến mãi">
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
<script src="{{asset('Admin/admin/slide/index/index.js')}}"></script>
<script>
    $(function() {
        $('#table-slide').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection