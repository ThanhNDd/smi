<?php require_once("../../common/common.php");
Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="<?php Common::getPath() ?>dist/img/icon.png"/>
    <title>Quản lý đơn hàng online</title>
    <?php require_once('../../common/css.php'); ?>
    <?php require_once('../../common/js.php'); ?>
    <style>

        td.details-control {
            text-align: center;
            color: forestgreen;
            cursor: pointer;
        }

        tr.shown td.details-control {
            text-align: center;
            color: red;
        }

        div#example_wrapper {
            margin-top: 10px;
        }

        div#example_filter label {
            width: 100%;
            float: left;
        }

        table.dataTable.no-footer {
            border-bottom: none;
        }

        .customer-phone .twitter-typeahead {
            width: 79% !important;
        }

        .info-box:hover {
            background: #dcd9d996;
        }

        .info-box.active {
            border: 1px solid red;
        }

        .info-box {
            cursor: pointer;
        }
        .nav-link.active {
          background-color: #17a2b8!important;
          color: white !important;
        }
        div.dataTables_wrapper div.dataTables_info {
            float: left;
        }
        .c-pointer {
            cursor: pointer;
        }



        .tracking-detail {
          padding:3rem 0
        }
        #tracking {
          margin-bottom:1rem
        }
        [class*=tracking-status-] p {
          margin:0;
          font-size:1.1rem;
          color:#fff;
          text-transform:uppercase;
          text-align:center
        }
        [class*=tracking-status-] {
          padding:1rem 0
        }
        .tracking-status-intransit {
          background-color:#65aee0
        }
        .tracking-status-outfordelivery {
          background-color:#f5a551
        }
        .tracking-status-deliveryoffice {
          background-color:#f7dc6f
        }
        .tracking-status-delivered {
          background-color:#4cbb87
        }
        .tracking-status-attemptfail {
          background-color:#b789c7
        }
        .tracking-status-error,.tracking-status-exception {
          background-color:#d26759
        }
        .tracking-status-expired {
          background-color:#616e7d
        }
        .tracking-status-pending {
          background-color:#ccc
        }
        .tracking-status-inforeceived {
          background-color:#214977
        }
        .tracking-list {
          border:1px solid #e5e5e5
        }
        .tracking-item {
          border-left:1px solid #e5e5e5;
          position:relative;
          padding:2rem 1.5rem .5rem 2.5rem;
          font-size:.9rem;
          margin-left:3rem;
          min-height:5rem
        }
        .tracking-item:last-child {
          padding-bottom:4rem
        }
        .tracking-item .tracking-date {
          margin-bottom:.5rem
        }
        .tracking-item .tracking-date span {
          color:#888;
          font-size:85%;
          padding-left:.4rem
        }
        .tracking-item .tracking-content {
          padding:.5rem .8rem;
          background-color:#f4f4f4;
          border-radius:.5rem
        }
        .tracking-item .tracking-content span {
          display:block;
          color:#888;
          font-size:85%
        }
        .tracking-item .tracking-icon {
          line-height:2.6rem;
          position:absolute;
          left:-1.3rem;
          width:2.6rem;
          height:2.6rem;
          text-align:center;
          border-radius:50%;
          font-size:1.1rem;
          background-color:#fff;
          color:#fff
        }
        .tracking-item .tracking-icon.status-sponsored {
          background-color:#f68
        }
        .tracking-item .tracking-icon.status-delivered {
          background-color:#4cbb87
        }
        .tracking-item .tracking-icon.status-outfordelivery {
          background-color:#f5a551
        }
        .tracking-item .tracking-icon.status-deliveryoffice {
          background-color:#f7dc6f
        }
        .tracking-item .tracking-icon.status-attemptfail {
          background-color:#b789c7
        }
        .tracking-item .tracking-icon.status-exception {
          background-color:#d26759
        }
        .tracking-item .tracking-icon.status-inforeceived {
          background-color:#214977
        }
        .tracking-item .tracking-icon.status-intransit {
          color:#e5e5e5;
          border:1px solid #e5e5e5;
          font-size:.6rem
        }
        @media(min-width:992px) {
          .tracking-item {
            margin-left:10rem
          }
          .tracking-item .tracking-date {
            position:absolute;
            left:-10rem;
            width:7.5rem;
            text-align:right
          }
          .tracking-item .tracking-date span {
            display:block
          }
          .tracking-item .tracking-content {
            padding:0;
            background-color:transparent
          }
        }
    </style>
</head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content">
    <div class="row pt-2">
<!--        create new-->
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-1 mb-2">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary order-create btn-flat p-2">
                            <i class="fas fa-plus-circle"></i> Tạo mới
                        </a>
                    </div>
                    <div class="col-md-1 mb-2">
                        <button class="btn btn-sm btn-info delivery_order btn-flat p-2" disabled>
                            <i class="fas fa-shipping-fast"></i> Giao hàng <span id="delivery_order_checked"></span>
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select class="form-control col-md-7 d-inline-block" name="order_status" id="order_status_batch">
<!--                            <option value="0" selected="selected">Chưa xử lý</option>-->
                            <option value="1" selected="selected">Đã gói hàng</option>
                            <option value="2">Đã giao</option>
                            <option value="3">Hoàn thành</option>
<!--                            <option value="4">Đổi size</option>-->
                            <option value="5">Chuyển hoàn</option>
                            <option value="6">Huỷ</option>
<!--                            <option value="7">Giao hàng sau</option>-->
                            <option value="8">Đợi hàng về</option>
                        </select>
                        <button class="btn btn-sm btn-info btn-flat p-2 order_status_update" disabled>
                            <i class="fa fa-spinner fa-spin show_loading_update_status hidden"></i>&nbsp;<i class="far fa-save"></i> Cập nhật <span id="order_checked_for_update"></span>
                        </button>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-sm btn-success btn-flat p-2 order_status_print_update" disabled>
                            <i class="fa fa-spinner fa-spin show_loading_update_print_status hidden"></i>&nbsp;<i class="fa fa-print fa-save-print-status"></i> In <span id="order_checked_for_print_for_update"></span> đơn hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
<!--      end create new-->
<!--      info important-->
        <div class="col-md-12 col-sm-12">
        <div class="card">
          <div class="card-body row">
            <div class="info-box col m-2 total-pending-status">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hourglass-half"></i></span>
              <div class="info-box-content col-12 row">
                <div class="col-md-12 col-sm-12 text-left">
                  <span class="info-box-text">Chờ xử lý</span>
                  <span class="info-box-number">
                      <h2 class="total_pending text-danger">0</h2>
                   </span>
                </div>
              </div>
            </div>
            <div class="info-box col m-2 total-created-bill-status">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-history"></i></span>
              <div class="info-box-content col-12 row">
                <div class="col-md-12 col-sm-12 text-left">
                  <span class="info-box-text">Đã tạo đơn</span>
                  <span class="info-box-number">
                      <h2 class="total_created_bill text-danger">0</h2>
                   </span>
                </div>
              </div>
            </div>
            <div class="info-box col m-2 total-packed-status">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-history"></i></span>
              <div class="info-box-content col-12 row">
                <div class="col-md-12 col-sm-12 text-left">
                  <span class="info-box-text">Đã gói hàng</span>
                  <span class="info-box-number">
                      <h2 class="total_packed text-danger">0</h2>
                   </span>
                </div>
              </div>
            </div>
            <div class="info-box col m-2 total-delivered-status">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-truck"></i></span>
              <div class="info-box-content col-12 row">
                <div class="col-md-12 col-sm-12 text-left">
                  <span class="info-box-text">Đã giao</span>
                  <span class="info-box-number">
                      <h2 class="total_delivered text-danger">0</h2>
                   </span>
                </div>
              </div>
            </div>
            <div class="info-box col m-2 total-wating-status">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-history"></i></span>
              <div class="info-box-content col-12 row">
                <div class="col-md-12 col-sm-12 text-left">
                  <span class="info-box-text">Đợi hàng về</span>
                  <span class="info-box-number">
                      <h2 class="total_wating text-danger">0</h2>
                   </span>
                </div>
              </div>
            </div>
            <div class="info-box col m-2 total-appointment-status">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
              <div class="info-box-content col-12 row">
                <div class="col-md-12 col-sm-12 text-left">
                  <span class="info-box-text">Giao hàng sau</span>
                  <span class="info-box-number">
                      <h2 class="total_appointment text-danger">0</h2>
                   </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<!--      end info important-->
<!--      search form-->
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body row">
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-left" id="reservation">
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="text" class="form-control col-md-12" placeholder="Mã vận đơn" id="search_bill_id">
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="text" class="form-control col-md-12" placeholder="Số điện thoại" id="search_phone">
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="text" class="form-control col-md-12" placeholder="Mã đơn hàng"
                               id="search_order_id">
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="text" class="form-control col-md-12" placeholder="Mã khách hàng"
                               id="search_customer_id">
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="text" class="form-control col-md-12" placeholder="Mã sản phẩm" id="search_sku">
                    </div>
