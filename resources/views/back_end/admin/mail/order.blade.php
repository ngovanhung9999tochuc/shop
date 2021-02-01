@extends('back_end.layout.layout_mail')
@section('content')
@section('css')
@endsection
<section class="content">
    <div class="container">
        <div class="container">
            <div class="main-body">
                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <div class="mt-3">
                                        <h5 id="full-name">{{$user->name}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- fb -->
                    </div>
                    <div class="col-md-8">
                        <div id="content" class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$bill->email}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Địa Chỉ</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$bill->address}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Số Điện Thoại</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$bill->phone}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Ngày Đặt Hàng</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$bill->date_order}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Tổng Số Lượng</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{$bill->quantity}}</div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Tổng Tiền</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">{{number_format($bill->total)}}đ</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số Lượng</th>
                                    <th>Giá</th>
                                    <!--   <th>Hình ảnh</th> -->
                                    <th id="th-inventory"></th>
                                </tr>
                            </thead>
                            <tbody id="table-product">
                                @foreach($products as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->pivot->quantity}}</td>
                                    <td>{{number_format($product->pivot->unit_price)}}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('js')
@endsection