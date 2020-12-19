@extends('back_end.layout.layout')
@section('content')
@section('css')
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
                                                    <select class="form-control @error('supplier_id') is-invalid @enderror" name="supplier_id">
                                                        <option value="">Chọn nhà cung ứng</option>
                                                        @foreach($suppliers as $supplier)
                                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <a class="btn btn-success" style="width: 100%; height:37px ; " href="{{route('supplier.create')}}"><i class="fas fa-plus"></i></a>
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
                                            <input type="text" class="form-control" id="total-quantity" name="quantity" value="" readonly >
                                        </div>
                                        <div class="form-group">
                                            <label>Tổng cộng</label>
                                            <input type="text" class="form-control" id="total-price" name="total_price" value="" readonly >
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
        </div>
    </section>

    <!-- /.content -->
</div>
@endsection @section('js')
<script src="{{asset('Admin/admin/bill_in/add/add.js')}}"></script>
@php
if(Session::has('message')){
echo Session::get('message');
}
@endphp
@endsection