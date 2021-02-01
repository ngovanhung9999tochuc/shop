@extends('back_end.layout.layout')
@section('content')
@section('css')
<link href="{{asset('Admin/admin/bill_in/add/add.css')}}" rel="stylesheet" />
<style>
    #product-list-are-looking-for {

        width: 98%;
    }

    #ul-product-list {
        width: 100%;
        position: absolute;
        top: -10px;
    }

    #product-list-are-looking-for ul li:hover {
        background-color: darkgray;
    }
</style>
@endsection
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include("back_end.parials.content_header",['title'=>'Thêm mới phiếu nhập kho', 'name'=>'Nhập kho',
    'key'=>'Thêm','route'=>route('billin.index')])
    <!-- /.content-header -->
    <div class="col-md-12">

    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8" style="position: relative;">
                    <div class="order-search" style="margin: 0px 0px 10px 0px;">
                        <input type="text" id="search-products" class="form-control ui-autocomplete-input" placeholder="Nhập mã sản phẩm hoặc tên sản phẩm" id="search-pro-box" autocomplete="off">
                        <input type="hidden" id="_token" value="{{ csrf_token() }}">
                    </div>
                    <div id="product-list-are-looking-for" class="col-md-12">
                        <ul id="ul-product-list" class="list-group">

                        </ul>
                    </div>
                    <div class="product-results">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Mã hàng</th>
                                    <th>Tên sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-center">Giá nhập</th>
                                    <th class="text-center">Thành tiền</th>
                                    <th>Xóa</th>
                                </tr>
                            </thead>
                            <tbody id="pro_search_append">

                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Thông Tin</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" method="POST" action="{{route('billin.store')}}">
                                    @csrf @method('post')
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nhà cung cấp</label>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <select id="select-supplers" class="form-control" name="supplier_id">
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <a id="btn-add-supplier" class="btn btn-success" style="width: 100%; height:37px ; "><i class="fas fa-plus"></i></a>
                                                </div>

                                            </div>
                                            @error('supplier_id')
                                            <br />
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Ngày nhập</label>
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input type="text" name="input_date" class="form-control datetimepicker-input @error('input_date') is-invalid @enderror" data-target="#reservationdate">
                                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            @error('input_date')
                                            <br />
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Tổng số lượng</label>
                                            <input type="text" class="form-control" id="total-quantity" name="quantity" value="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Tổng cộng</label>
                                            <input type="text" class="form-control" id="total-price" name="total_price" value="" readonly>
                                        </div>
                                        <input type="hidden" id="data-product-bill" name="data_product_bill" value="">
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button style="margin-left: 40%;" type="submit" class="btn btn-primary">Lưu</button>
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
                                <div class="card card-info">
                                    <div class="card-header" style="background-color: #28a745;">
                                        <h3 class="card-title"><b>Thêm nhà cung cấp</b></h3>
                                    </div>
                                    <div class="card-body">
                                        <form id="form-supplier" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Tên nhà cung cấp</label>
                                                <input type="text" name="name" class="form-control" value="" placeholder="nhập tên nhà cung cấp">
                                                <div id="validation-name"></div>
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control" value="" placeholder="nhập email">
                                                <div id="validation-email"></div>
                                            </div>

                                            <div class="form-group">
                                                <label>Địa chỉ</label>
                                                <input type="text" name="address" class="form-control" value="" placeholder="nhập địa chỉ">
                                                <div id="validation-address"></div>
                                            </div>

                                            <div class="form-group">
                                                <label>Số điện thoại</label>
                                                <input type="text" name="phone" class="form-control" value="" placeholder="nhập số điện thoại">
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
        </div>
    </section>

    <!-- /.content -->
