@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('Admin/admin/role/index/index.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/role/index/index2.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/role/index/index3.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/role/index/index4.css')}}" rel="stylesheet" />
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách vai trò',
    'name'=>'Vai trò','key'=>'Danh sách','route'=>route('role.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <button id="btn-add-role" class="btn btn-success btn-sm" style="width: 100px;"><i class="fas fa-plus"> Thêm mới</i></button>
                            <div class="card-tools">
                                <form method="POST" action="{{route('role.search')}}">
                                    @csrf @method('post')
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm mã hoặc tên vai trò">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div> -->
                    </div>
                    <!-- /.card-header -->
                    <div style="margin-top: 5px;" class="card-body table-responsive p-0">
                        <button id="btn-add-role" class="btn btn-success btn-sm float-right" style="width: 100px; margin: 0px 20px;"><i class="fas fa-plus"> Thêm mới</i></button>
                        <table id="table-role" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên vai trò</th>
                                    <th>Miêu tả vai trò</th>
                                    <th>Phân quyền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="trbody">
                                @foreach($roles as $role)
                                <tr>
                                    <td id="id-{{$role->id}}">{{$role->id}}</td>
                                    <td id="name-{{$role->id}}">{{$role->name}}</td>
                                    <td id="display-{{$role->id}}">{{$role->display_name}}</td>
                                    <td><button id="btn-permission-{{$role->id}}" onclick="grantingPermission(this)" class="btn btn-success btn-sm btn-price" style="width: 120px;"><i class="fas fa-plus"> Phân quyền</i></button></td>
                                    <td>
                                        <button id="btn-edit-{{$role->id}}" title="Sửa" onclick="editRole(this)" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>
                                        <button title="Xóa" data-url="{{route('role.destroy',$role->id)}}" value="{{$role->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
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
                                        <h3 class="card-title"><b>Thêm vai trò</b></h3>
                                    </div>
                                    <div class="card-body">
                                        <form id="form-add-role" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Tên vai trò</label>
                                                <input type="text" name="name" class="form-control" value="" placeholder="nhập tên vai trò">
                                                <div style="margin-top: 5px;" id="validation-add-name"></div>
                                            </div>

                                            <div class="form-group">
                                                <label>Miêu tả vai trò</label>
                                                <input type="text" name="display_name" class="form-control" value="" placeholder="nhập miêu tả vai trò">
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
                                        <h3 class="card-title"><b>Sửa vai trò</b></h3>
                                    </div>
                                    <div class="card-body">
                                        <form id="form-edit-role" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="" />
                                            <div class="form-group">
                                                <label>Tên vai trò</label>
                                                <input type="text" name="name" class="form-control" value="" placeholder="nhập tên vai trò">
                                                <div style="margin-top: 5px;" id="validation-edit-name"></div>
                                            </div>

                                            <div class="form-group">
                                                <label>Miêu tả vai trò</label>
                                                <input type="text" name="display_name" class="form-control" value="" placeholder="nhập miêu tả vai trò">
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
                            <div class="col-md-12">
                                <div class="card card-info">
                                    <div class="card-header" style="background-color: #28a745;">
                                        <h3 class="card-title"><b>Phân quyền</b></h3>
                                    </div>
                                    <div class="card-body">

                                        <form id="form-permission-role" method="POST">
                                            @csrf
                                            <input type="hidden" id="role-id-permissions" name="id" value="" />
                                            <div id="list-permissions" class="row my-4">
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

            <div id="id04" class="modal col-md-12">

                <div class="modal-content animate">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
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
                                                    <th>Tên người dùng</th>
                                                    <th>Tài khoản</th>
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
<!-- <script src="{{asset('Admin/admin/role/index/index.js')}}"></script> -->
<script src="{{asset('Admin/admin/role/index/delete.js')}}"></script>
<script>
    $(function() {
        $('#table-role').DataTable({
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
    const modal3 = document.getElementById('id03');
    const modal4 = document.getElementById('id04');
    const btnAddRole = document.getElementById('btn-add-role');
    const formAddRole = document.getElementById('form-add-role');
    const formEditRole = document.getElementById('form-edit-role');
    const trBody = document.getElementById('trbody');
    //event
    window.onclick = function(event) {
        if (event.target == modal || event.target == modal2 || event.target == modal3 || event.target == modal4) {
            modal.style.display = "none";
            modal2.style.display = "none";
            modal3.style.display = "none";
            modal4.style.display = "none";
        }
    }
    btnAddRole.addEventListener('click', function() {
        modal.style.display = "block";
        clearErrorMessagesAdd()
        formAddRole.reset();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#form-add-role').submit(function(e) {
        e.preventDefault();
        clearErrorMessagesAdd();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{route("role.store")}}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                this.reset();
                if (data['success']) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bạn thêm vai trò thành công',
                        showConfirmButton: false,
                        timer: 4000
                    });
                    let role = data['role'];

                    let tr = document.createElement('tr');
                    let dataRole = '';
                    dataRole += '<tr>';
                    dataRole += '<td id="id-' + role['id'] + '">' + role['id'] + '</td>';
                    dataRole += '<td id="name-' + role['id'] + '">' + role['name'] + '</td>';
                    dataRole += '<td id="display-' + role['id'] + '">' + role['display_name'] + '</td>';
                    dataRole += '<td><button id="btn-permission-' + role['id'] + '" onclick="grantingPermission(this)" class="btn btn-success btn-sm btn-price" style="width: 120px;"><i class="fas fa-plus"> Phân quyền</i></button></td>';
                    dataRole += '<td>';
                    dataRole += '<button id="btn-edit-' + role['id'] + '" title="Sửa" onclick="editRole(this)"  class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                    dataRole += '<button title="Xóa" data-url="' + base_url + 'admin/role/' + role['id'] + '" value="' + role['id'] + '" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>';
                    dataRole += '</td>';
                    dataRole += '</tr>';
                    tr.innerHTML = dataRole;
                    trBody.prepend(tr);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi hệ thống ! bạn thêm vai trò không thành công',
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

    $('#form-edit-role').submit(function(e) {
        e.preventDefault();
        clearErrorMessagesEdit();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{route("role.update")}}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                if (data['success']) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bạn sửa vai trò thành công',
                        showConfirmButton: false,
                        timer: 4000
                    });
                    let role = data['role'];
                    document.getElementById('name-' + role['id']).innerHTML = role['name'];
                    document.getElementById('display-' + role['id']).innerHTML = role['display_name'];
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi hệ thống ! bạn sửa vai trò không thành công',
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


    $('#form-permission-role').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '{{route("role.permission.update")}}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                if (data['success']) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bạn phân quyền thành công',
                        showConfirmButton: false,
                        timer: 4000
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Quản trị có quyền quản lý cao nhất, không thể sửa đổi',
                        showConfirmButton: false,
                        timer: 4000
                    });
                }
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống !',
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });
    });


    //function
    function editRole(edit) {
        const _token = document.getElementById('_token');
        let [x, y, id] = edit.id.split('-');

        clearErrorMessagesEdit();
        formEditRole.reset();
        request('{{route("role.edit")}}', JSON.stringify({
            '_token': _token.value,
            'id': id
        }), function(data) {
            data = JSON.parse(data);
            if (data['success']) {
                let role = data['role'];
                formEditRole['id'].value = role['id'];
                formEditRole['name'].value = role['name'];
                formEditRole['display_name'].value = role['display_name'];
                modal2.style.display = "block";
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống !',
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });

    }

    function grantingPermission(btnPermission) {
        let [x, y, id] = btnPermission.id.split('-');
        const _token = document.getElementById('_token');
        const listPermission = document.getElementById('list-permissions');
        const roleIdPermissions = document.getElementById('role-id-permissions');

        request('{{route("role.permission")}}', JSON.stringify({
            '_token': _token.value,
            'id': id
        }), function(data) {
            data = JSON.parse(data);

            if (data['success']) {
                let htmlList = data['htmlList'];
                listPermission.innerHTML = htmlList;
                roleIdPermissions.value = data['id'];
                modal3.style.display = "block";
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống !',
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });
    }



    function clearErrorMessagesAdd() {
        document.getElementById('validation-add-name').innerHTML = '';
    }

    function clearErrorMessagesEdit() {
        document.getElementById('validation-edit-name').innerHTML = '';
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