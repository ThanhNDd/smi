<?php
require_once("../../common/common.php");
Common::authen();
?>
<div class="modal fade" id="create-order">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="overlay d-flex justify-content-center align-items-center">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title">Tạo mới đơn hàng Online</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" class="form-control" id="order_id" value="">
                    <input type="hidden" class="form-control" id="customer_id" value="">
                    <input type="hidden" class="order_type" value="-1"/>
                    <div class="row">
                        <div class="w150 mr-2">
                            <label>Loại đơn</label>
                            <select class="form-control" name="order_type" id="order_type">
                                <option value="1">Online</option>
                                <option value="0">Shop</option>
                            </select>
                        </div>
                        <div class="w200 mr-2">
                            <label>Mã vận đơn</label>
                            <input type="text" class="form-control" id="bill_of_lading_no" placeholder="Mã vận đơn"
                                   autocomplete="off">
                        </div>
                        <div class="col-4">
                            <label>Phí ship (trả cho đơn vị vận chuyển)</label>
                            <input type="text" class="form-control" id="shipping_fee"
                                   placeholder="Phí ship trả cho đơn vị vận chuyển" autocomplete="off">
                        </div>
                        <div class="col-4">
                            <label>Đơn vị vận chuyển</label>
                            <select class="select-shipping-unit form-control" id="shipping_unit">
                                <option value="Viettel Post" selected="selected">Viettel Post</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Họ tên <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="customer_name" placeholder="Họ tên"
                                   autocomplete="off">
                        </div>
                        <div class="col-4">
                            <label>Số điện thoại <span style="color:red">*</span></label>
                            <input type="number" class="form-control" id="phone_number" placeholder="Nhập số điện thoại"
                                   min="0">
                        </div>
                        <div class="col-4">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Email" autocomplete="off">
                        </div>
                        <div class="col-4">
                            <label>Tỉnh / Thành phố <span style="color:red">*</span></label>
                            <select class="select-city form-control" id="select_city">
                                <option value="-1">Lựa chọn</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Quận / Huyện <span style="color:red">*</span></label>
                            <select class="select-district form-control" id="select_district">
                                <option value="-1">Lựa chọn</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label>Phường xã <span style="color:red">*</span></label>
                            <select class="select-village form-control" id="select_village">
                                <option value="-1">Lựa chọn</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>Địa chỉ <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="address"
                                   placeholder="Nhập số nhà, thôn xóm ... " autocomplete="off">
                        </div>
                        <div class="col-2">
                            <label>Trạng thái</label>
                            <select class="form-control" name="order_status" id="order_status">
                                <option value="0">Đang đợi</option>
                                <option value="1" selected="selected">Đang xử lý</option>
                                <option value="2">Đang giữ</option>
                                <option value="3">Hoàn thành</option>
                                <option value="4">Đã hủy</option>
                                <option value="5">Thất bại</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label>Ngày đặt hàng</label>
                            <input class="form-control datepicker" id="orderDate" data-date-format="dd/mm/yyyy"
                                   value="<?php echo date('d/m/Y'); ?>">
                        </div>
                        
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" value="0" class="count-row"/>
                    <div class="row product">
                        <div class="w130">
                            <label>Mã sản phẩm <span style="color:red">*</span></label>
                        </div>
                        <div class="col-4">
                            <label for="product_name_1">Tên sản phẩm</label>
                        </div>
                        <input type="hidden" id="variantId_1">
                        <div class="w130">
                            <label>Đơn giá</label>
                        </div>
                        <div class="col-1">
                            <label>Số lượng</label>
                        </div>
                        <div class="w130">
                            <label>Giảm trừ</label>
                        </div>
                        <div class="w130">
                            <label>Tổng</label>
                        </div>
                        <div class="col-1 center">
                            <label>Chọn</label>
                        </div>
                    </div>
                    <div class="form-group product-area">

                    </div>
                </div>

                <div class="form-group total-area">
                    <div class="row pd-t-5">
                        <div class="col-9 right pd-t-10">
                            <label class="pd-t-5">Tổng tiền hàng</label>
                        </div>
                        <h3 class="col-2 right pt-2" id="total_amount">0</h3>
                    </div>
                    <div class="row pd-t-5">
                        <div class="col-9 right pd-t-10">
                            <label>Phí ship (KH trả)</label>
                        </div>
                        <div class="col-2 right pd-t-5">
                            <input type="text" class="form-control" id="shipping" placeholder="Phí ship"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="row pd-t-5">
                        <div class="col-9 right pd-t-10">
                            <label>Chiết khấu</label>
                        </div>
                        <div class="col-2 right pd-t-5">
                            <input type="text" class="form-control" id="discount" placeholder="Giảm trừ"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="row pd-t-5">
                        <div class="col-9 right pd-t-10">
                            <label>Tổng thanh toán</label>
                        </div>
                        <h3 class="col-2 right pt-2" style="color: red;" id="total_checkout">0</h3>
                    </div>
                    <div class="row pd-t-5">
                        <div class="col-9 right pd-t-10">
                            <label>Khách thanh toán</label>
                        </div>
                        <div class="col-2 right pd-t-5">
                            <select class="form-control" name="payment_type" id="payment_type">
                                <option value="0">Tiền mặt</option>
                                <option value="1" selected="selected">Chuyển khoản</option>
                                <option value="2">Nợ</option>
                            </select>
                            <input type="text" class="form-control mt-2 hidden" name="payment" id="payment"
                                    width="100px" style="text-align: right;">
                        </div>
                    </div>
                    <div class="row pd-t-5">
                        <div class="col-9 right pd-t-10">
                            <label>Trả lại</label>
                        </div>
                        <h6 class="col-2 right pt-2" id="repay">0</h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info print_receipt_popup"><i class="fa fa-print"></i> In hóa đơn</button>
                <button type="button" class="btn btn-primary" id="create_new">Tạo mới</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  <?php require_once ('../../common/js.php'); ?>
    <script>
        let data_products;
        let flagError = 0;
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'vi',
                todayBtn: true,
                todayHighlight: true,
                autoclose: true
            });

            $("#order_type").change(function(){
                let order_type = $(this).val();
                onchange_order_type(order_type);
            });

            $("#payment_type").change(function(){
                if($(this).val() == 0) {
                    $("#payment").removeClass("hidden");
                    $("#payment").focus();
                } else {
                    $("#payment").val("");
                    $("#payment").addClass("hidden");
                }
            });

            $("#payment").change(function() {
                $("#payment").removeClass("is-invalid");
                let total_checkout = $("#total_checkout").text();
                total_checkout = replaceComma(total_checkout);
                let customer_payment = $("#payment").val();
                customer_payment = replaceComma(customer_payment);
                let repay = 0;
                if(customer_payment > total_checkout) {
                    repay = Number(customer_payment) - Number(total_checkout);
                } else if(customer_payment < total_checkout) {
                    $("#payment").addCLass("is-invalid");
                    return false;
                }
                $(this).val(formatNumber(customer_payment));
                $("#repay").text(formatNumber(repay));
            });

            $('.order-create').click(function () {
                reset_data();
                add_new_product();
                generate_select2_city();
                open_modal();
            });
            // $('.order-update').click(function () {
            //     update_data();
            // });

            $('.select-city').on('select2:select', function (e) {
                let data = e.params.data;
                let cityId = data.id;
                generate_select2_district(cityId);
            });
            $('.select-district').on('select2:select', function (e) {
                let data = e.params.data;
                let districtId = data.id;
                generate_select2_village(districtId);
                check_products_list();
            });

            $('#create_new').click(function () {
                create_new();
            });
            $("#shipping").change(function () {
                let e = this;
                let val = $(e).val();
                val = replaceComma(val);
                if (isNaN(val)) {
                    $(e).addClass("is-invalid");
                    disable_btn_add_new();
                } else {
                    $(e).removeClass("is-invalid");
                    check_products_list();
                    // if(val < 1000)
                    // {
                    //   if(val.indexOf(".") > 0)
                    //   {
                    //     val = val.replace(".","");
                    //     val = val+"00";
                    //   } else {
                    //     val = val+"000";
                    //   }
                    // }
                    val = Number(val);
                    $(e).val(formatNumber(val));
                    on_change_total();
                }
            });
            $("#discount").change(function () {
                let e = this;
                let val = $(e).val();
                val = replaceComma(val);
                if (isNaN(val)) {
                    $(e).addClass("is-invalid");
                    disable_btn_add_new();
                } else {
                    $(e).removeClass("is-invalid");
                    check_products_list();
                    // if(val < 1000)
                    // {
                    //   if(val.indexOf(".") > 0)
                    //   {
                    //     val = val.replace(".","");
                    //     val = val+"00";
                    //   } else {
                    //     val = val+"000";
                    //   }
                    // }
                    val = Number(val);
                    $(e).val(formatNumber(val));
                    on_change_total();
                }
            });

            $("#email").change(function () {
                let val = $(this).val();
                if (val != "" && !validateEmail(val)) {
                    $(this).addClass("is-invalid");
                    disable_btn_add_new();
                } else {
                    $(this).removeClass("is-invalid");
                    check_products_list();
                }
            });
            $("#shipping_fee").change(function () {
                let e = this;
                let val = $(e).val();
                val = replaceComma(val);
                if (isNaN(val)) {
                    $(e).addClass("is-invalid");
                    disable_btn_add_new();
                } else {
                    $(e).removeClass("is-invalid");
                    check_products_list();
                    val = Number(val);
                    $(e).val(formatNumber(val));
                }
            });
            $(".add-new-prod").on("click", function () {
                $(".add-new-prod").prop("disabled", true);
                add_new_product();
            });
            
            $(".print_receipt_popup").on("click", function () {
                let order_id = $("#order_id").val();
                let order_type = $("#order_type").val();
                console.log(order_id);
                console.log(order_type);
                print_receipt(order_id, order_type);
            });
        });

        function validate() {
            $(".modal-body").find("input").removeClass("is-invalid");
            $(".modal-body").find("select").removeClass("is-invalid");
            let order_type = $('#order_type').val();
            if (order_type == 1) {
                // online
                let customer_name = $("#customer_name").val();
                if (customer_name === "") {
                    $("#customer_name").addClass("is-invalid");
                    disable_btn_add_new();
                    return false;
                } else {
                    $("#customer_name").removeClass("is-invalid");
                    check_products_list();
                }
                let phone_number = $("#phone_number").val();
                if (phone_number === "") {
                    $("#phone_number").addClass("is-invalid");
                    disable_btn_add_new();
                    return false;
                } else {
                    $("#phone_number").removeClass("is-invalid");
                    check_products_list();
                }
                let cityId = $(".select-city").val();
                if (cityId === "-1") {
                    $(".select-city").addClass("is-invalid");
                    disable_btn_add_new();
                    return false;
                } else {
                    $(".select-city").removeClass("is-invalid");
                    check_products_list();
                    let districtId = $(".select-district").val();
                    if (districtId === "-1") {
                        $(".select-district").addClass("is-invalid");
                        disable_btn_add_new();
                        return false;
                    } else {
                        $(".select-district").removeClass("is-invalid");
                        check_products_list();
                        let villageId = $(".select-village").val();
                        if (villageId === "-1") {
                            $(".select-village").addClass("is-invalid");
                            disable_btn_add_new();
                            return false;
                        } else {
                            $(".select-village").removeClass("is-invalid");
                            check_products_list();
                            let add = $("#address").val();
                            if (add === "") {
                                $("#address").addClass("is-invalid");
                                disable_btn_add_new();
                                return false;
                            } else {
                                $("#address").removeClass("is-invalid");
                                check_products_list();
                            }
                        }

                    }
                }
            }
            let payment_type = $("#payment_type").val();
            if(payment_type == 0) {
                let customer_payment = $("#payment").val();
                if(customer_payment === "") {
                    $("#payment").addClass("is-invalid");
                    disable_btn_add_new();
                    return false;
                } else {
                    $("#payment").removeClass("is-invalid");
                    check_products_list();
                }
            } 
            return true;
        }

        function onchange_order_type(order_type) {
            if(order_type == 0) {
                // on shop
                $("#bill_of_lading_no").prop("disabled", true);
                $("#shipping_fee").prop("disabled", true);
                $("#shipping_unit").prop("disabled", true);
                $("#customer_name").prop("disabled", true);
                $("#phone_number").prop("disabled", true);
                $("#email").prop("disabled", true);
                $("#select_city").prop("disabled", true);
                $("#select_district").prop("disabled", true);
                $("#select_village").prop("disabled", true);
                $("#address").prop("disabled", true);
                $("#shipping").prop("disabled", true);
            } else {
                // online
                $("#bill_of_lading_no").prop("disabled", "");
                $("#shipping_fee").prop("disabled", "");
                $("#shipping_unit").prop("disabled", "");
                $("#customer_name").prop("disabled", "");
                $("#phone_number").prop("disabled", "");
                $("#email").prop("disabled", "");
                $("#select_city").prop("disabled", "");
                $("#select_district").prop("disabled", "");
                $("#select_village").prop("disabled", "");
                $("#address").prop("disabled", "");
                $("#shipping").prop("disabled", "");
            }
        }

        function check_products_list() {
            let rowProductNumber = $(".count-row").val();
            for (let i = 1; i <= rowProductNumber; i++) {
                let prodId = $("#prod_" + i).val();
                console.log(prodId);
                if (typeof prodId != "undefined" && prodId == "") {
                    $("#prod_" + i).focus();
                    disable_btn_add_new();
                    return;
                }
                $(".add-new-prod").prop("disabled", false);
                enable_btn_add_new();
            }
        }

        function create_new() {
            if (!validate()) {
                return;
            }
            let data = {};
            data["order_type"] = $('#order_type').val();
            data["order_id"] = $("#order_id").val();
            data["customer_id"] = $("#customer_id").val();
            data["bill_of_lading_no"] = $("#bill_of_lading_no").val();
            data["shipping_fee"] = replaceComma($("#shipping_fee").val());
            data["shipping_unit"] = $(".select-shipping-unit").val();
            data["customer_name"] = $("#customer_name").val();
            data["phone_number"] = $("#phone_number").val();
            data["email"] = $("#email").val();
            data["cityId"] = $(".select-city").val();
            data["districtId"] = $(".select-district").val();
            data["villageId"] = $(".select-village").val();
            data["address"] = $("#address").val();
            data["shipping"] = replaceComma($("#shipping").val());
            data["discount"] = replaceComma($("#discount").val());
            data["total_amount"] = replaceComma($("#total_amount").text());
            data["total_checkout"] = replaceComma($("#total_checkout").text());
            data["payment_type"] = $("#payment_type").val();
            data["order_date"] = $("#orderDate").val();
            data["order_status"] = $("#order_status").val();
            data["customer_payment"] = replaceComma($("#payment").val());
            let rowProductNumber = $(".count-row").val();

            let products = [];
            for (let i = 1; i <= rowProductNumber; i++) {
                let product = {};
                let sku = $("#sku_" + i).val();
                if (typeof sku !== "undefined" && sku !== "") {
                    product["sku"] = $("#sku_" + i).val();
                } else {
                    continue;
                }

                let detailId = $("#detailId_" + i).val();
                if (typeof detailId !== "undefined" && detailId !== "") {
                    product["detail_id"] = $("#detailId_" + i).val();
                }
                let prodId = $("#prod_" + i).val();
                if (typeof prodId !== "undefined" && prodId !== "") {
                    product["product_id"] = $("#prod_" + i).val();
                }
                let variantId = $("#variantId_" + i).val();
                if (typeof variantId !== "undefined" && variantId !== "") {
                    product["variant_id"] = $("#variantId_" + i).val();
                }

                let qty = $("#prodQty_" + i).val();
                if (typeof qty !== "undefined" && qty !== "") {
                    product["quantity"] = $("#prodQty_" + i).val();
                }
                let price = $("#prodPrice_" + i).val();
                if (typeof price !== "undefined" && price !== "") {
                    product["price"] = replaceComma($("#prodPrice_" + i).val());
                }
                let reduce = $("#prodReduce_" + i).val();
                if (typeof reduce !== "undefined" && reduce !== "") {
                    product["reduce"] = replaceComma($("#prodReduce_" + i).val());
                }
                products.push(product);
            }
            if(products.length === 0) {
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Chưa có sản phẩm"
                });
                return;
            }
            data["products"] = products;
            console.log(JSON.stringify(data));
            let title = 'Bạn có chắc chắn muốn tạo đơn hàng này?';
            let order_id = $("#order_id").val();
            if (order_id != "underfined" && order_id != "") {
                title = 'Bạn có chắc chắn muốn cập nhật đơn hàng này?';
            }
            Swal.fire({
                title: title,
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    $("#create-order .overlay").removeClass("hidden");
                    $.ajax({
                        dataType: 'json',
                        url: '<?php Common::getPath() ?>src/controller/orders/OrderController.php',
                        data: {
                            method: 'add_new',
                            data: JSON.stringify(data)
                        },
                        type: 'POST',
                        success: function (data) {
                            console.log(data);
                            let order_id = $("#order_id").val();
                            let msg;
                            if (order_id != "underfined" && order_id != "") {
                                msg = "Đơn hàng #" + order_id + " đã được cập nhật thành công.!!!";
                            } else {
                                msg = "Đơn hàng #" + data.order_id + " đã được tạo thành công.!!!";
                            }
                            toastr.success(msg);
                            reset_data();
                            $("#create-order .close").click();
                            $("#create-order .overlay").addClass("hidden");
                            table.ajax.reload();
                            get_info_total_checkout($("#startDate").val(), $("#endDate").val());
                        },
                        error: function (data, errorThrown) {
                            console.log(data.responseText);
                            console.log(errorThrown);
                            Swal.fire({
                                type: 'error',
                                title: 'Đã xảy ra lỗi',
                                text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                            })
                            $("#create-order .overlay").addClass("hidden");
                        }
                    });

                }
            })
        }

        function reset_data() {
            $(".modal-title").text("Tạo mới đơn hàng");
            $("#create_new").text("Tạo mới");
            $("#order_type").val("1");
            $("#payment_type").val("1").trigger("change");
            $("#customer_id").val("");
            $("#bill_of_lading_no").val("");
            $("#shipping_fee").val("");
            $("#customer_name").val("");
            $("#phone_number").val("");
            $("#email").val("");
            $(".select-city").val(-1).trigger("change");
            $(".select-district").val(-1).trigger("change");
            $(".select-village").val(-1).trigger("change");
            $("#address").val("");
            $("#shipping").val("");
            $("#discount").val("");
            $("#total_amount").text("0");
            $("#total_checkout").text("0");
            $(".product-area").html("");
            $('.count-row').val("");
            $('#order_id').val("");
            disable_btn_add_new();
            onchange_order_type(1);
        }

        function disable_btn_add_new() {
            // $(".create-new").prop("disabled", true);
        }

        function enable_btn_add_new() {
            // $(".create-new").prop("disabled", false);
        }

        function new_product(e, rowIndex) {
            let val = $(e).parent().parent().find("#sku_" + rowIndex).val();
            if (val == "") {
                $(e).parent().parent().find("#sku_" + rowIndex).focus();
            } else {
                add_new_product();
                $(".add-new-prod").prop("disabled", true);
                disable_btn_add_new();
            }

        }

        function add_new_product() {
            let noRow = $('.count-row').val();
            noRow = Number(noRow) + 1;
            $('.count-row').val(noRow);
            let content = '<div class="row" id="product-' + noRow + '" style="padding-top: 10px;">' +
                '<div class="w130">' +
                '<input type="hidden" class="form-control" id="detailId_' + noRow + '">' +
                '<input type="hidden" class="form-control" id="prod_' + noRow + '">' +
                '<input type="text" class="form-control" id="sku_' + noRow + '" placeholder="Nhập mã sản phẩm" onchange="on_change_product_2(this, ' + noRow + ')" onblur="blur_check(this)" onfocus="onfocus_check(this)">' +
                '</div>' +
                '<div class="col-4">' +
                '<input type="text" class="form-control" id="product_name_' + noRow + '" disabled="disabled">' +
                '</div>' +
                '<input type="hidden" id="variantId_' + noRow + '">' +
                '<div class="w130">' +
                '<input type="text" class="form-control" id="prodPrice_' + noRow + '" placeholder="0" disabled="disabled" onchange="on_change_qty(\'prodQty_' + noRow + '\', \'prodPrice_' + noRow + '\', \'prodTotal_' + noRow + '\')">' +
                '</div><div class="col-1">' +
                '<input type="number" class="form-control" id="prodQty_' + noRow + '" placeholder="0" disabled="disabled"  min="1" onchange="on_change_qty(\'prodQty_' + noRow + '\', \'prodPrice_' + noRow + '\', \'prodTotal_' + noRow + '\', ' + noRow + ', \'prodReduce_' + noRow + '\')">' +
                '</div>' +
                '<div class="w130 mr-2">' +
                '<input type="text" class="form-control" id="prodReduce_' + noRow + '" placeholder="0" min="0" disabled="disabled" onchange="on_change_reduce(this, \'prodQty_' + noRow + '\', \'prodPrice_' + noRow + '\', \'prodTotal_' + noRow + '\', ' + noRow + ')">' +
                '</div>' +
                '<div class="w130">' +
                '<input type="text" class="form-control" id="prodTotal_' + noRow + '" placeholder="0" min="0" disabled="disabled">' +
                '</div>' +
                '<div class="col-1">';
            if (noRow == 1) {
                content += '<button type="button" class="btn btn-success form-control add-new-prod" title="Thêm sản phẩm" onclick="new_product(this, ' + noRow + ');">' +
                    '<i class="fa fa-plus-circle" aria-hidden="true"></i>' +
                    '</button>';
            } else {
                content += '<button type="button" class="btn btn-danger form-control" onclick="del_product(this, \'product-' + noRow + '\',' + noRow + ')" title="Xóa sản phẩm">' +
                    '<i class="fa fa-minus-circle" aria-hidden="true"></i>' +
                    '</button>';
            }

            // '</div>' +
            content += '</div></div>';
            $(".product-area").append(content);
            $('#sku_' + noRow).focus();

            // generate_select2_products('.select-product-'+noRow);
        }

        function on_change_total() {
            let total_amount = 0;
            let rowProductNumber = $(".count-row").val();
            for (let i = 1; i <= rowProductNumber; i++) {
                let prodTotal = $("#prodTotal_" + i).val();
                if (typeof prodTotal !== "undefined" && prodTotal !== "") {
                    prodTotal = Number(replaceComma(prodTotal));
                    total_amount += prodTotal;
                }
            }
            $("#total_amount").text(formatNumber(total_amount));
            let shipping = $("#shipping").val();
            if (shipping !== "") {
                shipping = Number(replaceComma(shipping));
            }
            let discount = $("#discount").val();
            if (discount !== "") {
                discount = Number(replaceComma(discount));
            }
            let total_checkout = total_amount + shipping - discount;
            $("#total_checkout").text(formatNumber(total_checkout));
        }

        function on_change_qty(qtyId, priceId, totalId, rowIndex, reduceId) {
            let qty = $("[id=" + qtyId + "]").val();
            let price = $("[id=" + priceId + "]").val();
            let reduce = $("[id=" + reduceId + "]").val();
            let total = Number(qty) * (Number(replaceComma(price)) - Number(replaceComma(reduce)));
            if (total > 0) {
                $("[id=" + totalId + "]").val(formatNumber(total));
            } else {
                $("[id=" + totalId + "]").val(0);
            }
            $("[id=" + totalId + "]").trigger("change");
            on_change_total(rowIndex);
        }

        function on_change_reduce(e, qtyId, priceId, totalId, rowIndex) {
            let val = $(e).val();
            if (val.indexOf("%") > -1) {
                val = replacePercent(val);
            } else {
                val = replaceComma(val);
            }
            if (isNaN(val)) {
                $(e).addClass("is-invalid");
                disable_btn_add_new();
            } else {
                $(e).removeClass("is-invalid");
                check_products_list();
                val = Number(val);
                $(e).val(formatNumber(val));
                let qty = $("[id=" + qtyId + "]").val();
                let price = $("[id=" + priceId + "]").val();
                let total = Number(qty) * (Number(replaceComma(price)) - Number(val));
                if (total > 0) {
                    $("[id=" + totalId + "]").val(formatNumber(total));
                } else {
                    $("[id=" + totalId + "]").val(0);
                }
                $("[id=" + totalId + "]").trigger("change");
                on_change_total(rowIndex);
            }
        }

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }

        function validateEmail(email) {
            let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }

        function replaceComma(value) {
            return value.replace(/,/g, '');
        }

        function replacePercent(value) {
            return value.replace(/%/g, '');
        }

        function onfocus_check(e) {
            $(e).removeClass("is-invalid");
        }

        function blur_check(e) {
            if ($(e).val() === "") {
                $(e).addClass("is-invalid");
                disable_btn_add_new();
            }
        }

        function on_change_product_2(e, rowIndex) {
            let val = $(e).val();
            let priceId = "prodPrice_" + rowIndex;
            let productName = "product_name_" + rowIndex;
            let prodQty = "prodQty_" + rowIndex;
            let variantId = "variantId_" + rowIndex;
            $(e).removeClass("is-invalid");
            $.ajax({
                dataType: "json",
                url: "<?php Common::getPath() ?>src/controller/orders/OrderController.php",
                data: {
                    method: 'find_product_by_sku',
                    sku: val
                },
                type: 'POST',
                success: function (data) {
                    if (data.length > 0) {
                        $.each(data, function (k, v) {
                            let name = v.name + " - " + v.size + " - " + v.color;
                            $("[id=prod_" + rowIndex + "]").val(v.product_id);
                            $("[id=sku_" + rowIndex + "]").val(v.sku);
                            $("[id=" + productName + "]").val(name);
                            $("[id=" + priceId + "]").val(v.retail);
                            $("[id=" + variantId + "]").val(v.variant_id);
                            $("[id=prodReduce_" + rowIndex + "]").prop("disabled", false);
                            if (v.retail.replace(",", "") > 0) {
                                let qty = $("[id=" + prodQty + "]").val();
                                if (qty == "underfined" || qty == "") {
                                    $("[id=" + prodQty + "]").val(1);
                                }
                                $("[id=" + prodQty + "]").removeAttr("disabled");
                            } else {
                                $("[id=" + prodQty + "]").val(0);
                                $("[id=" + prodQty + "]").attr("disabled", "disabled");
                            }
                            $("[id=" + prodQty + "]").trigger("change");
                            on_change_total(rowIndex);
                            $(".add-new-prod").prop("disabled", false);
                            check_products_list();
                        });
                    } else {
                        $(e).addClass("is-invalid");
                        disable_btn_add_new();
                    }
                },
                error: function (data, errorThrown) {
                    console.log(data.responseText);
                    console.log(errorThrown);
                    $(e).addClass("is-invalid");
                    disable_btn_add_new();
                }
            });
        }

        function on_change_product(prodId) {
            let no = prodId.split("_");
            let priceId = "prodPrice_" + no[1];
            let prodQty = "prodQty_" + no[1];
            let variantId = "variantId_" + no[1];
            let totalId = "totalId_" + no[1];
            $("[id='" + prodId + "']").on('select2:select', function (e) {
                let data = e.params.data;
                $("[id=" + priceId + "]").val(data.price);
                $("[id=" + variantId + "]").val(data.variant_id);
                if (data.price.replace(",", "") > 0) {
                    $("[id=" + prodQty + "]").val(1);
                    $("[id=" + prodQty + "]").removeAttr("disabled");
                } else {
                    $("[id=" + prodQty + "]").val(0);
                    $("[id=" + prodQty + "]").attr("disabled", "disabled");
                }
                $("[id=" + prodQty + "]").trigger("change");
                // $("[id="+totalId+"]").trigger("change");
                on_change_total();
            });
        }

        function del_product(e, p, rowIndex) {
            let sku = $("#sku_" + rowIndex).val();
            if (sku != "") {
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
                        toastr.success('Sản phẩm đã được xóa thành công.');
                        on_change_total(rowIndex);
                        check_products_list();
                    }
                })
            } else {
                $(e).closest("[id='" + p + "']").remove();
                // $(".add-new-prod").prop("disabled", false);
                check_products_list();
            }
        }

        function open_modal() {
            $('#create-order').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }

        function generate_select2_city() {
            $("#create-order .overlay").removeClass("hidden");
            $.ajax({
                dataType: "json",
                url: "<?php Common::getPath() ?>src/controller/orders/OrderController.php",
                data: {
                    orders: 'loadDataCity'
                },
                type: 'GET',
                success: function (data) {
                    $('.select-city').select2({
                        data: data.results,
                        theme: 'bootstrap4',
                    });
                    $("#create-order .overlay").addClass("hidden");
                },
                error: function (data, errorThrown) {
                    console.log(data.responseText);
                    console.log(errorThrown);
                    $("#create-order .overlay").addClass("hidden");
                }
            });
        }

        function generate_select2_district(cityId) {
            $("#create-order .overlay").removeClass("hidden");
            $('.select-district').empty();
            $.ajax({
                dataType: "json",
                url: "<?php Common::getPath() ?>src/controller/orders/OrderController.php",
                data: {
                    orders: 'loadDataDistrict',
                    cityId: cityId
                },
                type: 'GET',
                success: function (data) {
                    $('.select-district').select2({
                        data: data.results,
                        theme: 'bootstrap4',
                    });
                    $("#create-order .overlay").addClass("hidden");
                    let select = $('.select-district');
                    let option = $('<option></option>').
                        attr('selected', true).
                        text("Lựa chọn").
                        val(-1);
                    option.prependTo(select);
                    select.trigger('change');
                },
                error: function (data, errorThrown) {
                    console.log(data.responseText);
                    console.log(errorThrown);
                    $("#create-order .overlay").addClass("hidden");
                }
            });
        }

        function generate_select2_village(districtId) {
            $("#create-order .overlay").removeClass("hidden");
            $('.select-village').empty();
            $.ajax({
                dataType: "json",
                url: "<?php Common::getPath() ?>src/controller/orders/OrderController.php",
                data: {
                    orders: 'loadDataVillage',
                    districtId: districtId
                },
                type: 'GET',
                success: function (data) {
                    $('.select-village').select2({
                        data: data.results,
                        theme: 'bootstrap4',
                    });
                    let select = $('.select-village');
                    let option = $('<option></option>').
                        attr('selected', true).
                        text("Lựa chọn").
                        val(-1);
                    option.prependTo(select);
                    select.trigger('change');
                    $("#create-order .overlay").addClass("hidden");

                },
                error: function (data, errorThrown) {
                    console.log(data.responseText);
                    console.log(errorThrown);
                    $("#create-order .overlay").addClass("hidden");
                }
            });
        }

        function generate_select2_products(el) {
            // $.getJSON("<?php //echo __PATH__.'src/controller/orders/products.json' ?>",function(data){
            $(el).select2({
                data: data_products.results,
                theme: 'bootstrap4',
            });
            // });
        }
    </script>
