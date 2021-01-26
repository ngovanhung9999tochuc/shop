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
                                        <td><img id="image-{{$slide->id}}" src="{{ asset($slide->image)}}" alt="image" style="width:250px ; height: 80px;" /></td>
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
<script>
    $(function() {
        $('#table-slide').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "order": [],
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });
    //
    const base_url = "{{ asset('') }}";
    const modal = document.getElementById('id01');
    const modal2 = document.getElementById('id02');
    const btnAddSlide = document.getElementById('btn-add-slide');
    const formAddSlide = document.getElementById('form-add-slide');
    const formEditSlide = document.getElementById('form-edit-slide');
    const trBody = document.getElementById('trbody');
    const image = document.getElementById('image');
    const imageEdit = document.getElementById('image-edit');
    const outputImageEdit = document.getElementById('output-image-edit');
    //event
    window.onclick = function(event) {
        if (event.target == modal || event.target == modal2) {
            modal.style.display = "none";
            modal2.style.display = "none";
        }
    }

    image.addEventListener('change', function() {
        const outputImage = document.getElementById('output-image');
        outputImage.src = URL.createObjectURL(this.files[0]);
        outputImage.style.height = '150px';
        outputImage.style.marginTop = '10px';
    });

    imageEdit.addEventListener('change', function() {
        outputImageEdit.src = URL.createObjectURL(this.files[0]);
        outputImageEdit.style.height = '150px';
        outputImageEdit.style.marginTop = '10px';
    });


    btnAddSlide.addEventListener('click', function() {
        modal.style.display = "block";
        clearErrorMessagesAdd();
        formAddSlide.reset();
    });

    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#form-add-slide').submit(function(e) {
            e.preventDefault();
            clearErrorMessagesAdd();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{route("slide.store")}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    this.reset();
                    if (data['success']) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Bạn thêm khuyến mãi thành công',
                            showConfirmButton: false,
                            timer: 4000
                        });
                        let slide = data['slide'];
                        let tr = document.createElement('tr');
                        let dataSlide = '';
                        dataSlide += '<tr>';
                        dataSlide += '<td id="id-' + slide['id'] + '" >' + slide['id'] + '</td>';
                        dataSlide += '<td id="title-' + slide['id'] + '" >' + slide['title'] + '</td>';
                        dataSlide += '<td id="description-' + slide['id'] + '" >' + slide['description'] + '</td>';
                        dataSlide += '<td><img id="image-' + slide['id'] + '" src="' + slide['image'] + '" alt="image" style="width:250px ; height: 80px;" /></td>';
                        dataSlide += '<td>';
                        dataSlide += '<button id="btn-edit-' + slide['id'] + '" title="Sửa khuyến mãi" onclick="editSlide(this)"  class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                        dataSlide += '<button title="Xóa" data-url="' + base_url + 'admin/slide/' + slide['id'] + '" value="' + slide['id'] + '" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>';
                        dataSlide += '</td>';
                        dataSlide += '</tr>';
                        tr.innerHTML = dataSlide;
                        trBody.prepend(tr);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi hệ thống ! bạn thêm khuyến mãi không thành công',
                            showConfirmButton: false,
                            timer: 4000
                        });
                    }

                },
                error: function(error) {
                    let errors = error.responseJSON['errors'];
                    for (const key in errors) {
                        $('#validation-add-' + key).append('<div class="alert alert-danger">' + errors[key][0] + '</div');
                    }
                }
            });
        });



        $('#form-edit-slide').submit(function(e) {
            e.preventDefault();
            clearErrorMessagesEdit();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{route("slide.update")}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    if (data['success']) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Bạn sửa khuyến mãi thành công',
                            showConfirmButton: false,
                            timer: 4000
                        });
                        let slide = data['slide'];
                        document.getElementById('id-' + slide['id']).innerHTML = slide['id'];
                        document.getElementById('title-' + slide['id']).innerHTML = slide['title'];
                        document.getElementById('description-' + slide['id']).innerHTML = slide['description'];
                        document.getElementById('image-' + slide['id']).src = base_url +slide['image'];
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi hệ thống ! bạn sửa khuyến mãi không thành công',
                            showConfirmButton: false,
                            timer: 4000
                        });
                    }

                },
                error: function(error) {
                    let errors = error.responseJSON['errors'];
                    for (const key in errors) {
                        $('#validation-edit-' + key).append('<div class="alert alert-danger">' + errors[key][0] + '</div');
                    }
                }
            });
        });
    });





    //function

    function editSlide(edit) {
        const _token = document.getElementById('_token');
        let [x, y, id] = edit.id.split('-')

        clearErrorMessagesEdit();
        formEditSlide.reset();

        request('{{route("slide.edit")}}', JSON.stringify({
            '_token': _token.value,
            'id': id
        }), function(data) {
            data = JSON.parse(data)['slide'];
            formEditSlide['id'].value = data['id'];
            formEditSlide['title'].value = data['title'];
            formEditSlide['description'].value = data['description'];
            formEditSlide['link'].value = data['link'];
            outputImageEdit.src = base_url + data['image'];
            outputImageEdit.style.height = '150px';
            outputImageEdit.style.marginTop = '10px';
            modal2.style.display = "block";
        });
    }


    function clearErrorMessagesAdd() {
        document.getElementById('validation-add-title').innerHTML = '';
        document.getElementById('validation-add-image').innerHTML = '';
    }


    function clearErrorMessagesEdit() {
        document.getElementById('validation-edit-title').innerHTML = '';
        document.getElementById('validation-edit-image').innerHTML = '';
    }

    function request(url = "", para = "", callbackSuccess = function() {}, callbackError = function(err) {
        console.log(err)
    }) {
        let xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                callbackSuccess(this.responseText);
            } else if (this.readyState == 4 && this.status == 500) {
                callbackError(this.responseText);
            }
        }
        xmlHttp.open("POST", url, true);
        xmlHttp.setRequestHeader("Content-type", "application/json");
        xmlHttp.send(para);
    }
</script>
@endsection