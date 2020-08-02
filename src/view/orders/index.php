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
                <div class="card-header border-transparent pb-0">
                    <div class="form-group col-md-4 float-left mb-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                            </div>
                            <input type="text" class="form-control float-left" id="reservation">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <div class="float-right">
                        <a href="javascript:void(0)" class="btn btn-sm btn-info float-left order-create">Tạo mới</a>
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
                                <div class="col-6">
                                    <span class="info-box-text">Tổng tiền</span>
                                    <span class="info-box-number">
                                        <h5 class="total_money">
                                          <sup>đ</sup>
                                        </h5>
                                     </span>
                                </div>
<!--                                <div class="col-4">-->
<!--                                    <h1 class="display-5 text-danger text-right total_orders"></h1>-->
<!--                                </div>-->
                                <div class="col-6 float-right">
                                    <h1 class="text-danger text-left no-margin d-inline-block col-md-12"><span class="total_orders d-inline-block text-right col-md-6 float-left">0</span> <small style="font-size: 30%;color: #676a6c;">Đơn</small></h1>
                                    <h5 class="text-danger text-left no-margin d-inline-block col-md-12"><span class="total_products d-inline-block text-right col-md-6 float-left" style="color: #676a6c;">0</span> <small style="font-size: 60%;color: #676a6c;">Sản phẩm</small></h5>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-store"></i></span>
                            <div class="info-box-content col-12 row">
                                <div class="col-6">
                                    <span class="info-box-text">Shop</span>
                                    <span class="info-box-number">
                                        <h5 class="total_on_shop">
                                            <sup>đ</sup>
                                        </h5>
                                    </span>
                                </div>
<!--                                <div class="col-4">-->
<!--                                    <h1 class="display-5 text-right count_on_shop"></h1>-->
<!--                                </div>-->
                                <div class="col-6 float-right">
                                    <h1 class="text-danger text-left no-margin d-inline-block col-md-12"><span class="count_on_shop d-inline-block text-right col-md-6 float-left">0</span> <small style="font-size: 30%;color: #676a6c;">Đơn</small></h1>
                                    <h5 class="text-danger text-left no-margin d-inline-block col-md-12"><span class="total_product_on_shop d-inline-block text-right col-md-6 float-left" style="color: #676a6c;">0</span> <small style="font-size: 60%;color: #676a6c;">Sản phẩm</small></h5>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-globe"></i></span>
                            <div class="info-box-content col-12 row">
                                <div class="col-6">
                                    <span class="info-box-text">Online</span>
                                    <span class="info-box-number">
                                        <h5 class="total_online">
                                          <sup>đ</sup>
                                        </h5>
                                    </span>
                                </div>
<!--                                <div class="col-4">-->
<!--                                    <h1 class="display-5 text-right count_online"></h1>-->
<!--                                </div>-->
                                <div class="col-6 float-right">
                                    <h1 class="text-danger text-left no-margin d-inline-block col-md-12"><span class="count_online d-inline-block text-right col-md-6 float-left">0</span> <small style="font-size: 30%;color: #676a6c;">Đơn</small></h1>
                                    <h5 class="text-danger text-left no-margin d-inline-block col-md-12"><span class="total_product_online d-inline-block text-right col-md-6 float-left" style="color: #676a6c;">0</span> <small style="font-size: 60%;color: #676a6c;">Sản phẩm</small></h5>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="clearfix hidden-md-up"></div>
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-sync-alt"></i></span>
                            <div class="info-box-content col-12 row">
                                <div class="col-6">
                                    <span class="info-box-text">Đổi hàng</span>
                                    <span class="info-box-number">
                                        <h5 class="total_exchange">
                                          <sup>đ</sup>
                                        </h5>
                                    </span>
                                </div>
