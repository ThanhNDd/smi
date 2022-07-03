<?php
require_once("../../common/common.php");
Common::authen();
?>
<div class="modal fade" id="create_order">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="overlay d-flex justify-content-center align-items-center">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title modal-order">Tạo mới đơn hàng Online</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" class="form-control" id="order_id" value="">
                    <input type="hidden" class="form-control" id="customer_id" value="">
                    <input type="hidden" class="order_type" value="-1"/>
                    <div class="form-group row col-md-12">
                        <div class="col-md-2 hidden">
                            <label>Loại đơn</label>
                            <select class="form-control order-type" name="order_type" id="order_type">
                                <option value="1">Online</option>
                                <option value="0">Shop</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Số điện thoại <span style="color:red">*</span></label>
                            <div class="input-group mb-1 customer-phone">
                                <input type="text" class="form-control" id="customer_phone" placeholder="Nhập số điện thoại" autocomplete="off">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-info btn-flat" id="btn_add_customer" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content="Thêm mới khách hàng">
                                        <i class="fa fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Tên khách hàng</label>
                            <input class="form-control" id="customer_name">
                        </div>
                        <div class="col-md-2">
                            <label for="orderDate">Ngày đặt hàng</label>
                            <div class="input-group mb-1">
                                <input type="text" class="form-control datetimepicker" id="orderDate" placeholder="Ngày đặt hàng" autocomplete="off" value="<?php echo date('Y-m-d H:i:s'); ?>">
                            </div>
                        </div>
                      <div class="col-md-2 hidden order-delivery-date">
                        <label for="orderAppointmentDeliveryDate">Ngày giao hàng</label>
                        <div class="input-group mb-1">
                          <input type="text" class="form-control delivery-date" id="orderAppointmentDeliveryDate" placeholder="Ngày giao hàng" autocomplete="off" value="<?php echo date('Y-m-d H:i:s'); ?>">
                        </div>
                      </div>
                        <div class="col-md-2">
                            <label>Trạng thái</label>
                            <select class="form-control order-status" name="order_status" id="order_status">
                                <option value="0" selected="selected">Chưa xử lý</option>
                                <option value="13">Đã tạo đơn</option>
                                <option value="1">Đã gói hàng</option>
                                <option value="2">Đã giao</option>
                                <option value="3">Hoàn thành</option>
                                <option value="4">Đổi size</option>
                                <option value="5">Chuyển hoàn</option>
                                <option value="6">Huỷ</option>
                                <option value="7">Giao hàng sau</option>
                                <option value="8">Đợi hàng về</option>
                                <option value="9">Chờ duyệt hoàn</option>
                                <option value="10">Đã duyệt hoàn</option>
                                <option value="11">Chờ đổi size</option>
                                <option value="12">Đã đổi size</option>
                                <option value="14">Chờ duyệt</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row col-md-12">
                        <div class="col-md-2">
                            <label>Mã vận đơn</label>
                            <input type="text" class="form-control" id="bill_of_lading_no" placeholder="Mã vận đơn"
                                   autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <label>Nguồn đặt hàng</label>
                            <select class="form-control order-source" id="order_source">
                                <option value="2" selected="selected">Facebook</option>
                                <option value="4">FB TTTE</option>
                                <option value="1">Website</option>
                                <option value="3">Shopee</option>
                                <option value="5">Lazada</option>
                                <option value="6">Zalo</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Phí ship</label>
                            <input type="text" class="form-control" id="shipping_fee"
                                   placeholder="Phí ship trả cho đơn vị vận chuyển" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <label>Đơn vị vận chuyển</label>
                            <select class="shipping-unit form-control" id="shipping_unit">
                                <option value="J&T" selected="selected">J&T Express</option>
                                <option value="SPXEXPRESS">SHOPEE Express</option>
                                <option value="VTP">Viettel Post</option>
                                <option value="GHN">Giao Hàng Nhanh</option>
                                <option value="GHTK">Giao Hàng Tiết Kiệm</option>
                                <option value="VNP">Việt Nam Post</option>
                                <option value="VNPN">Việt Nam Post Nhanh</option>
                                <option value="NINJAVAN">Ninja Van</option>
                                <option value="BESTEXPRESS">BEST Express</option>
                                <option value="GRABEXPRESS">GRAB Express</option>
                            </select>
                        </div>
                        <!-- <div class="col-md-2 hidden">
                          <label>Phí đổi size</label>
                          <input type="text" class="form-control" id="exchange_cost"
                                 placeholder="Phí đổi size" autocomplete="off">
                        </div> -->
                        <div class="col-md-2">
                            <label>Mã đơn hàng Shopee</label>
                            <input type="text" class="form-control" id="shopee_order_id" placeholder="Mã đơn hàng Shopee"
                                   autocomplete="off">
                        </div>
                        <!--<div class="col-md-2">-->
                        <!--  <label>Ghi chú</label>-->
                        <!--  <input type="text" class="form-control" id="description"-->
                        <!--         placeholder="Ghi chú đơn hàng" autocomplete="off">-->
                        <!--</div>-->
                    </div>
                    <div class="form-group row col-md-12">
                        <textarea class="col-md-9 m-2 form-control" rows="3" id="description" placeholder="Ghi chú đơn hàng"></textarea>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label>Thêm sản phẩm</label>
                    <input class="form-control col-md-3" id="add_product" placeholder="Nhập mã sản phẩm"
                           data-toggle="popover_add_product" data-content="Nhập mã sản phẩm">
                </div>
                <div class="form-group col-md-12">
                    <input type="hidden" value="0" class="count-row"/>
                    <table class="table table-hover table-striped" id="table_list_product">
                        <thead>
                            <tr>
                                <th class="hidden"></th>
                                <th class="hidden"></th>
                                <th>Hình ảnh</th>
                                <th>SKU</th>
                                <th>Tên</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Giảm giá</th>
                                <th>Tổng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="form-group total-area col-md-12">
                    <div class="row pd-t-5 col-md-12">
                        <div class="col-6 right pd-t-10 text-right">
                            <label class="pd-t-5">Tổng tiền hàng</label>
                        </div>
                        <h3 class="col-6 right pt-2 text-left" id="total_amount">0</h3>
                    </div>
                    <div class="row pd-t-5 col-md-12">
                        <div class="col-6 right pd-t-10 text-right">
                            <label>Phí ship (KH trả)</label>
                        </div>
                        <div class="col-6 right pd-t-5">
                            <input type="text" class="form-control col-md-4" id="shipping" placeholder="Phí ship"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="row pd-t-5 col-md-12">
                        <div class="col-6 right pd-t-10 text-right">
                            <label>Chiết khấu</label>
                        </div>
                        <div class="col-6 right pd-t-5">
                            <input type="text" class="form-control col-md-4" id="discount" placeholder="Giảm trừ"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="row pd-t-5 col-md-12">
                        <div class="col-6 right pd-t-10 text-right">
                            <label>Tổng giảm trừ</label>
                        </div>
                        <h4 class="col-6 right pt-2 text-left" id="total_reduce">0</h4>
                    </div>
                    <div class="row pd-t-5 col-md-12">
                        <div class="col-6 right pd-t-10 text-right">
                            <label>Tổng thanh toán</label>
                        </div>
                        <h3 class="col-6 right pt-2 text-left" style="color: red;" id="total_checkout">0</h3>
                    </div>
                    <div class="row pd-t-5 col-md-12">
                        <div class="col-6 right pd-t-10 text-right">
                            <label>Khách thanh toán</label>
                        </div>
                        <div class="col-md-2 col-sm-6 pd-t-5">
                            <select class="form-control payment-type col-md-4" name="payment_type" id="payment_type">
                                <option value="0" selected="selected">COD</option>
                                <option value="1">Chuyển khoản</option>
                            </select>
                            <input type="text" class="form-control mt-2 hidden" name="payment" id="payment"
                                   width="100px" style="text-align: right;">
                        </div>
                    </div>
                    <div class="row pd-t-5 col-md-12">
                        <div class="col-6 right pd-t-10 text-right">
                            <label>Trả lại</label>
                        </div>
                        <h6 class="col-6 right pt-2 text-left" id="repay">0</h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info print_receipt_popup"><i class="fa fa-print"></i> In hóa đơn</button>
                <button type="button" class="btn btn-primary" id="create_new_order">Tạo mới</button>
            </div>
        </div>
        <!-- /.modal-content -->
        <?php require_once '../customer/createCustomer.php'; ?>
    </div>
    <!-- /.modal-dialog -->
