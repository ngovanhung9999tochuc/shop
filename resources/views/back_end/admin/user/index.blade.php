@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('vendor/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/user/index/index.css')}}" rel="stylesheet" />

@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách người dùng',
    'name'=>'Người dùng','key'=>'Danh sách','route'=>route('user.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!--  <div class="card-header">
                            <div class="card-tools">
                                <form method="POST" action="{{route('user.search')}}">
                                    @csrf @method('post')
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm mã, số điện thoại, tên người dùng">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> -->
                        <!-- /.card-header -->
                        <div style="margin-top: 5px;" class="card-body table-responsive p-0">
                            <table id="table-user" class="table table-hover text-nowrap">
                                <thead>
                                    <tr style="font-size: 15px; font-weight: bold;">
                                        <th>ID</th>
                                        <th>Tên người dùng</th>
                                        <th>Tài khoản</th>
                                        <th>Số điện thoại</th>
                                        <th>Phân quyền</th>
                                        <th>Thao tác</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->username }}</td>
                                        <td>{{$user->phone}}</td>
                                        <td style="width: 450px;">
                                            <div class="form-group">
                                                <select id="{{$user->id}}" name="role_id[]" class="form-control select2_init select-roles" multiple>
                                                    @foreach($roles as $role)
                                                    <option title="{{ $role->display_name }}" {{ $user->roles->contains('id', $role->id) ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </td>
                                        <td>
                                            <a title="Xem thông tin" id="show_{{$user->id}}" class="btn btn-info btn-sm btn-show-info"><i class="fas fa-eye"></i></a>
                                            <button title="Xóa" data-url="{{route('user.destroy',$user->id)}}" value="{{$user->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
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
                                <div class="main-body">
                                    <div class="row gutters-sm">
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column align-items-center text-center">
                                                        <img id="image-avata" src="" alt="Admin" class="rounded-circle" width="150">
                                                        <div class="mt-3">
                                                            <h4 id="full-name">John Doe</h4>
                                                            <p id="roles" class="text-secondary mb-1">Full Stack Developer</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- fb -->
                                        </div>
                                        <div class="col-md-8">
                                            <div id="content" class="card mb-3">

                                            </div>

                                        </div>
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
    $('#table-user').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "order": [],
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });
</script>
<script src="{{asset('vendor/jquery-2.2.0.min.js')}}"></script>
<script src="{{asset('vendor/select2/select2.min.js')}}"></script>
<script src="{{asset('Admin/admin/delete.js')}}"></script>
<script>
    $(function() {
        $('.select2_init').select2({});

    });
    const base_url = "{{ asset('') }}";
    $('.select-roles').on('change', function() {
        let selected = $(this).find("option:selected");
        let arrSelected = [];
        let id = this.id;
        selected.each(function() {
            arrSelected.push($(this).val());
        });
        let _token = $('input[name="_token"]').val();
        $.ajax({
            url: '{{route("user.role")}}',
            method: "POST",
            dataType: "JSON",
            data: {
                'id': id,
                'role_ids': arrSelected,
                '_token': _token
            },
            success: function(data) {
                console.log(data);
            }
        });
    });

    //info
    // Get the modal
    let modal = document.getElementById('id01');
    let btnShowInfo = document.querySelectorAll('.btn-show-info');
    btnShowInfo.forEach(function(btn) {
        btn.addEventListener('click', function() {
            let [x, id] = this.id.split('_');
            let _token = $('input[name="_token"]').val();
            let fullName = document.getElementById('full-name');
            let roles = document.getElementById('roles');
            let content = document.getElementById('content');
            let imageAvata = document.getElementById('image-avata');
            $.ajax({
                url: '{{route("user.show")}}',
                method: "POST",
                dataType: "JSON",
                data: {
                    'id': id,
                    '_token': _token
                },
                success: function(data) {
                    let textContent = '';
                    textContent += '<div class="card-body">';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Họ Tên</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['name'];
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Email</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['email'];
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Địa Chỉ</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['address'] ? data[0]['address'] : '--';
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Số Điện Thoại</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['phone'] ? data[0]['phone'] : '--';
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Ngày Sinh</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['date_of_birth'] ? data[0]['date_of_birth'] : '--';
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Giới Tính</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['gender'] == null ? '--' : data[0]['gender'] == 1 ? 'Nam' : 'Nữ';
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '<hr>';
                    textContent += '<div class="row">';
                    textContent += '<div class="col-sm-3">';
                    textContent += '<h6 class="mb-0">Tài Khoản</h6>';
                    textContent += '</div>';
                    textContent += '<div class="col-sm-9 text-secondary">';
                    textContent += data[0]['username'];
                    textContent += '</div>';
                    textContent += '</div>';
                    textContent += '</div>';
                    let textRoles = '';
                    for (const i of data[1]) {
                        textRoles += i['display_name'] + ', ';
                    }

                    imageAvata.src = base_url + data[0]['image_icon'];
                    fullName.innerHTML = data[0]['name'];
                    roles.innerHTML = textRoles.substring(0, textRoles.length - 2);
                    content.innerHTML = textContent;
                    modal.style.display = "block";
                }
            });

        });
    });
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

@endsection