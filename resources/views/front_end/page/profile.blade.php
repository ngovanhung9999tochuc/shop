@extends('front_end.layout.layoutP')
@section('content')
@section('css')
<link href="{{asset('font_end/profile/profile.css')}}" rel="stylesheet" />
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
                                    <img class="profile-user-img img-fluid img-circle" id="image-icon-profile-user" src="{{asset(auth()->user()->image_icon)}}" alt="hình ảnh người dùng">
                                </div>
                                <h3 style="margin-top: 10px;" class="profile-username text-center">{{auth()->user()->name}}</h3>
                                @php
                                $textRole='';
                                $roles=auth()->user()->roles;
                                foreach($roles as $role){
                                $textRole.=$role->display_name.', ';
                                }
                                @endphp
                                <p class="text-muted text-center">{{substr($textRole,0,-2)}}</p>
                                <div style="text-align: center; color: black;">
                                    <button title="Chọn ảnh" id="btn-update-image" class="btn btn-info"><i class="fas fa-camera-retro"></i></button>
                                </div>
                                <br />
                                <div id="image-icon-user" style="display: none;" class="row form-group">

                                    <div class="col-sm-12">
                                        <form id="form-update-image-icon" method="post" style="text-align: center; ">
                                            @csrf
                                            <input type="hidden" value="{{auth()->user()->id}}" name="id" />
                                            <input type="file" onchange="changeImage(this)" class="form-control-file" name="image_icon">
                                            <div id="validation-update-image_icon"></div>
                                            <button title="Cập nhật" style="margin-top: 10px; text-align: center; " class="btn btn-info"><i class="fas fa-upload"></i></button>
                                        </form>
                                    </div>
                                </div>
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
                                                        <option {{$nu}} value="0">Nữ</option>
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
                                        <form id="form-update-password" method="POST" action="" style="margin-top: 10px;" class="form-horizontal">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Mật khẩu cũ</label>
                                                <div class="col-sm-9">
                                                    <input type="hidden" value="{{auth()->user()->id}}" name="id" />
                                                    <input type="password" class="form-control" name="password_old" value="">
                                                    <div id="validation-password-password_old"></div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Mật khẩu mới</label>
                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control" name="password_new" value="">
                                                    <div id="validation-password-password_new"></div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nhập lại mật khẩu mới</label>
                                                <div class="col-sm-9">
                                                    <input type="password" class="form-control" name="repassword_new" value="">
                                                    <div id="validation-password-repassword_new"></div>
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
                                        <div class="card-body">
                                            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Ngày đặt hàng</th>
                                                        <th>Số Lượng</th>
                                                        <th>Tổng tiền</th>
                                                        <th>Trình trạng</th>
                                                        <th>Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach(auth()->user()->bills()->latest()->get() as $bill)
                                                    <tr>
                                                        @php
                                                        $status='';
                                                        switch ($bill->status) {
                                                        case "0":
                                                        case "1":
                                                        $status='Xác nhận';
                                                        break;
                                                        case "2":
                                                        $status='Đang giao';
                                                        break;
                                                        case "3":
                                                        $status='Đã mua';
                                                        break;
                                                        case "4":
                                                        $status='Thất bại';
                                                        break;
                                                        default:
                                                        $status='Thất bại';
                                                        }
                                                        @endphp
                                                        <td>{{$bill->id}}</td>
                                                        <td>{{$bill->date_order}}</td>
                                                        <td>{{$bill->quantity}}</td>
                                                        <td>{{number_format($bill->total)}}đ</td>
                                                        <td>{{$status}}</td>
                                                        <td>
                                                            <a id="btn_info-{{$bill->id}}" onclick="showInfo(this)" class="btn-show-info btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane profile-info  -->
                                    <div id="profile-info" class="modal col-md-12">
                                        <div class="modal-content animate">
                                            <div class="imgcontainer">
                                                <span onclick="document.getElementById('profile-info').style.display='none'" class="close" title="Close Modal">&times;</span>
                                            </div>

                                            <div class="container">
                                                <div class="container">
                                                    <div class="col-md-12">
                                                        <div id="profile-table">
                                                            <div class="row">
                                                                <div class="card-body table-responsive p-0">
                                                                    <table class="table table-hover text-nowrap">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>ID</th>
                                                                                <th>Tên sản phẩm</th>
                                                                                <th>Số Lượng</th>
                                                                                <th>Giá</th>
                                                                                <th>Hình ảnh</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="table-product-bill">

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div> <!-- end login -->
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
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
    <script>
        const base_url1 = window.location.origin;
        let profileInfo = document.getElementById('profile-info');
        const btnUpdateImage = document.getElementById('btn-update-image');
        const imageIcon = document.getElementById('image-icon-profile-user')
        const imageIconUser = document.getElementById('image-icon-user');
        //event
        btnUpdateImage.addEventListener('click', function() {

            if (imageIconUser.style.display == 'none') {
                imageIconUser.style.display = 'block';
            } else {
                imageIconUser.style.display = 'none';
            }
        });

        function changeImage(inputImage) {
            imageIcon.src = URL.createObjectURL(inputImage.files[0]);
        }

        window.onclick = function(event) {
            if (event.target == profileInfo) {
                profileInfo.style.display = "none";
            }
        }

        $('#form-update-image-icon').submit(function(e) {
            e.preventDefault();
            clearErrorMessagesFormUpdateImage();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{route("profile.image")}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    this.reset();
                    if (data['success']) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Bạn cập nhật ảnh thành công',
                            showConfirmButton: false,
                            timer: 4000
                        });
                        imageIcon.src = data['image'];
                        imageIconUser.style.display = 'none';
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi ! bạn cập nhật ảnh không thành công',
                            showConfirmButton: false,
                            timer: 4000
                        });
                    }

                },
                error: function(error) {
                    let errors = error.responseJSON['errors'];
                    for (const key in errors) {
                        $('#validation-update-' + key).append('<div class="alert alert-danger">' + errors[key][0] + '</div');
                    }
                }
            });
        });
        //
        $('#form-update-password').submit(function(e) {
            e.preventDefault();
            clearErrorMessagesFormUpdatePassword();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{route("profile.password")}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    this.reset();
                    if (data['success']) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Bạn cập nhật mật khẩu mới thành công',
                            showConfirmButton: false,
                            timer: 4000
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Mật khẩu cũ không đúng',
                            showConfirmButton: false,
                            timer: 4000
                        });
                    }
                },
                error: function(error) {
                    let errors = error.responseJSON['errors'];
                    for (const key in errors) {
                        $('#validation-password-' + key).append('<div class="alert alert-danger">' + errors[key][0] + '</div');
                    }
                }
            });
        });



        //function
        function showInfo(info) {
            let [x, id] = info.id.split('-');
            let tableProductBill = document.getElementById('table-product-bill');
            let _token = document.getElementById('_token');
            request('{{route("profile.show")}}', JSON.stringify({
                '_token': _token.value,
                'id': id
            }), function(data) {
                data = JSON.parse(data);
                if (data['success']) {
                    let products = data['bill']['products'];
                    let tr = '';
                    for (const product of products) {

                        let td = '';
                        td += '<tr>';
                        td += '<td>' + product['id'] + '</td>';
                        td += '<td>' + product['name'] + '</td>';
                        td += '<td>' + product['pivot']['quantity'] + '</td>';
                        td += '<td>' + Number(product['pivot']['unit_price']).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ' + '</td>';
                        let image = product["image"];
                        var assetBaseUrl = "{{ asset('') }}"+image;
                        td += '<td><img src="'+assetBaseUrl+'" style="width:80px ; height: 80px;" /></td>';
                        td += '</tr>';
                        tr += td;
                    }
                    tableProductBill.innerHTML = tr;
                    profileInfo.style.display = "block";
                }
            });
        }

        function clearErrorMessagesFormUpdateImage() {
            document.getElementById('validation-update-image_icon').innerHTML = '';
        }

        function clearErrorMessagesFormUpdatePassword() {
            document.getElementById('validation-password-password_old').innerHTML = '';
            document.getElementById('validation-password-password_new').innerHTML = '';
            document.getElementById('validation-password-repassword_new').innerHTML = '';
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