</div>
    <?php require_once ('../../common/js.php'); ?>
    <script>
        $(document).ready(function () {
            load_customer_info();
            generate_select2('.order-type');
            generate_select2('.order-status');
            generate_select2('.order-source');
            generate_select2('.shipping-unit');
            generate_select2('.payment-type');
            create_customer();

            $('.delivery-date').datetimepicker({
                format: 'YYYY-MM-DD hh:mm:ss',
                minDate: $("#orderDate").val(),
                icons: {
                    time: 'far fa-clock',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-check',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                }
            });

            $("#order_type").change(function(){
                let order_type = $(this).val();
                onchange_order_type(order_type);
            });
            // $("#payment_type").change(function(){
            //     if ($(this).val() === "0") {
            //         $("#payment").removeClass("hidden").focus();
            //     } else {
            //         $("#payment").val("").addClass("hidden");
            //     }
            // });
            // $("#payment").change(function() {
            //     $("#payment").removeClass("is-invalid");
            //     let customer_payment = format_money(replaceComma($("#payment").val()));
            //     if (customer_payment && isNaN(customer_payment)) {
            //         $("#payment").addClass("is-invalid");
            //         return false;
            //     }
            //     let total_checkout = replaceComma($("#total_checkout").text());
            //     let repay = 0;
            //     if(customer_payment > total_checkout) {
            //         repay = Number(customer_payment) - Number(total_checkout);
            //     } else if(customer_payment < total_checkout) {
            //         $("#payment").addClass("is-invalid");
            //         return false;
            //     }
            //     $(this).val(formatNumber(customer_payment));
            //     $("#repay").text(formatNumber(repay));
            // });

            $('.order-create').click(function () {
                reset_data();
                set_row_index(1);
                add_new_product();
                open_modal('#create_order');
            });
            $('#create_new_order').click(function () {
                create_new_order();
            });
            $("#shipping").change(function () {
                let e = this;
                let val = $(e).val();
                val = format_money(val);
                val = replaceComma(val);
                if (isNaN(val)) {
                    $(e).addClass("is-invalid");
                    // // disable_btn_add_new();
                } else {
                    $(e).removeClass("is-invalid");
                    check_products_list();
                    val = Number(val);
                    $(e).val(formatNumber(val));
                    // on_change_total();
                    calculate_total();
                }
            });
            $("#discount").change(function () {
                let e = this;
                let val = $(e).val();
                val = format_money(val);
                val = replaceComma(val);
                if (isNaN(val)) {
                    $(e).addClass("is-invalid");
                    // // disable_btn_add_new();
                } else {
                    $(e).removeClass("is-invalid");
                    // check_products_list();
                    val = Number(val);
                    $(e).val(formatNumber(val));
                    // on_change_total();
                    calculate_total();
                }
            });

            $("#email").change(function () {
                let val = $(this).val();
                if (val != "" && !validate_email(val)) {
                    $(this).addClass("is-invalid");
                    // // disable_btn_add_new();
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
                } else {
                    $(e).removeClass("is-invalid");
                    check_products_list();
                    val = Number(val);
                    $(e).val(formatNumber(val));
                }
                calculate_total();
            });
            $(".add-new-prod").on("click", function () {
                let curr_row_index = get_row_index();
                curr_row_index++;
                set_row_index(curr_row_index);
                add_new_product();
            });

            $(".print_receipt_popup").on("click", function () {
                let order_id = $("#order_id").val();
                let order_type = $("#order_type").val();
                console.log(order_id);
                console.log(order_type);
                print_receipt(order_id, order_type);
            });

            add_product();
            $('[data-toggle="popover"]').popover();

            $("#customer_phone").on('blur', function () {
                let phone = $(this).val();
                if(phone) {
                    phone = format_phone(phone);
                    $("#customer_phone").val(phone);
                    check_exist_customer(phone);
                }
            });
            $("#customer_phone").on('keypress', function (event) {
                let keycode = event.keyCode;
                let phone = $(this).val();
                if(keycode === 13 && phone) {
                    $("#customer_phone").val(format_phone(phone));
                    check_exist_customer(phone);
                }
            });

            $(".order-status").change(function () {
                if($(this).val() == 7) {
                    // giao hàng sau
                    $(".order-delivery-date").removeClass("hidden");
                } else {
                    $(".order-delivery-date").addClass("hidden");
                    $("#orderAppointmentDeliveryDate").val($("#orderDate").val());
                }

                if($(this).val() == 11 || $(this).val() == 12 || $(this).val() == 4) {
                    // chờ đổi size
                    $("#exchange_cost").closest('div').removeClass("hidden");
                } else {
                    $("#exchange_cost").val('').closest('div').addClass("hidden");
                }
            });
        });

        function create_customer() {
            $("#btn_add_customer").click(function () {
                reset_data_customer();
                open_modal('#create_customer');
            });
        }

        function check_exist_customer(phone) {
            $("#customer_phone").removeClass("is-invalid");
            if(!validate_phone(phone)) {
                toastr.error("Số điện thoại chưa đúng");
                $("#customer_phone").addClass("is-invalid");
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
                    if(!res) {
                        $("#customer_id").val("");
                        $("#customer_name").val("");
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
                                $("#phone_number").val(format_phone(phone));
                                generate_select2_city();
                                open_modal('#create_customer');
                            }
                        })
                    } else {
                        $("#customer_id").val(res.id);
                        $("#customer_name").val(res.name);
                    }
                }
            });
        }

        function validate_order() {
            let is_valid = true;
            $(".modal-body").find("input").removeClass("is-invalid");
            $(".modal-body").find("select").removeClass("is-invalid");

            let customer_phone = $("#customer_phone").val();
            let order_type = $('#order_type').val();
            if (order_type === "1") {
                if (!customer_phone) {
                    $("#customer_phone").addClass("is-invalid");
                    is_valid = false;
                } else {
                    $("#customer_phone").removeClass("is-invalid");
                }
            }
            let customer_id = $("#customer_id").val();
            if (customer_phone && !customer_id) {
                check_exist_customer(customer_phone);
            }
            let table = $("#table_list_product tbody tr").length;
            if (!table || table === 0) {
                is_valid = false;
                toastr.error("Chưa có sản phẩm");
            } else {
                $("#table_list_product tbody tr").each(function () {
                    let row_id = $(this).attr("id");
                    if (row_id) {
                        row_id = row_id.split("_")[1];
                        let qty = $("[id=qty_" + row_id + "]").val();
                        if (!qty || qty < 1) {
                            is_valid = false;
                            $("[id=qty_" + row_id + "]").addClass("is-invalid");
                            // return false;
                        } else {
                            $("[id=qty_" + row_id + "]").removeClass("is-invalid");
                        }
                        let reduce = $("[id=reduce_" + row_id + "]").val();
                        if (reduce) {
                            reduce = replaceComma(replacePercent(reduce));
                            if (isNaN(reduce) || Number(reduce) < 0) {
                                $("[id=reduce_" + row_id + "]").addClass("is-invalid");
                                is_valid = false;
                                // return false;
                            } else {
                                $("[id=reduce_" + row_id + "]").removeClass("is-invalid");
                            }
                        } else {
                            $("[id=reduce_" + row_id + "]").removeClass("is-invalid");
                        }
                    }
                });
            }
            // let payment_type = $("#payment_type").val();
            // if(payment_type && payment_type === "0") {
            //     let customer_payment = format_money(replaceComma($("#payment").val()));
            //     if (!customer_payment || isNaN(customer_payment)) {
            //         $("#payment").addClass("is-invalid");
            //         is_valid = false;
            //         // toastr.error("Chưa nhập số tiền thanh toán");
            //     } else {
            //         $("#payment").removeClass("is-invalid");
            //     }
            // }
            if(!is_valid) {
                toastr.error("Đã xảy ra lỗi");
            }
            return is_valid;
        }

        function check_products_list() {
            let rowProductNumber = get_row_index();
            for (let i = 1; i <= rowProductNumber; i++) {
                let prodId = $("#prod_" + i).val();
                console.log(prodId);
                if (!prodId) {
                    $("#prod_" + i).focus();
                    return;
                }
                $(".add-new-prod").prop("disabled", false);
            }
        }

        function onchange_order_type(order_type) {
            if(order_type === "0") {
                // on shop
                $("#bill_of_lading_no").prop("disabled", true);
                $("#shipping_fee").prop("disabled", true);
                $("#shipping_unit").prop("disabled", true);
                $("#order_source").prop("disabled", true);
                $("#shipping").prop("disabled", true);
                $("#payment_type").val("0").trigger("change");
            } else {
                // online
                $("#bill_of_lading_no").prop("disabled", "");
                $("#shipping_fee").prop("disabled", "");
                $("#shipping_unit").prop("disabled", "");
                $("#order_source").prop("disabled", "");
                $("#shipping").prop("disabled", "");
                $("#payment_type").val("0").trigger("change");
            }
        }

        function create_new_order() {
            if (!validate_order()) {
                return;
            }
            let total_amount = replaceComma($("#total_amount").text());
            let total_reduce = replaceComma($("#total_reduce").text());
            let total_checkout = replaceComma($("#total_checkout").text());
            let discount = replaceComma($("#discount").val());
            if (discount.indexOf("%") > -1) {
                discount = discount.replace("%", "");
                discount = (discount * total_checkout) / 100;
            }
            // let customer_payment = replaceComma($("#payment").val());
            let payment_type = $("#payment_type").val();
            let repay = Number(replaceComma($("#repay").val()));
            let transferToWallet = 0;
            let totalUsePoint = 0;
            let totalRemainPoint = 0;
            let totalSavedPoint = 0;
            let customer_id = $("#customer_id").val();

            let data = {};
            data["order_type"] = $('#order_type').val();
            data["order_id"] = $("#order_id").val();

            let order_type = $('#order_type').val();
            data["customer_id"] = customer_id;

            let source = 0;// shop
            let bill_of_lading_no = '';
            let shipping_fee = 0;
            let shipping_unit = 0;
            let shopee_order_id = 0;
            if (order_type == "1") {
                // online
                bill_of_lading_no = $("#bill_of_lading_no").val();
                shipping_fee = replaceComma($("#shipping_fee").val());
                shipping_unit = $("#shipping_unit").val();
                source = $("#order_source").val();
                shopee_order_id = $("#shopee_order_id").val();
            }
            data["bill_of_lading_no"] = bill_of_lading_no;
            data["shipping_fee"] = shipping_fee;
            data["shipping_unit"] = shipping_unit;
            data["shopee_order_id"] = shopee_order_id;

            let order_status = $("#order_status").val();
            let order_date = $("#orderDate").val();
            let shipping = $("#shipping").val() ? replaceComma($("#shipping").val()) : 0;
            let appointment_delivery_date = '';
            if(order_status == 7) {
                appointment_delivery_date = $("#orderAppointmentDeliveryDate").val();
            }
            let description = $("#description").val();

            data["source"] = source;
            data["shipping"] = shipping;
            data["discount"] = discount;
            data["total_amount"] = total_amount;
            data["wallet"] = totalUsePoint;
            data["total_reduce"] = total_reduce;
            data["total_checkout"] = total_checkout;
            data["payment_type"] = payment_type;
            data["repay"] = repay;
            data["transfer_to_wallet"] = transferToWallet;
            data["order_date"] = order_date;
            data["appointment_delivery_date"] = appointment_delivery_date;
            data["order_status"] = Number(order_status);
            data["customer_payment"] = total_checkout;
            data["voucher_code"] = '';
            data["voucher_value"] = '';
            data["current_order_id"] = 0;
            data["payment_exchange_type"] = 0;
            data["wallet_used"] = totalUsePoint;
            data["wallet_saved"] = totalSavedPoint;
            data["wallet_repay"] = transferToWallet;
            data["wallet_remain"] = totalRemainPoint;
            data["description"] = description;

            let products = [];
            $("#table_list_product tbody tr").each(function () {
                let row_id = $(this).attr("id");
                row_id = row_id.replace("row_","");
                if (row_id) {
                    let price = replaceComma($("[id=price_" + row_id + "]").text());
                    let quantity = $("[id=qty_" + row_id + "]").val();
                    let reduce = Number(replacePercent(replaceComma($("[id=reduce_" + row_id + "]").val())));
                    let reduce_type = 0;
                    let reduce_percent = "";
                    if(reduce > 0) {
                        if (reduce < 101) {
                            reduce_percent = reduce;
                            reduce = (reduce * price) / 100;
                            reduce_type = 0;
                        } else {
                            reduce_percent = Math.round(reduce * 100 / (price * quantity));
                            reduce_type = 1;
                        }
                    }
                    let product = {};
                    product["product_id"] = $("[id=product_id_" + row_id + "]").text();
                    product["variant_id"] = $("[id=variant_id_" + row_id + "]").text();
                    product["sku"] = $("[id=sku_" + row_id + "]").text();
                    product["product_name"] = $("[id=product_name_" + row_id + "]").text();
                    product["price"] = price;
                    product["quantity"] = quantity;
                    product["reduce"] = reduce;
                    product["reduce_percent"] = reduce_percent;
                    product["reduce_type"] = reduce_type;
                    product["product_exchange"] = 0;
                    product["profit"] = replaceComma($("[id=profit_" + row_id + "]").text());
                    products.push(product);
                }
            });
            if(products.length === 0) {
                alert_error_message("Chưa có sản phẩm hoặc thông tin sản phẩm lỗi. Vui lòng kiểm tra lại");
                return;
            }
            data["products"] = products;
            console.log(JSON.stringify(data));
            let title = 'Bạn có chắc chắn muốn tạo đơn hàng này?';
            let order_id = $("#order_id").val();
            if (order_id) {
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
                    show_loading();
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
                            if (order_id) {
                                msg = "Đơn hàng #" + order_id + " đã được cập nhật thành công.!!!";
                            } else {
                                msg = "Đơn hàng #" + data.order_id + " đã được tạo thành công.!!!";
                            }
                            Swal.fire(msg).then((result) => {
                                if (result.value) {
                                    // reset_data();
                                    // $("#create_order .close").click();
                                    // hide_loading();
                                    // table.ajax.reload();
                                    // get_info_total_checkout('date');
                                    window.location.reload();
                                }
                            });
                        },
                        error: function (data, errorThrown) {
                            console.log(data.responseText);
                            console.log(errorThrown);
                            alert_error_message();
                            hide_loading();
                        }
                    });

                }
            })
        }

        function reset_data() {
            $(".modal-order").text("Tạo mới đơn hàng");
            $("#create_new_order").text("Tạo mới");
            $("#order_type").val("1").trigger("change");
            $("#payment_type").val("0").trigger("change");
            $("#customer_id").val("");
            $("#bill_of_lading_no").val("");
            $("#customer_name").val("");
            $("#customer_phone").val("");
            $("#order_status").val("0").trigger("change");
            $("#shipping_fee").val("");
            $("#shipping").val("0").trigger("change");
            $("#discount").val("");
            $("#total_amount").text("0");
            $("#total_checkout").text("0");
            $("#repay").text("0");
            $('#order_id').val("");
            $("#table_list_product tbody").html("");
            $('#exchange_cost').val("");
            $("#description").val("");
            row_description = 1;

            // onchange_order_type(1);
        }

        // function new_product(e, rowIndex) {
        //     let val = $(e).parent().parent().find("#sku_" + rowIndex).val();
        //     // if (val == "") {
        //     //     $(e).parent().parent().find("#sku_" + rowIndex).focus();
        //     // } else {
        //         add_new_product();
        //         // $(".add-new-prod").prop("disabled", true);
        //         // disable_btn_add_new();
        //     // }
        //
        // }

        function add_new_product() {
            let noRow = get_row_index();
            // $('.count-row').val(noRow);
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
            // if (noRow === 1) {
            //     content += '<button type="button" class="btn btn-success form-control add-new-prod" title="Thêm sản phẩm" onclick="add_new_product(this, ' + noRow + ');">' +
            //         '<i class="fa fa-plus-circle" aria-hidden="true"></i>' +
            //         '</button>';
            // } else {
                content += '<button type="button" class="btn btn-danger form-control" onclick="del_product(this, \'product-' + noRow + '\',' + noRow + ')" title="Xóa sản phẩm">' +
                    '<i class="fa fa-minus-circle" aria-hidden="true"></i>' +
                    '</button>';
            // }

            // '</div>' +
            content += '</div></div>';
            $(".product-area").append(content);
            // $('#sku_' + noRow).focus();
            // generate_select2_products('.select-product-'+noRow);
        }


        let row_num = 1;
        let row_description = 1;
        function add_product() {
            $("#add_product").change(function (e) {
                let _self = $(this);
                let sku = $(_self).val();
                console.log("SKU === " + sku);
                let is_exist_sku = checking_exist_sku_in_table_list(sku);
                if (!is_exist_sku) {
                    console.log("!is_exist_sku");
                    $.ajax({
                        dataType: "json",
                        url: "<?php Common::getPath() ?>src/controller/orders/OrderController.php",
                        data: {
                            method: 'find_product_by_sku',
                            sku: sku
                        },
                        type: 'POST',
                        success: function (data) {
                            if (data.length > 0) {
                                console.log("draw_table");
                                console.log(JSON.stringify(data));
                                add_product_list(data);
                                generate_description(data);
                                // calculate_total();
                                $(_self).val("");
                            } else {
                                $(e).addClass("is-invalid");
                                Swal.fire({
                                    type: 'error',
                                    title: 'Không tìm thấy sản phẩm',
                                    text: "Vui lòng kiểm tra lại mã sản phẩm"
                                });
                            }
                        },
                        error: function (data, errorThrown) {
                            console.log(data.responseText);
                            console.log(errorThrown);
                            $(e).addClass("is-invalid");
                        }
                    });
                }
            });
        }
        
        function generate_description(data) {
            let description = $("#description").val();
            $.each(data, function (k, v) {
                let product_name = row_description + '. ' +v.name + ',' + v.color + ',' +v.size+'\n';
                description += product_name;
                row_description++;
            });
            $("#description").val(description);
        }

        function add_product_list(data) {
            // row_num = 1;
            // let description = $("#description").val();
            $.each(data, function (k, v) {
                let retail = 0;
                if (v.retail) {
                    retail = Number(replaceComma(v.retail));
                }
                let quantity = 1;
                // if(v.quantity) {
                //     quantity = v.quantity;
                // }
                let total = 0;
                let reduce = '';
                if (v.discount && v.discount !== '' && v.discount !== '0') {
                    reduce = Number(replaceComma(v.discount));
                    if (reduce > 0 && reduce < 101) {
                        // reduce = Number(v.discount) * retail / 100;
                        total = retail * (100 - reduce) / 100;
                        reduce += "%";
                    } else {
                        // reduce = Number(replaceComma(v.discount));
                        total = retail - reduce;
                        reduce = formatNumber(reduce);
                    }
                } else {
                    total = retail;
                }
                total = total*quantity;

                console.log(JSON.stringify(v));
                // let product_name = row_description + '. ' +v.name + ',' + v.color + ',' +v.size+'|\n';
                // description += product_name;
                let content = "<tr id=\"row_" + row_num + "\">\n" +
                    "<td id=\"product_id_" + row_num + "\" class=\"hidden\">" + v.product_id + "</td>\n" +
                    "<td id=\"variant_id_" + row_num + "\" class=\"hidden\">" + v.variant_id + "</td>\n" +
                    "<td id=\"profit_" + row_num + "\" class=\"hidden\">" + v.profit + "</td>\n" +
                    "<td id=\"image_" + row_num + "\" class=\"w100\"><img src='" + v.image + "' style=\"border-radius: 50%;\" onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"' width='50px'></td>\n" +
                    "<td id=\"sku_" + row_num + "\" class=\"w100\">" + v.sku + "</td>\n" +
                    "<td id=\"name_" + row_num + "\" class=\"w200\"><strong>" + v.name + "</strong><br><small>Màu: " + v.color + "</small><br><small>Size: " + v.size + "</small></td>\n" +
                    "<td id=\"price_" + row_num + "\" class=\"w150\">" + formatNumber(retail) + "</td>\n" +
                    "<td><input type=\"number\" class=\"form-control w100\" id=\"qty_" + row_num + "\" min=\"1\" value=\""+quantity+"\" onchange=\"onchange_in_list(this, " + row_num + ")\"></td>\n" +
                    "<td><input type=\"text\" class=\"form-control w150\" id=\"reduce_" + row_num + "\" value='" + reduce + "' onchange=\"onchange_in_list(this, " + row_num + ", 'reduce')\"></td>\n" +
                    "<td id=\"total_" + row_num + "\" class=\"w150\">" + formatNumber(total) + "</td>\n" +
                    "<td id=\"delete_" + row_num + "\">" +
                    '<i class="fa fa-sync text-info c-pointer" title="Đổi sản phẩm" onclick="exchange_product(this)" "></i>' +
                    '<input type="text" class="form-control hidden" placeholder="Nhập mã sản phẩm" onchange="find_product_exchange(this)">' +
                    '<i class="fa fa-times-circle text-danger ml-1 c-pointer hidden" title="Huỷ đổi" onclick="cancel_exchange_product(this)" "></i>' +
                    "<a href=\"javascript:void(0)\" onclick='delete_product_in_list(" + row_num + ")' class=\"btn\"><i class=\"fa fa-trash text-danger\"></i></a></td>\n" +
                    "</tr>";
                $("#table_list_product tbody").append(content);
                row_num++;
                // row_description++;
                if(k === data.length-1) {
                    calculate_total();
                }
            });
            // $("#description").val(description);
        }

        function exchange_product(e) {
            $(e).addClass('hidden');
            $(e).next().removeClass('hidden').focus();
            $(e).next().next().removeClass('hidden');
        }

        function cancel_exchange_product(e) {
            $(e).addClass('hidden');
            $(e).prev().addClass('hidden').val('');
            $(e).prev().prev().removeClass('hidden');
        }

        function find_product_exchange(e) {
            let sku = $(e).val();
            $.ajax({
                url: '<?php Common::getPath() ?>src/controller/sales/processCheckout.php',
                type: "POST",
                dataType: "json",
                data: {
                    type: "find_product",
                    sku: sku
                },
                success: function (res) {
                    console.log(res[0].product_id);

                    // let table = '<tr>' +
                    //     '<input type="hidden" value="' + res[0].product_id + '"/>' +
                    //     '<input type="hidden" value="' + res[0].variant_id + '"/>' +
                    //     '<td>' + res[0].sku + '</td>' +
                    //     '<td>' + res[0].name + '</td>' +
                    //     '<td>' + res[0].size + '</td>' +
                    //     '<td>' + res[0].color + '</td>' +
                    //     '<td><input type="number" class="form-control" value="1"></td>' +
                    //     '<td class="right">' + res[0].price + '<sup>đ</sup></td>' +
                    //     '<td class="right">' + res[0].discount + '<sup>đ</sup></td>' +
                    //     '<td class="right">' + res[0].price + '<sup>đ</sup></td>' +
                    //     '<td class="right">' + formatNumber(res[0].profit) + '<sup>đ</sup></td>' +
                    //     '<td><span class="badge badge-success">Đổi</span></td>' +
                    //     '</tr>';

                    let table = "<tr id=\"row_" + row_num + "\">\n" +
                        "<td id=\"product_id_" + row_num + "\" class=\"hidden\">" + res[0].product_id + "</td>\n" +
                        "<td id=\"variant_id_" + row_num + "\" class=\"hidden\">" + res[0].variant_id + "</td>\n" +
                        "<td id=\"profit_" + row_num + "\" class=\"hidden\">" + res[0].profit + "</td>\n" +
                        "<td id=\"image_" + row_num + "\" class=\"w100\"><img src='" + res[0].image + "' style=\"border-radius: 50%;\" onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"' width='50px'></td>\n" +
                        "<td id=\"sku_" + row_num + "\" class=\"w100\">" + res[0].sku + "</td>\n" +
                        "<td id=\"name_" + row_num + "\" class=\"w200\"><strong>" + res[0].name + "</strong><br><small>Màu: " + res[0].color + "</small><br><small>Size: " + res[0].size + "</small></td>\n" +
                        "<td id=\"price_" + row_num + "\" class=\"w150\">" + formatNumber(res[0].retail) + "</td>\n" +
                        "<td><input type=\"number\" class=\"form-control w100\" id=\"qty_" + row_num + "\" min=\"1\" value=\"1\" onchange=\"onchange_in_list(this, " + row_num + ")\"></td>\n" +
                        "<td><input type=\"text\" class=\"form-control w150\" id=\"reduce_" + row_num + "\" value='" + (res[0].discount > 0 ? res[0].discount : '')+ "' onchange=\"onchange_in_list(this, " + row_num + ", 'reduce')\"></td>\n" +
                        "<td id=\"total_" + row_num + "\" class=\"w150\">" + formatNumber(res[0].retail) + "</td>\n" +
                        "<td id=\"delete_" + row_num + "\">" +
                        "<span class=\"badge badge-info\">Đổi</span>" +
                        "<a href=\"javascript:void(0)\" onclick='delete_product_in_list(" + row_num + ")' class=\"btn\"><i class=\"fa fa-trash text-danger\"></i></a>" +
                        "</td>\n" +
                        "</tr>";

                    $(e).closest('tr').after(table);

                    $(e).addClass('hidden').val('');
                    $(e).next().addClass('hidden');
                    $(e).prev().prev().removeClass('hidden');
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

        function onchange_in_list(e, row_num, type) {
            let val = $(e).val();
            val = replaceComma(val);
            val = replacePercent(val);
            val = format_money(val);
            if (isNaN(val) || val < 0) {
                $(e).addClass("is-invalid");
                return;
            } else {
                $(e).removeClass("is-invalid");
            }
            $(e).val(formatNumber(val));
            calculate_total_in_list(row_num);
            calculate_total();
        }

        function checking_exist_sku_in_table_list(sku) {
            console.log("checking_exist_sku_in_table_list ",sku);
            let is_exist_sku = false;
            let row_index = 1;
            let description = $("#description").val();
            $("#table_list_product tbody tr").each(function () {
                let sku_in_list = $("#sku_" + row_index).text();
                console.log("checking_exist_sku_in_table_list in each ", sku_in_list);
                if (sku_in_list === sku) {
                    let qty = $("#qty_" + row_index).val();
                    qty = Number(qty);
                    qty++;
                    $("#qty_" + row_index).val(qty);
                    calculate_total_in_list(row_index);
                    calculate_total();
                    $("#add_product").val("");
                    is_exist_sku = true;
                    let name = $("#name_" + row_index).text();
                    name = name.replace('Màu: ',',').replace('Size: ',',');
                    console.log(name);
                    let product_name = row_description + '. ' + name + '|\n';
                    description += product_name;
                    row_description++;
                }
                row_index++;
            });
            $("#description").val(description);
            return is_exist_sku;
        }
        

        function calculate_total_in_list(row_index) {
            let qty = $("#qty_" + row_index).val();
            if (qty && qty !== "") {
                qty = Number(replaceComma(qty));
            } else {
                qty = 0;
            }
            let price = $("#price_" + row_index).text();
            if (price && price !== "") {
                price = Number(replaceComma(price));
            } else {
                price = 0;
            }
            let reduce = $("#reduce_" + row_index).val();
            reduce = replacePercent(reduce);
            reduce = replaceComma(reduce);
            if (reduce && reduce !== "") {
                reduce = Number(reduce);
            } else {
                reduce = 0;
            }
            if (reduce > 0 && reduce < 101) {
                $("#reduce_" + row_index).val(reduce + "%");
                reduce = reduce * price / 100;
            }
            let subtotal = (price - reduce) * qty;
            $("#total_" + row_index).text(formatNumber(subtotal));
        }



        function delete_product_in_list(rowIndex) {
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
                    $("#table_list_product tbody #row_" + rowIndex).remove();
                    toastr.success('Sản phẩm đã được xóa thành công.');
                    re_draw_table_product_list();
                    // calculate_total();
                }
            })
        }

        function re_draw_table_product_list() {
            row_num = 1;
            let content = "";
            let length = $("#table_list_product tbody tr").length;
            if(length > 0) {
                $("#table_list_product tbody tr").each(function (key, value) {
                    let row_id = $(this).attr("id");
                    row_id = row_id.split("_")[1];
                    // if (row_id) {
                    //     row_id = row_id.replace("row_", "");
                    // }
                    let product_id = $("#product_id_" + row_id).text();
                    let variant_id = $("#variant_id_" + row_id).text();
                    let sku = $("#sku_" + row_id).text();
                    let name = $("#name_" + row_id).html();
                    let price = $("#price_" + row_id).text();
                    let qty = $("#qty_" + row_id).val();
                    let profit_ = $("#profit_" + row_id).text();
                    let image_ = $("#image_" + row_id).find("img").attr("src");
                    let reduce = $("#reduce_" + row_id).val();
                    let total = 0;
                    if (reduce) {
                        reduce = Number(replaceComma(replacePercent(reduce)));
                        if (reduce > 0 && reduce < 101) {
                            total = Number(qty) * (Number(replaceComma(price)) * (100 - reduce) / 100);
                            reduce += "%";
                        } else {
                            total = Number(qty) * (Number(replaceComma(price)) - reduce);
                        }
                    } else {
                        total = Number(qty) * Number(replaceComma(price));
                    }

                    content += "<tr id=\"row_" + row_num + "\">\n" +
                        "<td id=\"product_id_" + row_num + "\" class=\"hidden\">" + product_id + "</td>\n" +
                        "<td id=\"variant_id_" + row_num + "\" class=\"hidden\">" + variant_id + "</td>\n" +
                        "<td id=\"profit_" + row_num + "\" class=\"hidden\">" + profit_ + "</td>\n" +
                        "<td id=\"image_" + row_num + "\" class=\"w100\"><img src='" + image_ + "' onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"' width='50px'></td>\n" +
                        "<td id=\"sku_" + row_num + "\" class=\"w100\">" + sku + "</td>\n" +
                        "<td id=\"name_" + row_num + "\" class=\"w200\">" + name + "</td>\n" +
                        "<td id=\"price_" + row_num + "\" class=\"w150\">" + formatNumber(price) + "</td>\n" +
                        "<td><input type=\"number\" class=\"form-control w100\" id=\"qty_" + row_num + "\" value=\"" + qty + "\" onchange=\"onchange_in_list(this, " + row_num + ")\"></td>\n" +
                        "<td><input type=\"text\" class=\"form-control w150\" id=\"reduce_" + row_num + "\" value='" + reduce + "' onchange=\"onchange_in_list(this, " + row_num + ")\"></td>\n" +
                        "<td id=\"total_" + row_num + "\" class=\"w150\">" + formatNumber(total) + "</td>\n" +
                        "<td id=\"delete_" + row_num + "\"><a href=\"javascript:void(0)\" onclick='delete_product_in_list(" + row_num + ")' class=\"btn\"><i class=\"fa fa-trash text-danger\"></i></a></td>\n" +
                        "</tr>";
                    row_num++;
                    if (key === length - 1) {
                        calculate_total();
                    }
                });
                $("#table_list_product tbody").html(content);
            } else {
                calculate_total();
            }
        }

        function load_customer_info() {
            let customers = new Bloodhound({
                datumTokenizer: function (countries) {
                    return Bloodhound.tokenizers.whitespace(countries.value);
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '<?php Common::getPath() ?>/src/controller/customer/CustomersController.php?method=get_all_customer',
                    filter: function (response) {
                        return response.customers;
                    }
                }
            });
            customers.initialize();
            $('#customer_phone').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'customers',
                displayKey: function (customers) {
                    return customers.customer.phone;
                },
                source: customers.ttAdapter(),
                limit: 10
            });
            $('#customer_phone').bind('typeahead:select', function (ev, suggestions) {
                let customer = suggestions.customer;
                console.log(customer.id);
                console.log(customer.phone);
                console.log(customer.name);
                $("#customer_id").val(customer.id);
                $("#customer_phone").val(format_phone(customer.phone));
                $("#customer_name").val(customer.name);
            });

            $('#customer_name').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'customers',
                displayKey: function (customers) {
                    return customers.customer.name;
                },
                source: customers.ttAdapter(),
                limit: 10
            });
            $('#customer_name').bind('typeahead:select', function (ev, suggestions) {
                let customer = suggestions.customer;
                console.log(customer.id);
                console.log(customer.phone);
                console.log(customer.name);
                $("#customer_id").val(customer.id);
                $("#customer_phone").val(format_phone(customer.phone));
                $("#customer_name").val(customer.name);
            });
        }

        function calculate_total() {
            let total = 0;
            let total_reduce = 0;
            // let row_index = 1;
            let data_length = $("#table_list_product tbody tr").length;
            if(data_length > 0) {
                $("#table_list_product tbody tr").each(function (k, v) {
                    let row_index = $(this).attr("id");
                    row_index = row_index.split("_")[1];
                    let subtotal = $("#total_" + row_index).text();
                    if (subtotal && subtotal !== '') {
                        total += Number(replaceComma(subtotal));
                    }
                    let price = Number(replaceComma($("#total_" + row_index).text()));
                    let qty = Number(replaceComma($("#qty_" + row_index).val()));
                    let reduce = Number(replaceComma(replacePercent($("#reduce_" + row_index).val())));
                    if (reduce > 0) {
                        if (reduce < 101) {
                            total_reduce += reduce * price * qty / 100;
                            $("#reduce_" + row_index).val(reduce + "%");
                        } else {
                            total_reduce += reduce;
                            $("#reduce_" + row_index).val(formatNumber(reduce));
                        }
                    }
                    // row_index++;
                    if (k === data_length - 1) {
                        let shipping_fee = Number(replaceComma($("#shipping_fee").val()));
                        let shipping = Number(replaceComma($("#shipping").val()));
                        let discount = Number(replaceComma($("#discount").val()));
                        let total_checkout = total + shipping - discount - shipping_fee;
                        total_reduce += discount;
                        $("#total_checkout").text(formatNumber(total_checkout));
                        $("#total_reduce").text(formatNumber(total_reduce));
                        $("#total_amount").text(formatNumber(total));
                    }
                });
            } else {
                $("#total_checkout").text(0);
                $("#total_reduce").text(0);
                $("#total_amount").text(0);
            }
        }
        function on_change_total() {
            let total_amount = Number(replaceComma($("#total_amount").text()));
            let shipping = $("#shipping").val();
            if (shipping !== "") {
                shipping = Number(format_money(replaceComma(shipping)));
            }
            let discount = $("#discount").val();
            if (discount !== "") {
                discount = Number(format_money(replaceComma(discount)));
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
            // on_change_total(rowIndex);
            calculate_total();
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
                // disable_btn_add_new();
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
                // on_change_total(rowIndex);
                calculate_total();
            }
        }

        function get_row_index() {
            let row_index = $(".count-row").val();
            if(row_index) {
                return Number(row_index);
            }
            return 0;
        }
        function set_row_index(idx) {
            if(!idx) {
                idx = 0;
            }
            $(".count-row").val(idx);
        }

        function onfocus_check(e) {
            $(e).removeClass("is-invalid");
        }

        function blur_check(e) {
            if ($(e).val() === "") {
                $(e).addClass("is-invalid");
                // disable_btn_add_new();
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
                            // on_change_total(rowIndex);
                            calculate_total();
                            $(".add-new-prod").prop("disabled", false);
                            check_products_list();
                        });
                    } else {
                        $(e).addClass("is-invalid");
                        // disable_btn_add_new();
                    }
                },
                error: function (data, errorThrown) {
                    console.log(data.responseText);
                    console.log(errorThrown);
                    $(e).addClass("is-invalid");
                    // disable_btn_add_new();
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
                // on_change_total();
                calculate_total();
            });
        }

        function del_product(e, p, rowIndex) {
            let sku = $("#sku_" + rowIndex).val();
            if (sku !== "") {
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
                        // on_change_total(rowIndex);
                        // check_products_list();
                        calculate_total();
                        let product_list = get_length_product_list();
                        if(product_list === 0) {
                            set_row_index(1);
                            add_new_product();
                        }
                    }
                })
            } else {
                $(e).closest("[id='" + p + "']").remove();
                let product_list = get_length_product_list();
                if(product_list === 0) {
                    set_row_index(1);
                    add_new_product();
                }
                // $(".add-new-prod").prop("disabled", false);
                // check_products_list();
            }
        }

        function get_length_product_list() {
            return $(".product-area").find(".row").length;
        }

        // function open_modal(modal_element) {
        //     $('#create-order').modal({
        //         backdrop: 'static',
        //         keyboard: false,
        //         show: true
        //     });
        // }

        //function generate_select2_city(city_id) {
        //    $("#create-order .overlay").removeClass("hidden");
        //    $.ajax({
        //        dataType: "json",
        //        url: "<?php //Common::getPath() ?>//src/controller/orders/OrderController.php",
        //        data: {
        //            orders: 'loadDataCity'
        //        },
        //        type: 'GET',
        //        success: function (data) {
        //            $('.select-city').select2({
        //                data: data.results,
        //                theme: 'bootstrap4',
        //            });
        //            $("#create-order .overlay").addClass("hidden");
        //            if(city_id) {
        //                $("#select_city").val(city_id).trigger("change");
        //            }
        //        },
        //        error: function (data, errorThrown) {
        //            console.log(data.responseText);
        //            console.log(errorThrown);
        //            $("#create-order .overlay").addClass("hidden");
        //        }
        //    });
        //}

        //function generate_select2_district(cityId, districtId) {
        //    $("#create-order .overlay").removeClass("hidden");
        //    $('.select-district').empty();
        //    $.ajax({
        //        dataType: "json",
        //        url: "<?php //Common::getPath() ?>//src/controller/orders/OrderController.php",
        //        data: {
        //            orders: 'loadDataDistrict',
        //            cityId: cityId
        //        },
        //        type: 'GET',
        //        success: function (data) {
        //            console.log(data.results);
        //            $('.select-district').select2({
        //                data: data.results,
        //                theme: 'bootstrap4',
        //            });
        //            $("#create-order .overlay").addClass("hidden");
        //            let select = $('.select-district');
        //            let option = $('<option></option>').
        //            attr('selected', true).
        //            text("Lựa chọn").
        //            val(-1);
        //            option.prependTo(select);
        //            select.trigger('change');
        //            if(districtId) {
        //                districtId = districtId.padStart(3,'0');
        //                $(".select-district").val(districtId).trigger("change");
        //            }
        //        },
        //        error: function (data, errorThrown) {
        //            console.log(data.responseText);
        //            console.log(errorThrown);
        //            $("#create-order .overlay").addClass("hidden");
        //        }
        //    });
        //}
        //
        //function generate_select2_village(districtId, villageId) {
        //    $("#create-order .overlay").removeClass("hidden");
        //    $('.select-village').empty();
        //    $.ajax({
        //        dataType: "json",
        //        url: "<?php //Common::getPath() ?>//src/controller/orders/OrderController.php",
        //        data: {
        //            orders: 'loadDataVillage',
        //            districtId: districtId
        //        },
        //        type: 'GET',
        //        success: function (data) {
        //            $('.select-village').select2({
        //                data: data.results,
        //                theme: 'bootstrap4',
        //            });
        //            let select = $('.select-village');
        //            let option = $('<option></option>').
        //            attr('selected', true).
        //            text("Lựa chọn").
        //            val(-1);
        //            option.prependTo(select);
        //            select.trigger('change');
        //            $("#create-order .overlay").addClass("hidden");
        //            if(villageId) {
        //                villageId = villageId.padStart(5,'0');
        //                $(".select-village").val(villageId).trigger("change");
        //            }
        //        },
        //        error: function (data, errorThrown) {
        //            console.log(data.responseText);
        //            console.log(errorThrown);
        //            $("#create-order .overlay").addClass("hidden");
        //        }
        //    });
        //}

        //function generate_select2_products(el) {
        //    // $.getJSON("<?php ////echo __PATH__.'src/controller/orders/products.json' ?>//",function(data){
        //    $(el).select2({
        //        data: data_products.results,
        //        theme: 'bootstrap4',
        //    });
        //    // });
        //}
    </script>
