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
    <title>Bán hàng</title>
    <?php require_once('../../common/css.php'); ?>
    <?php require_once('../../common/js.php'); ?>
    <link rel="stylesheet" href="<?php Common::getPath() ?>plugins/typeahead/css/typeaheadjs.css">
    <script src="<?php Common::getPath() ?>plugins/typeahead/js/typeahead.jquery.min.js"></script>
    <script src="<?php Common::getPath() ?>plugins/typeahead/js/bloodhound.min.js"></script>
</head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content">
    <div class="row" style="margin-bottom: 10px;padding-top: 10px;">
        <div class="col-md-4">
            <input class="form-control" id="productId" type="text" autofocus="autofocus" style="border-color: #28a745"
                   autocomplete="off">
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Danh sách sản phẩm</h3>
                </div>
                <div class="card-body" style="min-height: 615px;">
                    <input type="hidden" id="noRow" value="0">
                    <table class="table table-bordered table-head-fixed" id="tableProd">
                        <thead>
                        <tr>
                            <th class="w10">#</th>
                            <th class="hidden"></th>
                            <th class="hidden"></th>
                            <th class="w70">ID</th>
                            <th class="w70">Hình ảnh</th>
                            <th class="w150">Tên sản phẩm</th>
                            <th class="w130">Size</th>
                            <th class="w130">Màu</th>
                            <th class="w100">Đơn giá</th>
                            <th class="w120">Số lượng</th>
                            <th class="w150">Giảm trừ</th>
                            <th class="w120">Thành tiền</th>
                            <th class="w120">Hành động</th>
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
        <div class="col-md-3">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Thông tin thanh toán</h3>
                </div>
                <div class="card-body" style="min-height: 615px;">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td class="right w90">Khách hàng</td>
                            <td class="right">
                                <input type="hidden" id="customer_id">
                                <a href="javascript:void(0)" id="customer_retail" class="d-inline-block col-md-12">
                                    <span>Khách lẻ</span> <i class="fa fa-user-edit"></i>
                                </a>
                                <div class="d-inline-block col-md-10">
                                    <a href="javascript:void(0)" id="out_customer_name"
                                       class="d-inline-block col-md-12 hidden">
                                        <span></span> <i class="fa fa-user-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="out_customer_phone"
                                       class="d-inline-block col-md-12 hidden">
                                        <span></span> <i class="fa fa-phone"></i>
                                    </a>
                                </div>
                                <div class="d-inline-block col-md-1" style="vertical-align: top;">
                                    <a href="javascript:void(0)" class="d-inline-block text-danger hidden"
                                       id="remove_customer">
                                        <i class="fa fa-times-circle"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="d-inline-block text-success hidden"
                                       id="edit_customer">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </div>
                                <div class="input-group mb-3 hidden" id="check_phone_form">
                                    <input type="text" class="form-control" placeholder="Nhập số điện thoại"
                                           id="input_customer_phone">
                                    <div class="input-group-append hidden">
                                        <span class="input-group-text btn-primary btn-flat c-pointer"><i
                                                    class="fa fa-spinner fa-spin"></i></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="right w90">Tổng tiền</td>
                            <td class="right"><b style="font-size: 20px;" id="totalAmount">0</b> <sup>đ</sup></td>
                        </tr>
                        <tr class="point hidden">
                            <td class="right w90">Số dư trong ví</td>
                            <td class="right">
                                <input type="text" class="form-control text-right" style="font-size: 20px;"
                                       id="totalUsePoint">
