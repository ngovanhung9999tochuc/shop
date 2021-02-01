@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('Admin/admin/producttype/index/index.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/producttype/index/index2.css')}}" rel="stylesheet" />
<link href="{{asset('Admin/admin/producttype/index/index3.css')}}" rel="stylesheet" />
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Danh sách danh mục',
    'name'=>'Danh mục','key'=>'Danh sách','route'=>route('producttype.index')])
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <button id="btn-add-type" class="btn btn-success btn-sm" style="width: 100px;"><i class="fas fa-plus"> Thêm mới</i></button>
                            <div class="card-tools">
                               <form method="POST" action="{{route('producttype.search')}}">
                                    @csrf @method('post')
                                    <div class="input-group input-group-sm" style="width: 300px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm mã hoặc tên danh mục">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form> 
                            </div>
                        </div> -->

                        <div style="margin-top: 5px;" class="card-body table-responsive p-0">
                            <button id="btn-add-type" class="btn btn-success btn-sm float-right " style="width: 100px; margin: 0px 20px;"><i class="fas fa-plus"> Thêm mới</i></button>
                            <table id="table-product-type" class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên danh mục</th>
                                        <th>Hình ảnh</th>
                                        <th>Danh mục cha</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="trbody">
                                    @foreach($productTypes as $productType)
                                    <tr>
                                        <td id="id-{{$productType->id}}">{{$productType->id}}</td>
                                        @php
                                        $text='';
                                        if($productType->parent_id==0){
                                        $text=' ('.$productType->productTypeChildrents->count().' danh mục con)';
                                        }else{
                                        $text=' ('.$productType->products->count().' sản phẩm)';
                                        }
                                        @endphp
                                        <td id="name-{{$productType->id}}">{{$productType->name}}{{$text}}</td>
                                        <td id="icon-{{$productType->id}}">
                                            @if($productType->icon)
                                            <img src="{{ asset($productType->icon)}}" alt="icon" style="width:200px ; height: 50px;" />
                                            @endif
                                        </td>
                                        <td id="parent-{{$productType->id}}">{{optional($productType->productTypeParent)->name}}</td>
                                        <td>
                                            <button id="btn-edit-{{$productType->id}}" title="Sửa" onclick="editProductType(this)" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>
                                            <button title="Xóa" data-url="{{route('producttype.destroy',$productType->id)}}" value="{{$productType->id}}" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>
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
                                            <h3 class="card-title"><b>Thêm danh mục</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-add-type" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Tên danh mục*</label>
                                                    <input type="text" name="name" class="form-control" value="" placeholder="nhập tên danh mục">
                                                    <div style="margin-top: 5px;" id="validation-add-name"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Danh mục cha</label>
                                                    <select id="parent_id" class="form-control" name="parent_id">

                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Hình ảnh danh mục</label>
                                                    <input type="file" id="image" name="image_file" class="form-control-file" value="">
                                                    <img id="output-image" />
                                                    <div style="margin-top: 10px;" id="validation-add-image_file"></div>
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
                                            <h3 class="card-title"><b>Sửa danh mục</b></h3>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-edit-type" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="" />
                                                <div class="form-group">
                                                    <label>Tên danh mục*</label>
                                                    <input type="text" name="name" class="form-control" value="" placeholder="nhập tên danh mục">
                                                    <div style="margin-top: 5px;" id="validation-edit-name"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label>danh mục cha</label>
                                                    <select id="parent-edit" class="form-control" name="parent_id">

                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Hình ảnh danh mục</label>
                                                    <input type="file" id="image-edit" name="image_file" class="form-control-file" value="">
                                                    <img id="output-image-edit" />
                                                    <div style="margin-top: 10px;" id="validation-edit-image_file"></div>
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
                                                        <th>Tên</th>
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
<script src="{{asset('Admin/admin/producttype/index/delete.js')}}"></script>
<script>
    $(function() {
        $('#table-product-type').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "order": [],
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });
    let base_url = "{{ asset('') }}";
    base_url = [...base_url];
    base_url.pop();
    base_url= base_url.join("");
    const modal = document.getElementById('id01');
    const modal2 = document.getElementById('id02');
    const modal3 = document.getElementById('id03');
    const btnAddType = document.getElementById('btn-add-type');
    const formAddType = document.getElementById('form-add-type');
    const formEditType = document.getElementById('form-edit-type');
    const trBody = document.getElementById('trbody');

    const image = document.getElementById('image');
    const imageEdit = document.getElementById('image-edit');
    const outputImageEdit = document.getElementById('output-image-edit');
    //event
    window.onclick = function(event) {
        if (event.target == modal || event.target == modal2 || event.target == modal3) {
            modal.style.display = "none";
            modal2.style.display = "none";
            modal3.style.display = "none";
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

    btnAddType.addEventListener('click', function() {
        const _token = document.getElementById('_token');
        const parentId = document.getElementById('parent_id');
        modal.style.display = "block";
        clearErrorMessagesAdd();
        formAddType.reset();
        request('{{route("producttype.parent")}}', JSON.stringify({
            '_token': _token.value,
        }), function(data) {
            data = JSON.parse(data);
            if (data['success']) {

                let option = data['htmlOption'];
                parentId.innerHTML = option;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống !',
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });

    });

    $(document).ready(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#form-add-type').submit(function(e) {
            e.preventDefault();
            clearErrorMessagesAdd();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{route("producttype.store")}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    this.reset();
                    if (data['success']) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Bạn thêm danh mục thành công',
                            showConfirmButton: false,
                            timer: 4000
                        });
                        let productType = data['productType'];
                        let icon = '',
                            parent = '';
                        if (productType['icon']) {
                            icon = '<img  src="' + productType['icon'] + '" alt="icon" style="width:200px ; height: 50px;" />';
                        }

                        if (productType['product_type_parent']) {
                            parent = productType['product_type_parent']['name'];
                        }
                        let tr = document.createElement('tr');
                        let dataType = '';
                        dataType += '<tr>';
                        dataType += '<td id="id-' + productType['id'] + '">' + productType['id'] + '</td>';
                        dataType += '<td id="name-' + productType['id'] + '">' + productType['name'] + '</td>';
                        dataType += '<td id="icon-' + productType['id'] + '">' + icon + '</td>';
                        dataType += '<td id="parent-' + productType['id'] + '">' + parent + '</td>';
                        dataType += '<td>';
                        dataType += '<button id="btn-edit-' + productType['id'] + '" title="Sửa" onclick="editProductType(this)"  class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                        dataType += '<button title="Xóa" data-url="' + base_url + '/admin/producttype/' + productType['id'] + '" value="' + productType['id'] + '" id="btn_delete" class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash"></i></button>';
                        dataType += '</td>';
                        dataType += '</tr>';
                        tr.innerHTML = dataType;
                        trBody.prepend(tr);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi hệ thống ! bạn thêm danh mục không thành công',
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



        $('#form-edit-type').submit(function(e) {
            e.preventDefault();
            clearErrorMessagesEdit();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: '{{route("producttype.update")}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    if (data['success']) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Bạn sửa danh mục thành công',
                            showConfirmButton: false,
                            timer: 4000
                        });
                        let productType = data['productType'];
                        let icon = '',
                            parent = '';
                        if (productType['icon']) {
                            icon = '<img  src="' + base_url + productType['icon'] + '" alt="icon" style="width:200px ; height: 50px;" />';
                        }

                        if (productType['product_type_parent']) {
                            parent = productType['product_type_parent']['name'];
                        }
                        document.getElementById('id-' + productType['id']).innerHTML = productType['id'];
                        document.getElementById('name-' + productType['id']).innerHTML = productType['name'];
                        document.getElementById('parent-' + productType['id']).innerHTML = parent;
                        document.getElementById('icon-' + productType['id']).innerHTML = icon;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi hệ thống !',
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

    function editProductType(edit) {
        const _token = document.getElementById('_token');
        let [x, y, id] = edit.id.split('-');
        clearErrorMessagesEdit();
        formEditType.reset();
        request('{{route("producttype.edit")}}', JSON.stringify({
            '_token': _token.value,
            'id': id
        }), function(data) {
            const parentEdit = document.getElementById('parent-edit');
            data = JSON.parse(data);
            if (data['success']) {
                let option = data['htmlOption'];
                let productType = data['productType'];
                parentEdit.innerHTML = option;
                formEditType['id'].value = productType['id'];
                formEditType['name'].value = productType['name'];
                outputImageEdit.src = base_url + productType['icon'];
                outputImageEdit.style.height = '60px';
                outputImageEdit.style.width = '200px';
                outputImageEdit.style.marginTop = '10px';
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


    function clearErrorMessagesAdd() {
        document.getElementById('validation-add-name').innerHTML = '';
        document.getElementById('validation-add-image_file').innerHTML = '';
    }

    function clearErrorMessagesEdit() {
        document.getElementById('validation-edit-name').innerHTML = '';
        document.getElementById('validation-edit-image_file').innerHTML = '';
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