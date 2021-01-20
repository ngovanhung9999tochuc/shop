@extends('back_end.layout.layout')
@section('content')
@section('css')
<link rel="stylesheet" href="{{asset('Admin/admin/dashboard/index/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('Admin/admin/dashboard/index/morris.css')}}">
<style>
  p.title_thongke {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
  }
</style>
@endsection
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  @include("back_end.parials.content_header",['title'=>'Quản trị',
  'name'=>'Tổng quan','key'=>'Danh sách','route'=>route('admin.dashboard')])
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$data['totalBillNew']}}</h3>

              <p>Đơn hàng mới</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{route('bill.index')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$data['totalProduct']}}</h3>

              <p>Sản phẩm</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{route('product.index')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$data['totalUser']}}</h3>

              <p>Người dùng</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{route('user.index')}}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{$data['totalVisitor']}}</h3>

              <p>Khách truy cập</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a class="small-box-footer">&nbsp</a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <p class="title_thongke">Thống kê số lượng khách truy cập</p>
        </div>
        <form>
          @csrf
          <div class="col-md-12 row" style="margin-bottom: 10px;">
            <div class="form-group col-md-5 row">
              <label for="example-date-input1" class="col-2 col-form-label">Từ</label>
              <div class="col-10">
                <input class="form-control" type="date" name="from" id="example-date-input1">
              </div>
            </div>
            <div class="form-group col-md-5 row">
              <label for="example-date-input2" class="col-2 col-form-label">Đến</label>
              <div class="col-10">
                <input class="form-control" type="date" name="to" id="example-date-input2">
              </div>
            </div>
            <div class="col-md-2">
              <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" style="margin-left: 10px; height: 37px;" value="Lọc kết quả" />
            </div>
          </div>
        </form>
        <div class="col-md-12 card">
          <div id="myfirstchart" style="height: 250px;">

          </div>
        </div>
      </div>
      <div class="row col-md-12" style="margin-top: 30px;">
        <div class="card col-md-6">
          <div class="card-header border-transparent">
            <h3 class="card-title">Sản phẩm xem nhiều nhất</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Xem</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data['productViews'] as $productView)
                  <tr>
                    <td><a href="{{route('detail',$productView->id)}}">{{$productView->id}}</a></td>
                    <td>{{$productView->name}}</td>
                    <td>{{$productView->product_view}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.card-body -->
          <!-- /.card-footer -->
        </div>
        <div class="card col-md-6">
          <div class="card-header border-transparent">
            <h3 class="card-title">Sản phẩm bán chạy</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    @foreach($data['sellingProducts'] as $productView)
                  <tr>
                    <td><a href="{{route('detail',$productView->product_id)}}">{{$productView->product_id}}</a></td>
                    <td>{{$productView->name}}</td>
                    <td>{{$productView->quantity}}</td>
                  </tr>
                  @endforeach
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>

        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('js')
<script src="{{asset('Admin/admin/dashboard/index/raphael-min.js')}}"></script>
<script src="{{asset('Admin/admin/dashboard/index/morris.min.js')}}"></script>
<script src="{{asset('Admin/admin/dashboard/index/jquery-1.12.4.js')}}"></script>
<script src="{{asset('Admin/admin/dashboard/index/jquery-ui.js')}}"></script>
<script>
  $(document).ready(function() {
    var chart = new Morris.Area({
      element: 'myfirstchart',
      lineColors: ['#fc8710', '#ff6541', '#819C79', '#A4ADD3', '#494439'],
      pointFillColors: ['#ffffff'],
      pointStrokeColors: ['black'],
      fillOpacity: 0.6,
      hideHover: 'auto',
      parseTime: false,
      xkey: 'period',
      ykeys: ['order'],
      behaveLikeLine: true,
      labels: ['số lượng khách truy cập']
    });

    $('#btn-dashboard-filter').click(function() {

      let _token = $('input[name="_token"]').val();
      let fromDate = $('#example-date-input1').val();
      let toDate = $('#example-date-input2').val();
      $.ajax({
        url: 'admin/dashboard/filter_by_date',
        method: "POST",
        dataType: "JSON",
        data: {
          'fromDate': fromDate,
          'toDate': toDate,
          '_token': _token
        },
        success: function(data) {
          chart.setData(data);
        }
      });
    });



    $(function() {
      let _token = $('input[name="_token"]').val();
      $.ajax({
        url: 'admin/dashboard/filter_by_date_15',
        method: "POST",
        dataType: "JSON",
        data: {
          '_token': _token
        },
        success: function(data) {

          chart.setData(data);
        }
      });
    });
  });
</script>
@endsection