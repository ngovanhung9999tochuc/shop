@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('vendor/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/user/index/index.css')}}" rel="stylesheet" />

@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách người dùng',
    'name'=>'user','key'=>'list','route'=>route('user.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
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
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
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
                {{$users->links()}}

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
<script src="{{asset('vendor/jquery-2.2.0.min.js')}}"></script>
<script src="{{asset('vendor/select2/select2.min.js')}}"></script>
<script src="{{asset('Admin/admin/delete.js')}}"></script>
<script src="{{asset('Admin/admin/user/index/index.js')}}"></script>

@endsection