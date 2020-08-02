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
                    <div class="form-group row">
                        <div class="col">
                            <label>Loại đơn</label>
                            <select class="form-control order-type" name="order_type" id="order_type">
                                <option value="1">Online</option>
                                <option value="0">Shop</option>
                            </select>
                        </div>
                        <div class="col">
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
                        <div class="col">
                            <label>Tên khách hàng</label>
                            <input class="form-control" id="customer_name">
                        </div>
                        <div class="col">
                            <label>Ngày đặt hàng</label>
                            <input class="form-control datepicker" id="orderDate" data-date-format="dd/mm/yyyy"
                                   value="<?php echo date('d/m/Y'); ?>">
                        </div>
                        <div class="col">
                            <label>Trạng thái</label>
                            <select class="form-control order-status" name="order_status" id="order_status">
                                <option value="0">Đang đợi</option>
                                <option value="1" selected="selected">Đang xử lý</option>
                                <option value="2">Đang giữ</option>
                                <option value="3">Hoàn thành</option>
                                <option value="4">Đã hủy</option>
                                <option value="5">Thất bại</option>
                            </select>
                        </div>
<!--                        <div class="col">-->
<!--                            <label>Họ tên <span style="color:red">*</span></label>-->
<!--                            <input type="text" class="form-control" id="customer_name" placeholder="Họ tên"-->
<!--                                   autocomplete="off">-->
<!--                        </div>-->
<!--                        <div class="col">-->
<!--                            <label>Email</label>-->
<!--                            <input type="text" class="form-control" id="email" placeholder="Email" autocomplete="off">-->
<!--                        </div>-->
<!--                        <div class="col">-->
<!--                            <label>Ngày sinh</label>-->
<!--                            <input class="form-control datepicker" id="birthday" data-date-format="dd/mm/yyyy" placeholder="Nhập ngày sinh">-->
<!--                        </div>-->
                    </div>
<!--                    <div class="form-group row">-->
<!--                        <div class="col">-->
<!--                            <label>Tỉnh / Thành phố <span style="color:red">*</span></label>-->
<!--                            <select class="select-city form-control" id="select_city">-->
<!--                                <option value="-1">Lựa chọn</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="col">-->
<!--                            <label>Quận / Huyện <span style="color:red">*</span></label>-->
<!--                            <select class="select-district form-control" id="select_district">-->
<!--                                <option value="-1">Lựa chọn</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="col">-->
<!--                            <label>Phường xã <span style="color:red">*</span></label>-->
<!--                            <select class="select-village form-control" id="select_village">-->
<!--                                <option value="-1">Lựa chọn</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="col">-->
<!--                            <label>Địa chỉ <span style="color:red">*</span></label>-->
<!--                            <input type="text" class="form-control" id="address"-->
<!--                                   placeholder="Nhập số nhà, thôn xóm ... " autocomplete="off">-->
<!--                        </div>-->

<!--                    </div>-->
                    <div class="form-group row">
                        <div class="col">
                            <label>Mã vận đơn</label>
                            <input type="text" class="form-control" id="bill_of_lading_no" placeholder="Mã vận đơn"
                                   autocomplete="off">
                        </div>
                        <div class="col">
                            <label>Nguồn đặt hàng</label>
                            <select class="form-control order-source" id="order_source">
                                <option value="Facebook" selected="selected">Facebook</option>
                                <option value="Website">Website</option>
                                <option value="Shopee">Shopee</option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Phí ship</label>
                            <input type="text" class="form-control" id="shipping_fee"
                                   placeholder="Phí ship trả cho đơn vị vận chuyển" autocomplete="off">
                        </div>
                        <div class="col">
                            <label>Đơn vị vận chuyển</label>
                            <select class="shipping-unit form-control" id="shipping_unit">
                                <option value="VTP" selected="selected">Viettel Post</option>
                                <option value="J&T">J&T Express</option>
                                <option value="GHN">Giao Hàng Nhanh</option>
                                <option value="GHTK">Giao Hàng Tiết Kiệm</option>
                                <option value="VNP">Việt Nam Post</option>
                            </select>
                        </div>

                    </div>

                </div>
                <div class="form-group col-2">
                    <label>Thêm sản phẩm</label>
                    <input class="form-control" id="add_product" placeholder="Nhập mã sản phẩm"
                           data-toggle="popover_add_product" data-content="Nhập mã sản phẩm">
                </div>
                <div class="form-group">
                    <input type="hidden" value="0" class="count-row"/>
