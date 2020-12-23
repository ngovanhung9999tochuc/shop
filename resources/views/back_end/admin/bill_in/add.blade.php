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
    @include("back_end.parials.content_header",['title'=>'Thêm mới phiếu nhập kho', 'name'=>'bill',
    'key'=>'add','route'=>route('billin.index')])
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
                                            <label>Nhà cung ứng</label>
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
<script src="{{asset('Admin/admin/bill_in/add/add.js')}}"></script>
<script src="{{asset('Admin/admin/bill_in/add/add1.js')}}"></script>
@php
if(Session::has('message')){
echo Session::get('message');
}
@endphp
@endsection