<!--                                <p class="mt-1 mb-0 text-danger overflow-total-checkout hidden">Số tiền tích lũy sử dụng-->
<!--                                    không được vượt quá 50% tổng tiền thanh toán</p>-->
                                <p class="mt-1">Quý khách có <span class="text-primary" id="totalBallanceInWallet">0</span> <sup
                                            class="text-primary">đ</sup> trong ví</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="right">Khuyến mãi</td>
                            <td class="right w110">
                                <input type="text" class="form-control text-right" name="discount" id="discount"
                                       placeholder="Số tiền"
                                       width="100px">
                                <!--                <input type="text" class="form-control mt-2" name="voucher" id="voucher" placeholder="Mã giảm giá"-->
                                <!--                       width="100px">-->
                                <input type="hidden" class="form-control" name="voucher_value" id="voucher_value">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="left voucher_info hidden">
                                <input type="hidden" id="vcFlag" value="0">
                                <input type="hidden" id="vcCode" value="">
                                <span class="msg"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="right">Tổng Giảm trừ</td>
                            <td class="right">
                                <span style="font-size: 20px;" id="totalReduce">0</span> <sup>đ</sup></td>
                        </tr>
                        <tr>
                            <td class="right">Tổng thanh toán</td>
                            <td class="right" style="color:red;"><h2><b id="totalCheckout">0</b> <small><sup>đ</sup></small></h2></td>
                        </tr>
                        <tr>
                            <td class="right">Khách thanh toán</td>
                            <td class="right">
                                <select class="form-control" name="sel_payment" id="sel_payment">
                                    <option value="0" selected="selected">Tiền mặt</option>
                                    <option value="1">Chuyển khoản</option>
                                    <option value="2">Nợ</option>
                                </select>
                                <input type="text" class="form-control mt-2" name="payment" id="payment" width="100px"
                                       style="text-align: right;">

                            </td>
                        </tr>
                        <tr class="saved-point hidden">
                            <td class="right pl-0" colspan="2">
                                <p class="mb-1">Quý khách sẽ tích lũy được <span class="text-primary"
                                                                                 id="total_saved_point">0</span> <sup
                                            class="text-primary">đ</sup> cho đơn hàng này.</p>
                            </td>
                        </tr>
                        <tr class="repay hidden">
                            <td class="right pl-0 pr-0">
                                <span>Trả lại</span>
                                <div class="form-group mt-3" style="">
                                    <a href="javascript:void(0)" class="ml-3" id="reverse"><i class="fas fa-retweet"></i></a>
                                </div>
                            </td>
                            <td class="left">
                                <input type="text" class="form-control mb-2 text-right" placeholder="Tiền mặt" id="repay">
                                <input type="text" class="form-control text-right" placeholder="Tiền chuyển vào ví" id="tranferToWallet">
                            </td>
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
            <!-- /.card -->
        </div>
    </div>