<!--                    <div class="col-md-12 text-center">-->
<!--                        <a href="javascript:void(0)" class="btn btn-sm btn-info order-create btn-flat p-2">-->
<!--                            <i class="fas fa-search"></i> Tìm kiếm-->
<!--                        </a>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
<!--      end search form-->
<!--      total info-->
        <div class="col-md-12 col-sm-12">
        <div class="card">
          <div class="card-body row">
            <div class="col">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content col-12 row">
                  <div class="col-md-6 col-sm-12 text-left">
                    <span class="info-box-text">Tổng tiền</span>
                    <span class="info-box-number">
                        <h5 class="total_money">0<sup>đ</sup></h5>
                     </span>
                  </div>
                  <div class="col-md-6 col-sm-12 text-left pl-0">
                    <h1 class="text-danger no-margin d-inline-block col-md-12 pl-0"><span class="total_orders col-md-6 pl-0 pr-0">0</span> <small style="font-size: 30%;color: #676a6c;">Đơn</small></h1>
                    <h5 class="text-danger text-left col-md-12 pl-0"><span class="total_products text-left col-md-6" style="color: #676a6c;">0</span> <small style="font-size: 60%;color: #676a6c;">Sản phẩm</small></h5>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col -->
            <div class="col hidden">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-store"></i></span>
                <div class="info-box-content col-12 row">
                  <div class="col-md-6 col-sm-12 text-left">
                    <span class="info-box-text">Shop</span>
                    <span class="info-box-number">
                                        <h5 class="total_on_shop">0<sup>đ</sup></h5>
                                     </span>
                    <span class="info-box-text" id="percent_onshop"></span>
                  </div>
                  <div class="col-md-6 col-sm-12 text-left pl-0">
                    <h1 class="text-danger no-margin d-inline-block col-md-12 pl-0"><span class="count_on_shop col-md-6 pl-0 pr-0">0</span> <small style="font-size: 30%;color: #676a6c;">Đơn</small></h1>
                    <h5 class="text-danger text-left col-md-12 pl-0"><span class="total_product_on_shop text-left col-md-6" style="color: #676a6c;">0</span> <small style="font-size: 60%;color: #676a6c;">Sản phẩm</small></h5>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col -->
            <!-- fix for small devices only -->
            <div class="col hidden">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-globe"></i></span>
                <div class="info-box-content col-12 row">
                  <div class="col-md-6 col-sm-12 text-left">
                    <span class="info-box-text">Online</span>
                    <span class="info-box-number">
                  <h5 class="total_online">0<sup>đ</sup></h5>
               </span>
                    <span class="info-box-text hidden" id="percent_online"></span>
                  </div>
                  <!--              <div class="col-md-6 col-sm-12 text-left pl-0">-->
                  <!--                <h1 class="text-danger no-margin d-inline-block col-md-12 pl-0"><span class="count_online col-md-6 pl-0 pr-0">0</span> <small style="font-size: 30%;color: #676a6c;">Đơn</small></h1>-->
                  <!--                <h5 class="text-danger text-left col-md-12 pl-0"><span class="total_product_online text-left col-md-6" style="color: #676a6c;">0</span> <small style="font-size: 60%;color: #676a6c;">Sản phẩm</small></h5>-->
                  <!--              </div>-->
                </div>
              </div>
            </div>
            <div class="col hidden">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-sync-alt"></i></span>
                <div class="info-box-content col-12 row">
                  <div class="col-md-6 col-sm-12 text-left">
                    <span class="info-box-text">Đổi hàng</span>
                    <span class="info-box-number">
                                        <h5 class="total_exchange">0<sup>đ</sup></h5>
                                     </span>
                    <span class="info-box-text" id="percent_exchange"></span>
                  </div>
                  <!--              <div class="col-md-6 col-sm-12 text-left pl-0">-->
                  <!--                <h1 class="text-danger no-margin d-inline-block col-md-12 pl-0"><span class="count_exchange col-md-6 pl-0 pr-0">0</span> <small style="font-size: 30%;color: #676a6c;">Đơn</small></h1>-->
                  <!--                <h5 class="text-danger text-left col-md-12 pl-0"><span class="total_product_exchange text-left col-md-6" style="color: #676a6c;">0</span> <small style="font-size: 60%;color: #676a6c;">Sản phẩm</small></h5>-->
                  <!--              </div>-->
                </div>
              </div>
            </div>
            <div class="col hidden">
              <div class="info-box">
                            <span class="info-box-icon bg-primary elevation-1"><i
                                class="far fa-money-bill-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Tiền mặt</span>
                  <span class="info-box-number">
                                    <h5 class="total_cash">
                                      <sup>đ</sup>
                                    </h5>
                                </span>
                </div>
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col hidden">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-credit-card"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Chuyển khoản</span>
                  <span class="info-box-number">
                                    <h5 class="total_transfer">
                                        <sup>đ</sup>
                                    </h5>
                                </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-wallet"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" id="percent_profit">-</span>
                  <span class="info-box-number">
                                    <h5 class="total_profit">
                                      <sup>đ</sup>
                                    </h5>
                                </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>
        </div>
      </div>
<!--      end total info-->
<!--      table data-->
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body pt-0">
                  <ul class="nav nav-tabs pt-3">
                    <li class="nav-item">
                      <a class="nav-link active" href="javascript:void(0)" id="status_all">Tất cả <span id="count_all"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="javascript:void(0)" id="status_pending">Chờ xử lý <span id="count_pending"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="javascript:void(0)" id="status_created_bill">Đã tạo đơn <span id="count_created_bill"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="javascript:void(0)" id="status_packed">Đã gói hàng <span id="count_packed"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="javascript:void(0)" id="status_delivered">Đã giao <span id="count_delivered"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="javascript:void(0)" id="status_success">Đã hoàn thành <span id="count_success"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="javascript:void(0)" id="status_exchange">Đã đổi size <span id="count_exchange"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="javascript:void(0)" id="status_return">Chuyển hoàn <span id="count_return"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="javascript:void(0)" id="status_cancel">Huỷ <span id="count_cancel"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="javascript:void(0)" id="status_appointment">Hẹn giao sau <span id="count_appointment"></span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="javascript:void(0)" id="status_waiting">Đợi hàng về <span id="count_wating"></span></a>
                    </li>
                  </ul>
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th class="w20 center"><input type="checkbox" id="check_all_order"></th>
                                <th class="w20 center"></th>
                                <th class="w20 center">ID</th>
                                <th class="w80 left">Khách hàng</th>
                                <th class="w80 left">SĐT</th>
                                <th class="w150 left">Địa chỉ</th>
                                <th class="w80 left">Ghi chú</th>
                                <th class="w80 left">SL</th>
                                <th class="w80 left">Mã vận đơn</th>
                                <th class="w80 right">Tổng tiền</th>
                                <th class="w80 center">Ngày mua hàng</th>
                                <th class="w50 left">Nguồn</th>
                                <th class="w50 left">Trạng thái</th>
                                <th class="w50 left">Trạng thái In đơn</th>
                                <th class="w80 left">Hành động</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
            </div>
        </div>
<!--      end table data-->
<!--      chart-->
        <!-- <div class="col-md-12 col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="chart">
              <canvas id="barChart" style="height:230px; min-height:230px"></canvas>
            </div>
          </div>
        </div>
      </div> -->
<!--      end chart-->
    </div>
</section>
<div class="modal fade" tabindex="-1" id="bill_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật mã vận đơn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="order_id_modal">
                <div class="form-group">
                  <label for="bill_of_lading_no_modal">Mã vận đơn</label>
                  <input type="text" class="form-control" id="bill_of_lading_no_modal" placeholder="Mã vận đơn"
                         autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="shipping_fee_modal">Phí ship trả cho đơn vị vận chuyển</label>
                  <input type="text" class="form-control" id="shipping_fee_modal"
                         placeholder="Phí ship trả cho đơn vị vận chuyển" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="order_status_modal">Trạng thái</label>
                  <select class="form-control order-status" name="order_status" id="order_status_modal">
                    <option value="0" selected="selected">Chưa xử lý</option>
                    <option value="13">Đã tạo đơn</option>
                    <option value="1">Đã gói hàng</option>
                    <option value="2">Đã giao</option>
                    <option value="3">Hoàn thành</option>
                    <option value="4">Đã đổi size</option>
                    <option value="5">Chuyển hoàn</option>
                    <option value="6">Huỷ</option>
                    <option value="7">Giao hàng sau</option>
                    <option value="8">Đợi hàng về</option>
                    <option value="9">Chờ duyệt hoàn</option>
                    <option value="10">Đã duyệt hoàn</option>
                    <option value="11">Chờ đổi size</option>
                    <option value="12">Đang đổi size</option>
                  </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_update_bill">Lưu lại</button>
            </div>
        </div>
    </div>
