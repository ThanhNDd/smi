<?php
  require_once("../../common/common.php");
  Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Khuyến mãi</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php Common::getPath() ?>dist/img/icon.png"/>
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
        #table_list_product.table td, .table th #products_list.table td {
            padding: 5px !important;
        }
        #table_list_product.table td img, #products_list.table td img {
            vertical-align: middle;
            border-style: none;
            width: 50px;
            border-radius: 50%;
        }
        .dataTables_scrollHeadInner {
            width: 100% !important;
        }
        table.table.table-hover.table-striped.dataTable.no-footer {
            width: 100% !important;
        }
        div#products_list_wrapper {
            width: 100%;
        }
        div.dataTables_wrapper div.dataTables_info {
            float: left;
        }
        #table_choose_product td {
          padding: 3px;
          vertical-align: middle;
        }
    </style>
</head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content">
    <div class="row pt-3">
        <div class="col col-md-6 col-sm-4">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Danh sách chương trình khuyến mãi</h3>
                </div>
                <div class="card-body" style="min-height: 615px;">
                    <table id="example" class="table table-hovered table-striped">
                        <thead>
                        <tr>
                            <th class="hidden"></th>
                            <th>Tên</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Loại sale</th>
                            <th>Phạm vi</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col col-md-6 col-sm-8">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Tạo mới chương trình khuyến mãi</h3>
                </div>
                <div class="card-body" style="min-height: 615px;">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" class="form-control" id="promotion_id" value="">
                            <input type="hidden" class="form-control" id="status" value="0">
                            <div class="form-group col-sm">
                                <label for="promotion_name">Tên chương trình</label>
                                <input type="text" class="form-control" placeholder="Nhập tên chương trình" id="promotion_name">
                            </div>
                            <div class="form-group col-sm">
                                <label for="reservation">Chọn ngày</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                                    </div>
                                    <input type="text" class="form-control float-left" id="reservation">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm">
                                <div class="form-group form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="sale_type" value="0">Flash Sale
                                    </label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="sale_type" checked value="1">Sale
                                    </label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" value="0" name="scope" id="website" checked>Website
                                    </label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" value="1" name="scope" id="shop">Shop
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-sm">
                                <button type="button" class="btn btn-outline-info float-right" id="add_new_product" style="font-size: 12px;">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm sản phẩm
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm">
                                <input type="text" class="form-control" placeholder="Giảm theo số tiền cho tất cả" id="sale_money_for_all" disabled>
                            </div>
                            <div class="form-group col-sm">
                                <input type="text" class="form-control" placeholder="Giảm theo % cho tất cả" id="sale_percent_for_all" disabled>
                            </div>
                            <div class="form-group col-sm">
                                <button type="button" class="btn btn-danger" id="clear_sale" style="font-size: 12px;padding: 9px;" disabled>
                                    <i class="fa fa-times-circle" aria-hidden="true"></i> Xóa
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <table id="products_list" class="table table-hovered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá bán lẻ</th>
                                        <th>Giá sale</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href="<?php Common::getPath() ?>src/view/promotion/" class="btn btn-outline-danger btn-flat" style="font-size: 12px;">
                        <i class="fa fa-ban" aria-hidden="true"></i> Hủy bỏ
                    </a>
                    <button type="button" class="btn btn-success btn-flat float-right" id="submit_promotion" style="font-size: 12px;" disabled>
                        <i class="fa fa-check-circle" aria-hidden="true"></i> Tạo chương trình
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="add_product">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="overlay d-flex justify-content-center align-items-center">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title modal-order">Chọn sản phẩm</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" value="0" class="count-row"/>
                    <table class="table table-hover table-striped" id="table_choose_product" style="width:100%">
                        <thead>
                            <tr>
                                <th width="20px"></th>
                                <th class="hidden">ID</th>
                                <th class="center" width="70px">Hình ảnh</th>
                                <th>Tên</th>
                                <th>Giá</th>
                                <th width="30px">Kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- BODY -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add_product_choice" disabled style="font-size: 12px;">Thêm <span id="checked_products"></span> sản phẩm</button>
            </div>
        </div>
        <!-- /.modal-content -->
        <?php require_once '../customer/createCustomer.php'; ?>
    </div>
    <!-- /.modal-dialog -->