<!--                                <div class="col-4">-->
<!--                                    <h1 class="display-5 text-right count_exchange"></h1>-->
<!--                                </div>-->
                                <div class="col-6 float-right">
                                    <h1 class="text-danger text-left no-margin d-inline-block col-md-12"><span class="count_exchange d-inline-block text-right col-md-6 float-left">0</span> <small style="font-size: 30%;color: #676a6c;">Đơn</small></h1>
                                    <h5 class="text-danger text-left no-margin d-inline-block col-md-12"><span class="total_product_exchange d-inline-block text-right col-md-6 float-left" style="color: #676a6c;">0</span> <small style="font-size: 60%;color: #676a6c;">Sản phẩm</small></h5>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
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
                                <span class="info-box-text">--</span>
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
<div class="iframeArea hidden"></div>
<!-- /.content -->
<?php include 'createOrders.php'; ?>
<input type="hidden" id="startDate">
<input type="hidden" id="endDate">
</div>
<?php require_once ('../../common/footer.php'); ?>
<script>
    $(document).ready(function () {
        // set title for page
        set_title("Danh sách đơn hàng");

        let currentDate = new Date()
        let day = currentDate.getDate()
        let month = currentDate.getMonth() + 1
        let year = currentDate.getFullYear()
        let start_date = year + "-" + month + "-" + day;
        let end_date = year + "-" + month + "-" + day;
        $("#startDate").val(start_date);
        $("#endDate").val(end_date);
        generate_datatable();
        get_info_total_checkout(start_date, end_date);

        //Date range picker
        $('#reservation').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
            }
        }, function (start, end, label) {
            let start_date = start.format('YYYY-MM-DD');
            let end_date = end.format('YYYY-MM-DD');
            $("#startDate").val(start_date);
            $("#endDate").val(end_date);
            generate_datatable();
            get_info_total_checkout(start_date, end_date);
        });
    });
    let table;

    function generate_datatable() {
        if ($.fn.dataTable.isDataTable('#example')) {
            table.destroy();
            table.clear();
            table.ajax.reload();
        }
        table = $('#example').DataTable({
            'ajax': {
                "type": "GET",
                "url": "<?php Common::getPath() ?>src/controller/orders/OrderController.php",
                "data": function (d) {
                    d.method = 'find_all';
                    d.start_date = $("#startDate").val();
                    d.end_date = $("#endDate").val();
                }
            },
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
            let start_date = $("#startDate").val();
            let end_date = $("#endDate").val();
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
                        start_date: start_date,
                        end_date: end_date
                    },
                    success: function (res) {
                        console.log(res);
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
                        })
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
            let type = row.data().type;
            console.log(order_id);
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
                            get_info_total_checkout($("#startDate").val(), $("#endDate").val());
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
            let order_type = row.data().type;
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
                    console.log(res);
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
                    $(".iframeArea").html('<iframe src="<?php Common::getPath() ?>src/controller/orders/pdf/' + filename + '" id="receiptContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                    let objFra = document.getElementById('receiptContent');
                    objFra.contentWindow.focus();
                    objFra.contentWindow.print();
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
            console.log(order_type);
            if (value.length != 0) {
                $("#order_id").val(value[0].order_id);
                $('#orderDate').val(value[0].order_date);
                // online
                if (order_type == 1) {
                    $("#customer_id").val(value[0].customer_id);
                    $("#bill_of_lading_no").val(value[0].bill_of_lading_no);
                    $("#shipping_fee").val(value[0].shipping_fee);
                    // $("#customer_name").val(value[0].customerName);
                    // $("#phone_number").val(value[0].phone);
                    // $("#email").val(value[0].email);
                    // generate_select2_city(value[0].city_id);
                    // generate_select2_district(value[0].city_id, value[0].district_id);
                    // generate_select2_village(value[0].district_id, value[0].village_id);
                    // $("#address").val(value[0].address);
                    $("#shipping").val(value[0].shipping).trigger("change");
                    $("#bill_of_lading_no").prop("disabled", false);
                    $("#shipping_fee").prop("disabled", false);
                    // $("#customer_name").prop("disabled", false);
                    // $("#phone_number").prop("disabled", false);
                    // $("#email").prop("disabled", false);
                    $(".select-shipping-unit").prop("disabled", false);
                    // $(".select-city").prop("disabled", false);
                    // $(".select-district").prop("disabled", false);
                    // $(".select-village").prop("disabled", false);
                    // $("#address").prop("disabled", false);
                    $("#shipping").prop("disabled", false);
                } else if (order_type == 0) {
                    generate_select2_city();
                    // on shop
                    $("#bill_of_lading_no").prop("disabled", true);
                    $("#shipping_fee").prop("disabled", true);
                    // $("#customer_name").prop("disabled", true);
                    // $("#phone_number").prop("disabled", true);
                    // $("#email").prop("disabled", true);
                    $(".select-shipping-unit").prop("disabled", true);
                    // $(".select-city").prop("disabled", true);
                    // $(".select-district").prop("disabled", true);
                    // $(".select-village").prop("disabled", true);
                    // $("#address").prop("disabled", true);
                    $("#shipping").prop("disabled", true);
                    $("#order_status").val(3).trigger("change");//complete
                }
                $("#payment_type").val(value[0].payment_type).trigger("change");
                $("#payment").val(value[0].customer_payment);
                $("#total_amount").text(value[0].total_amount);
                $("#discount").val(value[0].discount).trigger("change");
                $("#total_checkout").text(value[0].total_checkout);
                $("#repay").text(value[0].repay);
                $(".product-area").html("");
                $("#table_list_product tbody").html("");
                let details = value[0].details;
                add_product_list(details);
                // for (let i = 0; i < details.length; i++) {
                    // add_product_list(details[i]);

                    // $('.count-row').val(i);
                    // add_new_product();
                    // $("#detailId_" + (i + 1)).val(details[i].order_detail_id)
                    // $("#sku_" + (i + 1)).val(details[i].sku).trigger("change");
                    // $("#prodQty_" + (i + 1)).val(details[i].quantity).trigger("change");
                    // $("#prodReduce_" + (i + 1)).val(details[i].reduce);
                    // if (order_type == 1) {
                    //     $("#prodReduce_" + (i + 1)).prop("disabled", true);
                    // } else if (order_type == 0) {
                    //     $("#prodReduce_" + (i + 1)).prop("disabled", false);
                    // }
                // }
                open_modal('#create_order');
            } else {
                toastr.error('Đã xảy ra lỗi.');
            }
        });
    }

    function format_order_detail(data, row_data) {
        console.log(data);
        let order_type = row_data.type;
        let payment_exchange_type = row_data.payment_exchange_type;
        let order_refer = row_data.order_refer;
        let details = data.details;
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
            '<th class="right" style="display: none;">Profit</th>' +
            '<th class="center">Shopee</th>' +
            '<th class="center">Lazada</th>' +
            '</tr>' +
            '</thead>';
        let total_reduce = 0;
        let profit = 0;
        let intoMoney = 0;
        for (let i = 0; i < details.length; i++) {
            total_reduce += Number(replaceComma(details[i].reduce));
            intoMoney += Number(replaceComma(details[i].intoMoney));
            let type = details[i].type;
            let style = "color: black;";
            if (type === '1') {
                style = "color: red;";
            } else if (type === '2') {
                style = "color: green;";
            }
            let detail_profit = 0;
            if (type === '1') {
                profit += 0 - Number(replaceComma(details[i].profit));
                detail_profit = 0 - Number(replaceComma(details[i].profit));
            } else {
                profit += Number(replaceComma(details[i].profit));
                detail_profit = Number(replaceComma(details[i].profit));
            }
            let updated_qty = JSON.parse(details[i].updated_qty);
            let shopee = '';
            let lazada = '';
            if(typeof updated_qty != "undefined" && updated_qty != null) {
                shopee = updated_qty.shopee === 0 ? '' : 'checked';
                lazada = updated_qty.lazada === 0 ? '' : 'checked';
            }
            table += '<tr style="' + style + '">' +
                '<input type="hidden" id="product_id_' + i + '" value="' + details[i].product_id + '"/>' +
                '<input type="hidden" id="variant_id_' + i + '" value="' + details[i].variant_id + '"/>' +
                '<td>' + details[i].sku + '</td>' +
                '<td>' + details[i].product_name + '</td>' +
                '<td>' + details[i].size + '</td>' +
                '<td>' + details[i].color + '</td>' +
                '<td>' + details[i].quantity + '</td>' +
                '<td class="right">' + details[i].price + ' <sup>đ</sup></td>' +
                '<td class="right">' + details[i].reduce + ' <sup>đ</sup></td>' +
                '<td class="right">' + details[i].intoMoney + ' <sup>đ</sup></td>' +
                '<td class="right" style="display: none;">' + formatNumber(detail_profit) + ' <sup>đ</sup></td>' +
                '<td class="center"><div class="custom-control custom-switch">' +
                '<input type="checkbox" class="custom-control-input upd-qty-shopee" id="shopee_'+details[i].sku+'" '+shopee+' onchange="updatedQty(this, \'shopee\', '+details[i].sku+')">' +
                '<label class="custom-control-label" for="shopee_'+details[i].sku+'"></label>' +
                '</div></td>' +
                '<td class="center"><div class="custom-control custom-switch">' +
                '<input type="checkbox" class="custom-control-input upd-qty-lazada" id="lazada_'+details[i].sku+'" '+lazada+' onchange="updatedQty(this, \'lazada\', '+details[i].sku+')">' +
                '<label class="custom-control-label" for="lazada_'+details[i].sku+'"></label>' +
                '</div></td>' +
                '</tr>';
        }
        table += '</table>';
        table += '</div>';
        table += '</div>';

        let voucher_value = 0;
        // let order_type = data.type;
        let d = '<div class="card">' +
            '<div class="card-body">';
        if (order_type === "1") {
            // online
            d += '<div class="row">' +
                '<div class="col-3 col-sm-3 col-md-3"><small>Mã khách hàng</small> <h5>' + data.customer_id + '</h5></div>' +
                '<div class="col-6 col-sm-6 col-md-6"><small>Tên khách hàng</small> <h5>' + data.customer_name + '</h5></div>' +
                '<div class="col-3 col-sm-3 col-md-3"><small>Số điện thoại</small> <h5>' + data.phone + '</h5></div>' +
                '</div>' +
                '<div class="row col-12"><small>Địa chỉ</small> <h5 class="col-12 pl-0">' + data.address + '</h5></div>';
        } else {
            d += '<div class="row">' +
                '<div class="col-3 col-sm-3 col-md-3"><small>Khách hàng</small> <h5>Khách lẻ</h5></div>';
            if (data.voucher_code != null && data.voucher_code !== "") {
                voucher_value = Number((intoMoney * 10) / 100);
                d += '<div class="col-3 col-sm-3 col-md-3"><small>Mã giảm giá</small> <h5>' + data.voucher_code + ' <small>(-10%)(' + formatNumber(voucher_value) + ' đ)</small></h5></div>';
            }
            if (order_refer != null && order_refer !== "" && order_refer !== 0) {
                d += '<div class="col-3 col-sm-3 col-md-3"><small>Mã đơn đổi</small> <h5>' + order_refer + '</h5></div>';
            }
            d += '</div>';
        }

        let discount = Number(replaceComma(data.discount));
        profit = profit - discount - voucher_value;

        d += '<div class="row">' +
            '<div class="col-3 col-sm-3 col-md-3"><small>Chiết khấu trên tổng đơn hàng</small> <h5>' + data.discount + ' <sup>đ</sup></h5></div>' +
            '<div class="col-3 col-sm-3 col-md-3"><small>Tổng giảm trừ</small> <h5>' + data.total_reduce + ' <sup>đ</sup></h5></div>';
        let total_checkout = data.total_checkout;
        if (payment_exchange_type === '2') {
            total_checkout = '-' + total_checkout;
        }
        d += '<div class="col-3 col-sm-3 col-md-3"><small>Tổng tiền thanh toán</small> <h5>' + total_checkout + ' <sup>đ</sup></h5></div>' +
            '<div class="col-3 col-sm-3 col-md-3" style="display: block;"><small>-</small> <h5>' + formatNumber(profit) + ' <sup>đ</sup></h5></div>' +
            '</div>' +
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
                console.log(res);
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
        let order_type = data.type;
        let content = '';
        // online
        // if (data.type == 1) {
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
                return total_checkout + " <sup>đ</sup>";
            case '2':
                return '-' + total_checkout + " <sup>đ</sup>";
            default:
                return total_checkout + " <sup>đ</sup>";
        }
    }

    function format_type(data) {
        let type = data.type;
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
        let source = data.source;
        switch (source) {
            case '1' :
                return '<span class="badge badge-success">Website</span>';
            case '2':
                return '<span class="badge badge-primary">Facebook</span>';
            case '3':
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
                break;
            case '1':
                return '<span class="badge badge-success">Chuyển khoản</span>';
                break;
            case '2':
                return '<span class="badge badge-warning">Nợ</span>';
                break;
            case '3':
                return '<span class="badge badge-primary">COD</span>';
                break;
            default:
                return '';
                break;
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
                break;
            case '1':
                return '<span class="badge badge-primary">Đang xử lý</span>';
                break;
            case '2':
                return '<span class="badge badge-info">Tạm giữ</span>';
                break;
            case '3':
                return '<span class="badge badge-success">Thành công</span>';
                break;
            case '4':
                return '<span class="badge badge-secondary">Đã hủy</span>';
                break;
            case '5':
                return '<span class="badge badge-danger">Thất bại</span>';
                break;
            default:
                break;
        }
    }

    function get_info_total_checkout(start_date, end_date) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "get_info_total_checkout",
                start_date: start_date,
                end_date: end_date
            },
            success: function (res) {
                $(".total_money").html(res.total_checkout + " <sup>đ</sup>");
                $(".total_orders").html(res.count_total);
                $(".total_products").html(res.total_product);
                $(".total_on_shop").html(res.total_on_shop + " <sup>đ</sup>");
                $(".count_on_shop").html(res.count_on_shop);
                $(".total_product_on_shop").html(res.total_product_on_shop);
                $(".total_online").html(res.total_online + " <sup>đ</sup>");
                $(".count_online").html(res.count_online);
                $(".total_product_online").html(res.total_product_online);
                $(".total_exchange").html(res.total_exchange + " <sup>đ</sup>");
                $(".count_exchange").html(res.count_exchange);
                $(".total_product_exchange").html(res.total_product_exchange);
                $(".total_cash").html(res.total_cash + " <sup>đ</sup>");
                $(".total_transfer").html(res.total_transfer + " <sup>đ</sup>");
                $(".total_profit").html(res.total_profit + " <sup>đ</sup>");
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                })
                hide_loading();
            }
        });
    }

    // function show_loading() {
    //     $("#create-product .overlay").removeClass("hidden");
    // }
    //
    // function hide_loading() {
    //     $("#create-product .overlay").addClass("hidden");
    // }

</script>
</body>
</html>
