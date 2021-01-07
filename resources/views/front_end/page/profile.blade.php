@extends('front_end.layout.layoutP')
@section('content')
@section('css')
@endsection
<di class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2>Hồ sơ</h2>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="{{auth()->user()->image_icon}}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{auth()->user()->name}}</h3>
                                @php
                                $textRole='';
                                $roles=auth()->user()->roles;
                                foreach($roles as $role){
                                $textRole.=$role->display_name.', ';
                                }
                                @endphp
                                <p class="text-muted text-center">{{substr($textRole,0,-2)}}</p>
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Thông tin</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Đổi mật khẩu</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Đơn hàng</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <form method="POST" action="{{route('profile.info')}}" style="margin-top: 10px;" class="form-horizontal">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Họ tên</label>
                                                <div class="col-sm-10">
                                                    <input type="hidden" value="{{auth()->user()->id}}" name="id" />
                                                    <input type="text" class="form-control  @error('name') is-invalid @enderror" readonly name="name" value="{{auth()->user()->name}}">
                                                    @error('name')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Tài khoản</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control  @error('username') is-invalid @enderror" readonly name="username" value="{{auth()->user()->username}}">
                                                    @error('username')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Ngày sinh</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control @error('date_of_birth') is-invalid @enderror" type="date" name="date_of_birth" value="{{auth()->user()->date_of_birth}}">
                                                    @error('date_of_birth')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="exampleSelect1" class="col-sm-2 col-form-label">Giới tính</label>
                                                <div class="col-sm-10">
                                                    @php
                                                    $nam='';
                                                    $nu='';
                                                    if(auth()->user()->gender==1){
                                                    $nam='selected';
                                                    }else{
                                                    $nu='selected';
                                                    }
                                                    @endphp
                                                    <select class="form-control" name="gender" id="exampleSelect1">
                                                        <option {{$nam}} value="1">Nam</option>
                                                        <option {{$nu}} value="2">Nữ</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{auth()->user()->email}}">
                                                    @error('email')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Địa chỉ</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control  @error('address') is-invalid @enderror" name="address" value="{{auth()->user()->address}}">
                                                    @error('address')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Số điện thoại</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control  @error('phone') is-invalid @enderror" name="phone" value="{{auth()->user()->phone}}">
                                                    @error('phone')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-5">
                                                </div>
                                                <div class="col-sm-7">
                                                    <button type="submit" class="btn btn-danger">Cập Nhật</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="timeline">
                                        <form method="POST" action="{{route('profile.password')}}" style="margin-top: 10px;" class="form-horizontal">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Mật khẩu cũ</label>
                                                <div class="col-sm-9">
                                                    <input type="hidden" value="{{auth()->user()->id}}" name="id" />
                                                    <input type="password" class="form-control  @error('password_old') is-invalid @enderror" name="password_old" value="">
                                                    @error('password_old')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Mật khẩu mới</label>
                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control  @error('password_new') is-invalid @enderror" name="password_new" value="">
                                                    @error('password_new')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nhập lại mật khẩu mới</label>
                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control  @error('repassword_new') is-invalid @enderror" name="repassword_new" value="">
                                                    @error('repassword_new')
                                                    <div style="margin-top: 10px;" class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-5">
                                                </div>
                                                <div class="col-sm-7">
                                                    <button type="submit" class="btn btn-danger">Cập Nhật</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="settings">

                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <div style="background-color: white;" class="col-md-1"></div>
    </div>



    @endsection

    @section('js')

    @endsection