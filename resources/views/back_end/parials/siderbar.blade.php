<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('admin.dashboard')}}" class="brand-link" style="text-align: center;">
    <img src="/logo/logo.png" />
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{auth()->user()->image_icon}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info" >
        <a style="color: white;" class="d-block">{{auth()->user()->name}}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <!-- <li class="header">
          <span style="font-size:14px ;padding:4%;color:rgb(238, 238, 238)"> Quản lý </span>
        </li> -->

        <li class="nav-item has-treeview">
          <a class="nav-link" style="color: white;">
            <i class="nav-icon fa fa-barcode" ></i>
            <p>
              Quản lý sản phẩm
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('producttype')
            <li class="nav-item">
              <a style="padding-left: 30px;" href="{{route('producttype.index')}}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Danh mục
                </p>
              </a>
            </li>
            @endcan
            @can('product')
            <li class="nav-item">
              <a style="padding-left: 30px;" href="{{route('product.index')}}" class="nav-link">
                <i class="nav-icon fa fa-barcode"></i>
                <p>
                  Sản phẩm
                </p>
              </a>
            </li>
            @endcan

            @can('slide')
            <li class="nav-item">
              <a style="padding-left: 30px;" href="{{route('slide.index')}}" class="nav-link">
                <i class="nav-icon fab fa-bootstrap"></i>
                <p>
                Khuyến mãi
                </p>
              </a>
            </li>
            @endcan
          </ul>
        </li>







        <!--   @can('menu')
        <li class="nav-item">
          <a href="{{route('menu.index')}}" class="nav-link">
            <i class="nav-icon fas fa-bars"></i>
            <p>
              Menu
            </p>
          </a>
        </li>
        @endcan -->

        <li class="nav-item has-treeview">
          <a class="nav-link" style="color: white;">
            <i class="nav-icon fas fa fa-inbox"></i>
            <p>
              Quản lý kho
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('bill')
            <li class="nav-item">
              <a style="padding-left: 30px;" href="{{route('bill.index')}}" class="nav-link">
                <i class="nav-icon fa fa-shopping-cart"></i>
                <p>
                  Đơn hàng
                </p>
              </a>
            </li>
            @endcan


            @can('billin')
            <li class="nav-item">
              <a style="padding-left: 30px;" href="{{route('billin.index')}}" class="nav-link">
                <i class="nav-icon fa fa-truck"></i>
                <p>
                  Nhập kho
                </p>
              </a>
            </li>
            @endcan

            @can('archive')
            <li class="nav-item">
              <a style="padding-left: 30px;" href="{{route('archive.index')}}" class="nav-link">
                <i class="nav-icon fa fa-list-alt"></i>
                <p>
                  Tồn kho
                </p>
              </a>
            </li>
            @endcan

            @can('supplier')
            <li class="nav-item">
              <a style="padding-left: 30px;" href="{{route('supplier.index')}}" class="nav-link">
                <i class="nav-icon fas fa-industry"></i>
                <p>
                  Nhà cung cấp
                </p>
              </a>
            </li>
            @endcan

          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a class="nav-link" style="color: white;">
            <i class="nav-icon fas fas fa-user" ></i>
            <p>
              Phân quyền
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('user')
            <li  class="nav-item">
              <a style="padding-left: 30px;" href="{{route('user.index')}}" class="nav-link">
                <i class="nav-icon fa fa-users"></i>
                <p>
                  Người dùng
                </p>
              </a>
            </li>
            @endcan

            @can('role')
            <li class="nav-item">
              <a style="padding-left: 30px;" href="{{route('role.index')}}" class="nav-link">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>
                  Vai trò
                </p>
              </a>
            </li>
            @endcan

          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>