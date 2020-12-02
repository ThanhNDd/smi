<?php require_once("../../common/common.php");
Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="<?php Common::getPath() ?>dist/img/icon.png"/>
    <title>Quản lý đơn hàng</title>
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
    </style>
</head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content">
    <div class="row pt-2">
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header border-transparent pb-0 pl-0 pr-0">
                    <div class="form-group col-md-12 mb-0">
                        <div class="input-group col-md-3 float-left mt-1">
                            <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                            </div>
                            <input type="text" class="form-control float-left" id="reservation">
                        </div>
                        <div class="col-md-1 float-left d-inline-block mt-1">
                            <input type="text" class="form-control col-md-12" placeholder="Mã ĐH" id="search_order_id">
                        </div>
                        <div class="col-md-1 float-left d-inline-block mt-1">
                            <input type="text" class="form-control col-md-12" placeholder="Mã KH" id="search_customer_id">
                        </div>
                        <div class="col-md-2 float-left d-inline-block mt-1">
                            <input type="text" class="form-control col-md-12" placeholder="Số điện thoại" id="search_phone">
                        </div>
                        <div class="col-md-2 float-left d-inline-block mt-1">
                            <input type="text" class="form-control col-md-12" placeholder="Mã sản phẩm" id="search_sku">
                        </div>
                        <div class="col-md-1 float-right mt-1">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info order-create float-right">Tạo mới</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="w100">ID</th>
                                <!-- <th>Khách hàng</th> -->
                                <!-- <th>Số điện thoại</th>
                                <th>Địa chỉ</th> -->
                                <!--  <th class="right">Phí ship</th> -->
                                <!-- <th class="right">Chiết khấu</th> -->
                                <th class="right">Tổng tiền</th>
                                <th class="center">Ngày mua hàng</th>
                                <th class="left">Loại đơn</th>
                                <th class="left">Thanh toán</th>
                                <th class="left">Nguồn</th>
                                <th class="left">Hành động</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-12 col-sm-12 col-md-12">
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
                    <div class="col-12 col-sm-12 col-md-12">
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
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-globe"></i></span>
                            <div class="info-box-content col-12 row">
                                <div class="col-md-6 col-sm-12 text-left">
                                    <span class="info-box-text">Online</span>
                                    <span class="info-box-number">
                                        <h5 class="total_online">0<sup>đ</sup></h5>
                                     </span>
                                    <span class="info-box-text" id="percent_online"></span>
                                </div>
                                <div class="col-md-6 col-sm-12 text-left pl-0">
                                    <h1 class="text-danger no-margin d-inline-block col-md-12 pl-0"><span class="count_online col-md-6 pl-0 pr-0">0</span> <small style="font-size: 30%;color: #676a6c;">Đơn</small></h1>
                                    <h5 class="text-danger text-left col-md-12 pl-0"><span class="total_product_online text-left col-md-6" style="color: #676a6c;">0</span> <small style="font-size: 60%;color: #676a6c;">Sản phẩm</small></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-12 col-sm-12 col-md-12">
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
                                <div class="col-md-6 col-sm-12 text-left pl-0">
                                    <h1 class="text-danger no-margin d-inline-block col-md-12 pl-0"><span class="count_exchange col-md-6 pl-0 pr-0">0</span> <small style="font-size: 30%;color: #676a6c;">Đơn</small></h1>
                                    <h5 class="text-danger text-left col-md-12 pl-0"><span class="total_product_exchange text-left col-md-6" style="color: #676a6c;">0</span> <small style="font-size: 60%;color: #676a6c;">Sản phẩm</small></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="col-12 col-sm-12 col-md-12">
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
                    <div class="col-12 col-sm-12 col-md-12">
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
                    <div class="col-12 col-sm-12 col-md-12" style="display: block;">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-wallet"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text" id="percent_profit"></span>
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
</section>
<div class="iframeArea" style="visibility: hidden"></div>
<!-- /.content -->
<?php include 'createOrders.php'; ?>
<input type="hidden" id="startDate">
<input type="hidden" id="endDate">
</div>
<?php require_once '../wallet/showHistory.php'; ?>
<?php require_once ('../../common/footer.php'); ?>
<script>
    let table;
    $(document).ready(function () {
        // set title for page
        set_title("Danh sách đơn hàng");

        let currentDate = new Date();
        let day = currentDate.getDate();
        let month = currentDate.getMonth() + 1;
        let year = currentDate.getFullYear();
        let start_date = year + "-" + month + "-" + day;
        let end_date = year + "-" + month + "-" + day;
        $("#startDate").val(start_date);
        $("#endDate").val(end_date);
        generate_datatable('date');
        get_info_total_checkout('date');

        //Date range picker
        $('#reservation').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            }
        }, function (start, end, label) {
            $("#search_phone").val("");
            $("#search_customer_id").val("");
            $("#search_order_id").val("");
            $("#search_sku").val("");
            let start_date = start.format('YYYY-MM-DD');
            let end_date = end.format('YYYY-MM-DD');
            $("#startDate").val(start_date);
            $("#endDate").val(end_date);
            generate_datatable('date');
            get_info_total_checkout('date');
        });

        let order_id = "<?php echo (isset($_GET['order_id']) ? $_GET['order_id'] : '') ?>";
        if(order_id) {
            $("#search_order_id").val(order_id);
            setTimeout(function () {
                $('#search_order_id').trigger(
                    jQuery.Event( 'keydown', { keyCode: 13, which: 13 } )
                );
            },100);
        }

        $( "#search_order_id" ).on( "keydown", function( event ) {
            let key = event.which;
            // console.log(key);
            if(key === 13) {
                $("#search_phone").val("");
                $("#search_customer_id").val("");
                $("#search_sku").val("");
                let order_id = $(this).val();
                if(order_id) {
                    generate_datatable('order_id');
                    get_info_total_checkout('order_id');
                } else {
                    generate_datatable('date');
                    get_info_total_checkout('date');
                }
            }
        });

        let customer_phone = "<?php echo (isset($_GET['customer_phone']) ? $_GET['customer_phone'] : '') ?>";
        if(customer_phone) {
            $("#search_phone").val(customer_phone);
            setTimeout(function () {
                $('#search_phone').trigger(
                    jQuery.Event( 'keydown', { keyCode: 13, which: 13 } )
                );
            },100);
        }
        $( "#search_phone" ).on( "keydown", function( event ) {
            let key = event.which;
            if(key === 13) {
                $("#search_order_id").val("");
                $("#search_customer_id").val("");
                $("#search_sku").val("");
                let phone = $(this).val();
                if(phone) {
                    generate_datatable('phone');
                    get_info_total_checkout('phone');
                } else {
                    generate_datatable('date');
                    get_info_total_checkout('date');
                }
            }
        });

        $( "#search_sku" ).on( "keydown", function( event ) {
            let key = event.which;
            if(key === 13) {
                $("#search_phone").val("");
                $("#search_order_id").val("");
                $("#search_customer_id").val("");
                let sku = $(this).val();
                if(sku) {
                    generate_datatable('sku');
                    get_info_total_checkout('sku');
                } else {
                    generate_datatable('date');
                    get_info_total_checkout('date');
                }
            }
        });

        let customer_id = "<?php echo (isset($_GET['customer_id']) ? $_GET['customer_id'] : '') ?>";
        if(customer_id) {
            $("#search_customer_id").val(customer_id);
            setTimeout(function () {
                $('#search_customer_id').trigger(
                    jQuery.Event( 'keydown', { keyCode: 13, which: 13 } )
                );
            },100);
        }
        $( "#search_customer_id" ).on( "keydown", function( event ) {
            let key = event.which;
            if(key === 13) {
                $("#search_order_id").val("");
                $("#search_phone").val("");
                let customer_id = $(this).val();
                if(customer_id) {
                    generate_datatable('customer_id');
                    get_info_total_checkout('customer_id');
                } else {
                    generate_datatable('date');
                    get_info_total_checkout('date');
                }
            }
        });
    });

    function get_data_search(type) {
        if(type === 'date') {
            return {
                method: 'find_all',
                start_date:$("#startDate").val(),
                end_date: $("#endDate").val()
            }
        } else if(type === 'order_id') {
            return {
                method: 'find_all',
                order_id: $("#search_order_id").val()
            }
        } else if(type === 'phone') {
            return {
                method: 'find_all',
                phone: $("#search_phone").val()
            }
        } else if(type === 'customer_id') {
            return {
                method: 'find_all',
                customer_id: $("#search_customer_id").val()
            }
        } else if(type === 'sku') {
            return {
                method: 'find_all',
                sku: $("#search_sku").val()
            }
        }
        return '';
    }

    function get_data_search_info_total(type) {
        if(type === 'date') {
            return {
                method: 'get_info_total_checkout',
                start_date:$("#startDate").val(),
                end_date: $("#endDate").val()
            }
        } else if(type === 'order_id') {
            return {
                method: 'get_info_total_checkout',
                order_id: $("#search_order_id").val()
            }
        } else if(type === 'phone') {
            return {
                method: 'get_info_total_checkout',
                phone: $("#search_phone").val()
            }
        } else if(type === 'customer_id') {
            return {
                method: 'get_info_total_checkout',
                customer_id: $("#search_customer_id").val()
            }
        } else if(type === 'sku') {
            return {
                method: 'get_info_total_checkout',
                sku: $("#search_sku").val()
            }
        }
        return '';
    }

    function get_data_param_detail(type, order_id) {
        if(type === 'date') {
            return {
                method: 'find_detail',
                order_id: order_id,
                start_date:$("#startDate").val(),
                end_date: $("#endDate").val()
            }
        } else if(type === 'order_id') {
            return {
                method: 'find_detail',
                order_id: $("#search_order_id").val()
            }
        } else if(type === 'phone') {
            return {
                method: 'find_detail',
                phone: $("#search_phone").val()
            }
        } else if(type === 'customer_id') {
            return {
                method: 'find_detail',
                customer_id: $("#search_customer_id").val()
            }
        } else if(type === 'sku') {
            return {
                method: 'find_detail',
                sku: $("#search_sku").val()
            }
        }
        return '';
    }
    function get_info_total_checkout(type) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
            type: "GET",
            dataType: "json",
            data: get_data_search_info_total(type),
            success: function (res) {
                $(".total_money").html((res.total_checkout ? res.total_checkout : 0) + "<sup>đ</sup>");
                $(".total_orders").html(res.count_total ? res.count_total : 0);
                $(".total_products").html(res.total_product ? res.total_product : 0);
                $(".total_on_shop").html((res.total_on_shop ? res.total_on_shop : 0) + "<sup>đ</sup>");
                $(".count_on_shop").html(res.count_on_shop ? res.count_on_shop : 0);
                $(".total_product_on_shop").html(res.total_product_on_shop ? res.total_product_on_shop : 0);
                $(".total_online").html((res.total_online ? res.total_online : 0) + "<sup>đ</sup>");
                $(".count_online").html(res.count_online ? res.count_online : 0);
                $(".total_product_online").html(res.total_product_online ? res.total_product_online : 0);
                $(".total_exchange").html((res.total_exchange ? res.total_exchange : 0) + "<sup>đ</sup>");
                $(".count_exchange").html(res.count_exchange ? res.count_exchange : 0);
                $(".total_product_exchange").html(res.total_product_exchange ? res.total_product_exchange : 0);
                $(".total_cash").html((res.total_cash ? res.total_cash : 0) + "<sup>đ</sup>");
                $(".total_transfer").html((res.total_transfer ? res.total_transfer : 0) + "<sup>đ</sup>");
                $(".total_profit").html((res.total_profit ? res.total_profit : 0) + "<sup>đ</sup>");

                $("#percent_profit").html("");
                $("#percent_onshop").html("");
                $("#percent_online").html("");
                $("#percent_exchange").html("");

                let total_checkout = Number(replaceComma(res.total_checkout));
                let total_profit = Number(replaceComma(res.total_profit));
                let percent = ((total_profit/total_checkout) * 100).toFixed(2);
                if(!isNaN(percent)) {
                    $("#percent_profit").html(percent+"<sup>%</sup>");
                }
                let total_onshop = Number(replaceComma(res.total_on_shop));
                let percent_onshop = ((total_onshop/total_checkout) * 100).toFixed(2);
                if(!isNaN(percent_onshop)) {
                    $("#percent_onshop").html(percent_onshop+"<sup>%</sup>");
                }
                let total_online = Number(replaceComma(res.total_online));
                let percent_online = ((total_online/total_checkout) * 100).toFixed(2);
                if(!isNaN(percent_online)) {
                    $("#percent_online").html(percent_online+"<sup>%</sup>");
                }
                let total_exchange = Number(replaceComma(res.total_exchange));
                let percent_exchange = ((total_exchange/total_checkout) * 100).toFixed(2);
                if(!isNaN(percent_exchange)) {
                    $("#percent_exchange").html(percent_exchange+"<sup>%</sup>");
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
    function generate_datatable(type) {
        if ($.fn.dataTable.isDataTable('#example')) {
            table.destroy();
            table.clear();
            // if(table.ajax) {
                table.ajax.reload();
            // }
        }
        table = $('#example').DataTable({
            'ajax': {
                "type": "GET",
                "url": "<?php Common::getPath() ?>src/controller/orders/OrderController.php",
                "data": get_data_search(type)
            },
            "dom": '<"top"flp<"clear">>rt<"bottom"p<"clear">>',
            searching: false,
            ordering: false,
            scrollY: '50vh',
            scrollCollapse: true,
            "language": {
                "emptyTable": "Không có dữ liệu",
                "oPaginate": {
                    "sFirst":    	"&lsaquo;",
                    "sPrevious": 	"&laquo;",
                    "sNext":     	"&raquo;",
                    "sLast":     	"&rsaquo;"
                },
            },
            select: "single",
            "columns": [
                {
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": '',
                    "render": function () {
                        return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                    },
                    width: "5px"
                },
                {
                    "data": "order_id",
                    width: "30px",
                },
                {
                    "data": format_total_checkout,
                    width: "50px",
                    class: 'right'
                },
                {
                    "data": "order_date",
                    width: "70px",
                    class: 'center'
                },
                {
                    "data": format_type,
                    width: "30px"
                },
                {
                    "data": format_payment,
                    width: "30px"
                },
                {
                    "data": format_source,
                    width: "30px"
                },
                {
                    "data": format_action,
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
                        let data = res.data;
                        // let details = res[0].details;
                        if (data.length > 0) {
                            row.child(format_order_detail(data[0], row.data())).show();
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


        $('#example tbody').on('click', '.print_receipt', function () {
            show_loading();
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let order_id = row.data().order_id;
            let type = row.data().order_type;
            // console.log(order_id);
            // console.log(type);
            print_receipt(order_id, type);
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
                    // console.log(JSON.stringify(res));
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


    }

    function print_receipt(order_id, type) {
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
                    $(".iframeArea").html('<iframe src="<?php Common::getPath() ?>src/controller/orders/pdf/receipt.html" id="receiptContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                    //$(".iframeArea").html('<iframe src="<?php //Common::getPath() ?>//src/controller/orders/pdf/'+filename+'" id="receiptContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                    setTimeout(function () {
                        let objFra = document.getElementById('receiptContent');
                        objFra.contentWindow.focus();
                        objFra.contentWindow.print();
                    },500);
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
                $("#customer_id").val(value[0].customer_id);
                $("#customer_name").val(value[0].customerName);
                $("#customer_phone").typeahead('val', value[0].phone);
                // online
                if (order_type == 1) {
                    $("#bill_of_lading_no").val(value[0].bill_of_lading_no);
                    $("#shipping_fee").val(value[0].shipping_fee);
                    $("#shipping").val(value[0].shipping);
                    $("#bill_of_lading_no").prop("disabled", false);
                    $("#shipping_fee").prop("disabled", false);
                    $(".select-shipping-unit").prop("disabled", false);
                    $("#shipping").prop("disabled", false);
                } else if (order_type == 0) {
                    generate_select2_city();
                    // on shop
                    $("#bill_of_lading_no").prop("disabled", true);
                    $("#shipping_fee").prop("disabled", true);
                    $(".select-shipping-unit").prop("disabled", true);
                    $("#shipping").prop("disabled", true);
                    $("#order_status").val(3);//complete
                }
                $("#payment_type").val(value[0].payment_type);
                $("#payment").val(value[0].customer_payment);
                $("#total_amount").text(value[0].total_amount);
                $("#discount").val(value[0].discount);
                $("#total_checkout").text(value[0].total_checkout);
                $("#repay").text(value[0].repay);
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

    function format_order_detail(data, row_data) {
        // console.log(data);
        const SHOP = '0';
        const ONLINE = '1';
        const EXCHANGE = '2';

        let payment_exchange_type = row_data.payment_exchange_type;
        let order_refer = row_data.order_refer;
        let details = data.details;
        let order_type = data.order_type;
        let table = '<div class="card-body">';
        table += '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        table += '<thead>' +
            '<tr>' +
            '<th>Mã</th>' +
            '<th>Tên</th>' +
            '<th>Size</th>' +
            '<th>Màu</th>' +
            '<th>Số lượng</th>' +
            '<th class="right">Giá</th>' +
            '<th class="right">Giảm trừ</th>' +
            '<th class="right">Thành tiền</th>' +
            '<th class="right"></th>';
            // '<th class="center">Shopee</th>' +
            // '<th class="center">Lazada</th>' +
        if(order_type === EXCHANGE) {
            table += '<th class="right">Loại sản phẩm</th>';
        }
        table += '</tr>' +
            '</thead>';
        // let total_reduce = 0;
        let profit = 0;
        let intoMoney = 0;
        for (let i = 0; i < details.length; i++) {
            // total_reduce += Number(replaceComma(details[i].reduce));
            // let reduce = Number(replaceComma(details[i].reduce));
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
            // detail_profit = detail_profit - reduce;
            // let updated_qty = JSON.parse(details[i].updated_qty);
            // let shopee = '';
            // let lazada = '';
            // if(typeof updated_qty != "undefined" && updated_qty != null) {
            //     shopee = updated_qty.shopee === 0 ? '' : 'checked';
            //     lazada = updated_qty.lazada === 0 ? '' : 'checked';
            // }
            table += '<tr class="' + class_text + '">' +
                '<input type="hidden" id="product_id_' + i + '" value="' + details[i].product_id + '"/>' +
                '<input type="hidden" id="variant_id_' + i + '" value="' + details[i].variant_id + '"/>' +
                '<td>' + details[i].sku + '</td>' +
                '<td>' + details[i].product_name + '</td>' +
                '<td>' + details[i].size + '</td>' +
                '<td>' + details[i].color + '</td>' +
                '<td>' + details[i].quantity + '</td>' +
                '<td class="right">' + details[i].price + '<sup>đ</sup></td>' +
                '<td class="right">' + details[i].reduce + '<sup>đ</sup></td>' +
                '<td class="right">' + details[i].intoMoney + '<sup>đ</sup></td>' +
                '<td class="right">' + formatNumber(detail_profit) + '<sup>đ</sup></td>';
                // '<td class="center"><div class="custom-control custom-switch">' +
                // '<input type="checkbox" class="custom-control-input upd-qty-shopee" id="shopee_'+details[i].sku+'" '+shopee+' onchange="updatedQty(this, \'shopee\', '+details[i].sku+')">' +
                // '<label class="custom-control-label" for="shopee_'+details[i].sku+'"></label>' +
                // '</div></td>' +
                // '<td class="center"><div class="custom-control custom-switch">' +
                // '<input type="checkbox" class="custom-control-input upd-qty-lazada" id="lazada_'+details[i].sku+'" '+lazada+' onchange="updatedQty(this, \'lazada\', '+details[i].sku+')">' +
                // '<label class="custom-control-label" for="lazada_'+details[i].sku+'"></label>' +
                // '</div></td>' +
                if(order_type === EXCHANGE) {
                    if (type === '1') {
                        table += '<td class="right"><span class="badge badge-info">Đã mua</span></td>';
                    } else if (type === '2') {
                        table += '<td class="right"><span class="badge badge-success">Đổi</span></td>';
                    } else if (type === '3') {
                        table += '<td class="right"><span class="badge badge-danger">Trả lại</span></td>';
                    } else {
                        table += '<td class="right"><span class="badge badge-secondary">Mua mới</span></td>';
                    }
                }
            table += '</tr>';
        }
        table += '</table>';
        table += '</div>';
        table += '</div>';

        let voucher_value = 0;
        // let order_type = data.type;
        let d = '<div class="card">' +
            '<div class="card-body">' +
            '<div class="row">';
            if (data.customer_id && Number(data.customer_id) > 0) {
                // online
                d += '<div class="col-2 col-sm-2 col-md-2"><small>Mã khách hàng</small> <h5><a href="<?php  Common::getPath() ?>src/view/customer/?customer_id='+ data.customer_id +'" target="_blank">' + data.customer_id + '</a></h5></div>' +
                    '<div class="col-2 col-sm-2 col-md-2">' +
                    '<small>Tên khách hàng</small>' +
                    '<div> <h5 class="d-inline-block mr-2">' + data.customer_name + '</h5>' +
                    '<a href="javascript:void(0)" class="d-inline-block text-warning" id="show_history" onclick="show_history('+data.customer_id+',\''+data.customer_name+'\',\''+data.phone+'\')"><i class="fas fa-history"></i></a>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-2 col-sm-2 col-md-2"><small>Số điện thoại</small> <h5>' + data.phone + '</h5></div>';
                if(data.address) {
                    d +='<div class="row col-12"><small>Địa chỉ</small> <h5 class="col-12 pl-0">' + data.address + '</h5></div>';
                }
            } else {
                d += '<div class="col-2 col-sm-2 col-md-2"><small>Khách hàng</small> <h5>Khách lẻ</h5></div>';
            }
            if (data.voucher_code != null && data.voucher_code !== "") {
                voucher_value = Number((intoMoney * 10) / 100);
                d += '<div class="col-2 col-sm-2 col-md-2"><small>Mã giảm giá</small> <h5>' + data.voucher_code + ' <small>(-10%)(' + formatNumber(voucher_value) + ' đ)</small></h5></div>';
            }
            if (order_refer && Number(order_refer) !== 0) {
                d += '<div class="col-2 col-sm-2 col-md-2"><small>Mã đơn đổi</small> <h5><a href="<?php  Common::getPath() ?>src/view/orders/?order_id='+order_refer+'" target="_blank">' + order_refer + '</h5></a></div>';
            }
            d += '</div>';
        let discount = Number(replaceComma(data.discount));
        profit = profit - discount - voucher_value;

        d += '<div class="row">' +
                '<div class="col-2 col-sm-2 col-md-2"><small>Tổng đơn hàng</small> <h5>' + data.total_amount + '<sup>đ</sup></h5></div>' +
                '<div class="col-2 col-sm-2 col-md-2"><small>CK trên tổng đơn</small> <h5>' + data.discount + '<sup>đ</sup></h5></div>';

        if (data.customer_id && Number(data.customer_id) > 0) {
            profit = profit - Number(replaceComma(data.wallet));
            d += '<div class="col-2 col-sm-2 col-md-2"><small>Tiền trong Ví</small> <h5>' + data.wallet + '<sup>đ</sup></h5></div>';
        }
        d += '<div class="col-2 col-sm-2 col-md-2"><small>Tổng giảm trừ</small> <h5>' + data.total_reduce + '<sup>đ</sup></h5></div>';
        if(order_type === ONLINE) {
            let shipping_fee = replaceComma(data.shipping_fee);
            if(shipping_fee && shipping_fee > 0) {
                d += '<div class="col-2 col-sm-2 col-md-2"><small>Phí ship Shop trả</small> <h5>' + formatNumber(shipping_fee) + '<sup>đ</sup></h5></div>';
                profit = profit - Number(shipping_fee);
            }
            let total_amount = Number(replaceComma(data.total_amount));
            let shipping = Number(replaceComma(data.shipping));
            if(shipping && shipping > 0) {
                d += '<div class="col-2 col-sm-2 col-md-2"><small>Phí ship KH trả</small> <h5>' + formatNumber(shipping) + '<sup>đ</sup></h5></div>';
                profit += shipping;
                total_amount += shipping;
            } else {
                d += '<div class="col-2 col-sm-2 col-md-2"><small>Phí ship KH trả</small> <h5>Miễn Ship</h5></div>';
            }
            total_amount -= Number(replaceComma(data.total_reduce));
            d +='<div class="col-2 col-sm-2 col-md-2"><small>Tổng tiền Khách thanh toán</small> <h5>' + formatNumber(total_amount)+ '<sup>đ</sup></h5></div>';
        }
        let total_checkout = data.total_checkout;
        if (payment_exchange_type === '2') {
            if(total_checkout.indexOf("-") < -1) {
                total_checkout = '-' + total_checkout;
            }
        }
        d +='<div class="col-2 col-sm-2 col-md-2"><small>Tổng tiền Shop nhận</small> <h5>' + total_checkout + '<sup>đ</sup></h5></div>' +
            '<div class="col-2 col-sm-2 col-md-2" style="display: block;"><small>-</small> <h5>' + formatNumber(profit) + '<sup>đ</sup></h5></div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return d + table;
    }

    function updatedQty(e, type, sku) {
        let checked = $(e).prop('checked');
        let status = 0;
        if(checked) {
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
        let content = '';
        // online
        // if (data.type == 1) {
        content += '<a href="<?php Common::getPath() ?>src/view/exchange/?oid='+order_id+'" target="_blank" class="exchange mr-1 text-success" title="Đổi hàng"><i class="fas fa-reply"></i></a>';
        content += '<a href="javascript:void(0);" class="print_receipt mr-1 text-info" title="In hoá đơn"><i class="fa fa-print"></i></a>';

        // }
        if (order_type !== 2) {
            content += '<a href="javascript:void(0);" class="edit_order mr-1 text-primary" title="Sửa đơn hàng"><i class="fa fa-edit"></i></a>';
        }
        content += '<a href="javascript:void(0);" class="delete_order mr-1 text-danger" title="Xoá đơn hàng"><i class="fa fa-trash"></i></a>';
        return content;
    }

    function format_total_checkout(data) {
        let total_checkout = data.total_checkout;
        let payment_exchange_type = data.payment_exchange_type;
        switch (payment_exchange_type) {
            case '1':
                return total_checkout + "<sup>đ</sup>";
            case '2':
                if(total_checkout.indexOf("-") > -1) {
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
        switch (source) {
            case 1 :
                return '<span class="badge badge-success">Website</span>';
            case 2:
                return '<span class="badge badge-primary">Facebook</span>';
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

    function format_status(data) {
        if (data.status === null) {
            return;
        }
        let status = data.status;
        switch (status) {
            case '0' :
                return '<span class="badge badge-warning">Đang đợi</span>';
            case '1':
                return '<span class="badge badge-primary">Đang xử lý</span>';
            case '2':
                return '<span class="badge badge-info">Tạm giữ</span>';
            case '3':
                return '<span class="badge badge-success">Thành công</span>';
            case '4':
                return '<span class="badge badge-secondary">Đã hủy</span>';
            case '5':
                return '<span class="badge badge-danger">Thất bại</span>';
            default:
                break;
        }
    }
</script>
</body>
</html>
