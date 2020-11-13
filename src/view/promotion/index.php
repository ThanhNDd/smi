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
                            <th>No.</th>
                            <th class="hidden"></th>
                            <th>Tên chương trình</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
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
                                        <input type="radio" class="form-check-input" name="sale_type">Flash Sale
                                    </label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="sale_type" checked>Sale
                                    </label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" value="" checked>Website
                                    </label>
                                </div>
                                <div class="form-group form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" value="">Shop
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-sm">
                                <button type="button" class="btn btn-outline-info float-right" id="add_new_product">
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
                        </div>
                        <div class="row">
                            <table id="products_list" class="table table-hovered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Mã sản phẩm</th>
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
                    <button type="button" class="btn btn-outline-danger btn-flat" id="cancel_promotion">
                        <i class="fa fa-ban" aria-hidden="true"></i> Hủy bỏ
                    </button>
                    <button type="button" class="btn btn-success btn-flat float-right" id="submit_promotion">
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
                    <table class="table table-hover table-striped" id="table_list_product" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="hidden">ID</th>
                                <th class="center">Hình ảnh</th>
                                <th>Tên</th>
                                <th>Giá</th>
                                <th>Kho</th>
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
                <button type="button" class="btn btn-primary" id="add_product_choice" disabled>Thêm <span id="checked_products"></span> sản phẩm</button>
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
    let table;
    let table_list_product;

    $(document).ready(function () {
        set_title("Danh sách chương trình khuyến mãi");
        generate_datatable();
        $('#reservation').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour').add(1, 'hour'),
            endDate: moment().startOf('hour').add(25, 'hour'),
            locale: {
                format: 'DD/MM/YYYY hh:mm'
            }
        }, function (start, end, label) {
            let start_date = start.format('YYYY-MM-DD hh:mm');
            let end_date = end.format('YYYY-MM-DD hh:mm');
            $("#startDate").val(start_date);
            $("#endDate").val(end_date);
        });

        $("#add_new_product").click(function () {
            add_products();
        });
        $("#add_product_choice").click(function () {
            add_product_into_list();
        });
        $( "#sale_money_for_all" ).on( "keydown", function( event ) {
            let key = event.which;
            if(key === 13) {
                $("#sale_percent_for_all").val("");
                let money = $(this).val();
                $("#sale_money_for_all").val(formatNumber(money));
                apply_sale_for_all();
            }
        });
        $( "#sale_percent_for_all" ).on( "keydown", function( event ) {
            let key = event.which;
            if(key === 13) {
                $("#sale_money_for_all").val("");
                apply_sale_for_all();
            }
        });
        $("#submit_promotion").click(function () {
            submit_promotion();
        });
    });

    function submit_promotion() {
        let table = $("#products_list").DataTable();
        let data = table.rows().data();
        for(let i=0; i<data.length; i++) {
            // console.log(data[i]);
            let product_id = data[i][0];
            let variant_id = data[i][1];
            let sku = data[i][3];
            let retail_price = data[i][5];
            console.log($(data[i][6]).children("#retail_pice_"+sku).val());
            let sale_price = $("#retail_pice_"+sku).val();
            let sale_percent = $("#retail_pice_sale_percent_"+sku).val();
            // console.log(product_id+" - "+variant_id+" - "+sku+" - "+retail_price+" - "+sale_price+" - "+sale_percent);
        }
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
                    redraw_table_product_in_list();
                }
            }
        }
        if(percent) {
            for(let i=0; i<list_products.length; i++) {
                let price = list_products[i].price;
                list_products[i].sale_price = (price - percent * price / 100).toFixed(0);
                list_products[i].percent = percent;
                if(i === list_products.length-1) {
                    redraw_table_product_in_list();
                }
            }
        }
    }
    
    function add_product_into_list() {
        $.ajax({
            url: '<?php Common::getPath()?>src/controller/promotion/PromotionController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "find_variations",
                list_product_id: checked_products
            },
            success: function (res) {
                // console.log(res);
                if(res) {
                    $("#products_list tbody").html("");
                    let products = res.data;
                    console.log(JSON.stringify(products));
                    for(let i=0; i<products.length; i++) {
                        let product = products[i];
                        list_products.push(product);
                        let product_id = product.product_id;
                        let variant_id = product.variant_id;
                        let sku = product.sku;
                        let image = product.image;
                        let name = product.name;
                        let size = product.size;
                        let color = product.color;
                        let price = product.price;
                        let sale_price = product.sale_price;
                        let percent = product.percent;
                        // let quantity = product.quantity;

                        let body = "<tr>";
                        body += "<td><img src='"+image+"' width='64px' onerror='this.src=\"<?php Common::getPath() ?>dist/img/img_err.jpg\";'></td>";
                        body += "<td>"+sku+"</td>";
                        body += "<td>"+name+"<br><i style=\"font-size: 11px;\">Màu sắc: "+color+"</i><br><i style=\"font-size: 11px;\">Size: "+size+"</i></td>";
                        body += "<td>"+formatNumber(price)+"<sup>đ</sup></td>";
                        body += "<td>" +
                                "<div class=\"input-group mb-3\" style=\"width: 240px;\">" +
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
                                "    </div>  "+
                                "</td>";
                        body += "</tr>";
                        $("#products_list tbody").append(body);
                        if(i === products.length-1) {
                            console.log(JSON.stringify(list_products));
                            table = $('#products_list').DataTable({
                                "scrollY":        "500px",
                                "scrollCollapse": true,
                                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
                            });
                            close_modal("#add_product");
                            $("#sale_money_for_all").prop("disabled", "");
                            $("#sale_percent_for_all").prop("disabled", "");
                        }
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

    function redraw_table_product_in_list() {
        if ($.fn.dataTable.isDataTable('#products_list')) {
            table.destroy();
            table.clear();
            table.ajax.reload();
        }
        $("#products_list tbody").html("");
        let products = list_products;
        for(let i=0; i<products.length; i++) {
            let product = products[i];
            let product_id = product.product_id;
            let variant_id = product.variant_id;
            let sku = product.sku;
            let image = product.image;
            let name = product.name;
            let size = product.size;
            let color = product.color;
            let price = product.price;
            let sale_price = product.sale_price;
            let percent = product.percent;

            let body = "<tr>";
            body += "<td class=\"hidden\">"+product_id+"</td>";
            body += "<td class=\"hidden\">"+variant_id+"</td>";
            body += "<td><img src='"+image+"' width='64px' onerror='this.src=\"<?php Common::getPath() ?>dist/img/img_err.jpg\";'></td>";
            body += "<td>"+sku+"</td>";
            body += "<td>"+name+"<br><i style=\"font-size: 11px;\">Màu sắc: "+color+"</i><br><i style=\"font-size: 11px;\">Size: "+size+"</i></td>";
            body += "<td>"+formatNumber(price)+"<sup>đ</sup></td>";
            body += "<td>" +
                "<div class=\"input-group mb-3\" style=\"width: 240px;\">" +
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
                "    </div>  "+
                "</td>";
            body += "</tr>";
            $("#products_list tbody").append(body);
            if(i === products.length -1) {
                console.log(JSON.stringify(list_products));
                table = $('#products_list').DataTable({
                    "scrollY":        "500px",
                    "scrollCollapse": true,
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
                });
            }
        }
        // setTimeout(function () {
        //     console.log(JSON.stringify(list_products));
        //     $('#products_list').DataTable({
        //         "scrollY":        "500px",
        //         "scrollCollapse": true,
        //         "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
        //     });
        // },300);
    }


    function change_sale_price(e, sku, retail) {
        let sale_price = $(e).val();
        sale_price = replaceComma(sale_price);
        let percent = 100 - Math.round(sale_price * 100 / retail);
        $("#retail_pice_"+sku).val(formatNumber(sale_price));
        $("#retail_pice_sale_percent_"+sku).val(percent);
        set_data_in_json(sale_price, percent, sku);
    }
    function change_sale_percent(e, sku, retail) {
        let percent = $(e).val();
        let sale_price = Number(sale_percent * retail / 100);
        sale_price = (retail - sale_price).toFixed(0);
        $("#retail_pice_"+sku).val(formatNumber(sale_price));
        $("#retail_pice_sale_percent_"+sku).val(percent);
        set_data_in_json(sale_price, percent, sku);
    }
    function set_data_in_json(sale_price, percent, sku) {
        for(let i=0; i<list_products.length; i++) {
            let _sku = list_products[i].sku;
            if(sku == _sku) {
                list_products[i].sale_price = sale_price;
                list_products[i].percent = percent;
            }
        }
        console.log(JSON.stringify(list_products));
    }
    function add_products() {
        if ($.fn.dataTable.isDataTable('#table_list_product')) {
            table_list_product.destroy();
            table_list_product.clear();
            table_list_product.ajax.reload();
        }
        table_list_product = $('#table_list_product').DataTable({
            'ajax': {
                "type": "GET",
                "url": "<?php Common::getPath()?>src/controller/promotion/PromotionController.php",
                "data": {
                    "method": 'find_products',
                }
            },
            "scrollY":        "400px",
            "initComplete":function( settings, json){
                open_modal('#add_product');
            },
            "dom": '<"top"flp<"clear">>rt<"bottom"p<"clear">>',
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
                    "width": "50px",
                    class: "center"
                },
                {
                    "data": "product_id",
                    "width": "50px",
                    class: "hidden"
                },
                {
                    "data": format_image_
                },
                {
                    "data": "product_name"
                },
                {
                    "data": format_price
                },
                {
                    "data": "total_quantity",
                    width: "50px"
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
        return "<img src=\""+image+"\" width=\"64px\" onerror='this.src=\"<?php Common::getPath() ?>dist/img/img_err.jpg\";'>";
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


    function add_products1() {
        $.ajax({
            url: '<?php Common::getPath()?>src/controller/promotion/PromotionController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "find_products"
            },
            success: function (res) {
                console.log(res);
                if(res) {
                    $("#table_list_product tbody").html("");
                    let products = res.data;
                    for(let i=0; i<products.length; i++) {
                        let product = products[i];
                        let price = "";
                        if(product.min_retail == product.max_retail) {
                            price = formatNumber(product.min_retail) +"<sup>đ</sup>";
                        } else {
                            price = formatNumber(product.min_retail) + "<sup>đ</sup> - " + formatNumber(product.max_retail) + "<sup>đ</sup>";
                        }
                        let checked = false;
                        for(let j=0; j<checked_products.length; j++) {
                            let _product_id = checked_products[j];
                            if(_product_id == product.product_id) {
                                checked = true;
                            }
                        }
                        let body = "<tr>";
                        if(checked) {
                            body += "<td><input type='checkbox' id='chk_"+product.product_id+"' onclick='choose_product(this, "+product.product_id+")' checked></td>";
                        } else {
                            body += "<td><input type='checkbox' id='chk_"+product.product_id+"' onclick='choose_product(this, "+product.product_id+")'></td>";
                        }

                        body += "<td>"+product.product_id+"</td>";
                        body += "<td><img src='"+product.image+"' width='64px' onerror='this.src=\"<?php Common::getPath() ?>dist/img/img_err.jpg\";'></td>";
                        body += "<td>"+product.product_name+"</td>";
                        body += "<td>"+price+"</td>";
                        body += "<td>"+product.total_quantity+"</td>";
                        body += "</tr>";
                        $("#table_list_product tbody").append(body);
                        if(i === products.length -1) {
                            table_list_product = $('#table_list_product').DataTable({
                                "scrollY":        "500px",
                                "scrollCollapse": true,
                                "lengthMenu": [[8, 25, 50, 100, -1], [8, 25, 50, 100, "All"]]
                            });
                            open_modal('#add_product');
                        }
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



    function choose_product(e, product_id) {
        // console.log(checked_products.length);
        let isCheck = $(e).prop('checked');
        if (isCheck) {
            $(e).prop("checked", "checked");
            // let tr = $(e).parent().parent();
            // let td = tr.find("td");
            // let product = {};
            // product["product_id"] = product_id;
            // product["image"] = $(td[2]).children().attr("src");
            // product["product_name"] = $(td[3]).text();
            // product["price"] = $(td[4]).text();
            // product["quantity"] = $(td[5]).text();
            // checked_products.push(product);
            checked_products.push(product_id);
        } else {
            $(e).prop("checked", "");
            // for(let i=0; i<checked_products.length; i++) {
                // let id = checked_products[i].product_id;
                // if(id === product_id) {
                //     checked_products.splice(i,1);
                // }
            // }
            checked_products.splice(checked_products.indexOf(product_id),1);
        }
        // console.log(checked_products);
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
        let table = $('#example').DataTable({
            'ajax': {
                "type": "GET",
                "url": '<?php Common::getPath() ?>src/controller/promotion/PromotionController.php',
                "data": get_data_search()
            },
            responsive: true,
            select: "single",
            "columns": [
                {
                    "data": "id",
                    width: "5px"
                },
                {
                    "data": "",
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
                    "data": format_status
                },
                {
                    "data": format_action
                }
            ],
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
        });
        // Event click delete product
        $('#example tbody').on('click', '.edit_promotion', function () {
            let tr = $(this).closest('tr');
            let row = table.row(tr);
            let id = row.data().id;

            Swal.fire({
                title: 'Bạn có chắc chắn muốn hủy bỏ lần kiểm hàng này?',
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
                        url: '<?php Common::getPath() ?>src/controller/Check/CheckController.php',
                        type: "POST",
                        dataType: "json",
                        data: {
                            type: "cancel_checking",
                            data: id
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
                            hide_loading();
                        }
                    });
                }
            });
        });

    }

    function format_status(data) {
        let status = Number(data.status);
        switch (status) {
            case 0:
                status = '<span class="badge badge-info">Sắp diễn ra</span>';
                break;
            case 1:
                status = '<span class="badge badge-success">Đang hoạt động</span>';
                break;
            case 2:
                status =  '<span class="badge badge-secondary">Đã kết thúc</span>';
                break;
            case 3:
                status =  '<span class="badge badge-danger">Đã hủy bỏ</span>';
                break;
            default:
                return '';
        }
        return status;
    }

    function format_action(data) {
        let status = data.status;
        if(status == 1 || status == 0) {
            return '<button type="button" class="btn bg-gradient-info btn-sm edit_promotion" title="Sửa chương trinh"><i class="fas fa-edit"></i></button>&nbsp;'
                + '<button type="button" class="btn bg-gradient-danger btn-sm end_promotion" title="Kết thúc chương trình"><i class="fas fa-eye-slash"></i></button>';
        }
        return '';
    }

    function check_stock(e, product_id) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "check_update_out_of_stock",
                product_id: product_id
            },
            success: function (res) {
                console.log(res);
                if(res.response === "in_stock") {
                    Swal.fire({
                        type: 'error',
                        title: 'Số lượng sản phẩm vẫn còn',
                        text: "Bạn vui lòng kiểm tra lại trước khi cập nhật hết hàng."
                    });
                    return;
                } else if(res.response === "success") {
                    Swal.fire({
                        title: 'Bạn chắc chắn muốn cập nhật hết hàng cho sản phẩm này?',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.value) {
                            update_out_of_stock(e, product_id);
                        }
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

    function update_out_of_stock(e, product_id) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "update_stock",
                product_id: product_id,
                status: 1 // out of stock
            },
            success: function (res) {
                console.log(res);
                toastr.success('Cập nhật thành công!');
                $(e).parent().parent().hide(700);
                $(e).parent().parent().next().hide(700);
                count_out_of_stock();
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



    function format_intomoney(data) {
        let price = replaceComma(data.price);
        let fee = replaceComma(data.fee_transport);
        let into_money = Number(price) + Number(fee);
        if (!isNaN(into_money)) {
            return formatNumber(into_money);
        } else {
            return "";
        }
    }

    function format_name(data) {
        return "<a href='" + data.link + "' target='_blank'>" + data.name + "</a>";
    }

    function format_image(data) {
        return "<img src=" + data.image + " width='100px' id='thumbnail'>";
    }

    function format_variation(variations, isNew) {
        let table = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        table += '<thead>' +
            '<tr>' +
            '<th class="center"><input type="checkbox" id="selectall" onclick="checkAll(this)"></th>' +
            '<th>Mã sản phẩm</th>' +
            '<th>Màu</th>' +
            '<th>Size</th>' +
            '<th>Số lượng</th>' +
            '<th>Hành động</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
        for (let i = 0; i < variations.length; i++) {
            table += '<tr class="' + variations[i].sku + '">' +
                '<td class="center"><input type="checkbox" id="' + variations[i].sku + '" onclick="check(this)"></td>' +
                '<input type="hidden" class="product-id-' + variations[i].sku + '" value="' + variations[i].product_id + '">' +
                '<td>' + variations[i].sku + '</td>' +
                '<td>' + variations[i].color + '</td>' +
                '<td>' + variations[i].size + '</td>' +
                '<td id="qty">' + variations[i].quantity + '</td>' +
                '<td>' +
                '<button type="button" class="btn bg-gradient-info btn-sm edit_variation"><i class="fas fa-edit"></i> Sửa</button>&nbsp;' +
                //'<button type="button" class="btn bg-gradient-danger btn-sm delete_variation"><i class="fas fa-trash"></i> Xóa</button>' +
                '</td>' +
                '</tr>';
        }
        if (isNew === "isNew") {
            let new_sku = Number(variations[variations.length - 1].sku) < 10 ? "0" + variations[variations.length - 1].sku : Number(variations[variations.length - 1].sku) + 1;
            table += '<tr class="' + new_sku + '">' +
                '<td>' + new_sku + '</td>' +
                '<td><select class="select-color-' + new_sku + ' form-control w100" id="select_color_' + new_sku + '"><option value="-1"></option></select></td>' +
                '<td><select class="select-size-' + new_sku + ' form-control w100" id="select_size_' + new_sku + '"><option value="-1"></option></select></td>' +
                '<td><select class="select-qty-' + new_sku + ' form-control w100" id="select_qty_' + new_sku + '"><option value="-1"></option></select></td>' +
                '<td>' +
                '<button type="button" class="btn bg-gradient-primary btn-sm save_variation"><i class="fas fa-save"></i> Lưu</button>&nbsp;' +
                '</td>' +
                '<input type="hidden" class="product-id-' + new_sku + '" value="' + variations[variations.length - 1].product_id + '">' +
                '</tr>';
        }
        table += '</tbody>';
        table += '</table>';
        return table;
    }

    function check(e) {
        let isCheck = $(e).prop('checked');
        if (isCheck) {
            $(e).prop("checked", "checked");
        } else {
            $(e).prop("checked", "");
        }
        countAllChecked();
    }

    function checkAll(e) {
        let isCheck = $(e).prop('checked');
        if (isCheck) {
            $(e).parent().parent().parent().parent().find('td input:checkbox').prop("checked", "checked");
        } else {
            $(e).parent().parent().parent().parent().find('td input:checkbox').prop("checked", "");
        }
        countAllChecked();
    }

    // function formatNumber(num) {
    //     return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    // }

    // function replaceComma(value) {
    //     value = value.trim();
    //     return value.replace(/,/g, '');
    // }
    //
    // function replacePercent(value) {
    //     return value.replace(/%/g, '');
    // }

    function generate_select2(el, data, value) {
        $(el).select2({
            data: data
        });
        if (value !== "") {
            $(el).val(value).trigger('change');
        }
    }
</script>
</body>
</html>