</div>
@endsection @section('js')
<!-- <script src="{{asset('Admin/admin/bill_in/add/add.js')}}"></script>
<script src="{{asset('Admin/admin/bill_in/add/add1.js')}}"></script> -->
<script>
    let base_url = "{{ asset('') }}";
    base_url = [...base_url];
    base_url.pop();
    base_url = base_url.join("");
    const btnSearchProducts = document.getElementById('search-products');
    const _token = document.getElementById('_token').value;
    const productListAreLookingFor = document.getElementById('product-list-are-looking-for');
    const ulProductList = document.getElementById('ul-product-list');
    const proSearchAppend = document.getElementById('pro_search_append');
    const totalQuantity = document.getElementById('total-quantity');
    const totalPrice = document.getElementById('total-price');
    const inputProductBill = document.getElementById('data-product-bill');
    const dataProductBill = {};

    //event


    btnSearchProducts.addEventListener('keyup', function() {
        request("{{route('billin.products')}}", JSON.stringify({
                '_token': _token,
                'table_search': btnSearchProducts.value
            }),
            function(data) {
                let products = JSON.parse(data);
                let li = '';
                for (const p of products) {
                    li += '<li  data-product-type="' + p.id + '_' + p.name + '" class="list-group-item">' + p.id + '--' + p.name + '</li>';
                }
                ulProductList.innerHTML = li;
                productListAreLookingFor.style.display = 'block';
                //them su kien cho li product
                const listGroupProduct = document.querySelectorAll(".list-group-item");
                listGroupProduct.forEach(function(listProduct) {
                    //su kien them 1 product vao ban
                    listProduct.addEventListener('click', function() {
                        let product = this.getAttribute("data-product-type");
                        let [id, name] = product.split('_');
                        dataProductBill[id] = {
                            'id': id,
                            'name': name,
                            'quantity': 0,
                            'original_price': 0,

                        }
                        if (!document.getElementById(id)) {
                            let trProduct = document.createElement('tr');
                            trProduct.setAttribute('id', id)
                            trProduct.innerHTML = '<td style="width: 100px;">' + dataProductBill[id].id + '</td>\
                                <td style="width: 180px;">' + dataProductBill[id].name + '</td>\
                                <td class="text-center" style="width: 90px;"><input id="quantity-' + dataProductBill[id].id + '" type="number" min="0" class=" form-control" value="' + dataProductBill[id].quantity + '"></td>\
                                <td class="text-center" style="width: 150px;"><input id="price-' + dataProductBill[id].id + '" type="number" min="0" class=" form-control" value="' + dataProductBill[id].original_price + '"></td>\
                                <td class="text-center" id="total-' + dataProductBill[id].id + '">' + (dataProductBill[id].quantity * dataProductBill[id].original_price).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ' + '</td>\
                                <td class="text-center" style="width: 50px;"><i id="btnDelete-' + dataProductBill[id].id + '" class="fas fa-trash"></i></td>';
                            proSearchAppend.appendChild(trProduct);

                            //sua kien thay doi cua input quantity, price va delete
                            let inputQuantity = document.getElementById('quantity-' + dataProductBill[id].id);
                            let inputPrice = document.getElementById('price-' + dataProductBill[id].id);
                            let inputTotal = document.getElementById('total-' + dataProductBill[id].id);
                            let btnDelete = document.getElementById('btnDelete-' + dataProductBill[id].id);
                            inputQuantity.addEventListener('change', function() {
                                dataProductBill[id].quantity = inputQuantity.value;
                                inputTotal.innerHTML = (dataProductBill[id].quantity * dataProductBill[id].original_price).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
                                totalPriceAndQuantity();
                            });

                            inputPrice.addEventListener('change', function() {
                                dataProductBill[id].original_price = inputPrice.value;
                                inputTotal.innerHTML = (dataProductBill[id].quantity * dataProductBill[id].original_price).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
                                totalPriceAndQuantity();
                            });

                            btnDelete.addEventListener('click', function() {
                                proSearchAppend.removeChild(trProduct);
                                delete dataProductBill[id];
                                totalPriceAndQuantity();
                            });

                        }
                        totalPriceAndQuantity();

                        //tinh tong
                        function totalPriceAndQuantity() {
                            let quantity = 0,
                                Total = 0;
                            for (const key in dataProductBill) {

                                quantity += Number(dataProductBill[key]['quantity']);
                                Total += dataProductBill[key]['original_price'] * dataProductBill[key]['quantity'];
                            }
                            totalQuantity.value = quantity;
                            totalPrice.value = Total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + 'đ';
                            inputProductBill.value = JSON.stringify(dataProductBill);
                        }
                    });
                });
            });
    });

    ulProductList.addEventListener('mouseover', cleardisplay1);
    ulProductList.addEventListener('mouseout', cleardisplay2);



    //function




    function cleardisplay1() {
        productListAreLookingFor.style.display = 'block';
    }

    function cleardisplay2() {
        productListAreLookingFor.style.display = 'none';
    }


    let btnAddSupplier = document.getElementById('btn-add-supplier');
    const modal = document.getElementById('id01');
    const formSupplier = document.getElementById('form-supplier');
    const _tokenGlobal = document.getElementById('_token').value;
    //event
    getSuppliers();

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    btnAddSupplier.addEventListener('click', function() {
        modal.style.display = "block";
        clearErrorMessages()
        formSupplier.reset();
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
                getSuppliers();
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
    function getSuppliers() {
        let selectSupplers = document.getElementById('select-supplers');
        request('{{route("billin.supplier")}}', JSON.stringify({
                '_token': _tokenGlobal
            }),
            function(data) {
                data = JSON.parse(data);
                if (data['success']) {
                    let suppliers = data['suppliers'];
                    let dataSupplier = '<option value="">Chọn nhà cung cấp</option>';
                    for (const supplier of suppliers) {
                        dataSupplier += '<option value="' + supplier['id'] + '">' + supplier['name'] + '</option>';
                    }
                    selectSupplers.innerHTML = dataSupplier;
                }
            });
    }


    function clearErrorMessages() {
        document.getElementById('validation-name').innerHTML = '';
        document.getElementById('validation-email').innerHTML = '';
        document.getElementById('validation-phone').innerHTML = '';
        document.getElementById('validation-address').innerHTML = '';
    }

    function clearFormValue() {
        formSupplier['name'].value = '';
        formSupplier['email'].value = '';
        formSupplier['address'].value = '';
        formSupplier['phone'].value = '';
    }







    //Request voi callback voi 1 tham so--thuc hien truy van

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
@php
if(Session::has('message')){
echo Session::get('message');
}
@endphp
@endsection