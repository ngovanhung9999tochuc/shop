    <div class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @php
                    $displayUser='';
                    $displayLogin='';
                    $displayAdmin='style="display: none;"';

                    if(Auth::check()){
                    $displayUser='style="display: block;"';
                    $displayLogin='style="display: none;"';
                    }else{
                    $displayUser='style="display: none;"';
                    $displayLogin='style="display: block;"';
                    }
                    if(Gate::allows('admin')){
                    $displayAdmin='style="display: block;"';
                    }
                    @endphp

                    <div class="user-menu">
                        <ul class="row">
                            <div {!! $displayLogin !!} class="col-md-4" id="display-login-logout">
                                <li><a id="btn-login"><i class="fa fa-user"></i> Đăng nhập</a></li>
                                <li><a id="btn-register"><i class="fas fa-registered"></i></i> Đăng ký</a></li>
                            </div>
                            <div class="col-md-8">

                            </div>
                        </ul>
                    </div>
                </div>


                <div class="col-md-4">

                    <div id="header-right-login" {!! $displayUser !!} class="header-right">

                        <ul class="list-unstyled list-inline">
                            <li class="dropdown dropdown-small">
                                <a style="font-size: 14px;" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><span id="name-user-login" class="key">
                                        <b> @if(Auth::check())
                                            {{Auth::user()->name}}
                                            @endif</b>
                                    </span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('profile')}}" id="a-link-profile" style="font-size: 14px;"><b>Hồ sơ</b></a></li>
                                    <li {!! $displayAdmin !!} id="display-admin"><a href="{{route('admin.dashboard')}}" style="font-size: 14px;"><b>Quản trị</b></a></li>
                                    <li><a href="{{route('logout')}}" id="a-link-logout" style="font-size: 14px;"><b>Thoát</b></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End header area -->

    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="logo">
                        <h1><a href="{{route('home')}}"><img style="width: 176px; height: 64px;" src="/logo/logo.png"></a></h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="margin-top: 4%;" class="card">
                        <form method="GET" action="{{route('search')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" style="border-radius: 5px;" name="table_search" class="col-md-12" placeholder="Tìm mã hoặc tên sản phẩm">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-info"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="id01" class="modal col-md-12">
        <div class="modal-content animate">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>

            <div class="container">
                <div class="container">
                    <div class="col-md-12">
                        <div id="login">

                            <h2><span class="fontawesome-lock"></span>Đăng nhập</h2>

                            <form id="form-login" action="" method="POST">
                                @csrf
                                <fieldset>
                                    <p><label for="email">Tài khoản</label></p>
                                    <p><input type="email" id="email" value="" name="email" placeholder="mail@gmail.com"></p>
                                    <p id="validation-login-email" style="background-color: #dc3545;color: white;border-radius:3px; font-size: 14px;"></p>
                                    <p><label for="password">Mật khẩu</label></p>
                                    <p><input type="password" id="password" name="password" value="" placeholder="nhập mật khẩu"></p>
                                    <p id="validation-login-password" style="background-color: #dc3545;color: white;border-radius:3px; font-size: 14px;"></p>
                                    <p><input type="submit" value="Gửi"></p>

                                </fieldset>

                            </form>

                        </div> <!-- end login -->
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
                        <div id="login1">
                            <h2><span class="fontawesome-lock"></span>Đăng ký</h2>
                            <form id="form-register" action="" method="POST">
                                @csrf
                                <fieldset>
                                    <p><label>Họ tên</label></p>
                                    <p><input type="text" value="" name="fullname" value="" placeholder="nhập họ tên"></p>
                                    <p id="validation-register-fullname" style="background-color: #dc3545;color: white;border-radius:3px; font-size: 14px;"></p>


                                    <p><label>Email</label></p>
                                    <p><input type="email" value="" name="username" value="" placeholder="email@gmail.com"></p>
                                    <p id="validation-register-username" style="background-color: #dc3545;color: white;border-radius:3px; font-size: 14px;"></p>


                                    <p><label>Mật khẩu</label></p>
                                    <p><input type="password" name="password" value="" placeholder="nhập mật khẩu"></p>
                                    <p id="validation-register-password" style="background-color: #dc3545;color: white;border-radius:3px; font-size: 14px;"></p>


                                    <p><label>Nhập lại mật khẩu</label></p>
                                    <p><input type="password" name="repassword" value="" placeholder="nhập lại mật khẩu"></p>
                                    <p id="validation-register-repassword" style="background-color: #dc3545;color: white;border-radius:3px; font-size: 14px;"></p>
                                    <p><input type="submit" value="Gửi"></p>
                                </fieldset>
                            </form>
                        </div> <!-- end login -->
                    </div>
                </div>
            </div>

        </div>
    </div>