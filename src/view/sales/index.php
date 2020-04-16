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
              <th class="w150">Tên sản phẩm</th>
              <th class="w50">Size</th>
              <th class="w70">Màu</th>
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
              <td class="right w90">Tổng tiền</td>
              <td class="right"><b style="font-size: 20px;" id="totalAmount">0</b><b> đ</b></td>
            </tr>
            <tr>
              <td class="right">Khuyến mãi</td>
              <td class="right w110">
                <input type="text" class="form-control" name="discount" id="discount" placeholder="Số tiền"
                       width="100px">
                <input type="text" class="form-control mt-2" name="voucher" id="voucher" placeholder="Mã giảm giá"
                       width="100px">
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
                <span style="font-size: 20px;" id="totalReduce">0</span><span> đ</span></td>
            </tr>
            <tr>
              <td class="right">Tổng thanh toán</td>
              <td class="right" style="color:red;"><h2><b id="totalCheckout">0</b><b> đ</b></h2></td>
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
            <tr>
              <td class="right">Trả lại</td>
              <td class="right"><span style="font-size: 20px;" id="repay">0</span><span> đ</span></td>
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
<div class="iframeArea hidden">
</div>
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

        $("#discount").change(function (event) {
            let discount = $(this).val();
            onchange_discount(discount, event);
            event.preventDefault();
        });
        // $("#discount").blur(function(event){
        // 	console.log('blur');
        // 	let discount = $(this).val();
        // 	onchange_discount(discount);
        // 	event.preventDefault();
        // });
        $('#discount').keypress(function (event) {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                let discount = $(this).val();
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
            let payment = $(this).val();
            payment = replaceComma(payment);
            paymentChange(payment);
        });
        $("#payment").blur(function () {
            let payment = $(this).val();
            payment = replaceComma(payment);
            paymentChange(payment);
        });
        $('#payment').keypress(function (event) {
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                let payment = $(this).val();
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

    function validate_form() {
        let noRow = $("#noRow").val();
        if (noRow == 0) {
            disableCheckOutBtn();
            return;
        }
        let select_payment = $("#sel_payment").val();
        if (select_payment == 0) {
            let payment = $("#payment").val();
            if (payment == "") {
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
                console.log(res);
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
                                        $("#voucher").val("");
                                        $("#voucher").trigger("change");
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
                                            $("#voucher").val("");
                                            $("#voucher").trigger("change");
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
                                    $("#voucher").val(voucher_code);
                                    $("#voucher").prop("disabled", true);
                                }
                                break;
                            case '3':
                                Swal.fire({
                                    type: 'error',
                                    title: 'Đã xảy ra lỗi',
                                    text: "Mã khuyến mãi đã được sử dụng"
                                }).then((result) => {
                                    if (result.value) {
                                        $("#voucher").val("");
                                        $("#voucher").trigger("change");
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
                                        $("#voucher").val("");
                                        $("#voucher").trigger("change");
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
                                $("#voucher").val("");
                                $("#voucher").trigger("change");
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
                            $("#voucher").val("");
                            $("#voucher").trigger("change");
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
                $("#voucher").val("");
                $("#voucher_value").val("");
                $("#voucher").prop("disabled", "");
                calculateTotal();
                toastr.warning('Mã giảm giá đã được xoá.');
                $(".voucher_info").addClass("hidden");
            }
        });
    }

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
        let total_amount = replaceComma($("#totalAmount").text());
        let total_reduce = replaceComma($("#totalReduce").text());
        let discount = replaceComma($("#discount").val());

        let total_checkout = replaceComma($("#totalCheckout").text());
        let customer_payment = replaceComma($("#payment").val());
        let payment_type = $("#sel_payment").val();
        let repay = replaceComma($("#repay").text());
        let flag_print_receipt = $("#flag_print_receipt").is(':checked');
        let voucher_code = $("#vcCode").val();
        let voucher_value = $("#voucher_value").val();

        if (discount.indexOf("%") > -1) {
            discount = discount.replace("%", "");
            discount = (discount * total_checkout) / 100;
        }

        let data = {};
        data["total_amount"] = total_amount;
        data["total_reduce"] = total_reduce;
        data["discount"] = discount;
        data["total_checkout"] = total_checkout;
        data["customer_payment"] = customer_payment;
        data["payment_type"] = payment_type;
        data["repay"] = repay;
        data["customer_id"] = 0;
        data["type"] = 0;// Sale on shop
        data["flag_print_receipt"] = flag_print_receipt;
        data["voucher_code"] = voucher_code;
        data["voucher_value"] = voucher_value;
        data["current_order_id"] = 0;
        data["payment_exchange_type"] = 0;

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
            let reduce_percent = "";
            if (reduce.indexOf("%") > -1) {
                reduce = reduce.replace("%", "");
                reduce_percent = reduce;
                reduce = (reduce * price) / 100;
            } else {
                reduce_percent = Math.round(reduce * 100 / (price * quantity));
            }

            let product = {};
            product["product_id"] = product_id;
            product["variant_id"] = variant_id;
            product["sku"] = sku;
            product["product_name"] = product_name;
            product["price"] = price;
            product["quantity"] = quantity;
            product["reduce"] = reduce;
            product["reduce_percent"] = reduce_percent;
            product["product_exchange"] = 0;
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
                console.log('filename: ' + filename);
                $(".iframeArea").html("");
                if (typeof filename !== "undefined" && filename !== "") {
                    $(".iframeArea").html('<iframe src="<?php Common::getPath()?>src/controller/sales/pdf/' + filename + '" id="receiptContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                }
                // toastr.success('Đơn hàng #'+orderId+' đã được tạo thành công.');
                // resetData();
                $("#create-order .overlay").addClass("hidden");
                if (flag_print_receipt === true && typeof filename !== "undefined" && filename !== "") {
                    printReceipt();
                }
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
        let totalCheckout = Number(totalAmount) - Number(totalReduce);

        // use voucher
        let voucherValue = $("#voucher_value").val();
        if (voucherValue.indexOf("%") > -1) {
            voucherValue = replacePercent(voucherValue);
            voucherValue = Number(totalCheckout * voucherValue / 100);
        } else {
            voucherValue = replaceComma(voucherValue);
            voucherValue = voucherValue == "" ? 0 : Number(voucherValue);
        }
        totalReduce += Number(voucherValue);
        totalCheckout = Number(totalAmount) - Number(totalReduce);
        // $("#voucher").val("");

        // use cash
        let discount = $("#discount").val();
        if (discount.indexOf("%") > -1) {
            discount = replacePercent(discount);
            discount = Number(totalCheckout * discount / 100);
        } else {
            discount = replaceComma(discount);
            discount = discount == "" ? 0 : Number(discount);
        }
        totalReduce += Number(discount);
        totalCheckout = Number(totalAmount) - Number(totalReduce);

        let payment = replaceComma($("#payment").val());
        let repay = 0;
        if (payment != 0 && totalCheckout > 0) {
            repay = Number(payment) - Number(totalCheckout);
        }

        $("#totalAmount").text(formatNumber(totalAmount));
        $("#totalReduce").text(formatNumber(totalReduce));
        $("#totalCheckout").text(formatNumber(totalCheckout));
        $("#repay").text(formatNumber(repay));
        validate_form();
    }


    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
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
                console.log(JSON.stringify(products));
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
                        + '<td>' + products[0].sku + '</td>'
                        + '<td><span class="product-name" id="name_' + noRow + '">' + products[0].name + '</span></td>'
                        + '<td><span class="size" id="size_' + noRow + '">' + products[0].size + '</span></td>'
                        + '<td><span class="color" id="color_' + noRow + '">' + products[0].color + '</span></td>'
                        + '<td><span class="price" id="price_' + noRow + '">' + products[0].retail + '</span><span> đ</span></td>'
                        + '<td><input type="number" name="qty" id="qty_' + noRow + '" class="form-control" min="1" value="' + qty + '" onchange="on_change_qty(\'price_' + noRow + '\', \'qty_' + noRow + '\', \'intoMoney_' + noRow + '\', \'reduce_' + noRow + '\')"></td>'
                        + '<td><input type="text" name="reduce" id="reduce_' + noRow + '" class="form-control" value="' + discount + '" onchange="on_change_reduce(\'price_' + noRow + '\',\'qty_' + noRow + '\', \'intoMoney_' + noRow + '\', \'reduce_' + noRow + '\')"></td>'
                        + '<td><span class="intoMoney" id="intoMoney_' + noRow + '">' + products[0].retail + '</span><span> đ</span></td>'
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
