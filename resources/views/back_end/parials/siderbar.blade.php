<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link" style="text-align: center;">

    <span class="brand-text font-weight-light">Quản trị</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="{{route('product.index')}}" class="nav-link">
            <i class="nav-icon fa fa-barcode"></i>
            <p>
              Sản phẩm
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('producttype.index')}}" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Loại sản phẩm
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('supplier.index')}}" class="nav-link">
            <i class="nav-icon fas fa-industry"></i>
            <p>
              Nhà cung cấp
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('billin.index')}}" class="nav-link">
            <i class="nav-icon fa fa-truck"></i>
            <p>
              Nhập kho
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('user.index')}}" class="nav-link">
            <i class="nav-icon fa fa-users"></i>
            <p>
              Người dùng
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('bill.index')}}" class="nav-link">
            <i class="nav-icon fa fa-shopping-cart"></i>
            <p>
              Đơn hàng
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('archive.index')}}" class="nav-link">
            <i class="nav-icon fa fa-list-alt"></i>
            <p>
              Tồn kho
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('slide.index')}}" class="nav-link">
            <i class="nav-icon fas fa-swatchbook"></i>
            <p>
              Bìa
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{route('menu.index')}}" class="nav-link">
            <i class="nav-icon fas fa-bars"></i>
            <p>
              Menu
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>