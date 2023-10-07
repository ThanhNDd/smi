<?php
require_once("common.php");
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="<?php Common::getPath()?>dist/img/icon.png"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">SHOP MẸ ỈN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <a href="<?php Common::getPath() ?>src/controller/login/LoginController.php?logout" class="d-block">
                    <img src="<?php Common::getPath() ?>dist/img/avatar-in.jpg" class="img-circle elevation-2" alt="User Image">
                </a>
            </div>
            <div class="info">
                <a href="<?php Common::getPath() ?>src/controller/login/LoginController.php?logout" class="d-block text-secondary">
                    <h6 class="m-0 text-white text-uppercase">
                        <?php echo (isset($_COOKIE["display_name"]) ? $_COOKIE["display_name"] : "") ?>
                    </h6>
                   <small>Logout</small>                
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Bán hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php Common::getPath() ?>src/view/sales/" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Bán hàng</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php Common::getPath() ?>src/view/orders/" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Đơn hàng Shop</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php Common::getPath() ?>src/view/orders/online.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Đơn hàng online</p>
                                </a>
                            </li>
                        <?php if(Common::isAdminRole()) { ?>
                            <li class="nav-item">
                                <a href="<?php Common::getPath() ?>src/view/exchange/" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Đổi hàng</p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Sản phẩm
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php Common::getPath() ?>src/view/products/" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tất cả sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php Common::getPath() ?>src/view/products/?type=facebook" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Facebook</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php Common::getPath() ?>src/view/products/?type=shopee" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Shopee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php Common::getPath() ?>src/view/products/?type=website" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Website</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php Common::getPath() ?>src/view/products/?type=online&sorted=cat" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Online</p>
                            </a>
                        </li>
                        <?php if(Common::isAdminRole()) { ?>
                            <li class="nav-item">
                                <a href="<?php Common::getPath()?>src/view/check/" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kiểm hàng</p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php if(Common::isAdminRole()) { ?>
                    <!-- <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Kế toán
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php Common::getPath() ?>src/view/fee/" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Chi phí</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php Common::getPath() ?>src/view/voucher/" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Khoản thu</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Marketing
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php Common::getPath() ?>src/view/voucher/" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Vouchers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php Common::getPath() ?>src/view/promotion/" class="nav-link">
                                    <i class="fas fa-money-check-alt nav-icon"></i>
                                    <p>Khuyến mãi</p>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                <?php } ?>
                <li class="nav-item has-treeview menu-open">
                  <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                       Khách hàng
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php Common::getPath() ?>src/view/customer/" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh sách</p>
                      </a>
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
