<?php
require_once("../../common/common.php");
Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Quản lý sản phẩm</title>
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

        .modal-dialog.modal-xl {
            max-width: 90% !important;
        }

        .header-column {
            position: fixed;
            z-index: 999;
            background: #fff;
            top: 98px;
            height: 30px;
            margin: 0 -3px;
        }

        .product-area {
            position: relative;
            top: 20px;
        }

        .card-body {
            padding: 0;
        }

        .table td, .table th {
            padding: 5px;
            border-top: none;
            margin: 0 !important;
        }

        input[type=text], input[type=number], .select2-container--bootstrap4 .select2-selection {
            border-radius: 0 !important;
            margin: 0 !important;
        }

        .table-list td {
            /*border-top: 1px solid #b3b3b3;*/
        }

        .select2-container {
            display: inline-block;
            float: left;
        }

        .table-list tbody {
            /*max-height: 440px !important;*/
            /*display: block;*/
            /*width: 100%;*/
            /*overflow: auto;*/
        }

        table.table.table-list {
            /*display: inline-block;*/
        }

        .card.card-outline.card-danger {
            min-height: 690px;
        }
    </style>
</head>
<?php require_once('../../common/header.php'); ?>
<?php require_once('../../common/menu.php'); ?>
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row col-12" style="display: inline-block;">
                    <section class="ml-4" style="display: inline-block;float: left;padding-top: 1.25rem;">
                        <a class="btn btn-secondary btn-flat"
                           href="<?php Common::getPath() ?>src/view/products/outofstock.php">
                            Hết hàng <span class="badge badge-light number_out_of_stock">0</span>
                        </a>
                        <div class="form-inline" style="display: inline-block">
                            <input type="number" value="" name="discountAll" id="discountAll" min="0"
                                   placeholder="Giảm giá" class="form-control w110">
                            <button id="update_all" class="btn btn-primary btn-flat">Áp dụng</button>
                        </div>
                    </section>
                    <section style="display: inline-block;float: right;padding-top: 1.25rem;">
                        <button type="button" class="btn btn-success btn-flat product-create">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Tạo mới
                        </button>
                        <button type="button" class="btn btn-info btn-flat print-barcode">
                            <i class="fa fa-barcode" aria-hidden="true"></i> In mã vạch <span
                                    class="badge badge-light number-checked">0</span>
                        </button>
                    </section>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="center clearAll">
                                <i class="fa fa-trash" aria-hidden="true" style="color: red;cursor: pointer;"></i>
                            </th>
                            <th class="hidden">Id</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <!-- <th>Giá nhập</th>
                            <th>Phí vận chuyển</th>
                            <th>Thành tiền</th> -->
                            <th>Giá bán lẻ</th>
                            <th>Giảm giá</th>
                            <th></th>
                            <th>Publish</th>
                            <th>Hành động</th>
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
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<?php include 'createProducts.php'; ?>
</div>
<div class="iframeArea hidden"></div>
<?php require_once('../../common/footer.php'); ?>
<script>
    $(document).ready(function () {
        set_title("Danh sách sản phẩm");
        count_out_of_stock();
        generate_datatable();

        $(".print-barcode").on("click", function () {
            let data = [];
            $.each($("#example tbody td input[type='checkbox']:checked"), function () {
                let id = $(this).attr("id");
                if (id != "selectall") {
                    data.push($(this).attr("id"));
                }
            });
            if (data.length > 0) {
                printBarcode(data);
            }
        });
        $(".clearAll").on("click", function () {
            clearAll();
        });

        $("#update_all").on("click", function (e) {
            Swal.fire({
                title: 'Bạn chắc chắn chứ?',
                text: "Bạn muốn cập nhật giảm giá cho tất cả sản phẩm!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý'
            }).then((result) => {
                if (result.value) {
                    update_discount_all(e);
                }
            })
        })
    });

    function clearAll() {
        $.each($("#example tbody td input[type='checkbox']:checked"), function () {
            $(this).prop("checked", false);
        });
        $(".number-checked").text(0);
    }

    function countAllChecked() {
        let count = 0;
        $.each($("#example tbody td input[type='checkbox']:checked"), function () {
            let id = $(this).attr("id");
            if (id != "selectall") {
                count++;
            }
        });
        $(".number-checked").text(count);
    }

    function printBarcode(data) {
        $(".iframeArea").html("");
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "print_barcode",
                data: JSON.stringify(data)
            },
            success: function (res) {
                let filename = res.fileName;
                $(".iframeArea").html("");
                if (typeof filename !== "underfined" && filename !== "") {
                    $(".iframeArea").html('<iframe src="<?php Common::getPath()?>src/controller/product/pdf/' + filename + '" id="barcodeContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                    window.open("<?php Common::getPath() ?>src/controller/product/pdf/" + filename, "_blank");
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

    function generate_datatable() {
        let table = $('#example').DataTable({
            "ajax": '<?php Common::getPath() ?>src/controller/product/ProductController.php?method=findall&status=0',
            select: "single",
            deferRender: true,
            rowId: 'extn',
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
                    "data": "product_id",
                    "className": 'hidden',
                    width: "5px"
                },
                {
                    "data": format_image,
                    width: "70px"
                },
                {
                    "data": format_name,
                    width: "150px"
                },
                {
                    "data": "retail",
                    width: "50px"
                },
                {
                    "data": format_discount,
                    width: "50px"
                },
                {
                    "data": format_discount_display,
                    width: "50px"
                },
                {
                    "data": format_publish,
                    width: "50px"
                },
                {
                    "data": format_action,
                    width: "50px"
                }
            ],
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
        });

        // Add event listener for opening and closing details
        $('#example tbody').on('click', '.details-control', function () {
            let tr = $(this).closest('tr');
            let tdi = tr.find("i.fa");
            let row = table.row(tr);
            let productId = row.data().product_id;

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
                tdi.first().removeClass('fa-minus-square');
                tdi.first().addClass('fa-plus-square');
            } else {
                // Open this row
                $.ajax({
                    url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                    type: "POST",
                    dataType: "json",
                    data: {
                        method: "find_detail",
                        product_id: productId
                    },
                    success: function (res) {
                        console.log(res);
                        let data = res.data;
                        // let details = res[0].details;
                        if (data.length > 0) {
                            row.child(format_variation(data[0].variations)).show();
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
        });

        $('#example tbody').on('click', '.edit_product', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let product_id = $(td[1]).text();
            // clear();
            open_modal();
            // add_new_product();
            $.ajax({
                url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                type: "POST",
                dataType: "json",
                data: {
                    type: "edit_product",
                    product_id: product_id
                },
                success: function (res) {
                    console.log(res);
                    let arr = res.data;
                    console.log(arr[0].profit);
                    $("#display_product_id").val(arr[0].product_id);
                    $("#product_id").val(arr[0].product_id);

                    let image = arr[0].image;
                    let json = JSON.parse(image);
                    for(let i=0; i<json.length; i++) {
                        let src = json[i].src;
                        let type = json[i].type;
                        if(type === "upload") {
                            src = '<?php echo Common::path_img() ?>' + src;
                        }
                        $("#link_image_"+i).val(src).trigger('change');
                        $("#image_type_"+i).val(type);
                        $("[id=img_"+i+"]").removeClass('hidden');
                    }
                    $("#name").val(arr[0].name);
                    $("#link").val(arr[0].link);
                    $("#price").val(arr[0].price);
                    $("#fee").val(arr[0].fee_transport);
                    $("#percent").val(arr[0].percent);
                    $("#retail").val(arr[0].retail);
                    $("#profit").val(arr[0].profit);
                    $("#select_type").val(arr[0].type).trigger("change");
                    $("#select_cat").val(arr[0].category_id).trigger("change");
                    $("#select_size").prop("disabled", "disabled");
                    $("#select_color").prop("disabled", "disabled");
                    $("#qty").prop("disabled", "disabled");
                    if(arr[0].description !== "") {
                        $('#description').summernote('code', arr[0].description);
                    } else {
                        $('#description').summernote('code', '');
                    }

                    let variations = arr[0].variations;
                    let count = 0;
                    for (let i = 0; i < variations.length; i++) {
                        let id = variations[i].id;
                        let sku = variations[i].sku;
                        // let image = variations[i].image;
                        let size = variations[i].size;
                        let color = variations[i].color;
                        let qty = variations[i].quantity;
                        count++;
                        generate_variations(count, qty, id, color, size, sku);
                    }
                    $(".create-new").text("Cập nhật");
                    $(".add-new-prod").prop("disabled", '');
                    $("#create_variation").prop("disabled", true);

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
        });

        // Event click add new row variation
        $('#example tbody').on('click', '.add_variation', function () {
            let tr = $(this).closest('tr');
            let tdi = tr.find("i.fa");
            let row = table.row(tr);
            //  if (!row.child.isShown()) {
            // Open this row
            let variations = row.data().variations;
            let new_sku = Number(variations[variations.length - 1].sku) < 10 ? "0" + variations[variations.length - 1].sku : Number(variations[variations.length - 1].sku) + 1;
            row.child(format_variation(variations, "isNew")).show();
            tr.addClass('shown');
            tdi.first().removeClass('fa-plus-square');
            tdi.first().addClass('fa-minus-square');

            generate_select2(".select-qty-" + new_sku, select_qty, "");
            generate_select2(".select-color-" + new_sku, select_colors, "");
            generate_select2(".select-size-" + new_sku, select_size, "");
            //  }
        });

        // Event click Edit variation
        $('#example tbody').on('click', '.edit_variation', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let sku = tr.attr("class");
            let color_text = $(td[2]).text();
            let size_text = $(td[3]).text();
            let size_value = size_text;
            if (size_text.indexOf(" ") > -1) {
                size_value = size_text.split(" ")[0];
            } else {
                size_value = size_text.split("m")[0];
            }
            let qty_text = $(td[4]).text();
            let input_color = '<select class="select-color-' + sku + ' form-control" id="select_color_' + sku + '"></select>';
            let input_size = '<select class="select-size-' + sku + ' form-control" id="select_size_' + sku + '"></select>';
            let input_qty = '<select class="select-qty-' + sku + ' form-control" id="select_qty_' + sku + '"></select>';
            let btn_gr = '<button type="button" class="btn bg-gradient-primary btn-sm update_variation"><i class="fas fa-save"></i> Lưu</button>&nbsp;' +
                '<button type="button" class="btn bg-gradient-danger btn-sm cancel_variation" "><i class="fas fa-trash"></i> Hủy</button>';
            let gr_input_hidden = '<input type="hidden" id="curr_color_' + sku + '" value="' + color_text + '">' +
                '<input type="hidden" id="curr_size_' + sku + '" value="' + size_text + '">' +
                '<input type="hidden" id="curr_qty_' + sku + '" value="' + qty_text + '">';
            $(td[2]).html(input_color);
            $(td[3]).html(input_size);
            $(td[4]).html(input_qty);
            $(td[5]).html(btn_gr);
            $(tr).append(gr_input_hidden);
            generate_select2(".select-qty-" + sku, select_qty, qty_text);
            generate_select2(".select-color-" + sku, select_colors, color_text);
            generate_select2(".select-size-" + sku, select_size, size_value);
        });

        // Event click Save new variation
        $('#example tbody').on('click', '.save_variation', function () {
            show_loading();
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let sku = tr.attr("class");
            let product_id = $(".product-id-" + sku).val();
            let color = $(".select-color-" + sku).val();
            let size = $(".select-size-" + sku).val();
            let qty = $(".select-qty-" + sku).val();
            $.ajax({
                url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                type: "POST",
                dataType: "json",
                data: {
                    type: "save_variation",
                    product_id: product_id,
                    sku: sku,
                    color: color,
                    size: size,
                    qty: qty
                },
                success: function () {
                    toastr.success('Sản phẩm đã được tạo thành công.');
                    hide_loading();
                    table.ajax.reload();
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
        });

        // Event click update variation
        $('#example tbody').on('click', '.update_variation', function () {
            show_loading();
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let sku = tr.attr("class");
            let color = $(".select-color-" + sku).val();
            let size = $(".select-size-" + sku).val();
            let txtsize = $(".select-size-" + sku + ' option:selected').text();
            let qty = $(".select-qty-" + sku).val();
            $.ajax({
                url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                type: "POST",
                dataType: "json",
                data: {
                    type: "update_variation",
                    sku: sku,
                    color: color,
                    size: size,
                    qty: qty
                },
                success: function (res) {
                    toastr.success('Cập nhật thành công!');
                    let btn_gr = '<button type="button" class="btn bg-gradient-info btn-sm edit_variation"><i class="fas fa-edit"></i> Sửa</button>&nbsp;';
                    $(td[2]).html(color);
                    $(td[3]).html(txtsize);
                    $(td[4]).html(qty);
                    $(td[5]).html(btn_gr);
                    hide_loading();
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
        });

        // Event click cancel edit variation
        $('#example tbody').on('click', '.cancel_variation', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let sku = tr.attr("class");
            let color = $("#curr_color_" + sku).val();
            let size = $("#curr_size_" + sku).val();
            let qty = $("#curr_qty_" + sku).val();
            let btn_gr = '<button type="button" class="btn bg-gradient-info btn-sm edit_variation"><i class="fas fa-edit"></i> Sửa</button>&nbsp;';

            $(td[2]).html(color);
            $(td[3]).html(size);
            $(td[4]).html(qty);
            $(td[5]).html(btn_gr);

            $("#curr_color_" + sku).remove();
            $("#curr_size_" + sku).remove();
            $("#curr_qty_" + sku).remove();
        });

        // Event click delete product
        $('#example tbody').on('click', '.delete_variation', function () {
            let tr = $(this).closest('tr');
            let sku = $(tr).attr("class");

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
                    show_loading();
                    $.ajax({
                        url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                        type: "POST",
                        dataType: "json",
                        data: {
                            type: "delete_variation",
                            data: sku
                        },
                        success: function (res) {
                            console.log(res);
                            toastr.success('Xóa thành công!');
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

        $('#example tbody').on('click', '.cancal_add_new', function () {
            let tr = $(this).closest('tr');

            Swal.fire({
                title: 'Bạn có chắc chắn muốn hủy bỏ?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    $(tr).remove();
                }
            });
        });

        $('#example tbody').on('click', '.out_of_stock', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let product_id = $(td[1]).text();
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
            check_stock($(this), product_id);
        });

        $('#example tbody').on('click', '.website-publish', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let product_id = $(td[1]).text();
            let checked = $(this).parent().children('input').prop('checked');
            let status = 0;
            if(checked) {
                status = 1;
            }
            social_publish(product_id, 'website', status);
        });

        $('#example tbody').on('click', '.facebook-publish', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let product_id = $(td[1]).text();
            let checked = $(this).parent().children('input').prop('checked');
            let status = 0;
            if(checked) {
                status = 1;
            }
            social_publish(product_id, 'facebook', status);
        });

        $('#example tbody').on('click', '.shopee-publish', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let product_id = $(td[1]).text();
            let checked = $(this).parent().children('input').prop('checked');
            let status = 0;
            if(checked) {
                status = 1;
            }
            social_publish(product_id, 'shopee', status);
        });


        $('#example tbody').on('click', '.lazada-publish', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let product_id = $(td[1]).text();
            let checked = $(this).parent().children('input').prop('checked');
            let status = 0;
            if(checked) {
                status = 1;
            }
            social_publish(product_id, 'lazada', status);
        });

    }

    function social_publish(product_id, type, status) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "social_publish",
                product_id: product_id,
                type: type,
                status: status
            },
            success: function () {
                toastr.success('Cập nhật thành công!');
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

    function format_publish(data) {
        let product_id = data.product_id;
        let social_publish = JSON.parse(data.social_publish);
        let website = social_publish.website === 0 ? '' : 'checked';
        let btn = '<div class="custom-control custom-switch">' +
            '<input type="checkbox" class="custom-control-input website-publish" id="Website_'+product_id+'" '+website+'>' +
            '<label class="custom-control-label" for="Website_'+product_id+'">Website</label>' +
            '</div>';
        let facebook = social_publish.facebook === 0 ? '' : 'checked';
        btn += '<div class="custom-control custom-switch">' +
            '<input type="checkbox" class="custom-control-input facebook-publish" id="facebook_'+product_id+'" '+facebook+'>' +
            '<label class="custom-control-label" for="facebook_'+product_id+'">Facebook</label>' +
            '</div>';
        let shopee = social_publish.shopee === 0 ? '' : 'checked';
        btn += '<div class="custom-control custom-switch">' +
            '<input type="checkbox" class="custom-control-input shopee-publish" id="shopee_'+product_id+'" '+shopee+'>' +
            '<label class="custom-control-label" for="shopee_'+product_id+'">Shopee</label>' +
            '</div>';
        let lazada = social_publish.lazada === 0 ? '' : 'checked';
        btn += '<div class="custom-control custom-switch">' +
            '<input type="checkbox" class="custom-control-input lazada-publish" id="lazada_'+product_id+'" '+lazada+'>' +
            '<label class="custom-control-label" for="lazada_'+product_id+'">Lazada</label>' +
            '</div>';
        return btn;
    }

    function format_discount_display(data) {
        let discount = data.discount;
        if (typeof discount == "undefined" || discount == 0) {
            discount = "";
        } else {
            if (discount < 100) {
                discount = discount + "%";
            } else {
                discount = formatNumber(discount);
            }
        }
        return discount;
    }

    function format_discount(data) {
        let discount = data.discount;
        if (typeof discount == "undefined" || discount == 0) {
            discount = "";
        } else {
            if (discount < 100) {
                discount = discount + "%";
            } else {
                discount = formatNumber(discount);
            }
        }
        let retail = data.retail;
        let profit = data.profit;
        let product_id = data.product_id;
        return '<input type="text" onchange="onchange_discount(this, \'' + profit + '\')" onblur="onchange_discount(this, \'' + profit + '\', \'' + retail + '\')" class="form-control col-md-6 float-left" value="' + discount + '"/>&nbsp;' +
            '<button type="button" class="btn bg-gradient-info btn-sm mt-1" onclick="update_discount(this, ' + product_id + ')" title="Lưu khuyến mãi"><i class="fas fa-save"></i></button>';
    }

    function onchange_discount(e, profit, retail) {
        $(e).removeClass("is-invalid");
        $("#update_discount").prop("disabled", true);
        let val = $(e).val();
        val = replaceComma(val);
        console.log(val);
        // let profit;
        if (val == "") {

        } else if (val.indexOf("%") == -1) {
            if (!isNaN(val) && val >= 0) {
                profit = replaceComma(profit);
                profit = profit - val;
                val = formatNumber(val);
                $(e).val(val);
                $("#update_discount").prop("disabled", "");
            } else {
                $(e).addClass("is-invalid");
                $("#update_discount").prop("disabled", true);
            }
        } else {
            val = replacePercent(val);
            profit = replaceComma(profit);
            retail = replaceComma(retail);
            profit = profit - retail * val / 100;
            $("#update_discount").prop("disabled", "");
        }
        $(e).parent().next("td").text(formatNumber(profit));
    }

    function update_discount(e, product_id) {
        let discount = $(e).parent().find("input").val();
        discount = replaceComma(discount);
        discount = replacePercent(discount);
        console.log(discount);
        console.log(product_id);
        if (discount == "undefined" || discount == "" || discount < 0) {
            toastr.error('Nhập chưa đúng!');
            return;
        }
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "update_discount",
                product_id: product_id,
                discount: discount
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

    function update_discount_all() {
        let discount = $("#discountAll").val();
        console.log(discount);
        discount = replaceComma(discount);
        discount = replacePercent(discount);
        console.log(discount);
        if (discount == "undefined" || discount == "" || discount < 0) {
            toastr.error('Nhập chưa đúng!');
            return;
        }
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "update_discount_all",
                discount: discount
            },
            success: function (res) {
                console.log(res);
                toastr.success('Cập nhật thành công!');
                let table = $('#example').DataTable();
                table.ajax.reload();
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

    function count_out_of_stock() {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "count_out_of_stock"
            },
            success: function (res) {
                console.log(res);
                $(".number_out_of_stock").text(res.response);
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                $(".number_out_of_stock").text(0);
            }
        });
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
                if (res.response === "in_stock") {
                    Swal.fire({
                        type: 'error',
                        title: 'Số lượng sản phẩm vẫn còn',
                        text: "Bạn vui lòng kiểm tra lại trước khi cập nhật hết hàng."
                    });
                    return;
                } else if (res.response === "success") {
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

    function format_action(data) {
        let btn =  '<button type="button" class="btn bg-gradient-info btn-sm edit_product" title="Sửa sản phẩm"><i class="fas fa-edit"></i></button>&nbsp;'
            + '<button type="button" class="btn bg-gradient-danger btn-sm out_of_stock" title="Cập nhật hết hàng"><i class="fas fa-eye-slash"></i></button>';
        return btn;
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
        if(data.link == null || data.link == "") {
            return data.name;
        } else {
            return "<a href='" + data.link + "' target='_blank'>" + data.name + "</a>";
        }
    }

    function format_image(data) {
        let image = data.image;
        let json = JSON.parse(image);
        let src = json[0].src;
        let type = json[0].type;
        if(type === "upload") {
            src = '<?php Common::path_img() ?>' + src;
        }
        return "<img src='" + src + "' width='100px' id='thumbnail' onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"'>";
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
            '<th>Shopee</th>' +
            '<th>Lazada</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
        for (let i = 0; i < variations.length; i++) {
            let updated_qty = JSON.parse(variations[i].updated_qty);
            let shopee = updated_qty.shopee === 0 ? '' : 'checked';
            let lazada = updated_qty.lazada === 0 ? '' : 'checked';
            table += '<tr class="' + variations[i].sku + '">' +
                '<td class="center"><input type="checkbox" id="' + variations[i].sku + '" onclick="check(this)"></td>';
            table += '<input type="hidden" class="product-id-' + variations[i].sku + '" value="' + variations[i].product_id + '">' +
                '<td>' + variations[i].sku + '</td>' +
                '<td>' + variations[i].color + '</td>' +
                '<td>' + variations[i].size + '</td>' +
                '<td id="qty">' + variations[i].quantity + '</td>' +
                '<td><div class="custom-control custom-switch">' +
                '<input type="checkbox" class="custom-control-input upd-qty-shopee" id="shopee_'+variations[i].sku+'" '+shopee+' onchange="updatedQty(this, \'shopee\', '+variations[i].sku+')">' +
                '<label class="custom-control-label" for="shopee_'+variations[i].sku+'"></label>' +
                '</div></td>' +
                '<td><div class="custom-control custom-switch">' +
                '<input type="checkbox" class="custom-control-input upd-qty-lazada" id="lazada_'+variations[i].sku+'" '+lazada+' onchange="updatedQty(this, \'lazada\', '+variations[i].sku+')">' +
                '<label class="custom-control-label" for="lazada_'+variations[i].sku+'"></label>' +
                '</div></td>' +
                '</tr>';
        }
        if (isNew === "isNew") {
            let new_sku = Number(variations[variations.length - 1].sku) < 10 ? "0" + variations[variations.length - 1].sku : Number(variations[variations.length - 1].sku) + 1;
            table += '<tr class="' + new_sku + '">' +
                '<td>' + new_sku + '</td>' +
                '<td><select class="select-color-' + new_sku + ' form-control w100" id="select_color_' + new_sku + '"><option value="-1"></option></select></td>' +
                '<td><select class="select-size-' + new_sku + ' form-control w100" id="select_size_' + new_sku + '"><option value="-1"></option></select></td>' +
                '<td><select class="select-qty-' + new_sku + ' form-control w100" id="select_qty_' + new_sku + '"><option value="-1"></option></select></td>' +
                '<input type="hidden" class="product-id-' + new_sku + '" value="' + variations[variations.length - 1].product_id + '">' +
                '</tr>';
        }
        table += '</tbody>';
        table += '</table>';
        return table;
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

    function generate_select2(el, data, value) {
        $(el).select2({
            data: data,
            theme: 'bootstrap4',
            closeOnSelect: true,
            width: '100%'
        });
        if (value !== "") {
            $(el).val(value).trigger('change');
        }
    }
</script>
</body>
</html>