</section>
<div class="iframeArea" style="visibility: hidden"></div>
<?php require_once '../customer/createCustomer.php'; ?>
<?php require_once('../../common/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        set_title("Bán hàng");
        $("#productId").change(function () {
            let prodId = $(this).val();
            if (prodId.indexOf('SP') > -1) {
                prodId = prodId.replace("SP", "");
                prodId = parseInt(prodId);
            }
            validateProdId(prodId, calculateTotal, find_product, 1);
            $(this).val("");
        });

        $("#discount").on('keyup', function (event) {
            let discount = $(this).val();
            onchange_discount(discount, event);
            event.preventDefault();
        });
        $("#voucher").on('change', function (event) {
            let voucher = $(this).val();
            onchange_voucher(voucher, event);
        });

        $("#payment").on('keyup', function () {
            let payment = $(this).val();
            payment = format_money(payment);
            payment = replaceComma(payment);
            payment = formatNumber(payment);
            $(this).val(payment);
        });
        $("#payment").on('change', function () {
            let payment = $(this).val();
            payment = replaceComma(payment);
            paymentChange(payment);
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
            if ($(this).val() == 2) {
            //     $("#payment").show().focus();
            //     // disableCheckOutBtn();
            //     validate_form();
            // } else {
                $("#payment").val("").hide();
                // enableCheckOutBtn();
                validate_form();
            } else {
                    $("#payment").show().focus();
                    validate_form();
            }
            calculateTotal();
        });
        $("#sel_discount").change(function () {
            $("#discount").focus();
        });

        $("#customer_retail").click(function () {
            let cls = $("#check_phone_form").attr("class");
            if (cls.indexOf("hidden") > -1) {
                $("#check_phone_form").removeClass("hidden").children('input').removeClass("hidden");
                $("#input_customer_phone").focus();
            } else {
                $("#check_phone_form").addClass("hidden");
                $("#input_customer_phone").val("");
            }
        });

        $("#input_customer_phone").on('change keydown', function (e) {
            let key = e.keyCode;
            if (key === 13) {
                $(this).attr("disabled", true);
                $(this).next("div").removeClass("hidden");
                let phone = $(this).val();
                if (phone) {
                    check_exist_customer(phone);
                }
            }
        });

        $("#remove_customer").click(function () {
            $("#customer_id").val("");
            $("#out_customer_name").addClass("hidden").val("");
            $("#out_customer_phone").addClass("hidden").val("");
            $("#customer_retail").removeClass("hidden");
            $("#edit_customer").addClass("hidden");
            $("#input_customer_phone").addClass("hidden").val("");
            $(this).addClass("hidden");
            $(".saved-point").addClass("hidden");
            $("#total_saved_point").text("0");
            $(".point").addClass("hidden");
            $("#totalUsePoint").val("");
            $("#totalBallanceInWallet").text("");
            calculateTotal();
        });

        $("#edit_customer").click(function () {
            let customer_id = $("#customer_id").val();
            edit_customer(customer_id);
        });

        $("#totalUsePoint").on('keyup',function () {
            let value = format_money($(this).val());
            if (isNaN(value)) {
                $(this).addClass("is-invalid");
                disableCheckOutBtn();
                return;
            } else {
                $(this).removeClass("is-invalid");
                enableCheckOutBtn();
            }
            $(this).val(formatNumber(value));
            calculateTotal();
            // let total_checkout = $("#totalCheckout").text();
            // total_checkout = Number(replaceComma(total_checkout));
            // if (total_checkout > 0) {
            //     // if (Number(value) > total_checkout / 2) {
            //     //     // $(this).addClass("is-invalid");
            //     //     $(".overflow-total-checkout").removeClass("hidden");
            //     //     // disableCheckOutBtn();
            //     // } else {
            //     //     // $(this).removeClass("is-invalid");
            //     //     $(".overflow-total-checkout").addClass("hidden");
            //     //     enableCheckOutBtn();
            //     // }
            //     calculate_total_point();
            // }
        });


        transferToWallet();
        reverse_repay();
        // end document ready
    });

    function reverse_repay() {
        $("#reverse").click(function () {
            let repay = $("#repay").val();
            let transferToWallet = $("#tranferToWallet").val();
            $("#repay").val(transferToWallet);
            $("#tranferToWallet").val(repay);
        });
    }

    function transferToWallet() {
        $("#tranferToWallet").on('change',function() {
            let value = $(this).val();
            let repay = Number(replaceComma($("#repay").val()));
            if(value && repay) {
                if(isNaN(value) || Number(value) > repay) {
                    $(this).addClass("is-invalid");
                    return;
                } else {
                    $(this).removeClass("is-invalid");
                }
                repay = repay - Number(value);
                $("#repay").val(formatNumber(repay));
            }
            $(this).val(formatNumber(value));
        });
    }

    function check_exist_customer(phone) {
        $("#out_customer_phone").removeClass("is-invalid");
        if (!validate_phone(phone)) {
            toastr.error("Số điện thoại chưa đúng");
            $("#input_customer_phone").addClass("is-invalid").removeAttr("disabled").focus().next("div").addClass("hidden");
            return;
        }
        $.ajax({
            url: "<?php Common::getPath() ?>src/controller/customer/CustomersController.php",
            dataType: 'JSON',
            type: 'post',
            data: {
                value: phone,
                type: 'phone',
                method: 'find_customer'
            },
            success: function (res) {
                console.log(res);
                $("#input_customer_phone").removeAttr("disabled").next("div").addClass("hidden");
                if (!res) {
                    $("#customer_id").val("");
                    $("#out_customer_name").val("");
                    $("#out_customer_phone").val("");
                    Swal.fire({
                        title: "Số điện thoại chưa tồn tại",
                        text: "Bạn có muốn tạo khách hàng mới không?",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.value) {
                            reset_data_customer();
                            $("#phone_number").val(phone);
                            generate_select2_city();
                            open_modal('#create_customer');
                        }
                    })
                } else {
                    $("#customer_retail").trigger("click").addClass("hidden");
                    $("#out_customer_name").removeClass("hidden");
                    $("#out_customer_phone").removeClass("hidden");
                    $("#customer_id").val(res.id);
                    $("#out_customer_name span").text(res.name);
                    $("#out_customer_phone span").text(res.phone);
                    $("#remove_customer").removeClass("hidden");
                    $("#edit_customer").removeClass("hidden");
                    setTimeout(function () {
                        $(".point").removeClass("hidden");
                        get_ballance_in_wallet(res.id);
                        calculate_saved_point();
                    }, 200);
                }
            }
        });
    }

    function get_ballance_in_wallet(customer_id) {
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
                console.log(res);
                $("#totalBallanceInWallet").text(formatNumber(res));
                setTimeout(function () {
                    calculate_total_point();
                }, 200);
            }
        });
    }

    function calculate_total_point() {
        let currentPoint = $("#totalBallanceInWallet").text();
        currentPoint = Number(replaceComma(currentPoint));
        if (currentPoint && Number(currentPoint) > 0) {
            $("#totalUsePoint").removeClass("hidden");
            let total_checkout = $("#totalCheckout").text();
            total_checkout = Number(replaceComma(total_checkout));
            if (total_checkout > 0) {
                let totalPoint = 0;
                if (Number(currentPoint) > total_checkout) {
                    totalPoint = total_checkout;
                } else {
                    totalPoint = currentPoint;
                }
                $("#totalUsePoint").val(formatNumber(totalPoint));
            } else {
                $("#totalUsePoint").val(formatNumber(currentPoint));
            }
        } else {
            $("#totalUsePoint").addClass("hidden");
        }
        calculateTotal();
    }

    function calculate_saved_point() {
        let total_checkout = Number(replaceComma($("#totalCheckout").text()));
        if (total_checkout > 0) {
            let discount = Number(replaceComma($("#discount").val()));
            let total_saved_point = Math.round(total_checkout * 5 / 100);
            total_saved_point = formatNumber(total_saved_point - discount);
            $("#total_saved_point").text(total_saved_point);
            $(".saved-point").removeClass("hidden");
        }
    }

    function validate_form() {
        let noRow = $("#noRow").val();
        if (noRow == 0) {
            disableCheckOutBtn();
            return;
        }
        let select_payment = $("#sel_payment").val();
        if (select_payment == 0) {
            let payment = $("#payment").val();
            if (payment === "") {
                disableCheckOutBtn();
                return;
            }
        }
        enableCheckOutBtn();
    }

    function onchange_voucher(voucher, event) {
        $("#voucher").removeClass("is-invalid");
        let c = voucher.substring(0, 2);
        c = c.toUpperCase();
        if (c == 'VC') {
            // voucher
            ues_voucher(voucher);
            event.preventDefault();
        } else {
            disableCheckOutBtn();
            $("#voucher").addClass("is-invalid");
        }
    }

    function onchange_discount(discount, event) {
        discount = format_money(discount);
        if (!validate_discount(discount)) {
            event.preventDefault();
            return;
        }
        $("#discount").val(formatNumber(discount));
        calculateTotal();
        event.preventDefault();
        // }
    }

    function ues_voucher(voucher_code) {
        $.ajax({
            dataType: 'json',
            url: '<?php Common::getPath() . 'src/controller/voucher/VoucherController.php' ?>',
            data: {
                method: "find_by_code",
                code: voucher_code
            },
            type: 'POST',
            success: function (res) {
                // console.log(res);
                if (res.length > 0) {
                    let status = res[0].status;
                    if (status !== "undefined") {
                        switch (status) {
                            case '1':
                                Swal.fire({
                                    type: 'error',
                                    title: 'Đã xảy ra lỗi',
                                    text: "Mã khuyến mãi chưa được kích hoạt"
                                }).then((result) => {
                                    if (result.value) {
                                        $("#voucher").val("").trigger("change");
                                    }
                                });
                                break;
                            case '2':
                                if (res[0].valid_date === "expired") {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Đã xảy ra lỗi',
                                        text: "Mã khuyến mãi đã hết hạn"
                                    }).then((result) => {
                                        if (result.value) {
                                            $("#voucher").val("").trigger("change");
                                        }
                                    });

                                } else {
                                    let value;
                                    if (res[0].type == 0) {
                                        // cash
                                        value = formatNumber(res[0].value);
                                    } else if (res[0].type == 1) {
                                        // percent
                                        value = res[0].value + "%";
                                    }
                                    $("#voucher_value").val(value);
                                    let msg = '<div class="alert alert-success alert-dismissible">' +
                                        '<button type="button" class="close" aria-hidden="true" onclick="removeVC()">×</button>' +
                                        'Mã ' + voucher_code + ' có giá trị giảm ' + value + ' trên tổng đơn hàng!' +
                                        '</div>'
                                    $(".msg").html(msg);
                                    $("#vcFlag").val(1);
                                    $("#vcCode").val(voucher_code);
                                    // $("#voucher").val(value).trigger("change");
                                    $(".voucher_info").removeClass("hidden");
                                    calculateTotal();
                                    $("#voucher").val(voucher_code).prop("disabled", true);
                                }
                                break;
                            case '3':
                                Swal.fire({
                                    type: 'error',
                                    title: 'Đã xảy ra lỗi',
                                    text: "Mã khuyến mãi đã được sử dụng"
                                }).then((result) => {
                                    if (result.value) {
                                        $("#voucher").val("").trigger("change");
                                    }
                                });
                                break;
                            case '4':
                                Swal.fire({
                                    type: 'error',
                                    title: 'Đã xảy ra lỗi',
                                    text: "Mã khuyến mãi đã bị khoá"
                                }).then((result) => {
                                    if (result.value) {
                                        $("#voucher").val("").trigger("change");
                                    }
                                });
                                break;
                        }
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Đã xảy ra lỗi',
                            text: "Mã khuyến mãi không tồn tại"
                        }).then((result) => {
                            if (result.value) {
                                $("#voucher").val("").trigger("change");
                            }
                        });
                    }
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Đã xảy ra lỗi',
                        text: "Mã khuyến mãi không tồn tại"
                    }).then((result) => {
                        if (result.value) {
                            $("#voucher").val("").trigger("change");
                        }
                    });
                }
                $("#create-order .overlay").addClass("hidden");
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: ""
                })
                $("#create-order .overlay").addClass("hidden");
            }
        });
    }

    function removeVC() {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xoá?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                $(".msg").html("");
                $("#vcFlag").val(0);
                $("#vcCode").val("");
                $("#voucher_value").val("");
                $("#voucher").val("").prop("disabled", "");
                calculateTotal();
                toastr.warning('Mã giảm giá đã được xoá.');
                $(".voucher_info").addClass("hidden");
            }
        });
    }

    function validate_discount(discount) {
        discount = replaceComma(discount);
        discount = replacePercent(discount);
        if (discount.indexOf("%") > -1) {

            // if (discount1 < 1 || discount1 > 50) {
            //     $("#discount").addClass("is-invalid");
            //     disableCheckOutBtn();
            //     // validate_form();
            //     return false;
            // } else {
            //     $("#discount").removeClass("is-invalid");
            //     // $("#cash_value").val(discount);
            // }
        } else {
            if (!validateNumber(discount, 'discount')) {
                disableCheckOutBtn();
                // validate_form();
                return false;
            }
            // $("#cash_value").val(discount);
            // let totalCheckout = replaceComma($("#totalCheckout").text());
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
        if(!payment) {
            return;
        }
        payment = format_money(payment);
        payment = replaceComma(payment);
        if (!validateNumber(payment, 'payment')) {
            // disableCheckOutBtn();
            validate_form();
            return;
        }
        let totalCheckout = replaceComma($("#totalCheckout").text());
        payment = replaceComma(payment);
        if (payment !== "" && payment < 1000) {
            payment += "000";
        }
        $("#payment").val(formatNumber(payment));
        if (payment !== "" && Number(totalCheckout) > 0 && Number(payment) < Number(totalCheckout)) {
            $("#payment").addClass("is-invalid");
            disableCheckOutBtn();
            // validate_form();
            return;
        } else {
            $("#payment").removeClass("is-invalid");
            enableCheckOutBtn();
        }
        //  validate_form();
        calculateTotal();
    }

    function reset_repay_form() {
        $("#repay").val("");
        $("#tranferToWallet").val("");
    }

    function processDataCheckout() {
        // order information
        let total_amount = replaceComma($("#totalAmount").text());
        let total_reduce = replaceComma($("#totalReduce").text());
        let discount = replaceComma($("#discount").val());

        let total_checkout = replaceComma($("#totalCheckout").text());
        let customer_payment = replaceComma($("#payment").val());
        let payment_type = $("#sel_payment").val();
        let flag_print_receipt = $("#flag_print_receipt").is(':checked');
        let voucher_code = $("#vcCode").val();
        let voucher_value = $("#voucher_value").val();
        let customer_id = $("#customer_id").val();

        if (discount.indexOf("%") > -1) {
            discount = discount.replace("%", "");
            discount = (discount * total_checkout) / 100;
        }
        let repay = Number(replaceComma($("#repay").val()));
        let transferToWallet = Number(replaceComma($("#tranferToWallet").val()));
        let totalBallanceInWallet = 0;
        let totalUsePoint = 0;
        let totalRemainPoint = 0;
        let totalSavedPoint = 0;
        if(customer_id && Number(customer_id) > 0) {
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
        data["discount"] = discount;
        data["wallet"] = totalUsePoint;
        data["total_checkout"] = total_checkout;
        data["customer_payment"] = customer_payment;
        data["payment_type"] = payment_type;
        data["repay"] = repay;
        data["transfer_to_wallet"] = transferToWallet;
        data["customer_id"] = customer_id;
        data["type"] = 0;// Sale on shop
        data["flag_print_receipt"] = flag_print_receipt;
        data["voucher_code"] = voucher_code;
        data["voucher_value"] = voucher_value;
        data["current_order_id"] = 0;
        data["payment_exchange_type"] = 0;
        data["source"] = 0;// shop
        data["wallet_used"] = totalUsePoint;
        data["wallet_saved"] = totalSavedPoint;
        data["wallet_repay"] = transferToWallet;
        data["wallet_remain"] = totalRemainPoint;


        //order detail information
        let details = [];
        $.each($("#tableProd tbody tr"), function (key, value) {
            let product_id = $(value).find("input[name=prodId]").val();
            let variant_id = $(value).find("input[name=variantId]").val();
            let sku = $(value).find("input[name=sku]").val();
            let product_name = $(value).find("span.product-name").text();
            let price = replaceComma($(value).find("span.price").text());
            let quantity = $(value).find("input[name=qty]").val();
            let reduce = replaceComma($(value).find("input[name=reduce]").val());
            let reduce_type = 0;
            let reduce_percent = "";
            if (reduce.indexOf("%") > -1) {
                reduce = reduce.replace("%", "");
                reduce_percent = reduce;
                reduce = (reduce * price) / 100;
                reduce_type = 0;
            } else {
                reduce_percent = Math.round(reduce * 100 / (price * quantity));
                reduce_type = 1;
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
            product["product_exchange"] = 0;
            product["profit"] = profit;
            details.push(product);
        });

        if (jQuery.isEmptyObject(details[0])) {
            Swal.fire({
                type: 'error',
                title: 'Đã xảy ra lỗi',
                text: 'Bạn chưa chọn sản phẩm.'
            });
            return;
        }
        data["details"] = details;
        console.log(JSON.stringify(data));
        $.ajax({
            dataType: 'json',
            url: '<?php Common::getPath()?>src/controller/sales/processCheckout.php',
            data: {
                type: "checkout",
                data: JSON.stringify(data)
            },
            type: 'POST',
            success: function (data) {
                let orderId = data.orderId;
                let filename = data.fileName;
                // console.log('filename: ' + filename);
                $(".iframeArea").html("");
                if (typeof filename !== "undefined" && filename !== "") {
                    $(".iframeArea").html('<iframe src="<?php Common::getPath()?>src/controller/sales/pdf/receipt.html" id="receiptContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                }
                // toastr.success('Đơn hàng #'+orderId+' đã được tạo thành công.');
                // resetData();
                $("#create-order .overlay").addClass("hidden");
                setTimeout(function () {
                    if (flag_print_receipt === true && typeof filename !== "undefined" && filename !== "") {
                        printReceipt();
                    }
                }, 500);
                Swal.fire({
                    type: 'success',
                    title: 'Thành công!',
                    text: 'Đơn hàng #' + orderId + ' đã được tạo thành công!'
                }).then((result) => {
                    if (result.value) {
                        window.location.reload();
                    }
                });
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
        let objFra = document.getElementById('receiptContent');
        objFra.contentWindow.focus();
        objFra.contentWindow.print();
    }

    function validateProdId(prodId, calculateTotal, find_product) {
        let count = 0;
        $.each($("#tableProd tbody").find("input[name=sku]"), function (k, v) {
            if (v["value"] === prodId) {
                count++;
                let noId = v["id"];
                noId = noId.split("_")[1];
                let qty = $("[id=qty_" + noId + "]").val();
                qty++;
                $("[id=qty_" + noId + "]").val(qty).trigger("change");
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

    function calculateTotal() {
        let noRow = $("#noRow").val();
        noRow = Number(noRow);
        let totalAmount = 0;
        let totalReduce = 0;
        for (let i = 1; i <= noRow; i++) {
            let price = get_price("price_" + i);
            let qty = get_qty("qty_" + i);
            let intoMoney = qty * price;
            let reduce = 0;
            if (typeof $("[id=reduce_" + i + "]").val() !== "undefined") {
                let val = $("[id=reduce_" + i + "]").val();
                if (val.indexOf("%") > -1) {
                    val = replacePercent(val);
                    reduce = intoMoney * val / 100;
                } else {
                    val = replaceComma(val);
                    reduce = Number(val) * Number(qty);
                    // reduce = replaceComma(val);
                }
            }
            totalAmount += Number(intoMoney);
            totalReduce += Number(reduce);
        }

        // let totalCheckout = Number(totalAmount) - Number(totalReduce);

        // use voucher
        let voucherValue = $("#voucher_value").val();
        if (voucherValue.indexOf("%") > -1) {
            voucherValue = replacePercent(voucherValue);
            voucherValue = Number(totalAmount * voucherValue / 100);
        } else {
            voucherValue = Number(replaceComma(voucherValue));
        }
        totalReduce += Number(voucherValue);

        // totalCheckout = Number(totalAmount) - Number(totalReduce);

        // use wallet
        let currentPoint = Number(replaceComma($("#totalUsePoint").val()));
        if (currentPoint && Number(currentPoint) > 0) {
            totalReduce += Number(currentPoint);
        }

        // use discount
        let discount = $("#discount").val();
        if (discount.indexOf("%") > -1) {
            discount = replacePercent(discount);
            discount = Number(totalAmount * discount / 100);
        } else {
            discount = Number(replaceComma(format_money(discount)));
        }
        totalReduce += Number(discount);

        let totalCheckout = Number(totalAmount) - Number(totalReduce);

        $("#totalAmount").text(formatNumber(totalAmount));
        $("#totalReduce").text(formatNumber(totalReduce));
        $("#totalCheckout").text(formatNumber(totalCheckout));

        // calculate payment
        reset_repay_form();
        let repay = 0;
        let payment = Number(replaceComma($("#payment").val()));
        if(payment > totalCheckout) {
            repay = payment - totalCheckout;
            $("#repay").val(formatNumber(repay));
            if(repay > 0) {
                $(".repay").removeClass("hidden");
            } else {
                $(".repay").addClass("hidden");
            }
            // let customer_id = $("#customer_id").val();
            // if(customer_id && Number(customer_id) > 0) {
            //     $(".repay_method").removeClass("hidden");
            // } else {
            //     $(".repay_method").addClass("hidden");
            // }
        } else {
            $("#repay").val("");
            $("#tranferToWallet").val("");
            $(".repay").addClass("hidden");
        }
        calculate_saved_point();
    }

    function find_product(sku, qty) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/sales/processCheckout.php',
            type: "POST",
            dataType: "json",
            data: {
                type: "find_product",
                sku: sku
            },
            success: function (products) {
                // console.log(JSON.stringify(products));
                if (products.length > 0) {
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
                    $("#tableProd tbody").append('<tr id="product-' + noRow + '">'
                        + '<td>' + noRow + '</td>'
                        + '<td class="hidden"><input type="hidden" name="prodId" id="prodId_' + noRow + '" class="form-control" value="' + products[0].product_id + '"></td>'
                        + '<td class="hidden"><input type="hidden" name="variantId" id="variantId_' + noRow + '" class="form-control" value="' + products[0].variant_id + '"></td>'
                        + '<td class="hidden"><input type="hidden" name="sku" id="sku_' + noRow + '" class="form-control" value="' + products[0].sku + '"></td>'
                        + '<td class="hidden"><input type="hidden" name="profit" id="profit_' + noRow + '" class="form-control" value="' + products[0].profit + '"></td>'
                        + '<td>' + products[0].sku + '</td>'
                        + '<td><img src="' + products[0].image + '" onerror=\'this.onerror=null;this.src="<?php Common::image_error()?>"\' width="50px"></td>'
                        + '<td><span class="product-name" id="name_' + noRow + '">' + products[0].name + '</span></td>'
                        + '<td><span class="size" id="size_' + noRow + '">' + products[0].size + '</span></td>'
                        + '<td><span class="color" id="color_' + noRow + '">' + products[0].color + '</span></td>'
                        + '<td><span class="price" id="price_' + noRow + '">' + products[0].retail + '</span> <sup>đ</sup></td>'
                        + '<td><input type="number" name="qty" id="qty_' + noRow + '" class="form-control" min="1" value="' + qty + '" onchange="on_change_qty(\'price_' + noRow + '\', \'qty_' + noRow + '\', \'intoMoney_' + noRow + '\', \'reduce_' + noRow + '\')"></td>'
                        + '<td><input type="text" name="reduce" id="reduce_' + noRow + '" class="form-control" value="' + discount + '" onchange="on_change_reduce(\'price_' + noRow + '\',\'qty_' + noRow + '\', \'intoMoney_' + noRow + '\', \'reduce_' + noRow + '\')"></td>'
                        + '<td><span class="intoMoney" id="intoMoney_' + noRow + '">' + products[0].retail + '</span> <sup>đ</sup></td>'
                        + '<td><button type="button" class="btn btn-danger form-control add-new-prod" title="Xóa"  onclick="del_product(this, \'product-' + noRow + '\')"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</button></td>'
                        + '</tr>');
                    $('[id=qty_' + noRow + ']').trigger("change");
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
                reloadData(calculateTotal, find_product);
            }
        })

    }

    function reloadData(calculateTotal, find_product) {
        $("#noRow").val(0);
        let arr = [];
        let qty = [];
        $.each($("#tableProd tbody").find("input[name=sku]"), function (k, v) {
            arr.push(v["value"]);
        });
        $.each($("#tableProd tbody").find("input[name=qty]"), function (k, v) {
            qty.push(v["value"]);
        });
        // if(arr.length == 0)
        // {
        // 	disableCheckOutBtn();
        // } else
        // {
        // 	enableCheckOutBtn();
        // }
        validate_form();
        $("#tableProd tbody").html("");
        if (typeof find_product === 'function') {
            for (let i = 0; i < arr.length; i++) {
                find_product(arr[i], qty[i]);
            }
        }
        if (typeof calculateTotal === 'function') {
            calculateTotal();
        }

    }

    function on_change_reduce(priceId, qtyId, intoMoneyId, reduceId) {
        let price = get_price(priceId);
        let qty = get_qty(qtyId);
        if (!validateQty(qty, qtyId)) {
            disableCheckOutBtn();
            // validate_form();
            return;
        }
        let reduce = $("[id=" + reduceId + "]").val();
        reduce = format_money(reduce);
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

        // enableCheckOutBtn();
        //  validate_form();
        let intoMoney = price * qty - reduce;
        $("[id=" + intoMoneyId + "]").text(formatNumber(intoMoney));
        calculateTotal();
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
        let price = get_price(priceId);
        let qty = get_qty(qtyId);
        if (!validateQty(qty, qtyId)) {
            disableCheckOutBtn();
            //  validate_form();
            return;
        }
        // enableCheckOutBtn();
        //  validate_form();
        let intoMoney = price * qty;
        $("[id=" + intoMoneyId + "]").text(formatNumber(intoMoney));
        $("[id=" + reduceId + "]").trigger("change");
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
            // disableCheckOutBtn();
            validate_form();
            return false;
        } else {
            $("[id=" + qtyId + "]").removeClass("is-invalid");
            // enableCheckOutBtn();
            validate_form();
            return true;
        }
    }

    function disableCheckOutBtn() {
        $("#checkout").attr("disabled", "disabled");
    }

    function enableCheckOutBtn() {
        $("#checkout").removeAttr("disabled");
    }

    // function replaceComma(value) {
    //     return value.replace(/,/g, '');
    // }
    //
    // function replacePercent(value) {
    //     return value.replace(/%/g, '');
    // }

    function resetData() {
        $("#tableProd tbody").html("");
        $("#totalAmount").text(0);
        $("#totalReduce").text(0);
        $("#discount").val("");
        $("#totalCheckout").text(0);
        $("#payment").val("");
        $("#repay").val("");
        $("#tranferToWallet").val("");
        $("#noRow").val(0);
        $(".msg").html("");
        $("#flag_print_receipt").prop("checked", false);
        $(".voucher_info").addClass("hidden");
        $("#voucher_value").val("");
        $("#voucher").val("").prop("disabled", "");
        disableCheckOutBtn();
    }
</script>
</body>
</html>