</div>
<?php require_once ('../../common/footer.php'); ?>
<input type="hidden" id="startDate">
<input type="hidden" id="endDate">
<script>

    let checked_products = [];
    let list_products = [];
    let table_list_product;
    let table_choose_product;
    let table;
    const TIME_FORMAT = 'YYYY-MM-DD HH:mm';
    $(document).ready(function () {
        set_title("Danh sách chương trình khuyến mãi");
        reset_global_variable();
        update_status_promotion();
        // generate_datatable();

        let start_date = moment().add(3, 'minute');
        let end_date = moment().add(25, 'hour');
        $("#startDate").val(start_date.format(TIME_FORMAT));
        $("#endDate").val(end_date.format(TIME_FORMAT));
        $('#reservation').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            minDate: start_date,
            startDate: start_date,
            endDate: end_date,
            locale: {
                format: 'DD/MM/YYYY HH:mm'
            }
        }, function (start, end, label) {
            let start_date = start.format(TIME_FORMAT);
            let end_date = end.format(TIME_FORMAT);
            $("#startDate").val(start_date);
            $("#endDate").val(end_date);
        });

        $("#add_new_product").click(function () {
            add_products();
        });
        $("#add_product_choice").click(function () {
            add_product_into_list();
        });
        $("#clear_sale").click(function () {
            clear_sale();
        });
        $( "#sale_money_for_all" ).on( "keydown", function( event ) {
            let key = event.which;
            if(key === 13) {
                $("#sale_percent_for_all").val("");
                let money = $(this).val();
                if(!validate_number(money)) {
                    $(this).addClass(" is-invalid");
                    toast_error_message("Nhập chưa đúng");
                    return;
                } else {
                    $(this).removeClass(" is-invalid");
                }
                $("#sale_money_for_all").val(formatNumber(money));
                apply_sale_for_all();
            }
        });
        $( "#sale_percent_for_all" ).on( "keydown", function( event ) {
            let key = event.which;
            if(key === 13) {
                $("#sale_money_for_all").val("");
                let percent = $(this).val();
                if(!validate_number(percent)) {
                    $(this).addClass(" is-invalid");
                    toast_error_message("Nhập chưa đúng");
                    return;
                } else {
                    $(this).removeClass(" is-invalid");
                }
                apply_sale_for_all();
            }
        });
        $("#submit_promotion").click(function () {
            if(!validate_promotion()) {
                return;
            }
            Swal.fire({
                title: 'Bạn có chắc chắn muốn tạo chương trình này?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    submit_promotion();
                }
            });
        });

        let promotion_id = "<?php echo (isset($_GET["pid"]) ? $_GET["pid"] : '') ?>";
        if(promotion_id) {
            reset_global_variable();
            get_data_promotion(promotion_id);
        }

        $("#promotion_name").on("blur", function() {
             check_exist_name();
        });
    });

    function reset_global_variable() {
        checked_products = [];
        list_products = [];
    }

    function check_exist_name() {
        let name = $("#promotion_name").val();
        $.ajax({
            url: '<?php Common::getPath()?>src/controller/promotion/PromotionController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "check_exist_name",
                name: name
            },
            success: function (res) {
                // console.log(res);
                if(res.response === "existed") {
                    toast_error_message("Tên chương trình đã tồn tại");
                    $("#promotion_name").addClass("is-invalid").addClass("is-existed");
                } else {
                    $("#promotion_name").removeClass("is-invalid").removeClass("is-existed");
                }
                checking_button_promotion();
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

    function update_status_promotion() {
        $.ajax({
            url: '<?php Common::getPath()?>src/controller/promotion/PromotionController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "update_status_promotion"
            },
            success: function (res) {
                // console.log(res);
                generate_datatable();
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

    function get_data_promotion(promotion_id) {
        $.ajax({
            url: '<?php Common::getPath()?>src/controller/promotion/PromotionController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "load_promotion_by_id",
                promotion_id: promotion_id
            },
            success: function (res) {
                // console.log(res);
                let promotion = res.promotion[0];
                let detail = res.detail;
                let promotion_id = promotion.promotion_id;
                let name = promotion.name;
                let status = promotion.status;
                let start_date = promotion.start_date;
                let end_date = promotion.end_date;

                $("#promotion_id").val(promotion_id);
                $("#promotion_name").val(name);
                $("#status").val(status);
                $("#startDate").val(moment(start_date, "DD/MM/YYYY hh:mm").format("YYYY-MM-DD hh:mm"));
                $("#endDate").val(moment(end_date, "DD/MM/YYYY hh:mm").format("YYYY-MM-DD hh:mm"));
                $('#reservation').daterangepicker({
                    timePicker: true,
                    minDate: start_date,
                    startDate: start_date,
                    endDate: end_date,
                    locale: {
                        format: 'DD/MM/YYYY hh:mm'
                    }
                }, function (start, end, label) {
                    let start_date = start.format('YYYY-MM-DD hh:mm');
                    let end_date = end.format('YYYY-MM-DD hh:mm');
                    $("#startDate").val(start_date);
                    $("#endDate").val(end_date);
                });
                let type = promotion.type;
                $("input[name='sale_type'][value=" + type + "]").prop("checked", true);
                let scope = promotion.scope;
                if(scope) {
                    scope = JSON.parse(scope);
                    let website = scope.website;
                    let shop = scope.shop;
                    if(website == 1) {
                        $("#website").prop("checked", true);
                    }
                    if(shop == 1) {
                        $("#shop").prop("checked", true);
                    }
                }
                let product_id = 0;
                for(let i=0; i<detail.length; i++) {
                    if(product_id != detail[i].product_id) {
                        product_id = Number(detail[i].product_id);
                        checked_products.push(product_id);
                    }
                    if(i == detail.length-1) {
                        let is_edit_promotion = true;
                        add_product_into_list(is_edit_promotion);
                    }
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

    function submit_promotion() {
        let scope = {};
        scope["website"] = $("#website").prop("checked") ? 1 : 0;
        scope["shop"] = $("#shop").prop("checked") ? 1 : 0;
        // console.log(JSON.stringify(list_products));
        let data = {};
        data["promotion_id"] = $("#promotion_id").val();
        data["name"] = $("#promotion_name").val().trim();
        data["start_date"] = $("#startDate").val();
        data["end_date"] = $("#endDate").val();
        data["status"] = $("#status").val();
        data["type"] = $("input[name='sale_type']:checked").val();
        data["scope"] = JSON.stringify(scope);
        data["list_products"] = list_products;
        // console.log(data);
        $.ajax({
            url: '<?php Common::getPath()?>src/controller/promotion/PromotionController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "add_new",
                data: JSON.stringify(data)
            },
            success: function (res) {
                console.log(res);
                Swal.fire({
                    type: 'succes',
                    title: 'Thành công',
                    text: "Chương trình đã được tạo thành công"
                });
                setTimeout(function () {
                    window.location.href = "<?php Common::getPath(); ?>src/view/promotion/";
                },500);
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                if(data.responseText === "Existed") {
                    Swal.fire({
                        type: 'error',
                        title: 'Đã xảy ra lỗi',
                        text: "Tên chương trình đã tồn tại"
                    });
                    return;
                }
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Đã có lỗi xảy ra, vui lòng liên hệ quản trị hệ thống để được khắc phục."
                });
            }
        });
    }
    
    function validate_promotion() {
        let promotion_name = $("#promotion_name").val();
        let website = $("#website").prop('checked');
        let shop = $("#shop").prop('checked');
        if(!promotion_name) {
            toast_error_message("Bạn chưa nhập tên chương trình");
            $("#promotion_name").addClass("is-invalid");
            return false;
        } else if($("#promotion_name").hasClass("is-existed")) {
            toast_error_message("Tên chương trình đã tồn tại");
            $("#promotion_name").addClass("is-invalid");
            return false;
        } else {
            $("#promotion_name").removeClass("is-invalid");
        }
        if(!website && !shop) {
            toast_error_message("Bạn chưa chọn phạm vi khuyến mãi");
            $("#website").addClass("is-invalid");
            $("#shop").addClass("is-invalid");
            return false;
        } else {
            $("#website").removeClass("is-invalid");
            $("#shop").removeClass("is-invalid");
        }
        if(list_products.length == 0) {
            toast_error_message("Bạn chưa thêm sản phẩm");
            return false;
        }
        return true;
    }

    function apply_sale_for_all() {
        let money = $("#sale_money_for_all").val();
        let percent = $("#sale_percent_for_all").val();
        if(money) {
            money = replaceComma(money);
            for(let i=0; i<list_products.length; i++) {
                let price = list_products[i].price;
                list_products[i].sale_price = money;
                list_products[i].percent = 100 - Math.round(money / price * 100);
                if(i === list_products.length-1) {
                    enable_button_clear_sale();
                    redraw_table_product_in_list();
                    checking_button_promotion();
                }
            }
        }
        if(percent && validate_number(percent)) {
            for(let i=0; i<list_products.length; i++) {
                let price = list_products[i].price;
                list_products[i].sale_price = (price - percent * price / 100).toFixed(0);
                list_products[i].percent = percent;
                if(i === list_products.length-1) {
                    enable_button_clear_sale();
                    redraw_table_product_in_list();
                    checking_button_promotion();
                }
            }
        }
    }
    function clear_sale() {
        let money = "";
        let percent = "";
        $("#sale_money_for_all").val(money);
        $("#sale_percent_for_all").val(percent);
        for(let i=0; i<list_products.length; i++) {
            list_products[i].sale_price = money;
            list_products[i].percent = percent;
            if(i === list_products.length-1) {
                redraw_table_product_in_list();
                disable_button_clear_sale();
                disable_button_submit_promotion();
                $("#sale_money_for_all").removeClass("is-invalid");
                $("#sale_percent_for_all").removeClass("is-invalid");
            }
        }
    }

    function enable_button_clear_sale() {
        $("#clear_sale").prop("disabled", "");
    }
    function disable_button_clear_sale() {
        $("#clear_sale").prop("disabled", true);
    }
    function enable_button_submit_promotion() {
        $("#submit_promotion").prop("disabled", "");
    }
    function disable_button_submit_promotion() {
        $("#submit_promotion").prop("disabled", true);
    }
    function enable_input_sale_money_for_all() {
        $("#sale_money_for_all").prop("disabled", "");
    }
    function disable_input_sale_money_for_all() {
        $("#sale_money_for_all").prop("disabled", true);
    }
    function enable_input_sale_percent_for_all() {
        $("#sale_percent_for_all").prop("disabled", "");
    }
    function disable_input_sale_percent_for_all() {
        $("#sale_percent_for_all").prop("disabled", true);
    }

    function add_product_into_list(is_edit_promotion = false) {
        if ($.fn.dataTable.isDataTable('#products_list')) {
            table_list_product.destroy();
            table_list_product.clear();
            // table_list_product.ajax.reload();
        }
        table_list_product = $('#products_list').DataTable({
            'ajax': {
                "type": "GET",
                "url": "<?php Common::getPath()?>src/controller/promotion/PromotionController.php",
                "data": {
                    "method": "find_variations",
                    "list_product_id": checked_products,
                    "is_edit_promotion": is_edit_promotion
                }
            },
            "scrollY":        "500px",
            "initComplete":function(settings, json){
                // console.log(JSON.stringify(json));
                list_products = json.data;
                close_modal("#add_product");
                enable_input_sale_money_for_all();
                enable_input_sale_percent_for_all();
                checking_button_promotion();
            },
            // "dom": '<"top"flp<"clear">>rt<"bottom"ip<"clear">>',
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
            "columns": [
                {
                    "data": format_product_image,
                    class: "center"
                },
                {
                    "data": format_product_name
                },
                {
                    "data": format_price_into_list
                },
                {
                    "data": format_input_sale_price
                }
            ],
            "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]
        });
    }
    
    function format_product_image(data) {
        let image = data.image;
        return "<img src='"+image+"' width='64px' onerror='this.src=\"<?php Common::getPath() ?>dist/img/img_err.jpg\";'>";
    }

    function format_product_name(data) {
        let name = data.name;
        let color = data.color;
        let size = data.size;
        let sku = data.sku;
        return name+"<br><span style=\"font-size: 11px;\"><i>Mã sản phẩm:</i> "+sku+"</span><br>" +
            "<span style=\"font-size: 11px;\"><i>Màu sắc:</i> "+color+"</span><br>" +
            "<span style=\"font-size: 11px;\"><i>Size:</i> "+size+"</span>";
    }
    function format_price_into_list(data) {
        let price = data.price;
        return formatNumber(price)+"<sup>đ</sup>";
    }
    function format_input_sale_price(data) {
        let sku = data.sku;
        let sale_price = data.sale_price;
        let percent = data.percent;
        let price = data.price;
        return "<div class=\"input-group mb-3\" style=\"width: 240px;\">" +
            "      <div class=\"input-group-prepend\">\n" +
            "        <span class=\"input-group-text\" style='font-size: 10px'>đ</span>\n" +
            "      </div>\n" +
            "      <input type='text' id='retail_pice_"+sku+"' value='"+formatNumber(sale_price)+"' class='form-control' style=\"width: 30%;\" onchange='change_sale_price(this, "+sku+", "+price+")'>\n" +
            "      <div class=\"input-group-prepend\">\n" +
            "        <span class=\"input-group-text\" style='font-size: 10px'>-</span>\n" +
            "      </div>\n" +
            "      <input type='text' id='retail_pice_sale_percent_"+sku+"' value='"+percent+"' class='form-control' onchange='change_sale_percent(this, "+sku+", "+price+")'>\n" +
            "      <div class=\"input-group-prepend\">\n" +
            "        <span class=\"input-group-text\" style='font-size: 10px'>%</span>\n" +
            "      </div>\n" +
            "    </div>  ";
    }

    function redraw_table_product_in_list() {
        if ($.fn.dataTable.isDataTable('#products_list')) {
            table_list_product.clear();
            table_list_product.rows.add( list_products ).draw();
        }
    }

    function change_sale_price(e, sku, retail) {
        let sale_price = $(e).val();
        let percent = "";
        if(sale_price) {
            sale_price = replaceComma(sale_price);
            percent = 100 - Math.round(sale_price * 100 / retail);
            $("#retail_pice_"+sku).val(formatNumber(sale_price));
            $("#retail_pice_sale_percent_"+sku).val(percent);
        } else {
            $("#retail_pice_"+sku).val("");
            $("#retail_pice_sale_percent_"+sku).val("");
        }
        set_data_in_json(sale_price, percent, sku);
    }
    function change_sale_percent(e, sku, retail) {
        let percent = $(e).val();
        let sale_price = "";
        if(percent) {
            sale_price = Number(sale_percent * retail / 100);
            sale_price = (retail - sale_price).toFixed(0);
            $("#retail_pice_"+sku).val(formatNumber(sale_price));
            $("#retail_pice_sale_percent_"+sku).val(percent);
        } else {
            $("#retail_pice_"+sku).val("");
            $("#retail_pice_sale_percent_"+sku).val("");
        }
        set_data_in_json(sale_price, percent, sku);

    }
    function set_data_in_json(sale_price, percent, sku) {
        for(let i=0; i<list_products.length; i++) {
            let _sku = list_products[i].sku;
            if(sku == _sku) {
                list_products[i].sale_price = sale_price;
                list_products[i].percent = percent;
            }
            if(i == list_products.length-1) {
                // console.log("checking ...");
                checking_button_promotion();
            }
        }
    }
    function checking_button_promotion() {
        let is_valid = false;
        if($("#promotion_name").hasClass("is-existed")) {
            disable_button_submit_promotion();
            return;
        } else {
            enable_button_submit_promotion();
        }
        for(let i=0; i<list_products.length; i++) {
            let sale_price = list_products[i].sale_price;
            let percent = list_products[i].percent;
            if(sale_price || percent) {
                is_valid = true;
            }
            if(i == list_products.length-1) {
                if(is_valid) {
                    enable_button_submit_promotion();
                } else {
                    disable_button_submit_promotion();
                }
            }
        }
    }
    function add_products() {
        if ($.fn.dataTable.isDataTable('#table_choose_product')) {
            table_choose_product.destroy();
            table_choose_product.clear();
            table_choose_product.ajax.reload();
        }
        table_choose_product = $('#table_choose_product').DataTable({
            'ajax': {
                "type": "GET",
                "url": "<?php Common::getPath()?>src/controller/promotion/PromotionController.php",
                "data": {
                    "method": 'find_products',
                }
            },
            "scrollY":        "400px",
            "initComplete":function( settings, json){
                console.log(json);
                open_modal('#add_product');
            },
            // "dom": '<"top"flp<"clear">>rt<"bottom"ip<"clear">>',
            searching: false,
            ordering: false,
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
            "columns": [
                {
                    "data": format_checkbox,
                    "width": "20px",
                    class: "center"
                },
                {
                    "data": "product_id",
                    class: "hidden"
                },
                {
                    "data": format_image_,
                    "width": "70px"
                },
                {
                    "data": "product_name"
                },
                {
                    "data": format_price
                },
                {
                    "data": "total_quantity",
                    width: "30px"
                }
            ],
            "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]
        });
    }

    function format_checkbox(data) {
        let product_id = data.product_id;
        let checked = false;
        for(let j=0; j<checked_products.length; j++) {
            let _product_id = checked_products[j];
            if(_product_id == product_id) {
                checked = true;
            }
        }
        let body = "<tr>";
        if(checked) {
            body += "<td><input type='checkbox' id='chk_"+product_id+"' onclick='choose_product(this, "+product_id+")' checked></td>";
        } else {
            body += "<td><input type='checkbox' id='chk_"+product_id+"' onclick='choose_product(this, "+product_id+")'></td>";
        }
        return body;
    }

    function format_image_(data) {
        let image = data.image;
        return "<img src=\""+image+"\" width=\"40px\" style='border-radius: 50%' onerror='this.src=\"<?php Common::getPath() ?>dist/img/img_err.jpg\";'>";
    }

    function format_price(data) {
        let min_price = data.min_retail;
        let max_price = data.max_retail;
        if(min_price == max_price) {
            return formatNumber(min_price)+"<sup>đ</sup>";
        } else {
            return formatNumber(min_price)+"<sup>đ</sup> - "+formatNumber(max_price)+"<sup>đ</sup>";
        }
    }
    function choose_product(e, product_id) {
        let isCheck = $(e).prop('checked');
        if (isCheck) {
            $(e).prop("checked", "checked");
            checked_products.push(product_id);
            // let tr = $(e).parent().parent();
            // let td = tr.find("td");
            // let product = {};
            // product["product_id"] = product_id;
            // product["image"] = $(td[2]).children().attr("src");
            // product["product_name"] = $(td[3]).text();
            // product["price"] = $(td[4]).text();
            // product["quantity"] = $(td[5]).text();
            // checked_products.push(product);
        } else {
            $(e).prop("checked", "");
            checked_products.splice(checked_products.indexOf(product_id),1);
        }
        if(checked_products.length > 0) {
            $("#checked_products").text("("+checked_products.length+")");
            $("#add_product_choice").prop("disabled","");
        } else {
            $("#checked_products").text("");
            $("#add_product_choice").prop("disabled",true);
        }
    }

    function get_data_search() {
        return {
            method : 'findall',
        }
    }
    function generate_datatable() {
        if ($.fn.dataTable.isDataTable('#example')) {
            table.destroy();
            table.clear();
            table.ajax.reload();
        }
        table = $('#example').DataTable({
            'ajax': {
                "type": "GET",
                "url": '<?php Common::getPath() ?>src/controller/promotion/PromotionController.php',
                "data": get_data_search()
            },
            "scrollY":        "500px",
            "initComplete":function( settings, json){
                // console.log(json);
            },
            responsive: true,
            select: "single",
            "order": [[ 0, 'desc' ]],
            "columns": [
                {
                    "data": "id",
                    "class": "hidden"
                },
                {
                    "data": "name"
                },
                {
                    "data": "start_date"
                },
                {
                    "data": "end_date"
                },
                {
                    "data": format_type
                },
                {
                    "data": format_scope
                },
                {
                    "data": format_status
                },
                {
                    "data": format_action
                }
            ],
            "lengthMenu": [[10, 25, 50, 100, -1], [25, 50, 100, "All"]]
        });

        $('#example tbody').on('click', '.end_promotion', function () {
            show_loading();
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let promotion_id = row.data().id;
            Swal.fire({
                title: 'Bạn có chắc chắn muốn kết thúc chương trình này?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    end_promotion(promotion_id);
                }
            });

        });
    }

    function end_promotion(promotion_id) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/promotion/PromotionController.php',
            type: "POST",
            dataType: "text",
            data: {
                method: "end_promotion",
                promotion_id: promotion_id
            },
            success: function (res) {
                console.log(res);
                Swal.fire({
                    type: 'succes',
                    title: 'Thành công',
                    text: "Chương trình đã được kết thúc"
                });
                setTimeout(function () {
                    window.location.href = "<?php Common::getPath(); ?>src/view/promotion/";
                },1000);
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

    function format_status(data) {
        let status = Number(data.status);
        switch (status) {
            case 0:
                status = '<mark><span class="text-danger font-italic small">Sắp diễn ra</span></mark>';
                break;
            case 1:
                status = '<mark><span class="text-success font-italic small">Đang hoạt động</span></mark>';
                break;
            case 2:
                status =  '<mark><span class="text-secondary font-italic small">Đã kết thúc</span></mark>';
                break;
            case 3:
                status =  '<mark><span class="text-danger font-italic small">Đã hủy bỏ</span></mark>';
                break;
            default:
                return '';
        }
        return status;
    }
    function format_type(data) {
        let type = Number(data.type);
        switch (type) {
            case 0:
                return '<mark><span class="text-danger small">False sale</span></mark>';
            case 1:
                return '<mark><span class="text-primary small">Sale</span></mark>';
            default:
                return '';
        }
    }
    function format_scope(data) {
        let scope = data.scope;
        let txt = "";
        if(scope) {
            scope = JSON.parse(scope);
            if(scope.website == 1) {
                txt += '<mark><span class="text-success small">Website</span></mark><br>';
            }
            if(scope.shop == 1) {
                txt += '<mark><span class="text-danger small">Shop</span></mark>';
            }
        }
        return txt;
    }
    function format_action(data) {
        let status = data.status;
        let promotion_id = data.id;
        if(status == 1 || status == 0) {
            return '<a href="<?php Common::getPath(); ?>src/view/promotion?pid='+promotion_id+'" class="text-success edit_promotion" title="Sửa chương trinh"><i class="fas fa-edit"></i></a>&nbsp;'
                + '<a href="javascipt:void(0)" class="text-danger end_promotion" title="Kết thúc chương trình"><i class="fas fa-eye-slash"></i></a>';
        }
        return '';
    }

</script>
</body>
</html>