<!--                    <div class="row product">-->
<!--                        <div class="w130">-->
<!--                            <label>Mã sản phẩm <span style="color:red">*</span></label>-->
<!--                        </div>-->
<!--                        <div class="col-4">-->
<!--                            <label for="product_name_1">Tên sản phẩm</label>-->
<!--                        </div>-->
<!--                        <input type="hidden" id="variantId_1">-->
<!--                        <div class="w130">-->
<!--                            <label>Đơn giá</label>-->
<!--                        </div>-->
<!--                        <div class="col-1">-->
<!--                            <label>Số lượng</label>-->
<!--                        </div>-->
<!--                        <div class="w130">-->
<!--                            <label>Giảm trừ</label>-->
<!--                        </div>-->
<!--                        <div class="w130">-->
<!--                            <label>Tổng</label>-->
<!--                        </div>-->
<!--                        <div class="col-1 center">-->
<!--                            <label>Chọn</label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group product-area">-->
<!---->
<!--                    </div>-->

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
<!--                            <tr id="row_1">-->
<!--                                <td id="detail_id_1" class="hidden"></td>-->
<!--                                <td id="product_id_1" class="hidden"></td>-->
<!--                                <td id="variant_id_1" class="hidden"></td>-->
<!--                                <td id="sku_1"></td>-->
<!--                                <td id="name_1"></td>-->
<!--                                <td id="price_1"></td>-->
<!--                                <td id="quantity_1"></td>-->
<!--                                <td id="reduce_1"></td>-->
<!--                                <td id="total_1"></td>-->
<!--                                <td id="delete_1"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></td>-->
<!--                            </tr>-->
                        </tbody>
<!--                        <div class="row" id="product-' + noRow + '" style="padding-top: 10px;">' +-->
<!--                            '<div class="w130">' +-->
<!--                                '<input type="hidden" class="form-control" id="detailId_' + noRow + '">' +-->
<!--                                '<input type="hidden" class="form-control" id="prod_' + noRow + '">' +-->
<!--                                '<input type="text" class="form-control" id="sku_' + noRow + '" placeholder="Nhập mã sản phẩm" onchange="on_change_product_2(this, ' + noRow + ')" onblur="blur_check(this)" onfocus="onfocus_check(this)">' +-->
<!--                                '</div>' +-->
<!--                            '<div class="col-4">' +-->
<!--                                '<input type="text" class="form-control" id="product_name_' + noRow + '" disabled="disabled">' +-->
<!--                                '</div>' +-->
<!--                            '<input type="hidden" id="variantId_' + noRow + '">' +-->
<!--                            '<div class="w130">' +-->
<!--                                '<input type="text" class="form-control" id="prodPrice_' + noRow + '" placeholder="0" disabled="disabled" onchange="on_change_qty(\'prodQty_' + noRow + '\', \'prodPrice_' + noRow + '\', \'prodTotal_' + noRow + '\')">' +-->
<!--                                '</div><div class="col-1">' +-->
<!--                                '<input type="number" class="form-control" id="prodQty_' + noRow + '" placeholder="0" disabled="disabled"  min="1" onchange="on_change_qty(\'prodQty_' + noRow + '\', \'prodPrice_' + noRow + '\', \'prodTotal_' + noRow + '\', ' + noRow + ', \'prodReduce_' + noRow + '\')">' +-->
<!--                                '</div>' +-->
<!--                            '<div class="w130 mr-2">' +-->
<!--                                '<input type="text" class="form-control" id="prodReduce_' + noRow + '" placeholder="0" min="0" disabled="disabled" onchange="on_change_reduce(this, \'prodQty_' + noRow + '\', \'prodPrice_' + noRow + '\', \'prodTotal_' + noRow + '\', ' + noRow + ')">' +-->
<!--                                '</div>' +-->
<!--                            '<div class="w130">' +-->
<!--                                '<input type="text" class="form-control" id="prodTotal_' + noRow + '" placeholder="0" min="0" disabled="disabled">' +-->
<!--                                '</div>' +-->
<!--                            '<div class="col-1">';-->
<!--                                // if (noRow === 1) {-->
<!--                                //     content += '<button type="button" class="btn btn-success form-control add-new-prod" title="Thêm sản phẩm" onclick="add_new_product(this, ' + noRow + ');">' +-->
<!--                                    //         '<i class="fa fa-plus-circle" aria-hidden="true"></i>' +-->
<!--                                    //         '</button>';-->
<!--                                // } else {-->
<!--                                content += '<button type="button" class="btn btn-danger form-control" onclick="del_product(this, \'product-' + noRow + '\',' + noRow + ')" title="Xóa sản phẩm">' +-->
<!--                                    '<i class="fa fa-minus-circle" aria-hidden="true"></i>' +-->
<!--                                    '</button>-->
                    </table>
