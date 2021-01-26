@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('Admin/admin/supplier/index/index.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/supplier/index/index2.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/supplier/index/index3.css')}}" rel="stylesheet" />
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

                <div id="id03" class="modal col-md-12">

                    <div class="modal-content animate">
                        <div class="imgcontainer">
                            <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
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
                                                        <th>Ngày nhập</th>
                                                        <th>Người nhập</th>
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
    </section>
</div>
@endsection
@section('js')
<script>
    $('#table-supplier').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "order": [],
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });
    //
    var base_url = "{{ asset('') }}";
    let btnAddSupplier = document.getElementById('btn-add-supplier');
    const modal = document.getElementById('id01');
    const modal2 = document.getElementById('id02');
    const modal3 = document.getElementById('id03');
    const formSupplier = document.getElementById('form-supplier');
    const formSupplierEdit = document.getElementById('form-supplier-edit');
    const trBody = document.getElementById('trbody');

    //event
    window.onclick = function(event) {
        if (event.target == modal || event.target == modal2 || event.target == modal3) {
            modal.style.display = "none";
            modal2.style.display = "none";
            modal3.style.display = "none";
        }
    }

    btnAddSupplier.addEventListener('click', function() {
        modal.style.display = "block";
        clearErrorMessages()
        formSupplier.reset();
    });

    formSupplierEdit.addEventListener('submit', function(event) {
        event.preventDefault();
        clearErrorMessagesEdit();
        let _token = this['_token'].value;
        let name = this['name'].value;
        let id = this['id'].value;
        let email = this['email'].value;
        let address = this['address'].value;
        let phone = this['phone'].value;
        request('{{route("supplier.update")}}', JSON.stringify({
            '_token': _token,
            'name': name,
            'id': id,
            'email': email,
            'address': address,
            'phone': phone
        }), function(data) {
            data = JSON.parse(data);
            if (data['success']) {
                Swal.fire({
                    icon: 'success',
                    title: 'Bạn sửa nhà cung cấp thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
                let supplier = data['supplier'];
                document.getElementById('name-' + supplier['id']).innerHTML = supplier['name'];
                document.getElementById('email-' + supplier['id']).innerHTML = supplier['email'];
                document.getElementById('address-' + supplier['id']).innerHTML = supplier['address'];
                document.getElementById('phone-' + supplier['id']).innerHTML = supplier['phone'];
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống ! bạn sửa nhà cung cấp không thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
            }

        }, function(error) {
            let errors = JSON.parse(error)['errors'];
            for (const key in errors) {
                $('#validation-edit-' + key).append('<div class="alert alert-danger">' + errors[key][0] + '</div');
            }
        });
    });



    formSupplier.addEventListener('submit', function(event) {
        event.preventDefault();
        clearErrorMessages()
        let _token = this['_token'].value;
        let name = this['name'].value;
        let email = this['email'].value;
        let address = this['address'].value;
        let phone = this['phone'].value;

        request('{{route("supplier.store")}}', JSON.stringify({
            '_token': _token,
            'name': name,
            'email': email,
            'address': address,
            'phone': phone
        }), function(data) {
            data = JSON.parse(data);
            if (data['success']) {
                Swal.fire({
                    icon: 'success',
                    title: 'Bạn thêm nhà cung cấp thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
                formSupplier.reset();
                let supplier = data['supplier'];
                let tr = document.createElement('tr');
                let dataSupplier = '';
                dataSupplier += '<tr>';
                dataSupplier += '<td id="id-' + supplier['id'] + '">' + supplier['id'] + '</td>';
                dataSupplier += '<td id="name-' + supplier['id'] + '">' + supplier['name'] + '</td>';
                dataSupplier += '<td id="email-' + supplier['id'] + '">' + supplier['email'] + '</td>';
                dataSupplier += '<td id="address-' + supplier['id'] + '">' + supplier['address'] + '</td>';
                dataSupplier += '<td id="phone-' + supplier['id'] + '">' + supplier['phone'] + '</td>';
                dataSupplier += '<td>';
                dataSupplier += '<button id="btn-edit-' + supplier['id'] + '" title="Sửa nhà cung cấp" onclick="editSupplier(this)" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                dataSupplier += '<button title="Xóa" data-url="' + base_url + 'admin/supplier/' + supplier['id'] + '" value="' + supplier['id'] + '" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>';
                dataSupplier += '</td>';
                dataSupplier += '</tr>';
                tr.innerHTML = dataSupplier;
                trBody.prepend(tr);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống ! bạn thêm nhà cung cấp không thành công',
                    showConfirmButton: false,
                    timer: 4000
                });
            }

        }, function(error) {
            let errors = JSON.parse(error)['errors'];
            for (const key in errors) {
                $('#validation-' + key).append('<div class="alert alert-danger">' + errors[key][0] + '</div');
            }
        });

    });


    //function

    function editSupplier(edit) {
        const _token = document.getElementById('_token');

        clearErrorMessagesEdit();
        formSupplierEdit.reset();
        let [x, y, id] = edit.id.split('-');
        request('{{route("supplier.edit")}}', JSON.stringify({
            '_token': _token.value,
            'id': id
        }), function(data) {
            data = JSON.parse(data)['supplier'];
            formSupplierEdit['id'].value = data['id'];
            formSupplierEdit['name'].value = data['name'];
            formSupplierEdit['email'].value = data['email'];
            formSupplierEdit['address'].value = data['address'];
            formSupplierEdit['phone'].value = data['phone'];
            modal2.style.display = "block";
        });
    }


    function clearErrorMessages() {
        document.getElementById('validation-name').innerHTML = '';
        document.getElementById('validation-email').innerHTML = '';
        document.getElementById('validation-phone').innerHTML = '';
        document.getElementById('validation-address').innerHTML = '';
    }

    function clearErrorMessagesEdit() {
        document.getElementById('validation-edit-name').innerHTML = '';
        document.getElementById('validation-edit-email').innerHTML = '';
        document.getElementById('validation-edit-address').innerHTML = '';
        document.getElementById('validation-edit-phone').innerHTML = '';
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
<script src="{{asset('vendor/jquery-2.2.0.min.js')}}"></script>
<script src="{{asset('Admin/admin/supplier/index/delete.js')}}"></script>
<script src="{{asset('Admin/admin/supplier/index/index.js')}}"></script>
@endsection