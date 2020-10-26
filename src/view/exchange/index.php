<?php
require_once("../../common/common.php");
Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="<?php Common::getPath() ?>dist/img/icon.png"/>
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
            color: blue;
        }

        .checkout .h4, h4 {
            font-size: 1.5rem;
            vertical-align: middle;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .checkout .table th, .table td {
             padding: 5px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #dee2e6 !important;
            border-top: none !important;
        }

        .gray {
            color: gray;
        }
        .return-product {
            background: mistyrose !important;
        }
    </style>
</head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-primary">
<!--                <div class="card-header">-->
<!--                    <h3 class="card-title">Danh sách sản phẩm</h3>-->
<!--                </div>-->
                <div class="card-body" style="min-height: 760px;">
                    <div class="row mb-3">
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
                            <label class="hidden">Thêm sản phẩm</label>
                            <input class="form-control hidden" id="productId" type="text" autocomplete="off"
                                   placeholder="Nhập mã sản phẩm">
                        </div>
                    </div>
                    <input type="hidden" id="noRow" value="0">
                    <table class="table table-striped table-hover" id="tableProd">
                        <thead>
                        <tr>
                            <th class="w10">#</th>
                            <th class="hidden"></th>
                            <th class="hidden"></th>
                            <th class="hidden"></th>
                            <th class="hidden"></th>
                            <th class="hidden"></th>
                            <th class="w30">ID</th>
                            <th class="w200">Tên sản phẩm</th>
                            <th class="w80">Size</th>
                            <th class="w60">Màu</th>
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
            <div class="card card-outline card-primary">
<!--                <div class="card-header">-->
<!--                    <h3 class="card-title">Thông tin thanh toán</h3>-->
<!--                </div>-->
                <div class="card-body" style="height: auto;padding: 20px;">
                    <table class="table table-striped table-hover">
                        <tbody>
                        <tr class="customer_info">
                            <td class="right w90 gray">Khách hàng</td>
                            <td class="right p-0 gray">
                                <input type="hidden" id="customer_id" value="0">
<!--                                <span id="customer_name">Khách lẻ</span>-->
                                <div class="d-inline-block">
                                    <span id="customer_name" class="" style="display: flex;">Khách lẻ</span>
                                    <span id="customer_phone" class="d-inline-block hidden"></span>
                                </div>
                                <a href="javascript:void(0)" class="d-inline-block text-warning hidden"
                                   id="show_history">
                                    <i class="fas fa-history"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="right w90 gray">Tổng tiền</td>
                            <td class="right p-0 gray">
                                <span><span id="totalAmount">0</span> <small><sup>đ</sup></small></span>
                            </td>
                        </tr>
                        <tr class="wallet">
                            <td class="right gray">Trừ trong ví</td>
                            <td class="right w110 p-0 gray">
                                <span><span id="wallet">0</span> <small><sup>đ</sup></small></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="right gray">CK trên tổng đơn</td>
                            <td class="right w110 p-0 gray">
                                <span><span id="discount">0</span> <small><sup>đ</sup></small></span>
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
                            <td class="right gray">Tổng Giảm trừ</td>
                            <td class="right w110 p-0 gray">
                                <span><span id="totalReduce">0</span> <small><sup>đ</sup></small></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="right gray">Tổng thanh toán</td>
                            <td class="right w110 p-0 gray">
                                <span><span id="totalCheckout">0</span> <small><sup>đ</sup></small></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="right gray">Khách thanh toán</td>
                            <td class="right w110 p-0 gray">
                                <span class="mb-0"><span id="payment">0</span> <small><sup>đ</sup></small></span><br>
                                <small id="sel_payment"></small>
                            </td>
                        </tr>
                        <tr>
                            <td class="right gray">Trả lại</td>
                            <td class="right w110 p-0 gray">
                                <div class="repay hidden">
                                    <span class="mb-0"><span id="repay">0</span> <small><sup>đ</sup></small></span><br>
                                    <small>Tiền mặt</small>
                                </div>
                                <div class="transferToWallet hidden">
                                    <span class="mb-0"><span id="transferToWallet">0</span> <small><sup>đ</sup></small></span><br>
                                    <small>Chuyển vào ví</small>
                                </div>
                            </td>
                        </tr>
                        <tr class="saved">
                            <td class="right gray">Tích lũy</td>
                            <td class="right w110 p-0 gray">
                                <span><span id="saved">0</span> <small><sup>đ</sup></small></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card card-outline card-primary">
<!--                <div class="card-header">-->
<!--                    <h3 class="card-title">Thông tin thanh toán đơn hàng mới</h3>-->
<!--                </div>-->
                <div class="card-body" style="height: auto;padding: 20px;">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td class="right w130">Tổng tiền</td>
                                <td class="right w90 p-0 gray">
                                    <h4 style="margin: 0;"><span style="color: red;" id="total_amount_new">0</span> <small><sup>đ</sup></small></h4>
                                    <h6 class="hidden"><span style="color: green;" id="add_more_discount">0</span><small><sup>đ</sup></small></h6>
                                </td>
                            </tr>
<!--                            <tr class="discount-old hidden">-->
<!--                                <td class="right w130">Ck trên tổng đơn cũ</td>-->
<!--                                <td class="right w90 p-0 gray">-->
<!--                                    <span id="discount_old">0</span><small><sup>đ</sup></small>-->
<!--                                </td>-->
<!--                            </tr>-->
                            <tr class="wallet hidden">
                                <td class="right w90">Số dư trong ví</td>
                                <td class="right pr-0">
                                    <input type="text" class="form-control text-right" style="font-size: 20px;"
                                           id="totalUsePoint">
                                    <p class="mt-1 mb-0">Quý khách có <span class="text-primary c-pointer" id="totalBallanceInWallet">0</span><sup
                                                class="text-primary">đ</sup> trong ví</p>
                                </td>
                            </tr>
                            <tr class="discount-new hidden">
                                <td class="right">Giảm trừ</td>
                                <td class="right pt-2 pr-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="discount_new" id="discount_new" disabled>
                                        <div class="input-group-append">
                                            <span class="input-group-text">đ</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="total-reduce-new hidden">
                                <td class="right">Tổng Giảm trừ</td>
                                <td class="right p-0">
                                    <h4 style="margin: 0;"><span id="totalReduceNew">0</span><small><sup>đ</sup></small></h4>
                                </td>
                            </tr>
                            <tr>
                                <td class="right">Tổng thanh toán</td>
                                <td class="right p-0">
                                    <h4 style="margin: 0;"><span id="total_checkout_new">0</span><small><sup>đ</sup></small></h4>
                                </td>
                            </tr>
                            <tr class="payment-new hidden">
                                <td class="right">Khách thanh toán</td>
                                <td class="right pr-0">
                                    <select class="form-control" name="sel_payment_new" id="sel_payment_new" disabled>
                                        <option value="0" selected="selected">Tiền mặt</option>
                                        <option value="1">Chuyển khoản</option>
                                        <option value="2">Nợ</option>
                                    </select>
                                    <div class="input-group mt-2">
                                        <input type="text" class="form-control right" name="payment_new" id="payment_new" disabled>
                                        <div class="input-group-append">
                                            <span class="input-group-text">đ</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="saved-point">
                                <td class="right pl-0" colspan="2">
                                    <p class="mb-1">Quý khách sẽ tích lũy được <span class="text-primary"
                                                                                     id="total_saved_point">0</span> <sup
                                                class="text-primary">đ</sup> cho đơn hàng này.</p>
                                </td>
                            </tr>
                            <tr class="repay-new hidden">
                                <td class="right pl-0 pr-0">
                                    <span>Trả lại</span>
                                    <div class="form-group mt-3" style="">
                                        <a href="javascript:void(0)" class="ml-3" id="reverse"><i class="fas fa-retweet"></i></a>
                                    </div>
<!--                                    <div class="repay_method hidden">-->
<!--                                        <div class="form-check text-left">-->
<!--                                            <label class="form-check-label">-->
<!--                                                <input type="radio" class="form-check-input" name="repayType" checked value="0">Tiền mặt-->
<!--                                            </label>-->
<!--                                        </div>-->
<!--                                        <div class="form-check text-left">-->
<!--                                            <label class="form-check-label">-->
<!--                                                <input type="radio" class="form-check-input" name="repayType" value="1">Chuyển vào Ví-->
<!--                                            </label>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                </td>
                                <td class="left">
<!--                                    <span style="font-size: 20px;" id="repay_new">0 <small><sup>đ</sup></small></span>-->
<!--                                    <input type="text" class="form-control right" name="repay_new" id="repay_new">-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="cash">Tiền mặt</label>-->
                                        <input type="text" class="form-control mb-2 text-right" placeholder="Tiền mặt" id="repay_new">
<!--                                    </div>-->
<!--                                    <div class="form-group">-->
<!--                                        <label for="tranferWallet">Chuyển vào ví</label>-->
                                        <input type="text" class="form-control text-right" placeholder="Tiền chuyển vào ví" id="tranferToWallet_new">
<!--                                    </div>-->
                                </td>
                            </tr>
<!--                            <tr>-->
<!--                                <td class="right">Trả lại</td>-->
<!--                                <td class="right pr-0">-->
<!--                                    <div class="input-group mb-3">-->
<!--                                        <input type="text" class="form-control right" name="repay_new" id="repay_new" disabled>-->
<!--                                        <div class="input-group-append">-->
<!--                                            <span class="input-group-text">đ</span>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </td>-->
<!--                            </tr>-->
                        </tbody>
                    </table>
                    <div class="row mt-2 col-md-12 ml-0">
                        <div class="left skin-line">
                            <label for="flat-checkbox-1">
                                <input type="checkbox" id="flag_print_receipt" checked> In hóa đơn
                            </label>
                        </div>
                    </div>
                    <div class="row col-md-12 no-margin">
                        <button type="button" class="btn btn-success form-control" id="checkout" title="Thanh toán">
                            <i class="fas fa-shopping-basket"></i> Thanh toán
                        </button>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</section>
<div class="iframeArea" style="visibility: hidden;"></div>
<?php require_once '../wallet/showHistory.php'; ?>
<?php require_once('../../common/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        set_title("Đổi sản phẩm");
        $("#orderId").change(function () {
            let orderId = $(this).val();
            if(!orderId || orderId === "") {
                return;
            }
            if(orderId.length > 8) {
                orderId = orderId.substr(8, orderId.length);
            }
            $("#currentOrderId").val(orderId);
            find_order(orderId);
        });

        let order_id = "<?php echo (isset($_GET['oid']) ? $_GET['oid'] : '') ?>";
        if(order_id) {
            $("#currentOrderId").val(order_id);
            find_order(order_id);
        }

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
                    window.location.href = "<?php Common::getPath() ?>src/view/exchange";
                }
            });
        });

        $("#productId").change(function () {
            let sku = $(this).val();
            if (sku.indexOf('SP') > -1) {
                sku = sku.replace("SP", "");
                sku = parseInt(sku);
            }
            validateProdId(sku, calculateTotal, find_new_product, 1);
            // find_new_product(sku);
            $(this).val("");
        });

        $("#discount_new").change(function (event) {
            let discount = $(this).val();
            onchange_discount(discount, event);
            event.preventDefault();
        });
        $('#discount').keypress(function (event) {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                let discount = $(this).val();
                onchange_discount(discount, event);
                event.preventDefault();
            }
        });

        // $("#voucher").change(function (event) {
        //     let voucher = $(this).val();
        //     onchange_voucher(voucher, event);
        //     event.preventDefault();
        // });
        $('#voucher').keypress(function (event) {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                let voucher = $(this).val();
                onchange_voucher(voucher, event);
                event.preventDefault();
            }
        });

        $("#payment_new").on('change',function () {
            let payment = $(this).val();
            payment = replaceComma(payment);
            paymentChange(payment);
        });
        // $('#payment_new').keypress(function (event) {
        //     let keycode = (event.keyCode ? event.keyCode : event.which);
        //     if (keycode == '13') {
        //         let payment = $(this).val();
        //         payment = replaceComma(payment);
        //         paymentChange(payment);
        //     }
        // });
        $("#checkout").click(function () {
            if(validate_form_checkout()) {
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
            }
        });
        $("#sel_payment").change(function () {
            if ($(this).val() === 0) {
                $("#payment").show().focus();
                validate_form();
            } else {
                $("#payment").val("").hide();
                validate_form();
            }
        });
        $("#sel_discount").change(function () {
            $("#discount").focus();
        });
        $("#repay_new").on("change", function(){
            let val = $(this).val();
            $(this).val(formatNumber(val));
        });

        $("#totalBallanceInWallet").click(function () {
            let total_checkout_new = Number(replaceComma($("#total_checkout_new").text()));
            if(total_checkout_new > 0) {
                $("#totalUsePoint").val($(this).text()).trigger("change");
            }
        });
        totalUsedPointChange();
        transferToWallet();
        reverse_repay();

        $("#show_history").click(function () {
            let customer_id = $("#customer_id").val();
            let customer_name = $("#customer_name").text();
            let customer_phone = $("#customer_phone").text().trim();
            show_history(customer_id, customer_name, customer_phone);
        });
    });
    
    function validate_form_checkout() {
        let total_checkout_new = Number(replaceComma($("#total_checkout_new").text()));
        let payment_new = $("#payment_new").val();
        if(total_checkout_new > 0) {
            if(!payment_new) {
                $("#payment_new").addClass("is-invalid").focus();
                toastr.error("Bạn chưa nhập số tiền thanh toán");
                return false;
            } else {
                $("#payment_new").removeClass("is-invalid");
            }
        }
        return true;
    }

    function reverse_repay() {
        $("#reverse").click(function () {
            let repay = $("#repay_new").val();
            let transferToWallet = $("#tranferToWallet_new").val();
            $("#repay_new").val(transferToWallet);
            $("#tranferToWallet_new").val(repay);
        });
    }

    function transferToWallet() {
        $("#tranferToWallet_new").on('change',function() {
            let value = $(this).val();
            let repayNew = Number(replaceComma($("#repay_new").val()));
            if(value && repayNew) {
                if(isNaN(value) || Number(value) > repayNew) {
                    $(this).addClass("is-invalid");
                    return;
                } else {
                    $(this).removeClass("is-invalid");
                }
                repayNew = repayNew - Number(value);
                $("#repay_new").val(formatNumber(repayNew));
            }
            $(this).val(formatNumber(value));
        });
    }

    function totalUsedPointChange() {
        $("#totalUsePoint").on('change',function () {
            let totalBallanceInWallet = Number(replaceComma($("#totalBallanceInWallet").text()));
            let totalUsePoint = Number(replaceComma($(this).val()));
            if(totalUsePoint !== 0 && totalUsePoint > totalBallanceInWallet) {
                $(this).addClass("is-invalid");
                toastr.error("Số tiền sử dụng không được vượt quá số tiền trong ví");
                disableCheckOutBtn();
                return;
            } else {
                $(this).removeClass("is-invalid");
                enableCheckOutBtn();
            }
            $(this).val(formatNumber(totalUsePoint));
            // calculate_total_point();
            recalculateTotalReduce();
            recalculateTotalCheckout();
            calculate_repay_new();
        });
    }

    function returnBtn(e, noRow) {
        $(e).parent().parent().addClass("return-product").addClass("is_return");
        $(e).parent().children("#cancel_return_" + noRow).removeClass("hidden");
        $(e).parent().children("#exchange_" + noRow).addClass("hidden");
        $(e).addClass("hidden");
        calculateTotal();
    }
    function cancelReturnBtn(e, noRow) {
        $(e).parent().children("#productName_" + noRow).addClass("hidden");
        $(e).parent().children("#productName_" + noRow).val("");
        $(e).addClass("hidden");
        $(e).parent().children("#exchange_" + noRow).removeClass("hidden");
        $(e).parent().children("#return_" + noRow).removeClass("hidden");
        $(e).parent().parent().removeClass("return-product").removeClass("is_return");
        calculateTotal();
    }

    function exchangeBtn(e, noRow) {
        $(e).parent().children("#productName_" + noRow).val("");
        $(e).parent().children("#productName_" + noRow).removeClass("hidden");
        $(e).parent().children("#productName_" + noRow).focus();
        $(e).addClass("hidden");
        $(e).parent().children("#cancelExchange_" + noRow).removeClass("hidden");
        $(e).parent().children("#return_" + noRow).addClass("hidden");
    }

    function cancelExchangeBtn(e, noRow) {
        $(e).parent().children("#productName_" + noRow).val("").addClass("hidden");
        $(e).addClass("hidden");
        $(e).parent().children("#exchange_" + noRow).removeClass("hidden");
        $(e).parent().children("#return_" + noRow).removeClass("hidden");    
    }

    function find_order(orderId) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/exchange/ExchangeController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "find_order",
                orderId: orderId
            },
            success: function (order) {
                // console.log(JSON.stringify(order));
                $.each(order, function (key, value) {
                    if (value.length > 0) {
                        $("#orderId").val("").addClass("hidden");
                        let details = value[0].details;
                        for (let i = 0; i < details.length; i++) {
                            let reduce = details[i].discount;
                            if (reduce === 0) {
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
                                + '<td class="hidden"><input type="hidden" name="profit" id="profit_' + noRow + '" class="form-control" value="' + details[i].profit + '"></td>'
                                + '<td><span class="product-sku" id="sku_' + noRow + '">' + details[i].sku + '</span></td>'
                                + '<td><span class="product-name" id="name_' + noRow + '">' + details[i].name + '</span></td>'
                                + '<td><span class="size" id="size_' + noRow + '">' + details[i].size + '</span></td>'
                                + '<td><span class="color" id="color_' + noRow + '">' + details[i].color + '</span></td>'
                                + '<td><div><span class="price" id="price_' + noRow + '">' + details[i].retail + ' <small><sup>đ</sup></small></span></div></td>'
                                + '<td><span class="qty" id="qty_' + noRow + '">' + details[i].quantity + '</span></td>'
                                + '<td><span class="reduce" id="reduce_' + noRow + '">' + formatNumber(reduce) + '</span></td>'
                                + '<td><div><span class="intoMoney" id="intoMoney_' + noRow + '">' + details[i].intoMoney + '</span> <small><sup>đ</sup></small></div></td>'
                                + '<td><button type="button" id="exchange_' + noRow + '" class="btn btn-info form-control d-inline-block w50" onclick="exchangeBtn(this, ' + noRow + ')" title="Đổi hàng"><i class="fas fa-sync"></i></button>'
                                + '<button type="button" id="cancelExchange_' + noRow + '" class="btn btn-danger form-control hidden" onclick="cancelExchangeBtn(this, ' + noRow + ')" title="Hủy đổi hàng"><i class="fas fa-ban"></i> Hủy</button>'
                                + '<input type="text" value="" placeholder="Nhập mã sản phẩm" id="productName_' + noRow + '" onchange="find_product(this, '+details[i].sku+', 1, ' + noRow + ')" class="hidden form-control mt-2 mb-2">'
                                + '<button type="button" id="del_' + noRow + '" onclick="del_product_new(this, ' + noRow + ')" class="btn btn-danger hidden form-control mt-2 mb-2" title="Xóa sản phẩm đổi"><i class="fas fa-trash"></i> Xóa</button>'
                                + '<button type="button" id="return_' + noRow + '" class="btn btn-warning form-control d-inline-block w50" onclick="returnBtn(this, ' + noRow + ')" title="Trả hàng"><i class="fas fa-undo-alt"></i></button>'
                                + '<button type="button" id="cancel_return_' + noRow + '" class="btn btn-danger form-control hidden" onclick="cancelReturnBtn(this, ' + noRow + ')" title="Hủy Trả hàng"><i class="fas fa-ban"></i> Hủy</button>'
                                + '</td>'
                                + '</tr>');
                        }
                        // $("#productId").prop("disabled", "");
                        // $("#discount").prop("disabled", "");
                        $("#voucher").prop("disabled", "");
                        // $("#sel_payment").prop("disabled", "");
                        // $("#payment").prop("disabled", "");

                        $("#orderInfo").text("Thông tin hoá đơn #" + orderId).removeClass("hidden");
                        // $("#orderInfo").removeClass("hidden");
                        $("#orderDate").text("Ngày mua hàng: " + value[0].order_date).removeClass("hidden");
                        // $("#orderDate").removeClass("hidden");
                        $("#productId").removeClass("hidden").prop("disabled", "").prev("label").removeClass("hidden");
                        // $("#productId").prev("label").removeClass("hidden");
                        $("#cancel_exchange").removeClass("hidden");
                        if(value[0].customer_id && Number(value[0].customer_id) > 0) {
                            $("#customer_info").removeClass("hidden");
                            $("#customer_id").val(value[0].customer_id);
                            $("#customer_name").text(value[0].customerName);
                            $("#customer_phone").text(value[0].phone).removeClass("hidden");
                            $("#show_history").removeClass("hidden");
                            setTimeout(function () {
                                get_total_point(value[0].customer_id);
                            },200);
                        } else {
                            $("#customer_info").addClass("hidden");
                            $("#customer_id").val(0);
                            $("#customer_name").text('Khách lẻ');
                            $("#customer_phone").text("").addClass("hidden");
                            $("#show_history").addClass("hidden");
                        }
                        if(value[0].wallet && Number(value[0].wallet) > 0) {
                            $(".wallet").removeClass("hidden");
                            $("#wallet").text(formatNumber(value[0].wallet));
                        } else {
                            $(".wallet").addClass("hidden");
                            $("#wallet").text('');
                        }
                        if(value[0].saved && Number(value[0].saved) > 0) {
                            $(".saved").removeClass("hidden");
                            $("#saved").text(formatNumber(value[0].saved));
                        } else {
                            $(".saved").addClass("hidden");
                            $("#saved").text('');
                        }
                        $("#totalAmount").text(value[0].total_amount);
                        $("#discount").text(value[0].discount).prop("disabled", "");
                        $("#totalReduce").text(value[0].total_reduce);
                        $("#totalCheckout").text(value[0].total_checkout);
                        // if(value[0].discount) {
                        //     $("#discount_old").text("-"+value[0].discount);
                        //     $(".discount-old").removeClass("hidden");
                        // } else {
                        //     $(".discount-old").addClass("hidden");
                        // }
                        // $("#repay").text(value[0].repay);
                        if(value[0].repay) {
                            $("#repay").text(formatNumber(value[0].repay));
                            $(".repay").removeClass("hidden");
                        } else {
                            $("#repay").text("");
                            $(".repay").addClass("hidden");
                        }
                        if(value[0].transfer_to_wallet) {
                            $("#transferToWallet").text(formatNumber(value[0].transfer_to_wallet));
                            $(".transferToWallet").removeClass("hidden");
                        } else {
                            $("#transferToWallet").text("");
                            $(".transferToWallet").addClass("hidden");
                        }
                        // else {
                        //     $("#repay_type").text('');
                        // }
                        $("#payment").prop("disabled", "").text(value[0].customer_payment);
                        if (value[0].customer_payment && value[0].customer_payment !== 0) {
                            let payment = 'Tiền mặt';
                            switch (value[0].payment_type) {
                                case 1:
                                    payment = "Chuyển khoản";
                                    break;
                                case 2:
                                    payment = "Nợ";
                            }
                            $("#sel_payment").prop("disabled", "").text(payment);
                        }
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Đã xảy ra lỗi',
                            text: "Không tìm thấy đơn hàng #" + orderId
                        });
                    }
                });
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

    function validateProdId(sku, calculateTotal, find_new_product)
    {
        let count_sku_old = 0;
        $.each($("#tableProd tbody").find("input[name=sku]"), function(k, v) {
            if(v["value"] === sku) {
                count_sku_old++;
                Swal.fire({
                    type: 'error',
                    title: 'Sản phẩm đã tồn tại',
                    html: "Hãy chọn sản phẩm khác hoặc tạo đơn hàng mới <a href='<?php Common::getPath() ?>src/view/sales/'>tại đây</a>!"
                });
                return;
            }
        });
        let count_sku_new = 0;
        $.each($("#tableProd tbody").find("input[name=skuNew]"), function(k, v) {
            count_sku_new++;
            if(v["value"] === sku) {
                Swal.fire({
                    type: 'error',
                    title: 'Sản phẩm đã tồn tại',
                    html: "Hãy chọn sản phẩm khác hoặc tạo đơn hàng mới <a href='<?php Common::getPath() ?>src/view/sales/'>tại đây</a>!"
                });
                return;
            }
        });
        if(count_sku_new == 0) {
            Swal.fire({
                type: 'error',
                title: 'Không tồn tại sản phẩm đổi',
                html: "Nếu không đổi sản phẩm thì hãy tạo đơn hàng mới <a href='<?php Common::getPath() ?>src/view/sales/'>tại đây</a>!"
            });
            return;
        } else {
            if(typeof find_new_product  === 'function')
            {
                find_new_product(sku, 1);

            }
            if(typeof calculateTotal  === 'function')
            {
                calculateTotal();
            }
        }
    }

    function find_product(e, curr_sku, qty, noRow) {
        let sku = $(e).val();
        if (sku === "") {
            return;
        }
        if(sku == curr_sku) {
            console.log("sku = curr_sku");
            Swal.fire({
                type: 'error',
                title: 'Sản phẩm đã tồn tại',
                text: "Sản phẩm đổi phải khác sản phẩm đã mua!"
            });
            $(e).val("");
            return;
        }
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/sales/processCheckout.php',
            type: "POST",
            dataType: "json",
            data: {
                type: "find_product",
                sku: sku
            },
            success: function (products) {
                if(products.length > 0) {
                    let retail = products[0].retail;
                    retail = replaceComma(retail);
                    let into_money = 0;
                    let discount = products[0].discount;
                    if (discount == 0) {
                        discount = "";
                        into_money = retail;
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
                    $(e).parent().parent().find("td:eq(3)").append('<input type="hidden" name="profitNew" id="profit_new_' + noRow + '" class="form-control new" value="' + products[0].profit + '">');
                    $(e).parent().parent().find("td:eq(4)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(4)").append('<input type="hidden" name="skuNew" id="sku_new_' + noRow + '" class="form-control new" value="' + products[0].sku + '">');
                    $(e).parent().parent().find("td:eq(5)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(5)").append('<input type="hidden" name="orderDetailIdNew" id="orderDetailId_new_' + noRow + '" class="form-control new" value="' + products[0].order_detail_id + '">');
                    $(e).parent().parent().find("td:eq(6)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(6)").append('<span class="product-sku-new new" id="sku_new_' + noRow + '">' + products[0].sku + '</span>');
                    $(e).parent().parent().find("td:eq(7)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(7)").append('<span class="product-name-new new" id="name_new_' + noRow + '">' + products[0].name + '</span>');
                    $(e).parent().parent().find("td:eq(8)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(8)").append('<span class="size-new new" id="size_new_' + noRow + '">' + products[0].size + '</span>');
                    $(e).parent().parent().find("td:eq(9)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(9)").append('<span class="color-new new" id="color_new_' + noRow + '">' + products[0].color + '</span>');
                    $(e).parent().parent().find("td:eq(10)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(10)").append('<span class="price-new new" id="price_new_' + noRow + '">' + products[0].retail + '</span><sup>đ</sup>');
                    $(e).parent().parent().find("td:eq(11)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(11)").append('<input type="number" name="qtyNew" id="qty_new_' + noRow + '" class="new form-control" min="1" value="' + qty + '" onblur="on_change_qty(\'price_new_' + noRow + '\', \'qty_new_' + noRow + '\', \'intoMoney_new_' + noRow + '\', \'reduce_new_' + noRow + '\', \'intoMoney_' + noRow + '\', \'diff_money_new_' + noRow + '\')">');
                    $(e).parent().parent().find("td:eq(12)").children(":first").addClass("old");
                    $(e).parent().parent().find("td:eq(12)").append('<input type="text" name="reduceNew" id="reduce_new_' + noRow + '" class="new form-control" value="' + discount + '" onblur="on_change_reduce(\'price_new_' + noRow + '\',\'qty_new_' + noRow + '\', \'intoMoney_new_' + noRow + '\', \'reduce_new_' + noRow + '\', \'intoMoney_' + noRow + '\', \'diff_money_new_' + noRow + '\')">');
                    $(e).parent().parent().find("td:eq(13)").children(":first").addClass("old");
                    let into_money_old = $(e).parent().parent().find("td:eq(13)").children(":first").text();
                    into_money_old = replaceComma(into_money_old);
                    into_money_old = into_money_old.replace("đ","");
                    let diff_money = into_money - into_money_old;
                    let style = "color: gray;";
                    if(diff_money > 0 ) {
                        style = "color: green;";
                    } else if(diff_money < 0 ) {
                        style = "color: red;";
                    }
                    $(e).parent().parent().find("td:eq(13)").append('<div><span class="intoMoney new" id="intoMoney_new_' + noRow + '">' + formatNumber(into_money) + '</span><sup>đ</sup></div>');
                    $(e).parent().parent().find("td:eq(13)").append('<div class="old diff_money" style="'+style+'"><span id="diff_money_new_' + noRow + '">' + formatNumber(diff_money) + '</span><sup> đ</sup></div>');
                    $(e).parent().find("[id=cancelExchange_" + noRow + "]").addClass("hidden");
                    $(e).parent().find("[id=del_" + noRow + "]").removeClass("hidden");
                    $(e).addClass("hidden").val("");
                    calculateTotal();
                    $("#checkout").prop("disabled", "");
                } else {
                    $("#checkout").prop("disabled", true);
                    Swal.fire({
                        type: 'error',
                        title: 'Không tồn tại sản phẩm',
                        text: "Sản phẩm #"+sku+" không tồn tại!"
                    });
                    $(e).val("");
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
            url: '<?php Common::getPath() ?>src/controller/sales/processCheckout.php',
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
                        + '<td class="hidden"><input type="hidden" name="profitAddNew" id="profit_add_new_' + noRow + '" class="form-control" value="' + products[0].profit + '"></td>'
                        + '<td><span class="product-sku-add-new">' + products[0].sku + '</span></td>'
                        + '<td><span class="product-name-add-new" id="name_add_new_' + noRow + '">' + products[0].name + '</span></td>'
                        + '<td><span class="size-add-new" id="size_add_new_' + noRow + '">' + products[0].size + '</span></td>'
                        + '<td><span class="color-add-new" id="color_add_new_' + noRow + '">' + products[0].color + '</span></td>'
                        + '<td><span class="price-add-new" id="price_add_new_' + noRow + '">' + products[0].retail + '</span><sup> đ</sup></td>'
                        + '<td><input type="number" name="qtyAddNew" id="qty_add_new_' + noRow + '" class="form-control" min="1" value="'+qty+'" onchange="on_change_qty(\'price_' + noRow + '\', \'qty_' + noRow + '\', \'intoMoney_' + noRow + '\', \'reduce_' + noRow + '\')"></td>'
                        + '<td><input type="text" name="reduceAddNew" id="reduce_add_new_' + noRow + '" class="form-control" value="' + discount + '" onblur="on_change_reduce(\'price_add_new_' + noRow + '\',\'qty_add_new_' + noRow + '\', \'intoMoney_add_new_' + noRow + '\', \'reduce_add_new_' + noRow + '\',\'\', \'diff_money_add_new_' + noRow + '\')"></td>'
                        + '<td><span class="intoMoney" id="diff_money_add_new_' + noRow + '">' + products[0].retail + '</span><sup> đ</sup></td>'
                        + '<td><button type="button" class="btn btn-danger form-control add-new-prod" title="Xóa"  onclick="del_product(this, \'product-' + noRow + '\')"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</button></td>'
                        + '</tr>');
                    setTimeout(function () {
                        $('[id=reduce_add_new_' + noRow + ']').trigger("blur");
                    },50);
                    calculateTotal();
                    $("#checkout").prop("disabled", "");
                } else {
                    $("#checkout").prop("disabled", true);
                    Swal.fire({
                        type: 'error',
                        title: 'Không tồn tại sản phẩm',
                        text: "Sản phẩm #"+sku+" không tồn tại!"
                    });
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
        let totalAmount = calculateTotalAmountInList();
        // let discountOld = discount_old(totalAmount);
        let discountNew =  discount_new(totalAmount);
        // let totalCheckout = Number(totalAmount) - Number(discountNew) + Number(discountOld);
        let totalCheckout = Number(totalAmount) - Number(discountNew);
        if(totalCheckout > 0) {
            $("#discount_new").prop("disabled", "");
            $(".discount-new").removeClass("hidden");
        } else {
            $("#discount_new").prop("disabled", true);
            $(".discount-new").addClass("hidden");
        }
        $("#total_amount_new").text(formatNumber(totalAmount));
        $("#total_checkout_new").text(formatNumber(totalCheckout));
        calculate_total_point();
        recalculateTotalReduce();
        recalculateTotalCheckout();
    }
    function calculate_total_point() {
        let currentPoint = Number(replaceComma($("#totalBallanceInWallet").text()));
        if (currentPoint && Number(currentPoint) !== 0) {
            let total_checkout_new = Number(replaceComma($("#total_checkout_new").text()));
            let totalUsePoint = 0;
            if (total_checkout_new > 0) {
                if(total_checkout_new > currentPoint) {
                    totalUsePoint = currentPoint;
                } else {
                    totalUsePoint = total_checkout_new;
                }
                $("#totalUsePoint").val(formatNumber(totalUsePoint)).removeClass("hidden");
                recalculateTotalReduce();
                recalculateTotalCheckout();
            // } else if(total_checkout_new < 0) {
                // if(total_checkout_new < currentPoint) {
                //     totalUsePoint = currentPoint;
                // } else {
                //     totalUsePoint = total_checkout_new;
                // }
                // $("#totalUsePoint").val(formatNumber(totalUsePoint)).removeClass("hidden");
                // recalculateTotalReduce();
                // recalculateTotalCheckout();
            } else {
                $("#totalUsePoint").addClass("hidden");
                $("#totalReduceNew").text("0");
                $(".total-reduce-new").addClass("hidden");
            }
        } else {
            $("#totalUsePoint").addClass("hidden");
        }
        payment_box();
        calculate_saved_point();
        calculate_repay_new();
    }
    function calculateTotalAmountInList() {
        let noRow = $("#noRow").val();
        noRow = Number(noRow);
        let totalAmount = 0;
        for (let i = 1; i <= noRow; i++) {
            let isReturn = $("#order_"+i).attr("class");
            if(isReturn && isReturn.indexOf("is_return") > -1) {
                totalAmount += 0 - Number(replaceComma($("#intoMoney_"+i).text()));
            } else {
                if ($("[id=diff_money_new_" + i + "]") && $("[id=diff_money_new_" + i + "]").text() !== "") {
                    totalAmount += Number(replaceComma($("[id=diff_money_new_" + i + "]").text()));
                }
                if ($("[id=diff_money_add_new_" + i + "]") && $("[id=diff_money_add_new_" + i + "]").text() !== "") {
                    totalAmount += Number(replaceComma($("[id=diff_money_add_new_" + i + "]").text()));
                }
            }
        }
        return totalAmount;
    }

    function discount_old(totalAmount) {
        let discountOld = replaceComma($("#discount").text());
        if(totalAmount >= 0 || discountOld == "") {
            discountOld = 0;
            $("#add_more_discount").addClass("hidden");
            $("#add_more_discount span").text("");
        } else if(discountOld > 0) {
            $("#add_more_discount").removeClass("hidden");
            $("#add_more_discount span").text("+"+formatNumber(discountOld));
        }
        return Number(discountOld);
    }

    function discount_new(totalAmount) {
        let discountNew = replaceComma($("#discount_new").val());
        if(discountNew.indexOf("%") > -1) {
            discountNew = Number(replacePercent(discountNew));
            discountNew = discountNew * totalAmount / 100;
        }
        return Number(discountNew);
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
                $(e).parent().find("[id=cancelExchange_" + noRow + "]").removeClass("hidden");
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
                calculateTotal();
            }
        })
    }
    function onchange_discount(discount, event) {
        if (!validate_discount(discount)) {
            event.preventDefault();
            return;
        }
        $("#discount_new").val(formatNumber(discount));
        calculateTotal();
        event.preventDefault();
    }
    function validate_discount(discount) {
        let discount1 = replaceComma(discount);
        if (discount1.indexOf("%") > -1) {
            discount1 = replacePercent(discount1);
            if (discount1 < 1 || discount1 > 100) {
                $("#discount_new").addClass("is-invalid");
                disableCheckOutBtn();
                return false;
            } else {
                $("#discount_new").removeClass("is-invalid");
            }
        } else {
            if (discount1 !== "" && !validateNumber(discount1, 'discount_new')) {
                disableCheckOutBtn();
                return false;
            }
        }
        return true;
    }

    function paymentChange(payment) {
        if (!validateNumber(payment, 'payment_new')) {
            validate_form();
            return;
        }
        let totalCheckout = replaceComma($("#total_checkout_new").text());
        payment = replaceComma(payment);
        if(payment !== "" && payment < 1000)
        {
        	payment += "000";
        }
        $("#payment_new").val(formatNumber(payment));
        if (payment !== "" && Number(totalCheckout) > 0 && Number(payment) < Number(totalCheckout)) {
            $("#payment_new").addClass("is-invalid");
            disableCheckOutBtn();
            return;
        } else {
            $("#payment_new").removeClass("is-invalid");
            enableCheckOutBtn();
        }
        calculate_repay_new();
    }

    function processDataCheckout() {
        // order information
        let currentOrderId = Number($("#currentOrderId").val());
        let total_amount = replaceComma($("#total_amount_new").text());
        let total_checkout = replaceComma($("#total_checkout_new").text());
        let payment_type = $("#sel_payment_new").val();
        let customer_payment = replaceComma($("#payment_new").val());
        let flag_print_receipt = $("#flag_print_receipt").is(':checked');
        // let discount_old = replaceComma($("#discount").text());
        let discount = replaceComma($("#discount_new").val());
        if (discount.indexOf("%") > -1) {
            discount = discount.replace("%", "");
            discount = (discount * total_checkout) / 100;
        }
        let total_reduce = replaceComma($("#totalReduceNew").text());
        // equal
        let paymentExchangeType = 0;
        if(total_checkout > 0) {
            // Additional guests pay
            paymentExchangeType = 1;
        } else if(total_checkout < 0) {
            // Guest received back
            paymentExchangeType = 2;
        }
        let repay = replaceComma($("#repay_new").val());
        let transferToWallet = replaceComma($("#tranferToWallet_new").val());
        // let repayType = 0;
        let totalBallanceInWallet = 0;
        let totalUsePoint = 0;
        let totalRemainPoint = 0;
        let totalSavedPoint = 0;
        // let walletRepay = 0;
        let customer_id = $("#customer_id").val();
        if(customer_id && Number(customer_id) > 0) {
            // repayType = Number($("input[name='repayType']:checked").val());
            // if(repayType === 1) {
            //     walletRepay = Number(repay);
            // }
            totalBallanceInWallet = Number(replaceComma($("#totalBallanceInWallet").text()));
            totalUsePoint = Number(replaceComma($("#totalUsePoint").val()));
            if (!totalBallanceInWallet || totalBallanceInWallet === 0) {
                totalUsePoint = 0;
            }
            totalRemainPoint = totalBallanceInWallet - totalUsePoint;
            totalSavedPoint = Number(replaceComma($("#total_saved_point").text()));
        }
        let data = {};
        data["total_amount"] = total_amount;
        data["total_reduce"] = total_reduce;
        // data["discount_old"] = discount_old;
        data["discount"] = discount;
        data["wallet"] = totalUsePoint;
        data["total_checkout"] = total_checkout;
        data["customer_payment"] = customer_payment;
        data["payment_type"] = payment_type;
        data["repay"] = repay;
        data["transfer_to_wallet"] = transferToWallet;
        // data["repay_type"] = repayType;
        data["customer_id"] = customer_id;
        data["type"] = 2;// exchange product
        data["flag_print_receipt"] = flag_print_receipt;
        data["voucher_code"] = "";
        data["voucher_value"] = "";
        data["current_order_id"] = currentOrderId;
        data["payment_exchange_type"] = paymentExchangeType;
        data["source"] = 0;// shop
        data["wallet_used"] = totalUsePoint;
        data["wallet_saved"] = totalSavedPoint;
        data["wallet_repay"] = transferToWallet;
        data["wallet_remain"] = totalRemainPoint;

        //order detail information
        let curr_products = [];
        let exchange_products = [];
        let add_new_products = [];
        let return_products = [];
        $.each($("#tableProd tbody tr"), function (key, value) {
            //product new
            if($(value).hasClass("has-change")) {
                //current product
                let product_id = $(value).find("input[name=prodId]").val();
                let variant_id = $(value).find("input[name=variantId]").val();
                let sku = $(value).find("span.product-sku").text();
                let product_name = $(value).find("span.product-name").text();
                let price = replaceComma($(value).find("span.price").text());
                let quantity = $(value).find("span.qty").text();
                let reduce = replaceComma($(value).find("span.reduce").text());
                let reduce_type = 0;
                let reduce_percent = "";
                if(reduce) {
                    if (reduce.indexOf("%") > -1) {
                        reduce = replacePercent(reduce);
                        reduce_percent = reduce;
                        reduce = (reduce * price) / 100;
                        reduce_type = 0;
                    } else {
                        reduce_percent = Math.round(reduce * 100 / (price * quantity));
                        reduce_type = 1;
                    }
                }
                let profit = replaceComma($(value).find("input[name=profit]").val());
                let curr_product = {};
                curr_product["product_id"] = product_id;
                curr_product["variant_id"] = variant_id;
                curr_product["sku"] = sku;
                curr_product["product_name"] = product_name;
                curr_product["price"] = price;
                curr_product["quantity"] = quantity;
                curr_product["reduce"] = reduce;
                curr_product["reduce_percent"] = reduce_percent;
                curr_product["reduce_type"] = reduce_type;
                curr_product["product_exchange"] = 0;
                curr_product["profit"] = profit;
                curr_products.push(curr_product);

                //exchange_product
                let product_id_new = $(value).find("input[name=prodIdNew]").val();
                let variant_id_new = $(value).find("input[name=variantIdNew]").val();
                let sku_new = $(value).find("span.product-sku-new").text();
                let product_name_new = $(value).find("span.product-name-new").text();
                let price_new = replaceComma($(value).find("span.price-new").text());
                let quantity_new = $(value).find("input[name=qtyNew]").val();
                let reduce_new = replaceComma($(value).find("input[name=reduceNew]").val());
                let reduce_new_type = 0;
                let reduce_percent_new = "";
                if(reduce_new) {
                    if (reduce_new.indexOf("%") > -1) {
                        reduce_new = replacePercent(reduce_new);
                        reduce_percent_new = reduce_new;
                        reduce_new = (reduce_new * price_new) / 100;
                        reduce_new_type = 0;
                    } else {
                        reduce_percent_new = Math.round(reduce_new * 100 / (price_new * quantity_new));
                        reduce_new_type = 1;
                    }
                }
                let profit_new = replaceComma($(value).find("input[name=profitNew]").val());
                let product = {};
                product["product_id"] = product_id_new;
                product["variant_id"] = variant_id_new;
                product["sku"] = sku_new;
                product["product_name"] = product_name_new;
                product["price"] = price_new;
                product["quantity"] = quantity_new;
                product["reduce"] = reduce_new;
                product["reduce_percent"] = reduce_percent_new;
                product["reduce_type"] = reduce_new_type;
                product["product_exchange"] = sku;
                product["profit"] = profit_new;
                exchange_products.push(product);
            }
            if($(value).hasClass("is_return")) {
                let product_id = $(value).find("input[name=prodId]").val();
                let variant_id = $(value).find("input[name=variantId]").val();
                let sku = $(value).find("span.product-sku").text();
                let product_name = $(value).find("span.product-name").text();
                let price = replaceComma($(value).find("span.price").text());
                let quantity = $(value).find("span.qty").text();
                let reduce = replaceComma($(value).find("span.reduce").text());
                let reduce_type = 0;
                let reduce_percent = "";
                if (reduce) {
                    if (reduce.indexOf("%") > -1) {
                        reduce = replacePercent(reduce);
                        reduce_percent = reduce;
                        reduce = (reduce * price) / 100;
                        reduce_type = 0;
                    } else {
                        reduce_percent = Math.round(reduce * 100 / (price * quantity));
                        reduce_type = 1;
                    }
                }
                let profit = replaceComma($(value).find("input[name=profit]").val());
                let product = {};
                product["product_id"] = product_id;
                product["variant_id"] = variant_id;
                product["sku"] = sku;
                product["product_name"] = product_name;
                product["price"] = price;
                product["quantity"] = quantity;
                product["reduce"] = reduce;
                product["reduce_percent"] = reduce_percent;
                product["reduce_type"] = reduce_type;
                product["product_exchange"] = sku;
                product["profit"] = profit;
                return_products.push(product);
            }
            // add new product
            if($(value).hasClass("add-new-product")) {
                let product_id_add_new = $(value).find("input[name=prodIdAddNew]").val();
                let variant_id_add_new = $(value).find("input[name=variantIdAddNew]").val();
                let sku_add_new = $(value).find("span.product-sku-add-new").text();
                let product_name_add_new = $(value).find("span.product-name-add-new").text();
                let price_add_new = replaceComma($(value).find("span.price-add-new").text());
                let quantity_add_new = $(value).find("input[name=qtyAddNew]").val();
                let reduce_add_new = replaceComma($(value).find("input[name=reduceAddNew]").val());
                let reduce_type = 0;
                let reduce_percent_add_new = "";
                if(reduce_add_new) {
                    if (reduce_add_new.indexOf("%") > -1) {
                        reduce_add_new = replacePercent(reduce_add_new);
                        reduce_percent_add_new = reduce_add_new;
                        reduce_add_new = (reduce_add_new * price_add_new) / 100;
                        reduce_type = 0;
                    } else {
                        reduce_percent_add_new = Math.round(reduce_add_new * 100 / (price_add_new * quantity_add_new));
                        reduce_type = 1;
                    }
                }
                let profit_add_new = replaceComma($(value).find("input[name=profitAddNew]").val());
                let new_product = {};
                new_product["product_id"] = product_id_add_new;
                new_product["variant_id"] = variant_id_add_new;
                new_product["sku"] = sku_add_new;
                new_product["product_name"] = product_name_add_new;
                new_product["price"] = price_add_new;
                new_product["quantity"] = quantity_add_new;
                new_product["reduce"] = reduce_add_new;
                new_product["reduce_percent"] = reduce_percent_add_new;
                new_product["reduce_type"] = reduce_type;
                new_product["product_exchange"] = 0;
                new_product["profit"] = profit_add_new;
                add_new_products.push(new_product);
            }
        });
        // if(curr_products.length <= 0 || exchange_products.length <= 0 || return_products.length <= 0) {
        //     Swal.fire({
        //             type: 'error',
        //             title: 'Đã xảy ra lỗi',
        //             text: "Không tồn tại sản phẩm đổi!"
        //         });
        //     return;
        // }
        data["curr_products"] = curr_products;
        data["exchange_products"] = exchange_products;
        data["add_new_products"] = add_new_products;
        data["return_products"] = return_products;

        console.log(JSON.stringify(data));

        $.ajax({
            dataType: 'json',
            url: '<?php Common::getPath() ?>src/controller/exchange/ExchangeController.php',
            data: {
                method: "exchange",
                data: JSON.stringify(data)
            },
            type: 'POST',
            success: function (data) {
                let orderId = data.orderId;
                console.log(orderId);
                let filename = data.fileName;
                $(".iframeArea").html("");
                if (typeof filename !== "undefined" && filename !== "") {
                    $(".iframeArea").html('<iframe src="<?php Common::getPath() ?>src/controller/exchange/pdf/receipt.html" id="receiptContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                }
                if (flag_print_receipt === true && typeof filename !== "undefined" && filename !== "") {
                    printReceipt();
                }
                $("#create-order .overlay").addClass("hidden");
                Swal.fire({
                    type: 'success',
                    title: 'Thành công!',
                    text: "Đơn hàng #" + orderId + " đã được tạo thành công.!"
                }).then((result) => {
                    if (result.value) {
                        window.location.href = "<?php Common::getPath()?>src/view/exchange";
                    }
                });
            },
            error: function (data, errorThrown) {
                console.log(data);
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
        let objFra = document.getElementById('receiptContent');
        objFra.contentWindow.focus();
        objFra.contentWindow.print();
    }

    function on_change_reduce(priceId, qtyId, intoMoneyId, reduceId, oldIntoMoneyId, diffMoneyId) {
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
            $("[id=" + reduceId + "]").val(formatNumber(reduce));
            if (reduce !== "" && (reduce < 1000 || reduce > (price * qty) / 2)) {
                $("[id=" + reduceId + "]").addClass("is-invalid");
                disableCheckOutBtn();
                return;
            } else {
                $("[id=" + reduceId + "]").removeClass("is-invalid");
            }

        }

        let intoMoney = price * qty - reduce;
        $("[id=" + intoMoneyId + "]").text(formatNumber(intoMoney));
        //calculateTotal();

        $("[id=" + reduceId + "]").trigger("change");
        let oldIntoMoney = 0;
        if(oldIntoMoneyId != "") {
            oldIntoMoney = $("[id=" + oldIntoMoneyId + "]").text();
            oldIntoMoney = replaceComma(oldIntoMoney);
        }
        let diff_money = intoMoney - oldIntoMoney;
        $("[id=" + diffMoneyId + "]").text(formatNumber(diff_money));
        calculateTotal();
    }

    function validateNumber(value, id) {
        if (isNaN(value)) {
            $("[id=" + id + "]").addClass("is-invalid");
            return false;
        } else {
            $("[id=" + id + "]").removeClass("is-invalid");
            return true;
        }
    }

    function on_change_qty(priceId, qtyId, intoMoneyId, reduceId, oldIntoMoneyId, diffMoneyId) {
        let price = get_price(priceId);
        let qty = get_qty(qtyId);
        if (!validateQty(qty, qtyId)) {
            disableCheckOutBtn();
            return;
        }
        let intoMoney = price * qty;
        $("[id=" + intoMoneyId + "]").text(formatNumber(intoMoney));
        $("[id=" + reduceId + "]").trigger("change");
        let oldIntoMoney = $("[id=" + oldIntoMoneyId + "]").text();
        oldIntoMoney = replaceComma(oldIntoMoney);
        let diff_money = intoMoney - oldIntoMoney;
        $("[id=" + diffMoneyId + "]").text(formatNumber(diff_money));
        calculateTotal();
    }

    function get_qty(qtyId) {
        let qty = $("[id=" + qtyId + "]").val();
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
            return false;
        } else {
            $("[id=" + qtyId + "]").removeClass("is-invalid");
            return true;
        }
    }

    function disableCheckOutBtn() {
        $("#checkout").prop("disabled", "disabled");
    }

    function enableCheckOutBtn() {
        $("#checkout").prop("disabled","");
    }

    function resetData() {
        $("#tableProd tbody").html("");
        $("#totalAmount").text(0);
        $("#totalReduce").text(0);
        $("#discount").val("");
        $("#totalCheckout").text(0);
        $("#payment").val("");
        $("#repay").text(0);
        $("#repay_type").text("");
        $("#noRow").val(0);
        $(".msg").html("");
        $("#flag_print_receipt").prop("checked", false);
        $(".voucher_info").addClass("hidden");
        $("#voucher_value").val("");
        $("#voucher").val("").prop("disabled", "");
        // disableCheckOutBtn();
    }

    function get_total_point(customer_id) {
        if (!customer_id) {
            console.log("Error! customer_id is null. " + customer_id);
            return;
        }
        $.ajax({
            url: "<?php Common::getPath() ?>src/controller/Wallet/WalletController.php",
            dataType: 'TEXT',
            type: 'post',
            data: {
                customerId: customer_id,
                method: 'get_ballance_in_wallet'
            },
            success: function (res) {
                if(res) {
                    $(".wallet").removeClass("hidden");
                    $("#totalBallanceInWallet").text(formatNumber(res));
                    setTimeout(function () {
                        calculate_total_point();
                    }, 200);
                } else {
                    $(".wallet").addClass("hidden");
                }
            }
        });
    }


    function recalculateTotalCheckout() {
        let total_reduce = Number(replaceComma($("#totalReduceNew").text()));
        let total_amount = Number(replaceComma($("#total_amount_new").text()));
        let total_checkout = total_amount - total_reduce;
        $("#total_checkout_new").text(formatNumber(total_checkout));
    }

    function recalculateTotalReduce() {
        let totalUsePoint  = Number(replaceComma($("#totalUsePoint").val()));
        let total_amount = Number(replaceComma($("#total_amount_new").text()));
        // let discountOld = Number(replaceComma($("#discount_old").text()));
        let discountNew = replaceComma($("#discount_new").val());
        if(discountNew.indexOf("%") > -1) {
            discountNew = Math.round(replacePercent(discountNew) * total_amount / 100);
        }
        // recalculate total reduce
        // let total_reduce = totalUsePoint + Number(discountNew) + Number(discountOld);
        let total_reduce = 0;
        if(total_amount > 0) {
            total_reduce = totalUsePoint + Number(discountNew);
        }
        $("#totalReduceNew").text(formatNumber(total_reduce));
        $(".total-reduce-new").removeClass("hidden");
    }

    function payment_box() {
        let total_checkout = Number(replaceComma($("#total_checkout_new").text()));
        if(total_checkout > 0) {
            $(".payment-new").removeClass("hidden");
            $("#sel_payment_new").val(0).trigger("change").prop("disabled", "");
            $("#payment_new").val("").prop("disabled", "");
        } else {
            $(".payment-new").addClass("hidden");
            $("#sel_payment_new").val(0).trigger("change").prop("disabled", true);
            $("#payment_new").val("").prop("disabled", true);
        }
    }

    // function calculate_saved_point() {
    //     let total_checkout = Number(replaceComma($("#total_checkout_new").text()));
    //     let total_saved_point = Math.round(total_checkout * 5 / 100);
    //     total_saved_point = formatNumber(total_saved_point);
    //     $("#total_saved_point").text(total_saved_point);
    //     $(".saved-point").removeClass("hidden");
    // }
    function calculate_saved_point() {
        let total_saved_point = 0;
        let total_checkout = Number(replaceComma($("#total_checkout_new").text()));
        if (total_checkout > 0) {
            let discount = Number(replaceComma($("#discount_new").val()));
            total_saved_point = Math.round(total_checkout * 5 / 100);
            total_saved_point = formatNumber(total_saved_point - discount);
        }
        $("#total_saved_point").text(total_saved_point);
        $(".saved-point").removeClass("hidden");
    }

    function calculate_repay_new() {
        $(".repay-new").removeClass("hidden");
        $("#repay_new").val("");
        let total_checkout = Number(replaceComma($("#total_checkout_new").text()));
        if(total_checkout < 0) {
            $("#repay_new").val(formatNumber(Math.abs(total_checkout)));
            $("#tranferToWallet_new").val("");
        } else {
            let payment_new = Number(replaceComma($("#payment_new").val()));
            if(payment_new > total_checkout) {
                $("#repay_new").val(formatNumber(payment_new - total_checkout));
                $(".repay-new").removeClass("hidden");
            } else {
                $("#repay_new").val("");
                $(".repay-new").addClass("hidden");
            }
        }
    }
</script>
</body>
</html>
