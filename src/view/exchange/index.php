<?php require_once("../../common/common.php") ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo __PATH__ ?>dist/img/icon.png"/>
    <title>Đổi sản phẩm</title>
    <?php require_once('../../common/css.php'); ?>
    <?php require_once('../../common/js.php'); ?>
    <style>

        .old {
            color: gray;
            /*text-decoration: line-through;*/
            font-size: small;
            display: inline-block;
            width: 100%;
        }

        .new {
            font-size: large;
        }

        .checkout .h4, h4 {
            font-size: 1.5rem;
            vertical-align: middle;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .checkout .table th, .table td {
            /* padding: 0 !important; */
            vertical-align: middle !important;
            border-bottom: 1px solid #dee2e6 !important;
            border-top: none !important;
        }

        .gray {
            color: gray;
        }
    </style>
</head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Danh sách sản phẩm</h3>
                </div>
                <div class="card-body" style="min-height: 760px;">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-3">
                            <input class="form-control" id="orderId" type="text" autofocus="autofocus"
                                   autocomplete="off" placeholder="Nhập mã đơn hàng">
                            <input type="hidden" id="currentOrderId">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h3 id="orderInfo" class="hidden float-left mr-4"></h3>
                            <button class="btn btn-danger hidden" id="cancel_exchange"><i
                                        class="far fa-times-circle"></i> Hủy
                            </button>
                            <span id="orderDate" class="hidden" style="width: 100%; display: inline-block"></span>
                        </div>
                        <div class="col-md-3 mt-2 mb-2">
                            <input class="form-control hidden" id="productId" type="text" autocomplete="off"
                                   placeholder="Nhập mã sản phẩm">
                        </div>
                    </div>
                    <input type="hidden" id="noRow" value="0">
                    <table class="table table-bordered table-head-fixed" id="tableProd">
                        <thead>
                        <tr>
                            <th class="w10">#</th>
                            <th class="hidden"></th>
                            <th class="hidden"></th>
                            <th class="w30">ID</th>
                            <th class="w200">Tên sản phẩm</th>
                            <th class="w30">Size</th>
                            <th class="w50">Màu</th>
                            <th class="w110">Đơn giá</th>
                            <th class="w80">SL</th>
                            <th class="w100">Giảm trừ</th>
                            <th class="w110">Thành tiền</th>
                            <th class="w100">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-3 checkout">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Thông tin thanh toán</h3>
                </div>
                <div class="card-body" style="height: 760px;padding: 0 20px;">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td class="right w90 p-0 gray">Tổng tiền</td>
                            <td class="right p-0 gray">
                                <h4><span id="totalAmount">0</span>
                                    <small> đ</small>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="right p0 gray">Khuyến mãi</td>
                            <td class="right w110 p-0 gray">
                                <h4><span id="discount">0</span>
                                    <small> đ</small>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="left voucher_info hidden p0">
                                <input type="hidden" id="vcFlag" value="0">
                                <input type="hidden" id="vcCode" value="">
                                <span class="msg"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="right p-0 gray">Tổng Giảm trừ</td>
                            <td class="right p-0 gray">
                                <h4><span id="totalReduce">0</span>
                                    <small> đ</small>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="right p-0 gray">Tổng thanh toán</td>
                            <td class="right p-0 gray">
                                <h4><strong id="totalCheckout">0</strong>
                                    <small> đ</small>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="right p-0 gray">Khách thanh toán</td>
                            <td class="right p-0 gray">
                                <h4><span id="payment">0</span>
                                    <small> đ</small>
                                </h4>
                                <span id="sel_payment"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="right p-0 gray">Trả lại</td>
                            <td class="right p-0 gray">
                                <h4><span id="repay">0</span>
                                    <small> đ</small>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="left p-0">Khách trả thêm</td>
                            <td class="right p-0">
                                <h3 style="color: red;"><span id="surcharge">0</span>
                                    <small> đ</small>
                                </h3>
                            </td>
                        </tr>
                        <tr>
                            <td class="left p-0">Giảm trừ</td>
                            <td class="right pt-2 pr-0">
                                <input type="text" class="form-control" name="discount_new" id="discount_new"
                                       placeholder="Số tiền" width="100px" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td class="left p-0">Tổng thanh toán</td>
                            <td class="right p-0">
                                <h4><span id="total_checkout_new">0</span>
                                    <small> đ</small>
                                </h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="right">Khách thanh toán</td>
                            <td class="right">
                                <select class="form-control" name="sel_payment_new" id="sel_payment_new" disabled>
                                    <option value="0" selected="selected">Tiền mặt</option>
                                    <option value="1">Chuyển khoản</option>
                                    <option value="2">Nợ</option>
                                </select>
                                <input type="text" class="form-control mt-2" name="payment_new" id="payment_new" width="100px" disabled
                                       style="text-align: right;">

                            </td>
                        </tr>
                        <tr>
                            <td class="right">Trả lại</td>
                            <td class="right"><span style="font-size: 20px;" id="repay_new">0</span><span> đ</span></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="left skin-line">
                            <input type="checkbox" id="flag_print_receipt" checked>
                            <label for="flat-checkbox-1">In hóa đơn</label>
                        </div>
                    </div>
                    <div class="row">
                        <button type="button" class="btn btn-success form-control" id="checkout" title="Thanh toán"
                                disabled="disabled">
                            <i class="fas fa-shopping-basket"></i> Thanh toán
                        </button>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</section>
<div class="iframeArea hidden">
</div>
<?php require_once('../../common/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        set_title("Đổi sản phẩm");
        $("#orderId").change(function () {
            let orderId = $(this).val();
            console.log(orderId);
            if(orderId == "") {
                return;
            }
            $("#currentOrderId").val(orderId);
            find_order(orderId);
        });

        $("#cancel_exchange").on("click", function () {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn hủy đổi đơn này?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    window.location.reload();
                }
            });

        });

        $("#productId").change(function () {
            var prodId = $(this).val();
            if (prodId.indexOf('SP') > -1) {
                prodId = prodId.replace("SP", "");
                prodId = parseInt(prodId);
            }
            // validateProdId(prodId, calculateTotal, find_product, 1);
            find_new_product(prodId);
            $(this).val("");
        });

        $("#discount").change(function (event) {
            let discount = $(this).val();
            onchange_discount(discount, event);
            event.preventDefault();
        });
        // $("#discount").blur(function(event){
        // 	console.log('blur');
        // 	var discount = $(this).val();
        // 	onchange_discount(discount);
        // 	event.preventDefault();
        // });
        $('#discount').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                var discount = $(this).val();
                onchange_discount(discount, event);
                event.preventDefault();
            }
        });

        $("#voucher").change(function (event) {
            let voucher = $(this).val();
            onchange_voucher(voucher, event);
            event.preventDefault();
        });
        $('#voucher').keypress(function (event) {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                let voucher = $(this).val();
                onchange_voucher(voucher, event);
                event.preventDefault();
            }
        });

        $("#payment").change(function () {
            var payment = $(this).val();
            payment = replaceComma(payment);
            paymentChange(payment);
        });
        $("#payment").blur(function () {
            var payment = $(this).val();
            payment = replaceComma(payment);
            paymentChange(payment);
        });
        $('#payment').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                var payment = $(this).val();
                payment = replaceComma(payment);
                paymentChange(payment);
            }
        });

        $("#checkout").click(function () {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn tạo đơn hàng này?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    processDataCheckout();
                }
            });
        });


        $("#sel_payment").change(function () {
            if ($(this).val() == 0) {
                $("#payment").show();
                $("#payment").focus();
                // disableCheckOutBtn();
                validate_form();
            } else {
                $("#payment").val("");
                $("#payment").hide();
                // enableCheckOutBtn();
                validate_form();
            }
        });
        $("#sel_discount").change(function () {
            $("#discount").focus();
        });
        // end document ready
    });

    function exchangeBtn(e, noRow) {
        $(e).parent().children("#productName_" + noRow).val("");
        $(e).parent().children("#productName_" + noRow).removeClass("hidden");
        $(e).parent().children("#productName_" + noRow).focus();
        $(e).addClass("hidden");
        $(e).parent().children("#cancelExchange_" + noRow).removeClass("hidden");
    }

    function cancelExchangeBtn(e, noRow) {
        $(e).parent().children("#productName_" + noRow).addClass("hidden");
        $(e).parent().children("#productName_" + noRow).val("");
        $(e).addClass("hidden");
        $(e).parent().children("#exchange_" + noRow).removeClass("hidden");
    }

    function find_order(orderId) {
        $.ajax({
            url: '<?php echo __PATH__ . 'src/controller/exchange/ExchangeController.php' ?>',
            type: "POST",
            dataType: "json",
            data: {
                method: "find_order",
                orderId: orderId
            },
            success: function (order) {
                console.log(JSON.stringify(order));
                $.each(order, function (key, value) {
                    console.log(value);
                    if (value.length > 0) {
                        $("#orderId").val("");
                        $("#orderId").addClass("hidden");
                        let details = value[0].details;
                        for (let i = 0; i < details.length; i++) {
                            let price = replaceComma(details[i].price);
                            let reduce = details[i].reduce;
                            if (reduce == 0) {
                                reduce = "";
                            } else if (reduce > 0 && reduce < 100) {
                                reduce = reduce + "%";
                            } else {
                                reduce = replaceComma(reduce);
                            }
                            let noRow = $("#noRow").val();
                            noRow = Number(noRow);
                            noRow++;
                            $("#noRow").val(noRow);
                            $("#tableProd tbody").append('<tr id="order_' + noRow + '">'
                                + '<td>' + noRow + '</td>'
                                + '<td class="hidden"><input type="hidden" name="prodId" id="prodId_' + noRow + '" class="form-control" value="' + details[i].product_id + '"></td>'
                                + '<td class="hidden"><input type="hidden" name="variantId" id="variantId_' + noRow + '" class="form-control" value="' + details[i].variant_id + '"></td>'
                                + '<td class="hidden"><input type="hidden" name="sku" id="sku_' + noRow + '" class="form-control" value="' + details[i].sku + '"></td>'
                                + '<td class="hidden"><input type="hidden" name="orderDetailId" id="orderDetailId_' + noRow + '" class="form-control" value="' + details[i].order_detail_id + '"></td>'
                                + '<td><span class="product-sku" id="sku_' + noRow + '">' + details[i].sku + '</span></td>'
                                + '<td><span class="product-name" id="name_' + noRow + '">' + details[i].product_name + '</span></td>'
                                + '<td><span class="size" id="size_' + noRow + '">' + details[i].size + '</span></td>'
                                + '<td><span class="color" id="color_' + noRow + '">' + details[i].color + '</span></td>'
                                + '<td><span class="price" id="price_' + noRow + '">' + details[i].price + ' <small> đ</small></span></td>'
                                + '<td><span name="qty" id="qty_' + noRow + '">' + details[i].quantity + '</span></td>'
                                + '<td><span name="reduce" id="reduce_' + noRow + '">' + formatNumber(reduce) + '</span></td>'
                                + '<td><div><span class="intoMoney" id="intoMoney_' + noRow + '">' + details[i].intoMoney + '</span> <small> đ</small></div></td>'
                                + '<td><button type="button" id="exchange_' + noRow + '" class="btn btn-info form-control" onclick="exchangeBtn(this, ' + noRow + ')" title="Đổi hàng"><i class="fas fa-sync"></i> Đổi hàng</button>'
                                + '<button type="button" id="cancelExchange_' + noRow + '" class="btn btn-danger form-control hidden" onclick="cancelExchangeBtn(this, ' + noRow + ')" title="Hủy đổi hàng"><i class="fas fa-ban"></i> Hủy</button>'
                                + '<input type="text" value="" placeholder="Nhập mã sản phẩm" id="productName_' + noRow + '" onchange="find_product(this, 1, ' + noRow + ')" class="hidden form-control mt-2 mb-2">'
                                + '<button type="button" id="del_' + noRow + '" onclick="del_product_new(this, ' + noRow + ')" class="btn btn-danger hidden form-control mt-2 mb-2" title="Xóa sản phẩm đổi"><i class="fas fa-trash"></i> Xóa</button>'
                                + '</td>'
                                + '</tr>');
                        }
                        $("#productId").prop("disabled", "");
                        $("#discount").prop("disabled", "");
                        $("#voucher").prop("disabled", "");
                        $("#sel_payment").prop("disabled", "");
                        $("#payment").prop("disabled", "");

                        $("#orderInfo").text("Thông tin hoá đơn #" + orderId);
                        $("#orderInfo").removeClass("hidden");
                        $("#orderDate").text("Ngày mua hàng: " + value[0].order_date);
                        $("#orderDate").removeClass("hidden");
                        $("#productId").removeClass("hidden");
                        $("#cancel_exchange").removeClass("hidden");


                        $("#totalAmount").text(value[0].total_amount);
                        $("#discount").text(value[0].discount);
                        $("#totalReduce").text(value[0].total_reduce);
                        $("#totalCheckout").text(value[0].total_checkout);
                        $("#repay").text(value[0].repay);
                        $("#payment").text(value[0].customer_payment);
                        if (value[0].customer_payment != "" && value[0].customer_payment != 0) {
                            switch (value[0].payment_type) {
                                case 0:
                                    $("#sel_payment").text("Tiền mặt");
                                    break;
                                case 1:
                                    $("#sel_payment").text("Chuyển khoản");
                                    break;
                                case 2:
                                    $("#sel_payment").text("Nợ");
                                    break;
                                default:
                                    $("#sel_payment").text("Tiền mặt");
                                    break;
                            }
                        }
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Đã xảy ra lỗi',
                            text: "Không tìm thấy đơn hàng #" + orderId
                        });
                        return;
                    }
                });

                // $('[id=qty_' + noRow + ']').trigger("change");
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

    function find_product(e, qty, noRow) {
        let sku = $(e).val();
        if (sku == "") {
            return;
        }
        $.ajax({
            url: '<?php echo __PATH__ . 'src/controller/sales/processCheckout.php' ?>',
            type: "POST",
            dataType: "json",
            data: {
                type: "find_product",
                sku: sku
            },
            success: function (products) {
                console.log(JSON.stringify(products));
                if(products.length > 0) {
                    let retail = products[0].retail;
                    retail = replaceComma(retail);
                    let into_money = 0;
                    let discount = products[0].discount;
                    if (discount == 0) {
                        discount = "";
                    } else if (discount > 0 && discount < 100) {
                        into_money = Number(retail) - Number(retail)*Number(discount)/100;
                        discount = discount + "%";
                    } else {
                        discount = replaceComma(discount);
                        into_money = retail - discount;
                    }
                    $(e).parent().parent().addClass("has-change");
                    $(e).parent().parent().find("td:eq(1)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(1)").append('<input type="hidden" name="prodIdNew" id="prodId_new_' + noRow + '" class="form-control new" value="' + products[0].product_id + '">');
                    $(e).parent().parent().find("td:eq(2)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(2)").append('<input type="hidden" name="variantIdNew" id="variantId_new_' + noRow + '" class="form-control new" value="' + products[0].variant_id + '">');
                    $(e).parent().parent().find("td:eq(3)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(3)").append('<input type="hidden" name="skuNew" id="sku_new_' + noRow + '" class="form-control new" value="' + products[0].sku + '">');
                    $(e).parent().parent().find("td:eq(4)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(4)").append('<input type="hidden" name="orderDetailIdNew" id="orderDetailId_new_' + noRow + '" class="form-control new" value="' + products[0].order_detail_id + '">');
                    $(e).parent().parent().find("td:eq(5)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(5)").append('<span class="product-sku-new new" id="sku_new_' + noRow + '">' + products[0].sku + '</span>');
                    $(e).parent().parent().find("td:eq(6)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(6)").append('<span class="product-name-new new" id="name_new_' + noRow + '">' + products[0].name + '</span>');
                    $(e).parent().parent().find("td:eq(7)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(7)").append('<span class="size-new new" id="size_new_' + noRow + '">' + products[0].size + '</span>');
                    $(e).parent().parent().find("td:eq(8)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(8)").append('<span class="color-new new" id="color_new_' + noRow + '">' + products[0].color + '</span>');
                    $(e).parent().parent().find("td:eq(9)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(9)").append('<span class="price-new new" id="price_new_' + noRow + '">' + products[0].retail + '</span> <small class="new"> đ</small>');
                    $(e).parent().parent().find("td:eq(10)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(10)").append('<input type="number" name="qtyNew" id="qty_new_' + noRow + '" class="new form-control" min="1" value="' + qty + '" onblur="on_change_qty(\'price_new_' + noRow + '\', \'qty_new_' + noRow + '\', \'intoMoney_new_' + noRow + '\', \'reduce_new_' + noRow + '\')">');
                    $(e).parent().parent().find("td:eq(11)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(11)").append('<input type="text" name="reduceNew" id="reduce_new_' + noRow + '" class="new form-control" value="' + discount + '" onblur="on_change_reduce(\'price_new_' + noRow + '\',\'qty_new_' + noRow + '\', \'intoMoney_new_' + noRow + '\', \'reduce_new_' + noRow + '\')">');
                    $(e).parent().parent().find("td:eq(12)").children(":first").addClass("old");
                    let into_money_old = $(e).parent().parent().find("td:eq(12)").children(":first").text();
                    into_money_old = replaceComma(into_money_old);
                    into_money_old = into_money_old.replace("đ","");
                    let diff_money = into_money - into_money_old;
                    let style = "color: gray;";
                    if(diff_money > 0 ) {
                        style = "color: green;";
                    } else if(diff_money < 0 ) {
                        style = "color: red;";
                    }
                    $(e).parent().parent().find("td:eq(12)").append('<div><span class="intoMoney new" id="intoMoney_new_' + noRow + '">' + formatNumber(into_money) + '</span> <small class="new"> đ</small></div>');
                    $(e).parent().parent().find("td:eq(12)").append('<div class="old diff_money" style="'+style+'"><span id="diff_money_new_' + noRow + '">' + formatNumber(diff_money) + '</span> <small> đ</small></div>');
                    $(e).parent().find("[id=del_" + noRow + "]").removeClass("hidden");
                    $(e).addClass("hidden");
                    $(e).val("");
                    calculateTotal();
                    $("#checkout").prop("disabled", "");
                } else {
                    $("#checkout").prop("disabled", true);
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
            }
        });
    }

    function find_new_product(sku, qty = 1) {
        if (sku == "") {
            return;
        }
        $.ajax({
            url: '<?php echo __PATH__ . 'src/controller/sales/processCheckout.php' ?>',
            type: "POST",
            dataType: "json",
            data: {
                type: "find_product",
                sku: sku
            },
            success: function (products) {
                console.log(JSON.stringify(products));
                if(products.length > 0) {
                    let discount = products[0].discount;
                    if (discount == 0) {
                        discount = "";
                    } else if (discount > 0 && discount < 100) {
                        discount = discount + "%";
                    }
                    let noRow = $("#noRow").val();
                    noRow = Number(noRow);
                    noRow++;
                    $("#noRow").val(noRow);
                    $("#tableProd tbody").append('<tr id="product-' + noRow + '" class="add-new-product">'
                        + '<td>' + noRow + '</td>'
                        + '<td class="hidden"><input type="hidden" name="prodIdAddNew" id="prodId_add_new_' + noRow + '" class="form-control" value="' + products[0].product_id + '"></td>'
                        + '<td class="hidden"><input type="hidden" name="variantIdAddNew" id="variantId_add_new_' + noRow + '" class="form-control" value="' + products[0].variant_id + '"></td>'
                        + '<td class="hidden"><input type="hidden" name="skuAddNew" id="sku_add_new_' + noRow + '" class="form-control" value="' + products[0].sku + '"></td>'
                        + '<td><span class="product-sku-add-new">' + products[0].sku + '</span></td>'
                        + '<td><span class="product-name-add-new" id="name_add_new_' + noRow + '">' + products[0].name + '</span></td>'
                        + '<td><span class="size-add-new" id="size_add_new_' + noRow + '">' + products[0].size + '</span></td>'
                        + '<td><span class="color-add-new" id="color_add_new_' + noRow + '">' + products[0].color + '</span></td>'
                        + '<td><span class="price-add-new" id="price_add_new_' + noRow + '">' + products[0].retail + '</span><span> đ</span></td>'
                        + '<td><input type="number" name="qtyAddNew" id="qty_add_new_' + noRow + '" class="form-control" min="1" value="'+qty+'" onchange="on_change_qty(\'price_' + noRow + '\', \'qty_' + noRow + '\', \'intoMoney_' + noRow + '\', \'reduce_' + noRow + '\')"></td>'
                        + '<td><input type="text" name="reduceAddNew" id="reduce_add_new_' + noRow + '" class="form-control" value="' + discount + '" onchange="on_change_reduce(\'price_' + noRow + '\',\'qty_' + noRow + '\', \'intoMoney_' + noRow + '\', \'reduce_' + noRow + '\')"></td>'
                        + '<td><span class="intoMoney" id="diff_money_add_new_' + noRow + '">' + products[0].retail + '</span><span> đ</span></td>'
                        + '<td><button type="button" class="btn btn-danger form-control add-new-prod" title="Xóa"  onclick="del_product(this, \'product-' + noRow + '\')"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</button></td>'
                        + '</tr>');
                    $('[id=qty_add_new_' + noRow + ']').trigger("change");
                    calculateTotal();
                    $("#checkout").prop("disabled", "");
                } else {
                    $("#checkout").prop("disabled", true);
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
            }
        });
    }

    function calculateTotal() {
        let noRow = $("#noRow").val();
        noRow = Number(noRow);
        let totalAmount = 0;
        for (let i = 1; i <= noRow; i++) {
            if ($("[id=diff_money_new_" + i + "]") && $("[id=diff_money_new_" + i + "]").text() !== "") {
                let diff_money = $("[id=diff_money_new_" + i + "]").text();
                console.log(diff_money);
                diff_money = replaceComma(diff_money);
                totalAmount += Number(diff_money);
            }
        }
        let discount = $("#discount_new").val();
        discount = replaceComma(discount);
        let totalCheckout = Number(totalAmount) - Number(discount);

        //
        // // use cash
        // let discount = $("#discount_new").val();
        // if (discount.indexOf("%") > -1) {
        //     discount = replacePercent(discount);
        //     discount = Number(totalCheckout * discount / 100);
        // } else {
        //     discount = replaceComma(discount);
        //     discount = discount == "" ? 0 : Number(discount);
        // }
        // totalReduce += Number(discount);
        // totalCheckout = Number(totalAmount) - Number(totalReduce);
        //
        if(totalCheckout > 0) {
            let payment = replaceComma($("#payment_new").val());
            let repay = 0;
            if (payment != 0 && totalCheckout > 0) {
                repay = Number(payment) - Number(totalCheckout);
            }
            $("#repay_new").text(formatNumber(repay));
            $("#discount_new").prop("disabled", "");
            $("#sel_payment_new").prop("disabled", "");
            $("#payment_new").prop("disabled", "");
        } else {
            $("#repay_new").text(formatNumber(Math.abs(totalCheckout)));
            $("#discount_new").prop("disabled", true);
            $("#sel_payment_new").prop("disabled", true);
            $("#payment_new").prop("disabled", true);
        }
        $("#surcharge").text(formatNumber(totalAmount));
        $("#total_checkout_new").text(formatNumber(totalCheckout));

        // validate_form();
    }

    function del_product_new(e, noRow) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                $(e).parent().parent().removeClass("has-change");
                $(e).parent().parent().find(".new").remove();
                $(e).parent().parent().find(".old").removeClass("old");
                $(e).addClass("hidden");
                $(e).parent().find("[id=productName_" + noRow + "]").removeClass("hidden");
                $(e).parent().find("[id=productName_" + noRow + "]").focus();
                $(e).parent().parent().find(".diff_money").remove();
                toastr.success('Sản phẩm đã được xóa.');
                calculateTotal();
            }
        })
    }

    function del_product(e, p) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                $(e).closest("[id='" + p + "']").remove();
                toastr.success('Sản phẩm đã được xóa.');
                // reloadData(calculateTotal, find_product);
                calculateTotal();
            }
        })
    }

    // function reloadData(calculateTotal, find_product) {
    //     $("#noRow").val(0);
    //     let arr = [];
    //     let qty = [];
    //     $.each($("#tableProd tbody").find("input[name=sku_new]"), function (k, v) {
    //         arr.push(v["value"]);
    //     });
    //     $.each($("#tableProd tbody").find("input[name=qty_new]"), function (k, v) {
    //         qty.push(v["value"]);
    //     });
    //     validate_form();
    //     $("#tableProd tbody").html("");
    //     if (typeof find_product === 'function') {
    //         for (let i = 0; i < arr.length; i++) {
    //             find_new_product(arr[i], qty[i]);
    //         }
    //     }
    //     if (typeof calculateTotal === 'function') {
    //         calculateTotal();
    //     }
    // }
    // function validate_form() {
    //     var noRow = $("#noRow").val();
    //     if (noRow == 0) {
    //         disableCheckOutBtn();
    //         return;
    //     }
    //     var select_payment = $("#sel_payment").val();
    //     if (select_payment == 0) {
    //         var payment = $("#payment").val();
    //         if (payment == "") {
    //             disableCheckOutBtn();
    //             return;
    //         }
    //     }
    //     enableCheckOutBtn();
    // }
    //
    // function onchange_voucher(voucher, event) {
    //     $("#voucher").removeClass("is-invalid");
    //     let c = voucher.substring(0, 2);
    //     c = c.toUpperCase();
    //     if (c == 'VC') {
    //         // voucher
    //         ues_voucher(voucher);
    //         event.preventDefault();
    //     } else {
    //         disableCheckOutBtn();
    //         $("#voucher").addClass("is-invalid");
    //     }
    // }

    function onchange_discount(discount, event) {
        // let c = discount.substring(0, 2);
        // c = c.toUpperCase();
        // if(c == 'VC') {
        // 	// voucher
        // 	console.log('VC');
        // 	$("#flag_discount").val("VC");
        // 	$("#voucher_value").val(discount);
        //     $("#discount").val("");
        // 	ues_voucher();
        //     event.preventDefault();
        // } else if(c == 'QT') {
        // 	// gift
        // 	console.log('QT');
        //     $("#flag_discount").val("QT");
        //     event.preventDefault();
        // } else {
        // diccount
        if (!validate_discount(discount)) {
            event.preventDefault();
            return;
        }
        $("#discount").val(formatNumber(discount));
        calculateTotal();
        event.preventDefault();
        // }
    }

    //function ues_voucher(voucher_code) {
    //    $.ajax({
    //        dataType: 'json',
    //        url: '<?php //echo __PATH__ . 'src/controller/voucher/VoucherController.php' ?>//',
    //        data: {
    //            method: "find_by_code",
    //            code: voucher_code
    //        },
    //        type: 'POST',
    //        success: function (res) {
    //            console.log(res);
    //            if (res.length > 0) {
    //                var status = res[0].status;
    //                if (status !== "undefined") {
    //                    switch (status) {
    //                        case '1':
    //                            Swal.fire({
    //                                type: 'error',
    //                                title: 'Đã xảy ra lỗi',
    //                                text: "Mã khuyến mãi chưa được kích hoạt"
    //                            }).then((result) => {
    //                                if (result.value) {
    //                                    $("#voucher").val("");
    //                                    $("#voucher").trigger("change");
    //                                }
    //                            });
    //                            break;
    //                        case '2':
    //                            if (res[0].valid_date === "expired") {
    //                                Swal.fire({
    //                                    type: 'error',
    //                                    title: 'Đã xảy ra lỗi',
    //                                    text: "Mã khuyến mãi đã hết hạn"
    //                                }).then((result) => {
    //                                    if (result.value) {
    //                                        $("#voucher").val("");
    //                                        $("#voucher").trigger("change");
    //                                    }
    //                                });
    //
    //                            } else {
    //                                let value;
    //                                if (res[0].type == 0) {
    //                                    // cash
    //                                    value = formatNumber(res[0].value);
    //                                } else if (res[0].type == 1) {
    //                                    // percent
    //                                    value = res[0].value + "%";
    //                                }
    //                                $("#voucher_value").val(value);
    //                                let msg = '<div class="alert alert-success alert-dismissible">' +
    //                                    '<button type="button" class="close" aria-hidden="true" onclick="removeVC()">×</button>' +
    //                                    'Mã ' + voucher_code + ' có giá trị giảm ' + value + ' trên tổng đơn hàng!' +
    //                                    '</div>'
    //                                $(".msg").html(msg);
    //                                $("#vcFlag").val(1);
    //                                $("#vcCode").val(voucher_code);
    //                                // $("#voucher").val(value).trigger("change");
    //                                $(".voucher_info").removeClass("hidden");
    //                                calculateTotal();
    //                                $("#voucher").val(voucher_code);
    //                                $("#voucher").prop("disabled", true);
    //                            }
    //                            break;
    //                        case '3':
    //                            Swal.fire({
    //                                type: 'error',
    //                                title: 'Đã xảy ra lỗi',
    //                                text: "Mã khuyến mãi đã được sử dụng"
    //                            }).then((result) => {
    //                                if (result.value) {
    //                                    $("#voucher").val("");
    //                                    $("#voucher").trigger("change");
    //                                }
    //                            });
    //                            break;
    //                        case '4':
    //                            Swal.fire({
    //                                type: 'error',
    //                                title: 'Đã xảy ra lỗi',
    //                                text: "Mã khuyến mãi đã bị khoá"
    //                            }).then((result) => {
    //                                if (result.value) {
    //                                    $("#voucher").val("");
    //                                    $("#voucher").trigger("change");
    //                                }
    //                            });
    //                            break;
    //                    }
    //                } else {
    //                    Swal.fire({
    //                        type: 'error',
    //                        title: 'Đã xảy ra lỗi',
    //                        text: "Mã khuyến mãi không tồn tại"
    //                    }).then((result) => {
    //                        if (result.value) {
    //                            $("#voucher").val("");
    //                            $("#voucher").trigger("change");
    //                        }
    //                    });
    //                }
    //            } else {
    //                Swal.fire({
    //                    type: 'error',
    //                    title: 'Đã xảy ra lỗi',
    //                    text: "Mã khuyến mãi không tồn tại"
    //                }).then((result) => {
    //                    if (result.value) {
    //                        $("#voucher").val("");
    //                        $("#voucher").trigger("change");
    //                    }
    //                });
    //            }
    //            $("#create-order .overlay").addClass("hidden");
    //        },
    //        error: function (data, errorThrown) {
    //            console.log(data.responseText);
    //            console.log(errorThrown);
    //            Swal.fire({
    //                type: 'error',
    //                title: 'Đã xảy ra lỗi',
    //                text: ""
    //            })
    //            $("#create-order .overlay").addClass("hidden");
    //        }
    //    });
    //}

    // function removeVC() {
    //     Swal.fire({
    //         title: 'Bạn có chắc chắn muốn xoá?',
    //         text: "",
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Ok'
    //     }).then((result) => {
    //         if (result.value) {
    //             $(".msg").html("");
    //             $("#vcFlag").val(0);
    //             $("#vcCode").val("");
    //             $("#voucher").val("");
    //             $("#voucher_value").val("");
    //             $("#voucher").prop("disabled", "");
    //             calculateTotal();
    //             toastr.warning('Mã giảm giá đã được xoá.');
    //             $(".voucher_info").addClass("hidden");
    //         }
    //     });
    // }

    function validate_discount(discount) {
        let discount1 = replaceComma(discount);
        if (discount1.indexOf("%") > -1) {
            discount1 = replacePercent(discount1);
            if (discount1 < 1 || discount1 > 50) {
                $("#discount").addClass("is-invalid");
                disableCheckOutBtn();
                // validate_form();
                return false;
            } else {
                $("#discount").removeClass("is-invalid");
                // $("#cash_value").val(discount);
            }
        } else {
            if (!validateNumber(discount1, 'discount')) {
                disableCheckOutBtn();
                // validate_form();
                return false;
            }
            // $("#cash_value").val(discount);
            // var totalCheckout = replaceComma($("#totalCheckout").text());
            // if(discount !== "" && discount < 1000)
            // {
            // 	discount += "000";
            // }
            // $("#discount").val(formatNumber(discount));
            // if(vcFlag == 0 && discount != "" && (discount > totalCheckout/2)) {
            // 	$("#discount").addClass("is-invalid");
            // 	disableCheckOutBtn();
            // 	// validate_form();
            // 	return false;
            // } else {
            // 	$("#discount").removeClass("is-invalid");
            // }
        }
        return true;
    }

    function paymentChange(payment) {
        if (!validateNumber(payment, 'payment')) {
            // disableCheckOutBtn();
            validate_form();
            return;
        }
        var totalCheckout = replaceComma($("#totalCheckout").text());
        payment = replaceComma(payment);
        // if(payment !== "" && payment < 1000)
        // {
        // 	payment += "000";
        // }
        $("#payment").val(formatNumber(payment));
        if (payment != "" && Number(totalCheckout) > 0 && Number(payment) < Number(totalCheckout)) {
            $("#payment").addClass("is-invalid");
            disableCheckOutBtn();
            // validate_form();
            return;
        } else {
            $("#payment").removeClass("is-invalid");
        }
        // enableCheckOutBtn();
        //  validate_form();
        calculateTotal();
    }

    function processDataCheckout() {
        // order information
        let currentOrderId = Number($("#currentOrderId").val());
        let total_amount = replaceComma($("#surcharge").text());
        let total_checkout = replaceComma($("#total_checkout_new").text());
        let payment_type = $("#sel_payment_new").val();
        let customer_payment = replaceComma($("#payment_new").val());
        let repay = replaceComma($("#repay_new").text());
        let flag_print_receipt = $("#flag_print_receipt").is(':checked');
        let discount = replaceComma($("#discount_new").val());
        if (discount.indexOf("%") > -1) {
            discount = discount.replace("%", "");
            discount = (discount * total_checkout) / 100;
        }
        // equal
        let paymentExchangeType = 0;
        if(total_checkout > 0) {
            // Additional guests pay
            paymentExchangeType = 1;
        } else if(total_checkout < 0) {
            // Guest received back
            paymentExchangeType = 1;
        }
        let data = {};
        data["total_amount"] = Math.abs(total_amount);
        data["total_reduce"] = discount;
        data["discount"] = discount;
        data["total_checkout"] = Math.abs(total_checkout);
        data["customer_payment"] = customer_payment;
        data["payment_type"] = payment_type;
        data["repay"] = repay;
        data["customer_id"] = 0;
        data["type"] = 2;// exchange product
        data["flag_print_receipt"] = flag_print_receipt;
        data["voucher_code"] = "";
        data["voucher_value"] = "";
        data["current_order_id"] = currentOrderId;
        data["payment_exchange_type"] = paymentExchangeType;

        //order detail information
        let curr_products = [];
        let exchange_products = [];
        let add_new_products = [];
        $.each($("#tableProd tbody tr"), function (key, value) {
            //product new
            if($(value).hasClass("has-change")) {
                //current product
                let product_id = $(value).find("input[name=prodId]").val();
                let variant_id = $(value).find("input[name=variantId]").val();
                let sku = replaceComma($(value).find("span.product-sku").text());
                let product_name = $(value).find("span.product-name").text();
                let price = replaceComma($(value).find("span.price").text());
                let quantity = $(value).find("span[name=qty]").val();
                let reduce = replaceComma($(value).find("span[name=reduce]").val());
                let reduce_percent = "";
                if (reduce.indexOf("%") > -1) {
                    reduce = reduce.replace("%", "");
                    reduce_percent = reduce;
                    reduce = (reduce * price) / 100;
                } else {
                    reduce_percent = Math.round(reduce * 100 / (price * quantity));
                }
                let curr_product = {};
                curr_product["product_id"] = product_id;
                curr_product["variant_id"] = variant_id;
                curr_product["sku"] = sku;
                curr_product["product_name"] = product_name;
                curr_product["price"] = price;
                curr_product["quantity"] = quantity;
                curr_product["reduce"] = reduce;
                curr_product["reduce_percent"] = reduce_percent;
                curr_product["product_exchange"] = 0;

                curr_products.push(curr_product);

                //exchange_product
                let product_id_new = $(value).find("input[name=prodIdNew]").val();
                let variant_id_new = $(value).find("input[name=variantIdNew]").val();
                let sku_new = replaceComma($(value).find("span.product-sku-new").text());
                let product_name_new = $(value).find("span.product-name-new").text();
                let price_new = replaceComma($(value).find("span.price-new").text());
                let quantity_new = $(value).find("input[name=qtyNew]").val();
                let reduce_new = replaceComma($(value).find("input[name=reduceNew]").val());
                let reduce_percent_new = "";
                if (reduce_new.indexOf("%") > -1) {
                    reduce_new = reduce_new.replace("%", "");
                    reduce_percent_new = reduce_new;
                    reduce_new = (reduce_new * price_new) / 100;
                } else {
                    reduce_percent_new = Math.round(reduce_new * 100 / (price_new * quantity_new));
                }
                let product = {};
                product["product_id"] = product_id_new;
                product["variant_id"] = variant_id_new;
                product["sku"] = sku_new;
                product["product_name"] = product_name_new;
                product["price"] = price_new;
                product["quantity"] = quantity_new;
                product["reduce"] = reduce_new;
                product["reduce_percent"] = reduce_percent_new;
                product["product_exchange"] = sku;

                exchange_products.push(product);
            }
            // add new product
            if($(value).hasClass("add-new-product")) {
                let product_id_add_new = $(value).find("input[name=prodIdAddNew]").val();
                let variant_id_add_new = $(value).find("input[name=variantIdAddNew]").val();
                let sku_add_new = replaceComma($(value).find("span.product-sku-add-new").text());
                let product_name_add_new = $(value).find("span.product-name-add-new").text();
                let price_add_new = replaceComma($(value).find("span.price-add-new").text());
                let quantity_add_new = $(value).find("input[name=qtyAddNew]").val();
                let reduce_add_new = replaceComma($(value).find("input[name=reduceAddNew]").val());
                let reduce_percent_add_new = "";
                if (reduce_add_new.indexOf("%") > -1) {
                    reduce_add_new = reduce_add_new.replace("%", "");
                    reduce_percent_add_new = reduce_add_new;
                    reduce_add_new = (reduce_add_new * price_add_new) / 100;
                } else {
                    reduce_percent_add_new = Math.round(reduce_add_new * 100 / (price_add_new * quantity_add_new));
                }
                let new_product = {};
                new_product["product_id"] = product_id_add_new;
                new_product["variant_id"] = variant_id_add_new;
                new_product["sku"] = sku_add_new;
                new_product["product_name"] = product_name_add_new;
                new_product["price"] = price_add_new;
                new_product["quantity"] = quantity_add_new;
                new_product["reduce"] = reduce_add_new;
                new_product["reduce_percent"] = reduce_percent_add_new;
                new_product["product_exchange"] = 0;

                add_new_products.push(new_product);
            }
        });
        if(curr_products.length <= 0 || exchange_products.length <= 0) {
            Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Bạn hãy thử tạo lại đơn hàng hoặc liên hệ quản trị viên hệ thống!"
                });
            return;
        }
        data["curr_products"] = curr_products;
        data["exchange_products"] = exchange_products;
        data["add_new_products"] = add_new_products;
        console.log(JSON.stringify(data));
        $.ajax({
            dataType: 'json',
            url: '<?php echo __PATH__ . 'src/controller/exchange/ExchangeController.php' ?>',
            data: {
                method: "exchange",
                data: JSON.stringify(data)
            },
            type: 'POST',
            success: function (data) {
                let orderId = data.orderId;
                let filename = data.fileName;
                console.log('filename: ' + filename);
                $(".iframeArea").html("");
                if (typeof filename !== "undefined" && filename !== "") {
                    $(".iframeArea").html('<iframe src="<?php echo __PATH__?>src/controller/sales/pdf/' + filename + '" id="receiptContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                }
                toastr.success('Đơn hàng #' + orderId + ' đã được tạo thành công.');
                resetData();
                if ($flag_print_receipt === true && typeof filename !== "undefined" && filename !== "") {
                    printReceipt();
                }

                $("#create-order .overlay").addClass("hidden");
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Bạn hãy thử tạo lại đơn hàng hoặc liên hệ quản trị viên hệ thống!"
                }).then((result) => {
                    if (result.value) {
                        //resetData();
                    }
                });
                $("#create-order .overlay").addClass("hidden");
            }
        });
    }

    function printReceipt() {
        var objFra = document.getElementById('receiptContent');
        objFra.contentWindow.focus();
        objFra.contentWindow.print();
    }

    function validateProdId(prodId, calculateTotal, find_product) {
        var count = 0;
        $.each($("#tableProd tbody").find("input[name=sku]"), function (k, v) {
            if (v["value"] === prodId) {
                count++;
                var noId = v["id"];
                noId = noId.split("_")[1];
                var qty = $("[id=qty_" + noId + "]").val();
                qty++;
                $("[id=qty_" + noId + "]").val(qty);
                $("[id=qty_" + noId + "]").trigger("change");
                if (typeof calculateTotal === 'function') {
                    calculateTotal();
                }
                return;
            }
        });
        if (count == 0) {
            if (typeof find_product === 'function') {
                find_product(prodId, 1);

            }
            if (typeof calculateTotal === 'function') {
                calculateTotal();
            }
        }
    }




    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }


    // function del_product(e, p) {
    //     Swal.fire({
    //         title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
    //         text: "",
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Ok'
    //     }).then((result) => {
    //         if (result.value) {
    //             $(e).closest("[id='" + p + "']").remove();
    //             toastr.success('Sản phẩm đã được xóa.');
    //             reloadData(calculateTotal, find_product);
    //         }
    //     })
    // }



    function on_change_reduce(priceId, qtyId, intoMoneyId, reduceId) {
        let price = get_price(priceId);
        let qty = get_qty(qtyId);
        if (!validateQty(qty, qtyId)) {
            disableCheckOutBtn();
            // validate_form();
            return;
        }
        let reduce = $("[id=" + reduceId + "]").val();
        reduce = replaceComma(reduce);
        if (reduce.indexOf("%") > -1) {
            reduce = replacePercent(reduce);
            if (reduce < 1 || reduce > 50) {
                $("[id=" + reduceId + "]").addClass("is-invalid");
                disableCheckOutBtn();
                //  validate_form();
                return;
            }
            $("[id=" + reduceId + "]").removeClass("is-invalid");
            reduce = price * qty * reduce / 100;
        } else {
            if (!validateNumber(reduce, reduceId)) {
                disableCheckOutBtn();
                //  validate_form();
                return;
            }
            // if(reduce !== "" && reduce < 1000)
            // {
            // 	reduce = reduce+"000";
            // }
            $("[id=" + reduceId + "]").val(formatNumber(reduce));
            if (reduce !== "" && (reduce < 1000 || reduce > (price * qty) / 2)) {
                $("[id=" + reduceId + "]").addClass("is-invalid");
                disableCheckOutBtn();
                //  validate_form();
                return;
            } else {
                $("[id=" + reduceId + "]").removeClass("is-invalid");
            }

        }

        let intoMoney = price * qty - reduce;
        $("[id=" + intoMoneyId + "]").text(formatNumber(intoMoney));
        //calculateTotal();
    }

    function validateNumber(value, id) {
        if (isNaN(value)) {
            $("[id=" + id + "]").addClass("is-invalid");
            // disableCheckOutBtn();
            //  validate_form();
            return false;
        } else {
            $("[id=" + id + "]").removeClass("is-invalid");
            //$("[id="+id+"]").val(formatNumber(value));
            // enableCheckOutBtn();
            //  validate_form();
            return true;
        }
    }

    function on_change_qty(priceId, qtyId, intoMoneyId, reduceId) {
        var price = get_price(priceId);
        var qty = get_qty(qtyId);
        if (!validateQty(qty, qtyId)) {
            disableCheckOutBtn();
            //  validate_form();
            return;
        }
        // enableCheckOutBtn();
        //  validate_form();
        var intoMoney = price * qty;
        $("[id=" + intoMoneyId + "]").text(formatNumber(intoMoney));
        $("[id=" + reduceId + "]").trigger("change");
        // calculateTotal();
    }


    function get_qty(qtyId) {
        var qty = $("[id=" + qtyId + "]").val();
        qty = qty == "" ? 0 : Number(qty);
        return qty;
    }

    function get_price(priceId) {
        let price = replaceComma($("[id=" + priceId + "]").text());
        price = price == "" ? 0 : Number(price);
        return price;
    }

    function validateQty(qty, qtyId) {
        if (qty <= 0 || !Number.isInteger(qty)) {
            $("[id=" + qtyId + "]").addClass("is-invalid");
            // disableCheckOutBtn();
            // validate_form();
            return false;
        } else {
            $("[id=" + qtyId + "]").removeClass("is-invalid");
            // enableCheckOutBtn();
            // validate_form();
            return true;
        }
    }

    function disableCheckOutBtn() {
        $("#checkout").attr("disabled", "disabled");
    }

    function enableCheckOutBtn() {
        $("#checkout").removeAttr("disabled");
    }

    function replaceComma(value) {
        return value.replace(/,/g, '');
    }

    function replacePercent(value) {
        return value.replace(/%/g, '');
    }

    function resetData() {
        $("#tableProd tbody").html("");
        $("#totalAmount").text(0);
        $("#totalReduce").text(0);
        $("#discount").val("");
        $("#totalCheckout").text(0);
        $("#payment").val("");
        $("#repay").text(0);
        $("#noRow").val(0);
        $(".msg").html("");
        $("#flag_print_receipt").prop("checked", false);
        $(".voucher_info").addClass("hidden");
        $("#voucher").val("");
        $("#voucher_value").val("");
        $("#voucher").prop("disabled", "");
        disableCheckOutBtn();
    }


</script>
</body>
</html>