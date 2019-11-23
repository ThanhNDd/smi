<?php define('__PATH__', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/admin/"); ?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?php echo __PATH__?>dist/img/icon.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">SHOP MẸ ỈN</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo __PATH__?>dist/img/avatar-in.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Ỉn Thối</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo __PATH__?>src/view/products/" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sản phẩm</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo __PATH__?>src/view/sales/" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Bán hàng</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo __PATH__?>src/view/orders/" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Đơn hàng</p>
              </a>
            </li>
          </ul>
          </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">