<!--                    <div class="row col-md-12">-->
<!--                        <button type="button" class="btn btn-success form-control add-new-prod col-md-1" title="Thêm sản phẩm">-->
<!--                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm sản phẩm-->
<!--                        </button>-->
<!--                    </div>-->
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
                        <div class="col-2 pd-t-5">
                            <select class="form-control payment-type" name="payment_type" id="payment_type">
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
                <button type="button" class="btn btn-primary" id="create_new_order">Tạo mới</button>
            </div>
        </div>
        <!-- /.modal-content -->
        <?php require_once '../customer/createCustomer.php'; ?>
    </div>
    <!-- /.modal-dialog -->

    <?php require_once ('../../common/js.php'); ?>
    <script>
        // let data_products;
        // let flagError = 0;
        // const Toast = Swal.mixin({
        //     toast: true,
        //     position: 'top-end',
        //     showConfirmButton: false,
        //     timer: 3000
        // });
        $(document).ready(function () {
            // $('.datepicker').datepicker({
            //     format: 'dd/mm/yyyy',
            //     language: 'vi',
            //     todayBtn: true,
            //     todayHighlight: true,
            //     autoclose: true
            // });

            load_customer_info();

            generate_select2('.order-type');
            generate_select2('.order-status');
            generate_select2('.order-source');
            generate_select2('.shipping-unit');
            generate_select2('.payment-type');

            create_customer();

            $("#order_type").change(function(){
                let order_type = $(this).val();
                onchange_order_type(order_type);
            });

            $("#payment_type").change(function(){
                if ($(this).val() === "0") {
                    $("#payment").removeClass("hidden").focus();
                } else {
                    $("#payment").val("").addClass("hidden");
                }
            });

            $("#payment").change(function() {
                $("#payment").removeClass("is-invalid");
                let customer_payment = format_money(replaceComma($("#payment").val()));
                if (customer_payment && isNaN(customer_payment)) {
                    $("#payment").addClass("is-invalid");
                    return false;
                }
                let total_checkout = replaceComma($("#total_checkout").text());
                let repay = 0;
                if(customer_payment > total_checkout) {
                    repay = Number(customer_payment) - Number(total_checkout);
                } else if(customer_payment < total_checkout) {
                    $("#payment").addClass("is-invalid");
                    return false;
                }
                $(this).val(formatNumber(customer_payment));
                $("#repay").text(formatNumber(repay));
            });

            $('.order-create').click(function () {
                reset_data();
                set_row_index(1);
                add_new_product();
                open_modal('#create_order');
            });
            // $('.order-update').click(function () {
            //     update_data();
            // });

            // $('.select-city').on('select2:select', function (e) {
            //     let data = e.params.data;
            //     let cityId = data.id;
            //     generate_select2_district(cityId);
            // });
            // $('.select-district').on('select2:select', function (e) {
            //     let data = e.params.data;
            //     let districtId = data.id;
            //     generate_select2_village(districtId);
            //     check_products_list();
            // });

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
                    on_change_total();
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
                    on_change_total();
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

            $("#customer_phone").on('change', function () {
                let phone = $(this).val();
                if(phone) {
                    check_exist_customer(phone);
                }
            });
            $("#customer_phone").on('keypress', function (event) {
                let keycode = event.keyCode;
                let phone = $(this).val();
                if(keycode === 13 && phone) {
                    check_exist_customer(phone);
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
                // Swal.fire({
                //     type: 'error',
                //     title: 'Đã xảy ra lỗi',
                //     text: 'Số điện thoại chưa đúng!',
                // });
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
                                $("#phone_number").val(phone);
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
                // online
                //     let customer_name = $("#customer_name").val();
                //     if (!customer_name) {
                //         $("#customer_name").addClass("is-invalid");
                //         is_valid = false;
                //     } else {
                //         $("#customer_name").removeClass("is-invalid");
                //     }

                if (!customer_phone) {
                    $("#customer_phone").addClass("is-invalid");
                    is_valid = false;
                    // toastr.error("Chưa nhập số điện thoại");
                } else {
                    $("#customer_phone").removeClass("is-invalid");
                }
            }
            let customer_id = $("#customer_id").val();
            if (customer_phone && !customer_id) {
                check_exist_customer(customer_phone);
            }

            //     let cityId = $(".select-city").val();
            //     if (!cityId || cityId === "-1") {
            //         $(".select-city").addClass("is-invalid");
            //         is_valid = false;
            //     } else {
            //         $(".select-city").removeClass("is-invalid");
            //     }
            //     let districtId = $(".select-district").val();
            //     if (!districtId || districtId === "-1") {
            //         $(".select-district").addClass("is-invalid");
            //         is_valid = false;
            //     } else {
            //         $(".select-district").removeClass("is-invalid");
            //     }
            //     let villageId = $(".select-village").val();
            //     if (!villageId || villageId === "-1") {
            //         $(".select-village").addClass("is-invalid");
            //         is_valid = false;
            //     } else {
            //         $(".select-village").removeClass("is-invalid");
            //     }
            //     let add = $("#address").val();
            //     if (add) {
            //         $("#address").addClass("is-invalid");
            //         is_valid = false;
            //     } else {
            //         $("#address").removeClass("is-invalid");
            //     }
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
                            // toastr.error("Số lượng sản phẩm không đúng!");
                            $("[id=qty_" + row_id + "]").addClass("is-invalid");
                            // return false;
                        } else {
                            $("[id=qty_" + row_id + "]").removeClass("is-invalid");
                        }
                        let reduce = $("[id=reduce_" + row_id + "]").val();
                        if (reduce) {
                            reduce = replaceComma(replacePercent(reduce));
                            if (isNaN(reduce) || Number(reduce) < 0) {
                                // toastr.error("Giảm giá không đúng!");
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

            let payment_type = $("#payment_type").val();
            if(payment_type && payment_type === "0") {
                let customer_payment = format_money(replaceComma($("#payment").val()));
                if (!customer_payment || isNaN(customer_payment)) {
                    $("#payment").addClass("is-invalid");
                    is_valid = false;
                    // toastr.error("Chưa nhập số tiền thanh toán");
                } else {
                    $("#payment").removeClass("is-invalid");
                }
            }
            // let rowProductNumber = get_row_index();
            // for (let i = 1; i <= rowProductNumber; i++) {
            //     let sku = $("#sku_" + i).val();
            //     console.log(sku);
            //     if (!sku) {
            //         $("#sku_" + i).addClass("is-invalid");
            //         is_valid = false;
            //     } else {
            //         $("#sku_" + i).removeClass("is-invalid");
            //     }
            // }


            // else {
            //     $("#table_list_product tbody tr").each(function () {
            //         let row_id = $(this).attr("id");
            //         if(row_id) {
            //             row_id = row_id.split("_")[1];
            //             let product_id = $("[id=qty_"+row_id+"]").text();
            //             let variant_id = $("[id=variant_id_"+row_id+"]").text();
            //         }
            //     });
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
                // $("#customer_name").prop("disabled", true);
                // $("#customer_phone").prop("disabled", true);
                $("#order_source").prop("disabled", true);
                $("#shipping").prop("disabled", true);
                // $("#btn_add_customer").prop("disabled", true);
                // $("#email").prop("disabled", true);
                // $("#select_city").prop("disabled", true);
                // $("#select_district").prop("disabled", true);
                // $("#select_village").prop("disabled", true);
                // $("#address").prop("disabled", true);
                $("#payment_type").val("0").trigger("change");
            } else {
                // online
                $("#bill_of_lading_no").prop("disabled", "");
                $("#shipping_fee").prop("disabled", "");
                $("#shipping_unit").prop("disabled", "");
                // $("#customer_name").prop("disabled", "").prop("readonly", true);
                // $("#customer_phone").prop("disabled", "");
                $("#order_source").prop("disabled", "");
                // $("#btn_add_customer").prop("disabled", "");
                $("#shipping").prop("disabled", "");
                $("#payment_type").val("1").trigger("change");
                // $("#email").prop("disabled", "");
                // $("#select_city").prop("disabled", "");
                // $("#select_district").prop("disabled", "");
                // $("#select_village").prop("disabled", "");
                // $("#address").prop("disabled", "");
            }
        }

        function create_new_order() {
            if (!validate_order()) {
                return;
            }
            let data = {};
            data["order_type"] = $('#order_type').val();
            data["order_id"] = $("#order_id").val();

            let source = 0;// shop
            let order_type = $('#order_type').val();
            data["customer_id"] = $("#customer_id").val();
            if (order_type === "1") {
                // online
                data["bill_of_lading_no"] = $("#bill_of_lading_no").val();
                data["shipping_fee"] = replaceComma($("#shipping_fee").val());
                data["shipping_unit"] = $("#shipping_unit").val();
                // data["customer_name"] = $("#customer_name").val();
                // data["phone_number"] = $("#customer_phone").val();
                // data["email"] = $("#email").val();
                // data["cityId"] = $(".select-city").val();
                // data["districtId"] = $(".select-district").val();
                // data["villageId"] = $(".select-village").val();
                // data["address"] = $("#address").val();
                source = $("#order_source").val();
            }
            data["source"] = source;
            data["shipping"] = replaceComma($("#shipping").val());
            data["discount"] = replaceComma($("#discount").val());
            data["total_amount"] = replaceComma($("#total_amount").text());
            data["total_checkout"] = replaceComma($("#total_checkout").text());
            data["repay"] = replaceComma($("#repay").text());
            data["payment_type"] = $("#payment_type").val();
            data["order_date"] = $("#orderDate").val();
            data["order_status"] = $("#order_status").val();
            data["customer_payment"] = replaceComma($("#payment").val());

            // let rowProductNumber = get_row_index();

            let products = [];
            $("#table_list_product tbody tr").each(function () {
                let row_id = $(this).attr("id");
                if (row_id) {
                    let product = {};
                    row_id = row_id.split("_")[1];
                    product["product_id"] = $("[id=product_id_" + row_id + "]").text();
                    // let product_id = $("[id=product_id_"+row_id+"]").text();
                    // if(product_id) {
                    //     product["product_id"] = product_id;
                    // } else {
                    //     return;
                    // }
                    product["variant_id"] = $("[id=variant_id_" + row_id + "]").text();
                    // let variant_id = $("[id=variant_id_"+row_id+"]").text();
                    // if(variant_id) {
                    //     product["variant_id"] = variant_id;
                    // } else {
                    //     return;
                    // }
                    product["sku"] = $("[id=sku_" + row_id + "]").text();
                    // let sku = $("[id=sku_"+row_id+"]").text();
                    // if(sku) {
                    //     product["sku"] = sku;
                    // } else {
                    //     return;
                    // }
                    product["price"] = replaceComma($("[id=price_" + row_id + "]").text());
                    // let price = $("[id=price_"+row_id+"]").text();
                    // if(price) {
                    //     product["price"] = replaceComma(price);
                    // } else {
                    //     return;
                    // }
                    product["quantity"] = $("[id=qty_" + row_id + "]").val();
                    // let qty = $("[id=qty_"+row_id+"]").val();
                    // if(qty) {
                    //     product["quantity"] = qty;
                    // } else {
                    //     return;
                    // }
                    product["reduce"] = replacePercent(replaceComma($("[id=reduce_" + row_id + "]").val()));
                    // let reduce = $("[id=reduce_"+row_id+"]").val();
                    // if(reduce) {
                    //     product["reduce"] = replacePercent(replaceComma(reduce));
                    // } else {
                    //     product["reduce"] = 0;
                    // }
                    product["profit"] = replaceComma($("[id=profit_" + row_id + "]").text());
                    // let profit = $("[id=profit_"+row_id+"]").text();
                    // if(profit) {
                    //     product["profit"] = replaceComma(profit);
                    // } else {
                    //     return;
                    // }
                    products.push(product);
                }
            });


            // for (let i = 1; i <= rowProductNumber; i++) {
            //     let product = {};
            //     let sku = $("#sku_" + i).val();
            //     if (typeof sku !== "undefined" && sku !== "") {
            //         product["sku"] = $("#sku_" + i).val();
            //     } else {
            //         continue;
            //     }
            //
            //     let detailId = $("#detailId_" + i).val();
            //     if (typeof detailId !== "undefined" && detailId !== "") {
            //         product["detail_id"] = $("#detailId_" + i).val();
            //     }
            //     let prodId = $("#prod_" + i).val();
            //     if (typeof prodId !== "undefined" && prodId !== "") {
            //         product["product_id"] = $("#prod_" + i).val();
            //     }
            //     let variantId = $("#variantId_" + i).val();
            //     if (typeof variantId !== "undefined" && variantId !== "") {
            //         product["variant_id"] = $("#variantId_" + i).val();
            //     }
            //
            //     let qty = $("#prodQty_" + i).val();
            //     if (typeof qty !== "undefined" && qty !== "") {
            //         product["quantity"] = $("#prodQty_" + i).val();
            //     }
            //     let price = $("#prodPrice_" + i).val();
            //     if (typeof price !== "undefined" && price !== "") {
            //         product["price"] = replaceComma($("#prodPrice_" + i).val());
            //     }
            //     let reduce = $("#prodReduce_" + i).val();
            //     if (typeof reduce !== "undefined" && reduce !== "") {
            //         product["reduce"] = replaceComma($("#prodReduce_" + i).val());
            //     }
            //     products.push(product);
            // }
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
                                    reset_data();
                                    $("#create_order .close").click();
                                    hide_loading();
                                    table.ajax.reload();
                                    get_info_total_checkout($("#startDate").val(), $("#endDate").val());
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
            $("#payment_type").val("1").trigger("change");
            $("#customer_id").val("");
            $("#bill_of_lading_no").val("");
            $("#customer_name").val("");
            $("#customer_phone").val("");
            $("#order_status").val("1").trigger("change");
            $("#shipping_fee").val("");
            $("#shipping").val("");
            $("#discount").val("");
            $("#total_amount").text("0");
            $("#total_checkout").text("0");
            $("#repay").text("0");
            $('#order_id').val("");
            $("#table_list_product tbody").html("");

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
                                add_product_list(data);
                                calculate_total();
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

        function add_product_list(data) {
            $.each(data, function (k, v) {
                let retail = 0;
                if (v.retail) {
                    retail = Number(replaceComma(v.retail));
                }
                let total = 0;
                let reduce = '';
                if (v.discount && v.discount !== '' && v.discount !== '0') {
                    reduce = Number(replaceComma(v.discount));
                    if (reduce > 0 && reduce < 101) {
                        // reduce = Number(v.discount) * retail / 100;
                        total = formatNumber(retail * (100 - reduce) / 100);
                        reduce += "%";
                    } else {
                        // reduce = Number(replaceComma(v.discount));
                        total = formatNumber(retail - reduce);
                        reduce = formatNumber(reduce);
                    }
                } else {
                    total = retail;
                }
                let quantity = 1;
                if(v.quantity) {
                    quantity = v.quantity;
                }
                let content = "<tr id=\"row_" + row_num + "\">\n" +
                    "<td id=\"product_id_" + row_num + "\" class=\"hidden\">" + v.product_id + "</td>\n" +
                    "<td id=\"variant_id_" + row_num + "\" class=\"hidden\">" + v.variant_id + "</td>\n" +
                    "<td id=\"profit_" + row_num + "\" class=\"hidden\">" + v.profit + "</td>\n" +
                    "<td id=\"image_" + row_num + "\" class=\"w100\"><img src='" + v.image + "' onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"' width='50px'></td>\n" +
                    "<td id=\"sku_" + row_num + "\" class=\"w100\">" + v.sku + "</td>\n" +
                    "<td id=\"name_" + row_num + "\" class=\"w200\"><strong>" + v.name + "</strong><br><small>Size: " + v.size + "</small><br><small>Màu: " + v.color + "</small></td>\n" +
                    "<td id=\"price_" + row_num + "\" class=\"w150\">" + formatNumber(retail) + "</td>\n" +
                    "<td><input type=\"number\" class=\"form-control w100\" id=\"qty_" + row_num + "\" min=\"1\" value=\""+quantity+"\" onchange=\"onchange_in_list(this, " + row_num + ")\"></td>\n" +
                    "<td><input type=\"text\" class=\"form-control w150\" id=\"reduce_" + row_num + "\" value='" + reduce + "' onchange=\"onchange_in_list(this, " + row_num + ", 'reduce')\"></td>\n" +
                    "<td id=\"total_" + row_num + "\" class=\"w150\">" + formatNumber(total) + "</td>\n" +
                    "<td id=\"delete_" + row_num + "\"><a href=\"javascript:void(0)\" onclick='delete_product_in_list(" + row_num + ")' class=\"btn\"><i class=\"fa fa-trash text-danger\"></i></a></td>\n" +
                    "</tr>";
                $("#table_list_product tbody").append(content);
                row_num++;
            });
        }

        function onchange_in_list(e, row_num, type) {
            let val = $(e).val();
            val = replaceComma(val);
            val = replacePercent(val);
            val = format_money(val);
            if (isNaN(val) || val < 0) {
                // Swal.fire({
                //     type: 'error',
                //     title: 'Đã xảy ra lỗi',
                //     text: 'Giá trị nhập vào phải là số!',
                // });
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
            console.log("checking_exist_sku_in_table_list");
            let is_exist_sku = false;
            let row_index = 1;
            $("#table_list_product tbody tr").each(function () {
                console.log("checking_exist_sku_in_table_list in each");
                let sku_in_list = $("#sku_" + row_index).text();
                if (sku_in_list === sku) {
                    let qty = $("#qty_" + row_index).val();
                    qty = Number(qty);
                    qty++;
                    $("#qty_" + row_index).val(qty);
                    calculate_total_in_list(row_index);
                    calculate_total();
                    $("#add_product").val("");
                    is_exist_sku = true;
                }
                row_index++;
            });
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

        function calculate_total() {
            let total = 0;
            let row_index = 1;
            $("#table_list_product tbody tr").each(function () {
                let subtotal = $("#total_" + row_index).text();
                if (subtotal && subtotal !== '') {
                    total += Number(replaceComma(subtotal));
                }
                row_index++;
            });
            $("#total_amount").text(formatNumber(total));

            let shipping = $("#shipping").val();
            let discount = $("#discount").val();
            let total_checkout = total + Number(replaceComma(shipping)) - Number(replaceComma(discount));
            $("#total_checkout").text(formatNumber(total_checkout));
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
                    calculate_total();
                }
            })
        }

        function re_draw_table_product_list() {
            row_num = 1;
            let content = "";
            $("#table_list_product tbody tr").each(function () {
                let row_id = $(this).attr("id");
                if (row_id) {
                    row_id = row_id.replace("row_", "");
                }
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
                    "<td id=\"delete_" + row_num + "\"><a href=\"javascript:void(0)\" class=\"btn\"><i class=\"fa fa-trash text-danger\"></i></a></td>\n" +
                    "</tr>";
                row_num++;
            });
            $("#table_list_product tbody").html(content);
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
                $("#customer_phone").val(customer.phone);
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
                $("#customer_phone").val(customer.phone);
                $("#customer_name").val(customer.name);
            });
        }






        
        
        
        function on_change_total() {
            // let total_amount = 0;
            // let rowProductNumber = $(".count-row").val();
            // for (let i = 1; i <= rowProductNumber; i++) {
            //     let prodTotal = $("#prodTotal_" + i).val();
            //     if (typeof prodTotal !== "undefined" && prodTotal !== "") {
            //         prodTotal = Number(replaceComma(prodTotal));
            //         total_amount += prodTotal;
            //     }
            // }
            let total_amount = Number(replaceComma($("#total_amount").text()));

            let shipping = $("#shipping").val();
            if (shipping !== "") {
                shipping = Number(format_money(replaceComma(shipping)));
            }
            let discount = $("#discount").val();
            if (discount !== "") {
                // discount = format_money(discount);
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
                on_change_total(rowIndex);
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

        // function formatNumber(num) {
        //     return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        // }

        // function validateEmail(email) {
        //     let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        //     return re.test(String(email).toLowerCase());
        // }

        // function replaceComma(value) {
        //     return value.replace(/,/g, '');
        // }
        //
        // function replacePercent(value) {
        //     return value.replace(/%/g, '');
        // }

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
                            on_change_total(rowIndex);
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
                on_change_total();
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
                        on_change_total(rowIndex);
                        // check_products_list();
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