</div>
<div class="iframeArea" style="visibility: hidden"></div>
<!-- /.content -->
<?php include 'createOrders.php'; ?>
<input type="hidden" id="startDate">
<input type="hidden" id="endDate">
<input type="hidden" id="lastDateOfMonth">
<input type="hidden" id="currentMonth">
<input type="hidden" id="currentYear">
<?php //require_once '../wallet/showHistory.php'; ?>
<?php require_once('../../common/footer.php'); ?>
<script>
    const PENDING = 0;
    const PACKED = 1;
    const DELIVERED = 2;
    const SUCCESS = 3;
    const CANCEL = 4;
    const RETURN = 5;
    const EXCHANGE = 6;
    const APPOINTMENT = 7;
    const WAITING = 8;
    const WAITING_RETURN = 9;
    const APPROVED_RETURN = 10;
    const WAITING_EXCHANGE = 11;
    const EXCHANGED = 12;
    const CREATED_BILL = 13;

    let delivery_order_checked = [];
    let order_checked = [];
    let order_checked_for_print = [];
    let status = [];
    let table;
    $(document).ready(function () {
        // set title for page
        set_title("Danh sách đơn hàng online");

        current_date();
        generate_datatable('date');
        count_status();
        count_all_status();

        get_info_total_checkout('date');

        //Date range picker
        generate_datetime_range_picker();

        search_by_bill();
        search_by_order_id();
        search_by_phone();
        search_by_sku();
        search_by_customer_id();

        shipping_modal();

        pending_status_click();
        waiting_status_click();
        created_bill_status_click();
        packed_status_click();
        deliverd_status_click();
        appointment_status_click();

        tab_all_click();
        tab_pending_click();
        tab_created_bill_click();
        tab_packed_click();
        tab_delivered_click();
        tab_success_click();
        tab_exchange_click();
        tab_return_click();
        tab_cancel_click();
        tab_appointment_click();
        tab_waiting_click();

        check_all();
        batch_update_status_order();
        update_bill();

        batch_update_order_status_print();
        // chart();
    });

    function chart() {

        let start_date = $("#startDate").val();
        let end_date = $("#endDate").val();
        let start_day = start_date.split('/')[0];

        var areaChartData = {
            labels  : ['01/01/2021', '02/01/2021', '03/01/2021', '04/01/2021', '05/01/2021', '06/01/2021', '07/01/2021'],
            datasets: [
                {
                    label               : 'Sales',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : [28, 48, 40, 19, 86, 27, 90]
                },
                {
                    label               : 'Profit',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : [65, 59, 80, 81, 56, 55, 40]
                },
            ]
        };

        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = $.extend(true, {}, areaChartData);
        barChartData.datasets[0] = areaChartData.datasets[1];
        barChartData.datasets[1] = areaChartData.datasets[0];

        var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        };

        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
    }

    function current_date() {
        let currentDate = new Date();
        let day = currentDate.getDate();
        let month = currentDate.getMonth() + 1;
        let year = currentDate.getFullYear();
        let start_date = year + "-" + month + "-" + day;
        let end_date = year + "-" + month + "-" + day;
        $("#startDate").val(start_date);
        $("#endDate").val(end_date);
        getLastDayOfYearAndMonth(year, month);
    }

    function getLastDayOfYearAndMonth(year, month)
    {
        var d = new Date(year, month, 0);
        var lastdate = d.getDate() + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
        $("#startDateOfMonth").val("01/"+month+"/"+year);
        $("#endDateOfMonth").val(lastdate+"/"+month+"/"+year);
    }

    function generate_datetime_range_picker() {
        $('#reservation').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            }
        }, function (start, end, label) {
            
            reset_search_param();
            let start_date = start.format('YYYY-MM-DD');
            let end_date = end.format('YYYY-MM-DD');
            $("#startDate").val(start_date);
            $("#endDate").val(end_date);

            let current_month = start.format('YYYY-MM-DD');

            reset_active_class();
            generate_datatable('date');
            get_info_total_checkout('date');
            count_status();
            // get_info_total_checkout('date');
        });
    }

    var reset_active_class = function() {
        $(".nav-link").removeClass('active');
        $("#status_all").addClass('active');
    };

    function tab_waiting_click() {
        $("#status_waiting").click(function () {
            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');
            get_status(WAITING);
        });
    }

    function tab_appointment_click() {

        $("#status_appointment").click(function () {
            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');
            get_status(APPOINTMENT);
        });
    }

    function tab_cancel_click() {

        $("#status_cancel").click(function () {
            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');
            get_status(CANCEL);
        });
    }

    function tab_return_click() {

        $("#status_return").click(function () {
            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');
            get_status(RETURN);
        });
    }

    function tab_exchange_click() {

        $("#status_exchange").click(function () {
            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');
            get_status(EXCHANGE);
        });
    }

    function tab_success_click() {

        $("#status_success").click(function () {
            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');
            get_status(SUCCESS);
        });
    }

    function tab_delivered_click() {

        $("#status_delivered").click(function () {
            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');
            get_status(DELIVERED);
        });
    }

    function tab_packed_click() {
        $("#status_packed").click(function () {
            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');
            get_status(PACKED);
        });
    }

    function tab_created_bill_click() {
        $("#status_created_bill").click(function () {
            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');
            get_status(CREATED_BILL);
        });
    }

    function tab_pending_click() {
        $("#status_pending").click(function () {
            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');
            let status = PENDING+','+WAITING_RETURN+','+APPROVED_RETURN+','+WAITING_EXCHANGE+','+EXCHANGED;
            get_status(status);
        });
    }

    function tab_all_click() {
        $("#status_all").click(function () {
            $(this).parent().parent().find('a').removeClass('active');
            $(this).addClass('active');
            get_status('');
        });
    }

    function deliverd_status_click() {
        $(".total-delivered-status").click(function () {
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(".nav-tabs").find('.nav-link').removeClass('disabled');
                generate_datatable('date');
            } else {
                $(this).parent().children().removeClass('active');
                $(this).addClass('active');
                $(".nav-tabs").find('.nav-link').addClass('disabled');
                generate_datatable('status_no_date', DELIVERED);
            }
        });
    }

    function packed_status_click() {
        $(".total-packed-status").click(function () {
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(".nav-tabs").find('.nav-link').removeClass('disabled');
                generate_datatable('date');
            } else {
                $(this).parent().children().removeClass('active');
                $(this).addClass('active');
                $(".nav-tabs").find('.nav-link').addClass('disabled');
                generate_datatable('status_no_date', PACKED);
            }
        });
    }

    function created_bill_status_click() {
        $(".total-created-bill-status").click(function () {
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(".nav-tabs").find('.nav-link').removeClass('disabled');
                generate_datatable('date');
            } else {
                $(this).parent().children().removeClass('active');
                $(this).addClass('active');
                $(".nav-tabs").find('.nav-link').addClass('disabled');
                generate_datatable('status_no_date', CREATED_BILL);
            }
        });
    }

    function appointment_status_click() {
        $(".total-appointment-status").click(function () {
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(".nav-tabs").find('.nav-link').removeClass('disabled');
                generate_datatable('date');
            } else {
                $(this).parent().children().removeClass('active');
                $(this).addClass('active');
                $(".nav-tabs").find('.nav-link').addClass('disabled');
                generate_datatable('status_no_date', APPOINTMENT);
            }
        });
    }

    function waiting_status_click() {
        $(".total-wating-status").click(function () {
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(".nav-tabs").find('.nav-link').removeClass('disabled');
                generate_datatable('date');
            } else {
                $(this).parent().children().removeClass('active');
                $(this).addClass('active');
                $(".nav-tabs").find('.nav-link').addClass('disabled');
                generate_datatable('status_no_date', WAITING);
            }
        });
    }

    function pending_status_click() {
        $(".total-pending-status").click(function () {
            if($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(".nav-tabs").find('.nav-link').removeClass('disabled');
                generate_datatable('date');
            } else {
                $(this).parent().children().removeClass('active');
                $(this).addClass('active');
                $(".nav-tabs").find('.nav-link').addClass('disabled');
                let status = PENDING+','+WAITING_RETURN+','+APPROVED_RETURN+','+WAITING_EXCHANGE+','+EXCHANGED;
                generate_datatable('status_no_date', status);
            }
        });
    }

    function shipping_modal() {
        $("#shipping_fee_modal").change(function () {
            let e = this;
            let val = $(e).val();
            if(Number(val) < 100) {
                val += '000';
            }
            val = replaceComma(val);
            if (isNaN(val)) {
                $(e).addClass("is-invalid");
            } else {
                $(e).removeClass("is-invalid");
                val = Number(val);
                $(e).val(formatNumber(val));
            }
        });
    }

    function search_by_bill() {
        let bill = "<?php echo(isset($_GET['bill']) ? $_GET['bill'] : '') ?>";
        if (bill) {
            $("#search_bill_id").val(bill);
            setTimeout(function () {
                $('#search_bill_id').trigger(
                    jQuery.Event('keydown', {keyCode: 13, which: 13})
                );
            }, 100);
        }
        $("#search_bill_id").on("keydown", function (event) {
            let key = event.which;
            if (key === 13) {
                reset_search_param('bill');
                reset_active_class();
                let bill = $(this).val();
                if (bill) {
                    generate_datatable('bill');
                    // get_info_total_checkout('customer_id');
                } else {
                    generate_datatable('date');
                    // get_info_total_checkout('date');
                }
            }
        });
    }

    function search_by_customer_id() {
        let customer_id = "<?php echo(isset($_GET['customer_id']) ? $_GET['customer_id'] : '') ?>";
        if (customer_id) {
            $("#search_customer_id").val(customer_id);
            setTimeout(function () {
                $('#search_customer_id').trigger(
                    jQuery.Event('keydown', {keyCode: 13, which: 13})
                );
            }, 100);
        }
        $("#search_customer_id").on("keydown", function (event) {
            let key = event.which;
            if (key === 13) {
                reset_search_param('customer');
                reset_active_class();
                let customer_id = $(this).val();
                if (customer_id) {
                    generate_datatable('customer_id');
                    // get_info_total_checkout('customer_id');
                } else {
                    generate_datatable('date');
                    // get_info_total_checkout('date');
                }
            }
        });
    }

    function search_by_sku() {
        $("#search_sku").on("keydown", function (event) {
            let key = event.which;
            if (key === 13) {
                reset_search_param('sku');
                reset_active_class();
                let sku = $(this).val();
                if (sku) {
                    generate_datatable('sku');
                    // get_info_total_checkout('sku');
                } else {
                    generate_datatable('date');
                    // get_info_total_checkout('date');
                }
            }
        });
    }

    function search_by_phone() {
        let customer_phone = "<?php echo(isset($_GET['customer_phone']) ? $_GET['customer_phone'] : '') ?>";
        if (customer_phone) {
            $("#search_phone").val(customer_phone);
            setTimeout(function () {
                $('#search_phone').trigger(
                    jQuery.Event('keydown', {keyCode: 13, which: 13})
                );
            }, 100);
        }
        $("#search_phone").on("keydown", function (event) {
            let key = event.which;
            if (key === 13) {
                reset_search_param('phone');
                reset_active_class();
                let phone = $(this).val();
                if (phone) {
                    generate_datatable('phone');
                    // get_info_total_checkout('phone');
                } else {
                    generate_datatable('date');
                    // get_info_total_checkout('date');
                }
            }
        });
    }

    function search_by_order_id() {
        let order_id = "<?php echo(isset($_GET['order_id']) ? $_GET['order_id'] : '') ?>";
        if (order_id) {
            $("#search_order_id").val(order_id);
            setTimeout(function () {
                $('#search_order_id').trigger(
                    jQuery.Event('keydown', {keyCode: 13, which: 13})
                );
            }, 100);
        }

        $("#search_order_id").on("keydown", function (event) {
            let key = event.which;
            // console.log(key);
            if (key === 13) {
                reset_search_param('order');
                reset_active_class();
                let order_id = $(this).val();
                if (order_id) {
                    generate_datatable('order_id');
                } else {
                    generate_datatable('date');
                }
            }
        });
    }

    function reset_search_param(type) {
        if(type !== 'phone') {
            $("#search_phone").val("");
        }
        if(type !== 'customer') {
            $("#search_customer_id").val("");
        }
        if(type !== 'sku') {
            $("#search_sku").val("");
        }
        if(type !== 'order') {
            $("#search_order_id").val("");
        }if(type !== 'bill') {
            $("#search_bill_id").val("");
        }
    }

    function count_all_status() {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
            type: "POST",
            data: {
                method: "count_all_status"
            },
            dataType: "json",
            success: function (res) {
                $(".total_pending").text(res.pending);
                $(".total_wating").text(res.wating);
                $(".total_created_bill").text(res.created_bill);
                $(".total_packed").text(res.packed);
                $(".total_delivered").text(res.delivered);
                $(".total_appointment").text(res.appointment);
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                });
                hide_loading();
            }
        });
    }

    function count_status() {
      $.ajax({
          url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
          type: "POST",
          data: {
              method: "count_status",
            start_date: $("#startDate").val(),
            end_date: $("#endDate").val()
          },
          dataType: "json",
          success: function (res) {
              $("#count_all").html("("+res.count_total+")");
              if(res.count_total > 0) {
                  $("#count_all").addClass('text-danger');
              } else {
                  $("#count_all").removeClass('text-danger');
              }
              $("#count_pending").html("("+res.pending+")");
              if(res.pending > 0) {
                  $("#count_pending").addClass('text-danger');
              } else {
                  $("#count_pending").removeClass('text-danger');
              }
              $("#count_created_bill").html("("+res.created_bill+")");
              if(res.created_bill > 0) {
                  $("#count_created_bill").addClass('text-danger');
              } else {
                  $("#count_created_bill").removeClass('text-danger');
              }
              $("#count_packed").html("("+res.packed+")");
              if(res.packed > 0) {
                  $("#count_packed").addClass('text-danger');
              } else {
                  $("#count_packed").removeClass('text-danger');
              }
              $("#count_delivered").html("("+res.delivered+")");
              if(res.delivered > 0) {
                  $("#count_delivered").addClass('text-danger');
              } else {
                  $("#count_delivered").removeClass('text-danger');
              }
              $("#count_success").html("("+res.success+")");
              if(res.success > 0) {
                  $("#count_success").addClass('text-danger');
              } else {
                  $("#count_success").removeClass('text-danger');
              }
              $("#count_exchange").html("("+res.exchange+")");
              if(res.exchange > 0) {
                  $("#count_exchange").addClass('text-danger');
              } else {
                  $("#count_exchange").removeClass('text-danger');
              }
              $("#count_return").html("("+res.return+")");
              if(res.return > 0) {
                  $("#count_return").addClass('text-danger');
              } else {
                  $("#count_return").removeClass('text-danger');
              }
              $("#count_appointment").html("("+res.appointment+")");
              if(res.appointment > 0) {
                  $("#count_appointment").addClass('text-danger');
              } else {
                  $("#count_appointment").removeClass('text-danger');
              }
              $("#count_wating").html("("+res.wating+")");
              if(res.wating > 0) {
                  $("#count_wating").addClass('text-danger');
              } else {
                  $("#count_wating").removeClass('text-danger');
              }
          },
          error: function (data, errorThrown) {
              console.log(data.responseText);
              console.log(errorThrown);
              Swal.fire({
                  type: 'error',
                  title: 'Đã xảy ra lỗi',
                  text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
              });
              hide_loading();
          }
      });
    }

    function update_bill() {
        $("#btn_update_bill").click(function () {
            let order_id = $("#order_id_modal").val();
            let bill_no = $("#bill_of_lading_no_modal").val();
            let shipping_fee = replaceComma($("#shipping_fee_modal").val());
            let status = $("#order_status_modal").val();
            if(!bill_no) {
                $("#bill_of_lading_no_modal").addClass("is-invalid").focus();
                toast_error_message('Mã vận đơn không được để trống');
                return false;
            } else {
                $("#bill_of_lading_no_modal").removeClass("is-invalid");
            }
            if(!shipping_fee) {
                $("#shipping_fee_modal").addClass("is-invalid").focus();
                toast_error_message('Phí ship không được để trống');
                return false;
            } else {
                shipping_fee = replaceComma(shipping_fee);
                if(isNaN(shipping_fee)) {
                    $("#shipping_fee_modal").addClass("is-invalid").focus();
                    toast_error_message('Phí ship phải là số');
                    return false;
                }
                $("#bill_of_lading_no_modal").removeClass("is-invalid");
            }
            Swal.fire({
                title: 'Bạn có chắc chắn muốn cập nhật mã vận đơn này?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
                        type: "POST",
                        dataType: "json",
                        data: {
                            method: 'update_bill',
                            order_id: order_id,
                            status: status,
                            bill_no: bill_no,
                            shipping_fee: shipping_fee
                        },
                        success: function (res) {
                            table.ajax.reload();
                            toastr.success('Mã vận đơn đã được cập nhật thành công.');
                            $("#bill_modal").modal("hide");
                            count_all_status();
                            count_status();
                        },
                        error: function (data, errorThrown) {
                            console.log(data.responseText);
                            console.log(errorThrown);
                            Swal.fire({
                                type: 'error',
                                title: 'Đã xảy ra lỗi',
                                text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                            });
                            hide_loading();
                        }
                    });
                }
            });
        });
    }


    function check_all() {
        $('#check_all_order').on('click', function () {
            if($(".dataTables_scrollBody").length > 0) {
                console.log($(".dataTables_scrollBody").find('td input:checkbox'));
                $(".dataTables_scrollBody").find('td input:checkbox').trigger("click");
            } else {
                $(this).closest('table').find('td input:checkbox').each(function(){
                    let isChecked = $(this).prop("checked");
                    if(isChecked) {
                        $(this).prop("checked", false);
                    } else {
                        $(this).prop("checked", true);
                    }
                });
                // $(this).closest('table').find('td input:checkbox').trigger("click");
            }
        });
    }

    function get_status(stt) {
        generate_datatable('status', stt);
        get_info_total_checkout('status', stt);
    }

    function get_data_search(type, status) {
        if(typeof status === 'undefined' || status === '') {
            status = -1;
        }
        if (type === 'date') {
            return {
                method: 'find_all',
                start_date: $("#startDate").val(),
                end_date: $("#endDate").val(),
                type: 1,
                status: status
            }
        } else if (type === 'bill') {
            return {
                method: 'find_all',
                bill: $("#search_bill_id").val(),
                type: 1,
                status: status
            }
        }  else if (type === 'order_id') {
            return {
                method: 'find_all',
                order_id: $("#search_order_id").val(),
                type: 1,
                status: status
            }
        } else if (type === 'phone') {
            return {
                method: 'find_all',
                phone: $("#search_phone").val(),
                type: 1,
                status: status
            }
        } else if (type === 'customer_id') {
            return {
                method: 'find_all',
                customer_id: $("#search_customer_id").val(),
                type: 1,
                status: status
            }
        } else if (type === 'sku') {
            return {
                method: 'find_all',
                sku: $("#search_sku").val(),
                type: 1,
                status: status
            }
        } else if (type === 'status') {
            return {
                method: 'find_all',
                type: 1,
                start_date: $("#startDate").val(),
                end_date: $("#endDate").val(),
                status: status
            }
        } else if (type === 'status_no_date') {
            return {
                method: 'find_all',
                type: 1,
                status: status
            }
        }
        return '';
    }

    function get_data_search_info_total(type, status) {
        if(typeof status === 'undefined' || status === '') {
            status = -1;
        }
        if (type === 'date') {
            return {
                method: 'get_info_total_checkout',
                start_date: $("#startDate").val(),
                end_date: $("#endDate").val(),
                type: 1,
                status: status
            }
        } else if (type === 'order_id') {
            return {
                method: 'get_info_total_checkout',
                order_id: $("#search_order_id").val(),
                type: 1,
                status: status
            }
        } else if (type === 'phone') {
            return {
                method: 'get_info_total_checkout',
                phone: $("#search_phone").val(),
                type: 1,
                status: status
            }
        } else if (type === 'customer_id') {
            return {
                method: 'get_info_total_checkout',
                customer_id: $("#search_customer_id").val(),
                type: 1,
                status: status
            }
        } else if (type === 'sku') {
            return {
                method: 'get_info_total_checkout',
                sku: $("#search_sku").val(),
                type: 1,
                status: status
            }
        } else if (type === 'status') {
            return {
                method: 'get_info_total_checkout',
                type: 1,
                start_date: $("#startDate").val(),
                end_date: $("#endDate").val(),
                status: status
            }
        } else if (type === 'status_no_date') {
            return {
                method: 'get_info_total_checkout',
                type: 1,
                status: status
            }
        }
        return '';
    }

    function get_data_param_detail(type, order_id) {
        if (type === 'date') {
            return {
                method: 'find_detail',
                order_id: order_id,
                start_date: $("#startDate").val(),
                end_date: $("#endDate").val()
            }
        } else if (type === 'order_id') {
            return {
                method: 'find_detail',
                order_id: $("#search_order_id").val()
            }
        } else if (type === 'phone') {
            return {
                method: 'find_detail',
                phone: $("#search_phone").val()
            }
        } else if (type === 'customer_id') {
            return {
                method: 'find_detail',
                customer_id: $("#search_customer_id").val()
            }
        } else if (type === 'sku') {
            return {
                method: 'find_detail',
                sku: $("#search_sku").val()
            }
        }
        return '';
    }

    function get_info_total_checkout(type, status) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
            type: "GET",
            dataType: "json",
            data: get_data_search_info_total(type, status),
            success: function (res) {
                $(".total_money").html((res.total_amount ? res.total_amount : 0) + "<sup>đ</sup>");
                $(".total_orders").html(res.count_total ? res.count_total : 0);
                $(".total_products").html(res.total_product ? res.total_product : 0);
                // $(".total_on_shop").html((res.total_on_shop ? res.total_on_shop : 0) + "<sup>đ</sup>");
                // $(".count_on_shop").html(res.count_on_shop ? res.count_on_shop : 0);
                // $(".total_product_on_shop").html(res.total_product_on_shop ? res.total_product_on_shop : 0);
                // $(".total_online").html((res.total_online ? res.total_online : 0) + "<sup>đ</sup>");
                // $(".count_online").html(res.count_online ? res.count_online : 0);
                // $(".total_product_online").html(res.total_product_online ? res.total_product_online : 0);
                // $(".total_exchange").html((res.total_exchange ? res.total_exchange : 0) + "<sup>đ</sup>");
                // $(".count_exchange").html(res.count_exchange ? res.count_exchange : 0);
                // $(".total_product_exchange").html(res.total_product_exchange ? res.total_product_exchange : 0);
                // $(".total_cash").html((res.total_cash ? res.total_cash : 0) + "<sup>đ</sup>");
                // $(".total_transfer").html((res.total_transfer ? res.total_transfer : 0) + "<sup>đ</sup>");
                $(".total_profit").html((res.total_profit ? res.total_profit : 0) + "<sup>đ</sup>");

                $("#percent_profit").html("");
                // $("#percent_onshop").html("");
                // $("#percent_online").html("");
                // $("#percent_exchange").html("");
                //
                let total_amount = Number(replaceComma(res.total_amount));
                let total_profit = Number(replaceComma(res.total_profit));
                let percent = ((total_profit / total_amount) * 100).toFixed(2);
                if (!isNaN(percent)) {
                    $("#percent_profit").html(percent + "<sup>%</sup>");
                }
                // let total_onshop = Number(replaceComma(res.total_on_shop));
                // let percent_onshop = ((total_onshop / total_checkout) * 100).toFixed(2);
                // if (!isNaN(percent_onshop)) {
                //     $("#percent_onshop").html(percent_onshop + "<sup>%</sup>");
                // }
                // let total_online = Number(replaceComma(res.total_online));
                // let percent_online = ((total_online / total_checkout) * 100).toFixed(2);
                // if (!isNaN(percent_online)) {
                //     $("#percent_online").html(percent_online + "<sup>%</sup>");
                // }
                // let total_exchange = Number(replaceComma(res.total_exchange));
                // let percent_exchange = ((total_exchange / total_checkout) * 100).toFixed(2);
                // if (!isNaN(percent_exchange)) {
                //     $("#percent_exchange").html(percent_exchange + "<sup>%</sup>");
                // }
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                });
                hide_loading();
            }
        });
    }

    function generate_datatable(type, status) {
        if ($.fn.dataTable.isDataTable('#example')) {
            table.destroy();
            table.clear();
            $("#check_all_order").prop("checked", false);
            // table.ajax.reload();
        }
        order_checked = [];
        order_checked_for_print = [];
        $("#order_checked_for_update").text("("+order_checked.length+")");
        $("#order_checked_for_print_for_update").text("("+order_checked_for_print.length+")");
        table = $('#example').DataTable({
            'ajax': {
                "type": "GET",
                "url": "<?php Common::getPath() ?>src/controller/orders/OrderController.php",
                "data": get_data_search(type, status)
            },
            "dom": '<"top"flp<"clear">>rt<"bottom"ip<"clear">>',
            searching: false,
            // ordering: false,
            // scrollY: '100vh',
            scrollCollapse: true,
            "language": {
                "emptyTable": "Không có dữ liệu",
                "oPaginate": {
                    "sFirst": "&lsaquo;",
                    "sPrevious": "&laquo;",
                    "sNext": "&raquo;",
                    "sLast": "&rsaquo;"
                },
            },
            select: "single",
            "columns": [
                {
                    "className": 'check-box center',
                    "orderable": false,
                    "data": null,
                    "defaultContent": '',
                    "render": format_checkbox,
                    width: "5px",
                },
                {
                    "className": 'details-control center',
                    "orderable": false,
                    "data": null,
                    "defaultContent": '',
                    "render": function () {
                        return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                    },
                    width: "5px",
                },
                {
                    "data": "order_id",
                    width: "30px",
                    class: 'center',
                    "orderable": false
                },
                {
                    "data": 'customer_name',
                    width: "100px",
                    "orderable": false,
                    class: 'left'
                },
                {
                    "data": 'customer_phone',
                    width: "50px",
                    "orderable": false,
                    class: 'left'
                },
                {
                    "data": 'customer_address',
                    "orderable": false,
                    class: 'left'
                },
                {
                    "data": format_description,
                    "orderable": false,
                    class: 'left'
                },
                {
                    "data": 'quantity',
                    class: 'center'
                },
                {
                    "data": format_bill_of_lading_no,
                    width: "50px",
                    "orderable": false,
                    class: 'center'
                },
                {
                    "data": format_total_amount,
                    width: "50px",
                    "orderable": false,
                    class: 'right'
                },
                {
                    "data": format_order_date,
                    width: "70px",
                    "orderable": true,
                    class: 'center'
                },
                // {
                //     "data": format_type,
                //     width: "30px"
                // },
                // {
                //     "data": format_payment,
                //     width: "30px"
                // },
                {
                    "data": format_source,
                    width: "30px",
                    "orderable": true
                },
                {
                    "data": format_status,
                    width: "50px",
                    "orderable": true
                },
                {
                    "data": format_print_status,
                    width: "50px",
                    "orderable": true
                },
                {
                    "data": format_action,
                    "orderable": false,
                    width: "50px"
                }
            ],
            "lengthMenu": [[50, 100, -1], [50, 100, "All"]]
        });

        // Add event listener for opening and closing details
        $('#example tbody').off('click').on('click', '.details-control', function (event) {
            let tr = $(this).closest('tr');
            let tdi = tr.find("i.fa");
            let row = table.row(tr);
            let order_id = row.data().order_id;
            // let start_date = $("#startDate").val();
            // let end_date = $("#endDate").val();
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
                tdi.first().removeClass('fa-minus-square');
                tdi.first().addClass('fa-plus-square');
            } else {
                // Open this row
                // row.child(format_order_detail(row.data())).show();
                $.ajax({
                    url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
                    type: "POST",
                    dataType: "json",
                    data: {
                        method: "find_detail",
                        order_id: order_id,
                    },
                    success: function (res) {
                        // console.log(res);
                        let order = res.orders[0];
                        let order_logs = res.order_logs;
                        // let details = res[0].details;
                        if (res.orders.length > 0) {
                            row.child(format_order_detail(order, order_logs, row.data())).show();
                            tr.addClass('shown');
                            tdi.first().removeClass('fa-plus-square');
                            tdi.first().addClass('fa-minus-square');
                        }

                    },
                    error: function (data, errorThrown) {
                        console.log(data.responseText);
                        console.log(errorThrown);
                        Swal.fire({
                            type: 'error',
                            title: 'Đã xảy ra lỗi',
                            text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                        });
                        hide_loading();
                    }
                });

            }
            event.preventDefault();
        });

        $('#example tbody').on('click', '.edit-status', function () {
            show_loading();
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let status = row.data().status;
            // let order_date = row.data().order_date;
            // let min_date = order_date.split("/")[2].split(' ')[0]+'-'+order_date.split("/")[1]+'-'+order_date.split("/")[0];
            // console.log(min_date);
            let selectbox = '<div class="select-status">' +
                                '<select class="form-control p-2 fast-order-status">' +
                                    '<option value="0" '+(status == PENDING ? selected="selected" : '')+'>Chưa xử lý</option>' +
                                    '<option value="13" '+(status == CREATED_BILL ? selected="selected" : '')+'>Đã tạo đơn</option>' +
                                    '<option value="1" '+(status == PACKED ? selected="selected" : '')+'>Đã gói hàng</option>' +
                                    '<option value="2" '+(status == DELIVERED ? selected="selected" : '')+'>Đã giao</option>' +
                                    '<option value="3" '+(status == SUCCESS ? selected="selected" : '')+'>Hoàn thành</option>' +
                                    // '<option value="4" '+(status == EXCHANGE ? selected="selected" : '')+'>Đổi size</option>' +
                                    '<option value="5" '+(status == RETURN ? selected="selected" : '')+'>Chuyển hoàn</option>' +
                                    '<option value="6" '+(status == CANCEL ? selected="selected" : '')+'>Huỷ</option>' +
                                    '<option value="7" '+(status == APPOINTMENT ? selected="selected" : '')+'>Giao hàng sau</option>' +
                                    '<option value="8" '+(status == WAITING ? selected="selected" : '')+'>Đợi hàng về</option>' +
                                    '<option value="9" '+(status == WAITING_RETURN ? selected="selected" : '')+'>Chờ duyệt hoàn</option>' +
                                    '<option value="10" '+(status == APPROVED_RETURN ? selected="selected" : '')+'>Đã duyệt hoàn</option>' +
                                    '<option value="11" '+(status == WAITING_EXCHANGE ? selected="selected" : '')+'>Chờ đổi size</option>' +
                                    '<option value="12" '+(status == EXCHANGED ? selected="selected" : '')+'>Đang đổi size</option>' +
                                '</select>' +
                                '<input type="text" class="form-control delivery-date1 p-2 mt-2 hidden">' +
                                '<i class="fa fa-save text-secondary c-pointer save-status mt-2" style="font-size: 20px;"></i> ' +
                                '<i class="fa fa-times-circle text-danger c-pointer cancel-edit-status mt-2" style="font-size: 20px;"></i>' +
                            '</div>';
            $(this).closest('.text-status').addClass("hidden").parent().append(selectbox);
            $(".fast-order-status").change(function(){
                if($(this).val() == 7) {
                    $(this).next('.delivery-date1').removeClass('hidden').datepicker({
                        format: 'yyyy-mm-dd',
                        language: 'vi',
                        todayBtn: true,
                        todayHighlight: true,
                        autoclose: true,
                        startDate: new Date()
                    })
                } else {
                    $(this).next('.delivery-date1').addClass('hidden').val('');
                }
            });
        });



        $('#example tbody').on('click', '.cancel-edit-status', function () {
            show_loading();
            let tr = $(this).closest('tr');
            let row = table.row(tr);

            $(this).closest('.select-status').prev(".text-status").removeClass("hidden");
            $(this).closest('.select-status').remove();
        });

        $('#example tbody').on('click', '.save-status', function () {
            show_loading();
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let order_id = row.data().order_id;
            let status = $(this).prev().prev('select').val();
            let delivery_date = '';
            if(status == 7) {
                delivery_date = $(this).prev('input').val();
            }
            Swal.fire({
                title: 'Bạn có chắc chắn muốn cập nhật trạng thái đơn này?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    update_status(order_id, status, delivery_date);
                }
            });

        });

        $('#example tbody').on('click', '.print_receipt', function () {
            show_loading();
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let order_id = row.data().order_id;
            let type = row.data().order_type;
            let is_print = row.data().is_print;
            let td = tr.find("td");
            print_receipt(order_id, type, td, is_print);
        });

        $('#example tbody').on('click', '.edit-bill', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let order_id = row.data().order_id;
            let status = row.data().status;
            $("#order_id_modal").val(order_id);
            $("#order_status_modal").val(status).trigger('change');
            $("#bill_of_lading_no_modal").val("");
            $("#shipping_fee_modal").val("");
            $("#bill_modal").modal("show");
        });

        $('#example tbody').on('click', '.edit-description', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let order_id = row.data().order_id;

            $(this).addClass('hidden');
            $(this).prev().removeClass('hidden');
            $(this).prev().prev().removeClass('hidden');
            $(this).prev().prev().prev().removeClass('hidden');


        });



        $('#example tbody').on('click', '.delete_order', function () {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xoá đơn hàng này?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    show_loading();
                    let tr = $(this).closest('tr');
                    let row = table.row(tr);
                    let order_id = row.data().order_id;
                    $.ajax({
                        url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
                        type: "POST",
                        dataType: "json",
                        data: {
                            method: "delete_order",
                            order_id: order_id
                        },
                        success: function (res) {
                            table.ajax.reload();
                            get_info_total_checkout('date');
                            toastr.success('Đơn hàng đã được xoá thành công.');
                        },
                        error: function (data, errorThrown) {
                            console.log(data.responseText);
                            console.log(errorThrown);
                            Swal.fire({
                                type: 'error',
                                title: 'Đã xảy ra lỗi',
                                text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                            });
                            hide_loading();
                        }
                    });
                }
            });
        });

        $('#example tbody').on('click', '.edit_order', function () {
            show_loading();
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let order_id = row.data().order_id;
            let order_type = row.data().order_type;
            $.ajax({
                url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
                type: "POST",
                dataType: "json",
                data: {
                    method: "edit_order",
                    order_id: order_id,
                    order_type: order_type
                },
                success: function (res) {
                    console.log(JSON.stringify(res));
                    set_data_edit_order(order_id, res, order_type);
                },
                error: function (data, errorThrown) {
                    console.log(data.responseText);
                    console.log(errorThrown);
                    Swal.fire({
                        type: 'error',
                        title: 'Đã xảy ra lỗi',
                        text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                    });
                    hide_loading();
                }
            });
        });

        $('#example tbody').on('click', '.checked_order', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let order_id = row.data().order_id;
            let is_print = row.data().is_print;
            let bill = row.data().bill_of_lading_no;
            let isCheck = $(this).prop('checked');
            if (isCheck) {
                $(this).prop("checked", "checked");
                order_checked.push(order_id);
                if(bill && is_print == 0) {
                    order_checked_for_print.push(order_id);
                }
            } else {
                $(this).prop("checked", "");
                let index = order_checked.indexOf(order_id);
                order_checked.splice(index, 1);
                let index_print = order_checked_for_print.indexOf(order_id);
                if(index_print > -1) {
                    order_checked_for_print.splice(index_print, 1);
                }
            }
            if(order_checked.length > 0) {
                $("#order_checked_for_update").text("("+order_checked.length+")");
                $(".order_status_update").prop("disabled","");
            } else {
                $("#order_checked_for_update").text("");
                $(".order_status_update").prop("disabled",true);
            }
            if(order_checked_for_print.length > 0) {
                $("#order_checked_for_print_for_update").text("("+order_checked_for_print.length+")");
                $(".order_status_print_update").prop("disabled","");
            } else {
                $("#order_checked_for_print_for_update").text("");
                $(".order_status_print_update").prop("disabled",true);
            }
        });

    }

    function batch_update_order_status_print() {
        $(".order_status_print_update").click(function () {
            $(".show_loading_update_print_status").removeClass("hidden");
            $(".fa-save").addClass("hidden");
            let order_ids = '';
            for (let i = 0; i < order_checked_for_print.length; i++) {
                order_ids += order_checked_for_print[i] + ',';
            }
            order_ids = order_ids.substr(0, order_ids.length - 1);
            Swal.fire({
                title: 'Xác nhận',
                text: "Bạn có chắc chắn muốn cập nhật trạng thái Đã In cho các đơn hàng này?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    update_status_print(order_ids);
                } else {
                    $(".show_loading_update_print_status").addClass("hidden");
                    $(".fa-save").removeClass("hidden");
                }
            });
        });

    }
    function update_status_print(order_ids) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "update_print",
                order_id: order_ids,
            },
            success: function (res) {
                table.ajax.reload();
                $(".show_loading_update_print_status").addClass("hidden");
                $(".fa-save-print-status").removeClass("hidden");
                $("#order_checked_for_print_for_update").text('');
                $("#check_all_order").prop("checked", '');
                order_checked_for_print = [];
                toastr.success('Cập nhật trạng thái thành công.');
            },
            error: function (data, errorThrown) {
                console.log(data);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                });
                $(".show_loading_update_status").addClass("hidden");
                $(".fa-save").removeClass("hidden");
            }
        });

    }

    function batch_update_status_order() {
        $(".order_status_update").click(function () {
            $(".show_loading_update_status").removeClass("hidden");
            $(".fa-save").addClass("hidden");
            let order_ids = '';
            for (let i = 0; i < order_checked.length; i++) {
                order_ids += order_checked[i] + ',';
            }
            order_ids = order_ids.substr(0, order_ids.length - 1);
            let status = $("#order_status_batch").val();
            Swal.fire({
                title: 'Xác nhận',
                text: "Bạn có chắc chắn muốn cập nhật trạng thái các đơn hàng này?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    update_status(order_ids, status);
                } else {
                    $(".show_loading_update_status").addClass("hidden");
                    $(".fa-save").removeClass("hidden");
                }
            });
        });

    }
    function update_status(order_id, status, delivery_date) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "update_status",
                order_id: order_id,
                status: status,
                delivery_date: delivery_date
            },
            success: function (res) {
                table.ajax.reload();
                $(".show_loading_update_status").addClass("hidden");
                $(".fa-save").removeClass("hidden");
                $(".order_status_update").prop("disabled", true);
                $("#order_checked_for_update").text('');
                $("#check_all_order").prop("checked", '');
                order_checked = [];
                toastr.success('Cập nhật trạng thái thành công.');
                count_status();
                count_all_status();
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                });
                $(".show_loading_update_status").addClass("hidden");
                $(".fa-save").removeClass("hidden");
            }
        });

    }

    function print_receipt(order_id, type, td, is_print) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "print_receipt",
                order_id: order_id,
                type: type
            },
            success: function (res) {
                let filename = res.fileName;
                $(".iframeArea").html("");
                if (typeof filename !== "underfined" && filename !== "") {
                    // $(".iframeArea").html('<iframe src="<?php //Common::getPath() ?>src/controller/orders/pdf/receipt.html" id="receiptContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                    $(".iframeArea").html('<iframe src="<?php Common::getPath() ?>src/controller/orders/pdf/'+filename+'" id="receiptContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                    window.open("<?php Common::getPath() ?>src/controller/orders/pdf/" + filename, "_blank");
                    setTimeout(function () {
                        // let objFra = document.getElementById('receiptContent');
                        // objFra.contentWindow.focus();
                        // objFra.contentWindow.print();

                        if(is_print == '0') { 
                            Swal.fire({
                                title: 'Chuyển trạng thái thành Đã in?',
                                text: "",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.value) {
                                    $.ajax({
                                        url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
                                        type: "POST",
                                        dataType: "json",
                                        traditional: true,
                                        data: {
                                            method: "update_print",
                                            order_id: order_id
                                        },
                                        success: function (res) {
                                            toastr.success('Cập nhật thành công.');
                                            $(td[13]).html('<span class="badge badge-success">Đã in</span>');
                                        },
                                        error: function (data, errorThrown) {
                                            console.log(data.responseText);
                                            console.log(errorThrown);
                                            Swal.fire({
                                                type: 'error',
                                                title: 'Đã xảy ra lỗi',
                                                text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                                            });
                                            hide_loading();
                                        }
                                    });
                                }
                            });
                        }
                    }, 500);
                    
                }
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                });
                hide_loading();
            }
        });
    }

    function set_data_edit_order(order_id, data, order_type) {
        reset_data();
        $(".modal-title").text("Cập nhật đơn hàng #" + order_id);
        $("#create_new_order").text("Cập nhật");
        // enable_btn_add_new();
        $("#order_type").val(order_type).trigger("change");
        $.each(data, function (key, value) {
            // console.log(order_type);
            if (value.length != 0) {
                $("#order_id").val(value[0].order_id);
                $('#orderDate').val(value[0].order_date);
                $("#order_status").val(value[0].status).trigger('change');
                $("#customer_id").val(value[0].customer_id);
                $("#customer_name").val(value[0].customerName);
                $("#customer_phone").typeahead('val', value[0].phone);
                $("#description").val(value[0].description);
                $("#order_source").val(value[0].source).trigger('change');
                $("#shipping_unit").val(value[0].shipping_unit).trigger('change');
                // online
                // if (order_type == 1) {

                    $("#bill_of_lading_no").val(value[0].bill_of_lading_no);
                    $("#shipping_fee").val(Number(replaceComma(value[0].shipping_fee)) > 0 ? value[0].shipping_fee : '');
                    $("#shipping").val(Number(replaceComma(value[0].shipping)) > 0 ? value[0].shipping : '');
                    $("#bill_of_lading_no").prop("disabled", false);
                    $("#shipping_fee").prop("disabled", false);
                    $(".select-shipping-unit").prop("disabled", false);
                    $("#shipping").prop("disabled", false);
                // } else if (order_type == 0) {
                //     generate_select2_city();
                //     // on shop
                //     $("#bill_of_lading_no").prop("disabled", true);
                //     $("#shipping_fee").prop("disabled", true);
                //     $(".select-shipping-unit").prop("disabled", true);
                //     $("#shipping").prop("disabled", true);
                //     // $("#order_status").val(3);//complete
                // }
                $("#payment_type").val(value[0].payment_type);
                $("#payment").val(value[0].customer_payment);
                $("#total_amount").html(value[0].total_amount+'<sup>đ</sup>');
                $("#discount").val(Number(replaceComma(value[0].discount)) > 0 ? value[0].discount : '');
                $("#total_checkout").html(value[0].total_checkout+'<sup>đ</sup>');
                $("#repay").html(value[0].repay+'<sup>đ</sup>');
                $(".product-area").html("");
                $("#table_list_product tbody").html("");
                let details = value[0].details;
                add_product_list(details);
                open_modal('#create_order');
            } else {
                toastr.error('Đã xảy ra lỗi.');
            }
        });
    }

    function format_order_detail(data, order_logs, row_data) {
        // console.log(data);
        const SHOP = '0';
        const ONLINE = '1';
        const EXCHANGE = '2';

        let payment_exchange_type = row_data.payment_exchange_type;
        let order_refer = row_data.order_refer;
        let details = data.details;
        let order_type = data.order_type;
        let table = '<div class="card">' +
            '<div class="card-header bg-info"><h5>Danh sách sản phẩm</h5></div>' +
            '<div class="card-body">';
        table += '<table class="table table-striped" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        table += '<thead>' +
            '<tr>' +
            '<th>Hình ảnh</th>' +
            '<th>Mã</th>' +
            '<th>Tên</th>' +
            '<th>Size</th>' +
            '<th>Màu</th>' +
            '<th>Số lượng</th>' +
            '<th class="right">Giá</th>' +
            '<th class="right">Giảm trừ</th>' +
            '<th class="right">Thành tiền</th>' +
            '<th class="right"></th>';
            // '<th class="center"></th>';
        // '<th class="center">Lazada</th>' +
        if (order_type === EXCHANGE) {
            table += '<th class="right">Loại sản phẩm</th>';
        }
        table += '</tr>' +
            '</thead>';
        // let total_reduce = 0;
        let profit = 0;
        let intoMoney = 0;
        for (let i = 0; i < details.length; i++) {
            intoMoney += Number(replaceComma(details[i].intoMoney));
            let type = details[i].product_type;
            let class_text = "";
            if (type === '1') {
                class_text = "text-info";
            } else if (type === '2') {
                class_text = "text-success";
            } else if (type === '3') {
                class_text = "text-danger";
            }
            let detail_profit = 0;
            if (type === '1' || type === '3') {
                profit += 0 - Number(replaceComma(details[i].profit));
                detail_profit = 0 - Number(replaceComma(details[i].profit));
            } else {
                profit += Number(replaceComma(details[i].profit));
                detail_profit = Number(replaceComma(details[i].profit));
            }
            table += '<tr class="' + class_text + '">' +
                '<input type="hidden" id="product_id_' + i + '" value="' + details[i].product_id + '"/>' +
                '<input type="hidden" id="variant_id_' + i + '" value="' + details[i].variant_id + '"/>' +
                '<td><img src=\'' + details[i].image + '\' width=\'50px\' style=\'border-radius:50%\' id=\'thumbnail\' onerror=\'this.onerror=null;this.src=\\"<?php Common::image_error()?>\\"\'></td>' +
                '<td>' + details[i].sku + '</td>' +
                '<td>' + details[i].product_name + '</td>' +
                '<td>' + details[i].size + '</td>' +
                '<td>' + details[i].color + '</td>' +
                '<td>' + details[i].quantity + '</td>' +
                '<td class="right">' + details[i].price + '<sup>đ</sup></td>' +
                '<td class="right">' + details[i].reduce + '<sup>đ</sup></td>' +
                '<td class="right">' + details[i].intoMoney + '<sup>đ</sup></td>' +
                '<td class="right">' + formatNumber(detail_profit) + '<sup>đ</sup></td>';
            if (order_type === EXCHANGE) {
                if (type === '1') {
                    table += '<td class="right"><span class="badge badge-info">Đã mua</span></td>';
                } else if (type === '2') {
                    table += '<td class="right"><span class="badge badge-success">Đổi</span></td>';
                } else if (type === '3') {
                    table += '<td class="right"><span class="badge badge-danger">Trả lại</span></td>';
                } else {
                    table += '<td class="right"><span class="badge badge-secondary">Mua mới</span></td>';
                }
            } else {
                // table += '<td class="center">' +
                //           '<span class="badge badge-info hidden">Đã mua</span>' +
                //           '<i class="fa fa-sync text-info c-pointer" title="Đổi sản phẩm" onclick="exchange_product(this)" "></i>' +
                //           '<input type="text" class="form-control hidden" placeholder="Nhập mã sản phẩm" onchange="find_product_exchange(this)">' +
                //           '<i class="fa fa-times-circle text-danger ml-1 c-pointer hidden" title="Huỷ đổi" onclick="cancel_exchange_product(this)" "></i>' +
                //         '</td>';
            }
            table += '</tr>';
        }
        table += '</table>';
        table += '</div>';
        table += '</div>';
        table += '</div>';

        let voucher_value = 0;
        // let order_type = data.type;
        let d = '<div class="card">' +
            '<div class="card-header bg-info"><h5>Thông tin khách hàng</h5></div>' +
            '<div class="card-body">' +
            '<div class="row">';
        if (data.customer_id && Number(data.customer_id) > 0) {
            // online
            d += '<div class="col-2 col-sm-2 col-md-2"><small>Mã khách hàng</small> <h5><a href="<?php  Common::getPath() ?>src/view/customer/?customer_id=' + data.customer_id + '" target="_blank">' + data.customer_id + '</a></h5></div>' +
                '<div class="col-4 col-sm-4 col-md-4">' +
                '<small>Tên khách hàng</small>' +
                '<div> <h5 class="d-inline-block mr-2">' + data.customer_name + '</h5>' +
                // '<a href="javascript:void(0)" class="d-inline-block text-warning" id="show_history" onclick="show_history(' + data.customer_id + ',\'' + data.customer_name + '\',\'' + data.phone + '\')"><i class="fas fa-history"></i></a>' +
                '</div>' +
                '</div>' +
                '<div class="col-2 col-sm-2 col-md-2"><small>Số điện thoại</small> <h5>' + data.phone + '</h5></div>';
            if (data.address) {
                d += '<div class="row col-12"><small>Địa chỉ</small> <h5 class="col-12 pl-0">' + data.address + '</h5></div>';
            }
        } else {
            d += '<div class="col-4 col-sm-4 col-md-4"><small>Khách hàng</small> <h5>Khách lẻ</h5></div>';
        }
        if (data.voucher_code != null && data.voucher_code !== "") {
            voucher_value = Number((intoMoney * 10) / 100);
            d += '<div class="col-2 col-sm-2 col-md-2"><small>Mã giảm giá</small> <h5>' + data.voucher_code + ' <small>(-10%)(' + formatNumber(voucher_value) + ' đ)</small></h5></div>';
        }
        if (order_refer && Number(order_refer) !== 0) {
            d += '<div class="col-2 col-sm-2 col-md-2"><small>Mã đơn đổi</small> <h5><a href="<?php  Common::getPath() ?>src/view/orders/?order_id=' + order_refer + '" target="_blank">' + order_refer + '</h5></a></div>';
        }
        d += '</div>';
        let discount = Number(replaceComma(data.discount));
        profit = profit - discount - voucher_value;

        d += '<div class="row">' +
            '<div class="col-2 col-sm-2 col-md-2"><small>Tổng đơn hàng</small> <h5>' + data.total_amount + '<sup>đ</sup></h5></div>' +
            '<div class="col-2 col-sm-2 col-md-2"><small>CK trên tổng đơn</small> <h5>' + data.discount + '<sup>đ</sup></h5></div>';

        let total_checkout = Number(replaceComma(data.total_checkout));

        if (data.customer_id && Number(data.customer_id) > 0) {
            profit -= Number(replaceComma(data.wallet));
            d += '<div class="col-2 col-sm-2 col-md-2"><small>Tiền trong Ví</small> <h5>' + data.wallet + '<sup>đ</sup></h5></div>';
        }
        d += '<div class="col-2 col-sm-2 col-md-2"><small>Tổng giảm trừ</small> <h5>' + data.total_reduce + '<sup>đ</sup></h5></div>';

        if (order_type === ONLINE) {
            let shipping_fee = replaceComma(data.shipping_fee);
            if (shipping_fee && shipping_fee > 0) {
                d += '<div class="col-2 col-sm-2 col-md-2"><small>Phí ship Shop trả</small> <h5>' + formatNumber(shipping_fee) + '<sup>đ</sup></h5></div>';
                profit -= Number(shipping_fee);
            }
            let total_amount = Number(replaceComma(data.total_amount));
            let shipping = Number(replaceComma(data.shipping));
            if (shipping && shipping > 0) {
                d += '<div class="col-2 col-sm-2 col-md-2"><small>Phí ship KH trả</small> <h5>' + formatNumber(shipping) + '<sup>đ</sup></h5></div>';
                profit += shipping;
                total_amount += shipping;
            } else {
                d += '<div class="col-2 col-sm-2 col-md-2"><small>Phí ship KH trả</small> <h5>Miễn Ship</h5></div>';
            }
            total_amount -= Number(replaceComma(data.total_reduce));
            d += '<div class="col-2 col-sm-2 col-md-2"><small>Tổng tiền KH thanh toán</small> <h5>' + formatNumber(total_amount) + '<sup>đ</sup></h5></div>';
        }

        if (payment_exchange_type === '2') {
            if (total_checkout.indexOf("-") < -1) {
                total_checkout = '-' + total_checkout;
            }
        }

        d += '<div class="col-2 col-sm-2 col-md-2"><small>Tổng tiền Shop nhận</small> <h5>' + formatNumber(total_checkout) + '<sup>đ</sup></h5></div>' +
            '<div class="col-2 col-sm-2 col-md-2" style="display: block;"><small>-</small> <h5>' + formatNumber(profit) + '<sup>đ</sup></h5></div>' +
            '</div>' +
            '</div>' +
            '</div>';

        let html = "<div class='col-md-8 d-inline-block'>"+d + table+"</div>";
        html += "<div class='col-md-4 d-inline-block' style='vertical-align: top'>" +
            "<div class='card'>" +
            "<div class=\"card-header bg-info\"><h5>Lịch sử đơn hàng</h5></div>";
        html += "<div class='card-body' style=\"max-height: 450px;overflow-y: scroll;\">";
        html += `<div class="row">
                  <div class="col-md-12 col-lg-12">
                    <div id="tracking-pre"></div>
                      <div id="tracking">
                        <div class="tracking-list">`;
            if(order_logs.length > 0) {
                for(let i=0; i<order_logs.length; i++) {
                    html += `<div class="tracking-item">
                              <div class="tracking-icon status-intransit">
                              <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                              <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                              </svg>
                              <!-- <i class="fas fa-circle"></i> -->
                              </div>
                              <div class="tracking-date">`+order_logs[i].created_date+`<span>`+order_logs[i].created_time+`</span></div>
                              <div class="tracking-content">`+order_logs[i].action+`</div>
                            </div>`;
                }
            } else {
                html += "<span class='center form-control'>Chưa có thông tin</span>";
            }
        html +=         `</div>
                      </div>
                    </div>
                  </div>
                </div>`;
        html += "</div>";
        html += "</div>";
        html += "</div>";
        return html;
    }



    function updatedQty(e, type, sku) {
        let checked = $(e).prop('checked');
        let status = 0;
        if (checked) {
            status = 1;
        }
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "updated_qty",
                sku: sku,
                type: type,
                status: status
            },
            success: function (res) {
                // console.log(res);
                toastr.success('Cập nhật thành công!');
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                })
            }
        });
    }

    function format_customer_name(data) {
        if (data.customer_name === "" || data.customer_name == null) {
            return "Khách lẻ";
        } else {
            return "<a href='javascript:void(0)'>" + data.customer_name + "</a>";
        }
    }

    function format_action(data) {
        let order_type = data.order_type;
        let order_id = data.order_id;
        let bill = data.bill_of_lading_no;
        let content = '';
        // online
        // if (data.type == 1) {
        let status = data.status;
        if(status == DELIVERED) {
            content += '<a href="<?php Common::getPath() ?>src/view/exchange/online.php?oid=' + order_id + '" target="_blank" class="exchange mr-1 text-success" title="Đổi hàng"><i class="fas fa-reply"></i></a>';
        }
        if(bill){
          // content += '<a href="javascript:void(0);" class="return_order mr-1 text-info" title="In hoá đơn"><i class="fas fa-sync"></i></a>';
        content += '<a href="javascript:void(0);" class="print_receipt mr-1 text-info" title="In hoá đơn"><i class="fa fa-print"></i></a>';
        }
        // }
        if (order_type !== 2) {
            content += '<a href="javascript:void(0);" class="edit_order mr-1 text-primary" title="Sửa đơn hàng"><i class="fa fa-edit"></i></a>';
        }
        content += '<a href="javascript:void(0);" class="delete_order mr-1 text-danger" title="Xoá đơn hàng"><i class="fa fa-trash"></i></a>';
        return content;
    }

    function format_description(data) {
        let description = data.description;
        let order_id = data.order_id;
        if(!description) {
            return '<textarea type="text" class="form-control hidden" placeholder="Nhập ghi chú" id="content_description"></textarea>' +
                '<i class="fa fa-save c-pointer text-primary save-description hidden m-2" style="font-size: 20px" onclick="save_description(this, '+order_id+')"></i>' +
                '<i class="fa fa-times-circle c-pointer text-danger cancel-description hidden m-2" style="font-size: 20px" onclick="cancel_description(this)"></i>' +
                '<i class="fa fa-edit c-pointer text-info edit-description"></i>';
        }
        return description;
    }

    function save_description(e, order_id) {
        let content_description = $(e).prev().val();
        console.log(content_description);
        if(!content_description) {
            $(e).prev().addClass('is-invalid').focus();
            toast_error_message('Bạn chưa nhập ghi chú');
            return false;
        } else {
            $(e).prev().removeClass('is-invalid');
        }
        Swal.fire({
            title: 'Bạn có chắc chắn muốn cập nhật?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
                    type: "POST",
                    dataType: "json",
                    traditional: true,
                    data: {
                        method: "update_description",
                        order_id: order_id,
                        content_description: content_description
                    },
                    success: function (res) {
                        $(e).closest('td').html(content_description);
                        toastr.success('Cập nhật ghi chú thành công.');
                    },
                    error: function (data, errorThrown) {
                        console.log(data.responseText);
                        console.log(errorThrown);
                        Swal.fire({
                            type: 'error',
                            title: 'Đã xảy ra lỗi',
                            text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                        });
                        hide_loading();
                    }
                });
            }
        });
    }

    function cancel_description(e) {
        $("#content_description").val('');
        $(e).addClass('hidden');
        $(e).prev().prev().addClass('hidden');
        $(e).prev().addClass('hidden');
        $(e).next().removeClass('hidden');
    }

    function format_bill_of_lading_no(data) {
        let bill_of_lading_no = data.bill_of_lading_no;
        if(!bill_of_lading_no) {
            return '<i class="fa fa-edit c-pointer text-info edit-bill"></i>';
        }
        let shipping_unit = data.shipping_unit;
        if(shipping_unit === 'VTP') {
            return '<a href="https://viettelpost.vn/thong-tin-don-hang?peopleTracking=sender&orderNumber='+bill_of_lading_no.trim()+'" target="_blank">'+bill_of_lading_no+'</a><br>'+shipping_unit;
        }
        return bill_of_lading_no+'<br>'+shipping_unit;
    }

    function format_total_amount(data) {
        let total_amount = data.total_amount;
        return total_amount + "<sup>đ</sup>";
    }

    function format_order_date(data) {
        let order_id = data.order_id;
        let order_date = data.order_date;
        let delivery_date = data.delivery_date;

        if(delivery_date) {
            order_date += "<br>" +
                          "<div>" +
                            "<div class='d-inline-block row'>" +
                              "<span class=\"badge badge-warning\">Ngày hẹn giao hàng</span>" +
                              "<i class=\"fa fa-times-circle ml-1 mt-1 text-danger c-pointer\" title=\"Xoá\" onclick='delete_delivery_date("+order_id+", this)'></i>" +
                            "</div>" +
                            "<div class='d-inline-block row'>" +
                              "<span>"+delivery_date+"</span>" +
                              '<input type="text" class="form-control delivery-date2 p-2 mt-2 hidden" placeholder="Chọn ngày giao">' +
                              "<i class=\"fa fa-edit ml-1 text-info c-pointer edit-delivery-date\" onclick='edit_delivery_date(this)'></i>"+
                              "<i class=\"fa fa-save mt-1 mr-2 text-primary c-pointer save-delivery-date hidden\" onclick='save_delivery_date("+order_id+", this)' style='font-size: 20px' title='Lưu'></i>"+
                              "<i class=\"fa fa-times-circle mt-1 text-danger c-pointer cancel-delivery-date hidden\" onclick='cancel_delivery_date(this)' style='font-size: 20px' title='Huỷ'></i>" +
                            "</div>" +
                          "</div>";

                $('.delivery-date2').datepicker({
                    format: 'yyyy-mm-dd',
                    language: 'vi',
                    todayBtn: true,
                    todayHighlight: true,
                    autoclose: true,
                    startDate: new Date()
                });

        }
        return order_date;
    }

    function edit_delivery_date(e) {
        $(e).addClass('hidden');
        $(e).next().removeClass('hidden');
        $(e).next().next().removeClass('hidden');
        $(e).prev('.delivery-date2').removeClass('hidden');
    }
    
    function cancel_delivery_date(e) {
        $(e).addClass('hidden');
        $(e).prev('.save-delivery-date').addClass('hidden');
        $(e).prev().prev('.edit-delivery-date').removeClass('hidden');
        $(e).prev().prev().prev('.delivery-date2').val('').removeClass('is-invalid').addClass('hidden');
    }

    function save_delivery_date(order_id, e) {
        let delivery_date = $(e).prev().prev().val();
        console.log(delivery_date);
        if(!delivery_date) {
            $(e).prev().prev().addClass('is-invalid').focus();
            toast_error_message('Ngày hẹn giao hàng không được để trống');
            return false;
        } else {
            $(e).prev().prev().removeClass('is-invalid');
        }
        Swal.fire({
            title: 'Bạn có chắc chắn muốn cập nhật ngày giao hàng?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
                    type: "POST",
                    dataType: "json",
                    traditional: true,
                    data: {
                        method: "update_delivery_date",
                        order_id: order_id,
                        delivery_date: delivery_date
                    },
                    success: function (res) {
                        // table.ajax.reload();
                        let new_delivery_date = delivery_date.split("-")[2]+"/"+delivery_date.split("-")[1]+"/"+delivery_date.split("-")[0];
                        $(e).prev().prev().prev().text(new_delivery_date);
                        $(e).next().click();
                        toastr.success('Cập nhật ngày giao hàng thành công.');
                    },
                    error: function (data, errorThrown) {
                        console.log(data.responseText);
                        console.log(errorThrown);
                        Swal.fire({
                            type: 'error',
                            title: 'Đã xảy ra lỗi',
                            text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                        });
                        hide_loading();
                    }
                });
            }
        });
    }

    function delete_delivery_date(order_id, e) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xoá ngày giao hàng?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
                    type: "POST",
                    dataType: "json",
                    traditional: true,
                    data: {
                        method: "update_delivery_date",
                        order_id: order_id,
                        delivery_date: ''
                    },
                    success: function (res) {
                        $(e).closest('div').remove();
                        toastr.success('Xoá ngày giao hàng thành công.');
                    },
                    error: function (data, errorThrown) {
                        console.log(data.responseText);
                        console.log(errorThrown);
                        Swal.fire({
                            type: 'error',
                            title: 'Đã xảy ra lỗi',
                            text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                        });
                        hide_loading();
                    }
                });
            }
        });
    }
    
    function format_total_checkout(data) {
        let total_checkout = data.total_checkout;
        let payment_exchange_type = data.payment_exchange_type;
        switch (payment_exchange_type) {
            case '1':
                return total_checkout + "<sup>đ</sup>";
            case '2':
                if (total_checkout.indexOf("-") > -1) {
                    return total_checkout + "<sup>đ</sup>";
                } else {
                    return '-' + total_checkout + "<sup>đ</sup>";
                }
            default:
                return total_checkout + "<sup>đ</sup>";
        }
    }

    function format_type(data) {
        let type = data.order_type;
        switch (type) {
            case '0' :
                return '<span class="badge badge-warning">Shop</span>';
            case '1':
                return '<span class="badge badge-success">Online</span>';
            case '2':
                return '<span class="badge badge-danger">Đổi hàng</span>';
            default:
                return '';
        }
    }

    function format_source(data) {
        let source = Number(data.source);
        let utm_source = data.utm_source;
        switch (source) {
            case 1 :
                if(utm_source) {
                    return `<span class="badge badge-success">Website</span>
                            <span class="badge badge-secondary">${utm_source}</span>`;
                } else {
                    return '<span class="badge badge-success">Website</span>';
                }
            case 2:
                if(utm_source) {
                    return `<span class="badge badge-success">Website</span>
                            <span class="badge badge-secondary">${utm_source}</span>`;
                } else {
                    return '<span class="badge badge-primary">Facebook</span>';
                }
            case 3:
                return '<span class="badge badge-danger">Shopee</span>';
            default:
                return '<span class="badge badge-warning">Cửa hàng</span>';
        }
    }

    function format_payment(data) {
        let type = data.payment_type;
        switch (type) {
            case '0' :
                return '<span class="badge badge-info">Tiền mặt</span>';
            case '1':
                return '<span class="badge badge-success">Chuyển khoản</span>';
            case '2':
                return '<span class="badge badge-warning">Nợ</span>';
            case '3':
                return '<span class="badge badge-primary">COD</span>';
            default:
                return '';
        }
    }
    function format_print_status(data) {
        let is_print = data.is_print;
        let bill = data.bill_of_lading_no;
        if(bill) {
            if(is_print == 1) {
                return '<span class="badge badge-success">Đã in</span>';
            } else {
                return '<span class="badge badge-danger">Chưa in</span>';
            }
        }
        return '';
    }

    function format_status(data) {
        if (data.status === null) {
            return;
        }
        let txt_status = '';
        let status = Number(data.status);
        switch (status) {
            case PENDING :
                txt_status = '<div class="text-status"><span class="badge badge-warning">Chưa xử lý</span> <i class="fa fa-edit text-warning c-pointer edit-status"></i></div>';
                break;
            case PACKED:
                txt_status = '<div class="text-status"><span class="badge badge-info">Đã gói hàng</span> <i class="fa fa-edit text-info c-pointer edit-status"></i></div>';
                break;
            case DELIVERED:
                txt_status = '<div class="text-status"><span class="badge badge-primary">Đã giao</span> <i class="fa fa-edit text-primary c-pointer edit-status"></i></div>';
                break;
            case SUCCESS:
                txt_status = '<div class="text-status"><span class="badge badge-success">Hoàn thành</span> <i class="fa fa-edit text-success c-pointer edit-status"></i></div>';
                break;
            case EXCHANGE:
                txt_status = '<div class="text-status"><span class="badge badge-danger">Đã đổi size</span> <i class="fa fa-edit text-danger c-pointer edit-status"></i></div>';
                break;
            case RETURN:
                txt_status = '<div class="text-status"><span class="badge badge-secondary">Chuyển hoàn</span> <i class="fa fa-edit text-secondary c-pointer edit-status"></i></div>';
                break;
            case CANCEL:
                txt_status = '<div class="text-status"><span class="badge badge-danger">Đã huỷ</span> <i class="fa fa-edit text-danger c-pointer edit-status"></i></div>';
                break;
            case APPOINTMENT:
                txt_status = '<div class="text-status"><span class="badge badge-warning">Giao hàng sau</span> <i class="fa fa-edit text-warning c-pointer edit-status"></i></div>';
                break;
            case WAITING:
                txt_status = '<div class="text-status"><span class="badge badge-secondary">Đợi hàng về</span> <i class="fa fa-edit text-secondary c-pointer edit-status"></i></div>';
                break;
            case WAITING_RETURN:
                txt_status = '<div class="text-status"><span class="badge badge-danger">Chờ duyệt hoàn</span> <i class="fa fa-edit text-danger c-pointer edit-status"></i></div>';
                break;
            case APPROVED_RETURN:
                txt_status = '<div class="text-status"><span class="badge badge-danger">Đã duyệt hoàn</span> <i class="fa fa-edit text-danger c-pointer edit-status"></i></div>';
                break;
            case WAITING_EXCHANGE:
                txt_status = '<div class="text-status"><span class="badge badge-danger">Chờ đổi size</span> <i class="fa fa-edit text-danger c-pointer edit-status"></i></div>';
                break;
            case EXCHANGED:
                txt_status = '<div class="text-status"><span class="badge badge-secondary">Đang đổi size</span> <i class="fa fa-edit text-secondary c-pointer edit-status"></i></div>';
                break;
            case CREATED_BILL:
                txt_status = '<div class="text-status"><span class="badge badge-info">Đã tạo đơn</span> <i class="fa fa-edit text-info c-pointer edit-status"></i></div>';
                break;
            default:
                break;
        }

        return  txt_status;
    }

    function format_checkbox(data) {
        // let status = data.status;
        // switch (status) {
        //     case '0' :
        //         return '<input type="checkbox" class="checked_order">';
        //     case '1':
        //         return '<input type="checkbox" class="checked_order">';
        //     default:
        //         return '<input type="checkbox" disabled>';
        // }
        return '<input type="checkbox" class="checked_order">';
    }

</script>
</body>
</html>
