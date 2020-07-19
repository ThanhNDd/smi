<?php
require_once("../../common/common.php");
Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sản phẩm hết hàng</title>
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
    </style>
</head>
<?php require('../../common/header.php'); ?>
<?php require('../../common/menu.php'); ?>
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row col-12" style="display: inline-block;">
                    <section class="ml-4" style="display: inline-block;float: left;padding-top: 1.25rem;">
                        <a class="btn btn-secondary btn-flat" href="<?php Common::getPath() ?>src/view/products/index.php">
                            <i class="fas fa-chevron-circle-left"></i> Quay lại
                        </a>
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
                            <th>Giá bán lẻ</th>
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
<?php include 'createProducts.php'; ?>
<!-- /.content -->
</div>
<div class="iframeArea hidden"></div>
<?php require_once ('../../common/footer.php'); ?>
<?php require_once('attribute.php'); ?>
<script>
    $(document).ready(function () {
        set_title("Danh sách sản phẩm hết hàng");

        generate_datatable();

        $(".clearAll").on("click", function () {
            clearAll();
        });
    });

    function clearAll() {
        $.each($("#example tbody td input[type='checkbox']:checked"), function () {
            $(this).prop("checked", false);
        });
        $(".number-checked").text(0);
    }

    function generate_datatable() {
        let table = $('#example').DataTable({
            "ajax": '<?php Common::getPath() ?>src/controller/product/ProductController.php?method=findall&status=1',
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
            let input_color = '<select class="select-color-' + sku + ' form-control w100" id="select_color_' + sku + '"></select>';
            let input_size = '<select class="select-size-' + sku + ' form-control w200" id="select_size_' + sku + '"></select>';
            let input_qty = '<select class="select-qty-' + sku + ' form-control w100" id="select_qty_' + sku + '"></select>';
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
                success: function () {
                    toastr.success('Cập nhật thành công.');
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
                            toastr.success('Xóa thành công.');
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

        $('#example tbody').on('click', '.update_in_stock', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let product_id = $(td[1]).text();
            check_stock($(this), product_id);
        });
    }

    function check_stock(e, product_id) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "check_update_in_stock",
                product_id: product_id
            },
            success: function (res) {
                console.log(res);
                if (res.response === "out_stock") {
                    Swal.fire({
                        type: 'error',
                        title: 'Chưa cập nhật số lượng',
                        text: "Bạn vui lòng cập nhật lại số lượng sản phẩm."
                    });
                    return;
                } else if (res.response === "success") {
                    Swal.fire({
                        title: 'Bạn chắc chắn muốn cập nhật còn hàng cho sản phẩm này?',
                        text: "",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.value) {
                            update_in_stock(e, product_id);
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

    function update_in_stock(e, product_id) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "update_stock",
                product_id: product_id,
                status: 0 // in stock
            },
            success: function (res) {
                console.log(res);
                toastr.success('Cập nhật thành công!');
                $(e).parent().parent().hide(700);
                $(e).parent().parent().next().hide(700);
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

    function format_action() {
        return '<button type="button" class="btn bg-gradient-success btn-sm update_in_stock" title="Cập nhật còn hàng"><i class="fas fa-eye"></i></button>';
    }

    function format_name(data) {
        return "<a href='" + data.link + "' target='_blank'>" + data.name + "</a>";
    }

    function format_image(data) {
        let image = data.image;
        let json = JSON.parse(image);
        let src = json[0].src;
        let type = json[0].type;
        if(type === "upload") {
            src = '<?php Common::path_img() ?>' + src;
        }
        return "<a href='"+src+"' target='_blank'><img src='" + src + "' width='100px' id='thumbnail' onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"'></a>";
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
                //'<button type="button" class="btn bg-gradient-danger btn-sm cancal_add_new"><i class="fas fa-trash"></i> Hủy</button>' +
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
    }

    function checkAll(e) {
        let isCheck = $(e).prop('checked');
        if (isCheck) {
            $(e).parent().parent().parent().parent().find('td input:checkbox').prop("checked", "checked");
        } else {
            $(e).parent().parent().parent().parent().find('td input:checkbox').prop("checked", "");
        }
    }

    // function formatNumber(num) {
    //     return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    // }
    //
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
