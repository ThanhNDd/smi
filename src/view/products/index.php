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

        div#product_datatable {
            margin-top: 10px;
        }

        div#product_datatable_filter label {
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

        td, th {
            white-space: nowrap;
        }

        /*.card.card-outline.card-danger {*/
        /*    min-height: 690px;*/
        /*}*/
        span.twitter-typeahead {
            margin-top: 10px;
            width: 86%;
        }
        .select_material label {
            margin-bottom: 0 !important;
        }
        .select_material .twitter-typeahead {
            margin-top: 8px !important;
        }
        table#product_datatable {
            width: 100% !important;
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
                            <button id="btn_update_out_of_stock" class="btn btn-danger btn-flat">
                                <i class="fa fa-spinner fa-spin show_loading_update hidden"></i>&nbsp;Cập nhật hết hàng
                            </button>
                        </div>
                        <div class="form-inline" style="display: inline-block">
                            <input type="number" value="" name="discountAll" id="discountAll" min="0"
                                   placeholder="Giảm giá" class="form-control w110">
                            <button id="update_all" class="btn btn-primary btn-flat">Áp dụng</button>
                        </div>
                        <div class="form-inline" style="display: inline-block">
                            <div class="input-group  d-inline-block">
                                <div class="input-group-prepend d-inline-block">
                                    <select class="form-control" id="search_operator">
                                        <option value="=" selected>=</option>
                                        <option value=">">></option>
                                        <option value="<"><</option>
                                    </select>
                                </div>
                                <input type="number" class="form-control w110 d-inline-block" placeholder="Số lượng" id="search_qty" min="0">
                            </div>
                            <input type="text" class="form-control w110 d-inline-block" placeholder="SKU" id="search_sku">
                            <button id="search_btn" type="button" class="btn btn-primary btn-flat d-inline-block">Tìm kiếm</button>
                            <a href="javascript:void(0)" style="color: red" id="clear_search" class="hidden" title="Xóa điều kiện tìm kiếm"><i class="fas fa-times"></i> xóa</a>
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
                <div class="row col-md-12 mt-2 ml-3">
                    <button class="btn btn-info expandall" id="expandall">Expand all</button>
                    <!-- <a href="<?php Common::getPath() ?>src/view/batch/updateQuantityShopee.php" type="button" class="btn btn-success btn-flat ml-2" id="updateShopee">Cập nhật Shopee</a> -->
                </div>
                <!-- /.card-header -->
                <div class="card-body m-3">
                    <table id="product_datatable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <td class="center clearAll">
                                <i class="fa fa-trash" aria-hidden="true" style="color: red;cursor: pointer;"></i>
                            </td>
                            <th class="">ID</th>
                            <td>Hình ảnh</td>
                            <th>Tên sản phẩm</th>
                            <th>Giá bán lẻ</th>
                            <th>Số lượng</th>
                            <th>Giảm giá</th>
                            <th>Giá sale</th>
                            <th>Danh mục</th>
                            <th>Giới tính</th>
                            <th>Chất liệu</th>
                            <th>Xuất xứ</th>
                            <!-- <td>Publish</td> -->
                            <td>Hành động</td>
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
    let table;
    let dataUpdateQuantity = [];
    $(document).ready(function () {
        set_title("Danh sách sản phẩm");
        count_out_of_stock();

        $('#product_datatable thead th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
        });

        let operator = "<?php echo (isset($_GET['operator']) ? $_GET['operator'] : '=') ?>";
        $("#search_operator").val(operator);
        let qty = "<?php echo (isset($_GET['qty']) ? $_GET['qty'] : '') ?>";
        $("#search_qty").val(qty);
        let sku = "<?php echo (isset($_GET['sku']) ? $_GET['sku'] : '') ?>";
        $("#search_sku").val(sku);
        if(qty || sku) {
            $("#clear_search").removeClass("hidden");
        } else {
            $("#clear_search").addClass("hidden");
        }
        generate_datatable();
        custom_select2('#search_category', select_cats);

        $(".print-barcode").on("click", function () {
            let data = [];
            $.each($("#product_datatable tbody td input[type='checkbox']:checked"), function () {
                let id = $(this).attr("id");
                if (id != "selectall" && !isNaN(id)) {
                    let product = {};
                    product["id"] = $(this).attr("id");
                    product["qty"] = $("#text_qty_"+id).val();
                    // data.push($(this).attr("id"));
                    data.push(product);
                    // console.log(JSON.stringify(product));
                }
            });
            setTimeout(function () {
                // console.log(JSON.stringify(data));
                if (data.length > 0) {
                    printBarcode(data);
                }
            },300);
        });
        $(".clearAll").on("click", function () {
            clearAll();
        });

        $("#update_all").on("click", function (e) {
            Swal.fire({
                title: 'Bạn chắc chắn chứ?',
                text: "Bạn muốn cập nhật giảm giá cho tất cả sản phẩm!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý'
            }).then((result) => {
                if (result.value) {
                    update_discount_all(e);
                }
            })
        });

        $("#clear_search").on("click", function () {
            $("#search_operator").val("=");
            $("#search_qty").val("");
            $("#search_sku").val("");
            window.location.href = create_url();
        });

        $("#search_btn").on( "click", function() {
            window.location.href = create_url();
        });
        $("#search_btn").on( "keydown", function( event ) {
            let key = event.which;
            if(key === 13) {
                window.location.href = create_url();
            }
        });
        $("#search_operator").on( "change", function() {
            let qty = $("#search_qty").val();
            if(qty) {
                window.location.href = create_url();
            }
        });
        $("#search_qty").on( "keydown", function( event ) {
            let key = event.which;
            if(key === 13) {
                // console.log(create_url());
                $("#search_sku").val("");
                window.location.href = create_url();
            }
        });
        $("#search_sku").on( "keydown", function( event ) {
            let key = event.which;
            if(key === 13) {
                // console.log(create_url());
                $("#search_qty").val("");
                window.location.href = create_url();
            }
        });

        $("#btn_update_out_of_stock").on("click", function (e) {
            $(this).children("i.show_loading_update").removeClass("hidden");
            $(this).prop("disabled", true);
            let that = this;
            Swal.fire({
                title: 'Bạn chắc chắn chứ?',
                text: "Tất cả các sản phẩm hết hàng sẽ được tự động cập nhật và ẩn khỏi danh sách sản phẩm!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý'
            }).then((result) => {
                if (result.value) {
                    update_out_of_stock(e, -1, that);
                } else {
                    $(that).prop("disabled", '');
                    $(that).children("i.show_loading_update").addClass("hidden");
                }
            })
        });
    
        // getDataForChatBot();

    });

    function create_url() {
        let url = window.location.href;
        url = url.split("?")[0];
        let qty = $("#search_qty").val();
        let operator = $("#search_operator").val();
        let sku = $("#search_sku").val();
        if(!qty && !sku) {
            return url;
        }
        url += "?";
        if(qty) {
            url += "qty="+qty.trim()+"&operator="+operator;
        }
        if(qty && sku) {
            url += "&";
        }
        if(sku) {
            url += "sku="+sku.trim();
        }
        return url;
    }

    function clearAll() {
        $.each($("#product_datatable tbody td input[type='checkbox']:checked"), function () {
            $(this).prop("checked", false);
        });
        $(".number-checked").text(0);
    }

    function countAllChecked() {
        let count = 0;
        $.each($("#product_datatable tbody td:first-child input[type='checkbox']:checked"), function () {
            let id = $(this).attr("id");
            if (id != "selectall") {
                count++;
            }
        });
        $(".number-checked").text(count);
    }

    function printBarcode(data, customPrint = false) {
        $(".iframeArea").html("");
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "print_barcode",
                data: JSON.stringify(data),
                customPrint: customPrint 
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
        if ($.fn.dataTable.isDataTable('#product_datatable')) {
            let dt =  $('#product_datatable').DataTable();
            dt.destroy();
            dt.clear();
            dt.ajax.reload();
        }
        $('#product_datatable').DataTable({
            'ajax': {
                "type": "GET",
                "url": '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                "data": get_data_search()
            },
            ordering: false,
            "dom": '<"top"flp<"clear">>rt<"bottom"ip<"clear">>',
            select: "single",
            deferRender: true,
            rowId: 'extn',
            "initComplete": function() {
                // init_select2();
                // Apply the search
                this.api().columns().every( function () {
                    var that = this;
                    $( 'input', this.header() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that.search( this.value ).draw();
                        }
                    });
                } );
            },
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
                    "className": '',
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
                    "data": format_quantity,
                    "class": "center",
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
                    "data": format_category,
                    width: "50px"
                },
                {
                    "data": format_gender,
                    width: "50px"
                },
                {
                    "data": "material",
                    width: "50px"
                },
                {
                    "data": format_origin,
                    width: "50px"
                },
                // {
                //     "data": format_publish,
                //     width: "50px"
                // },
                {
                    "data": format_action,
                    width: "50px"
                }
            ],
            "lengthMenu": [[200, 500], [200, 500]]
        });
        
        $("#expandall").click(function () {
            let cls = $(this).attr("class");
            if(cls.indexOf('expandall') > -1) {
                $(this).removeClass('expandall');
                $(this).html('Collapse all');
            } else {
                $(this).addClass('expandall');
                $(this).html('Expand all');
            }
            table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
        });

        // Add event listener for opening and closing details
        $('#product_datatable tbody').on('click', '.details-control', function (event) {
            let dt =  $('#product_datatable').DataTable();
            let tr = $(this).closest('tr');
            let tdi = tr.find("i.fa");
            let row = dt.row(tr);
            let productId = row.data().product_id;
            let discount = row.data().discount;

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
                        let data = res.data;
                        if (data.length > 0) {
                            row.child(format_variation(productId, data, discount)).show();
                            tr.addClass('shown');
                            tdi.first().removeClass('fa-plus-square');
                            tdi.first().addClass('fa-minus-square');
                            prinrBarcodeProductCustom();
                        }
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
            event.preventDefault();
        });

        $('#product_datatable tbody').on('click', '.edit_product', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let product_id = $(td[1]).text();
            // clear();
            // open_modal();
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
                    open_modal_product_create();
                    // console.log(res);
                    let arr = res.data;
                    $("#display_product_id").val(arr[0].product_id);
                    $("#product_id").val(arr[0].product_id);

                    $("#name").val(arr[0].name);
                    $("#name_for_website").val(arr[0].name_for_website);
                    $("#link").val(arr[0].link);
                    // $("#fee").val(arr[0].fee_transport);
                    // $("#price").val(arr[0].price);
                    // $("#percent").val(arr[0].percent);
                    // $("#retail").val(arr[0].retail);
                    // $("#profit").val(arr[0].profit);
                    // $("#qty").val(arr[0].quantity);

                    $("#select_gender").val(arr[0].type).trigger("change");
                    $("#select_cat").val(arr[0].category_id).trigger("change");
                    // $("#select_material").val(arr[0].material).trigger("change");
                    $("#select_origin").val(arr[0].origin).trigger("change");
                    $('#short_description').val(arr[0].short_description);

                    if(arr[0].description !== "") {
                        $('#description').summernote('code', arr[0].description);
                    } else {
                        $('#description').summernote('code', '');
                    }

                    // $(".select_material").html("<label for=\"select_material\">Chất liệu:</label><input id='select_material' class=\"form-control\" type=\"text\" placeholder=\"Chọn chất liệu\" autocomplete=\"off\" spellcheck=\"false\">");
                    $('#select_material').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        name: 'size',
                        source: substringMatcher(materials),
                        limit: 10
                    });
                    setTimeout(function(){
                        if(arr[0].material) {
                            $('#select_material').typeahead('val', arr[0].material);
                        }
                    },200);

                    let color = arr[0].colors;
                    for(let i=0; i<color.length; i++) {
                        add_color(color[i]);
                    }
                    let size = arr[0].sizes;
                    for(let i=0; i<size.length; i++) {
                        add_size(size[i]);
                    }

                    let image = arr[0].image;
                    let json = JSON.parse(image);
                    if(json.length > 0) {
                        $("#image").html("");
                        idx_image = 1;
                        for(let i=0; i<json.length; i++) {
                            let src = json[i].src;
                            let type = json[i].type;
                            if(type === "upload") {
                                src = '<?php echo Common::path_img() ?>' + src;
                            }
                            add_image(src, type);
                        }
                    }

                    let image_variation = arr[0].image_variation;
                    if(image_variation.length > 0) {
                        $("#image_by_color").html("");
                        for (let i = 0; i < color.length; i++) {
                            add_image_by_color((i + 1), image_variation[i]);
                        }
                    }

                    // $("#select_size").prop("disabled", "disabled");
                    // $("#select_color").prop("disabled", "disabled");
                    //

                    let variations = arr[0].variations;
                    if(variations.length > 0){
                        $(".table-list tbody").html("");
                        draw_table_variations_by_edit_product(color.length, size.length, variations);
                    }

                    // let count = 0;
                    // for (let i = 0; i < variations.length; i++) {
                    //     let id = variations[i].id;
                    //     let sku = variations[i].sku;
                    //     // let image = variations[i].image;
                    //     let size = variations[i].size;
                    //     let color = variations[i].color;
                    //     let qty = variations[i].quantity;
                    //     count++;
                    //     // generate_variations(count, qty, id, color, size, sku);
                    // }
                    $(".create-new").text("Cập nhật");
                    $(".add-new-prod").prop("disabled", '');
                    // $("#create_variation").prop("disabled", true);

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
        });

        // Event click add new row variation
        // $('#product_datatable tbody').on('click', '.add_variation', function () {
        //     let tr = $(this).closest('tr');
        //     let tdi = tr.find("i.fa");
        //     let row = table.row(tr);
        //     //  if (!row.child.isShown()) {
        //     // Open this row
        //     let variations = row.data().variations;
        //     let new_sku = Number(variations[variations.length - 1].sku) < 10 ? "0" + variations[variations.length - 1].sku : Number(variations[variations.length - 1].sku) + 1;
        //     row.child(format_variation(variations, "isNew")).show();
        //     tr.addClass('shown');
        //     tdi.first().removeClass('fa-plus-square');
        //     tdi.first().addClass('fa-minus-square');

        //     generate_select2(".select-qty-" + new_sku, select_qty, "");
        //     generate_select2(".select-color-" + new_sku, select_colors, "");
        //     generate_select2(".select-size-" + new_sku, select_size, "");
        //     //  }
        // });

        // Event click Edit variation
        $('#product_datatable tbody').on('click', '.edit_variation', function () {
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
        $('#product_datatable tbody').on('click', '.save_variation', function () {
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
                    table.ajax.reload(init_select2, false);
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
        });

        // Event click update variation
        $('#product_datatable tbody').on('click', '.update_variation', function () {
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
        $('#product_datatable tbody').on('click', '.cancel_variation', function () {
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
        $('#product_datatable tbody').on('click', '.delete_variation', function () {
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
                            // console.log(res);
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

        $('#product_datatable tbody').on('click', '.cancal_add_new', function () {
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

        $('#product_datatable tbody').on('click', '.out_of_stock', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let product_id = $(td[1]).text();
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
            check_stock($(this), product_id);
        });

        // $('#product_datatable tbody').on('click', '.copy-to-online', function () {
        //     let tr = $(this).closest('tr');
        //     let td = tr.find("td");
        //     let product_id = $(td[1]).text();
        //     if ($(this).hasClass('selected')) {
        //         $(this).removeClass('selected');
        //     } else {
        //         $('tr.selected').removeClass('selected');
        //         $(this).addClass('selected');
        //     }
        //     Swal.fire({
        //         title: 'Bạn chắc chắn muốn copy sản phẩm này sang hệ thống Online?',
        //         text: "",
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Ok'
        //     }).then((result) => {
        //         if (result.value) {
        //             copyToOnline($(this), product_id);
        //         }
        //     });
        // });

        $('#product_datatable tbody').on('click', '.website-publish', function () {
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

        $('#product_datatable tbody').on('click', '.facebook-publish', function () {
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

        $('#product_datatable tbody').on('click', '.shopee-publish', function () {
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


        $('#product_datatable tbody').on('click', '.feature-publish', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let product_id = $(td[1]).text();
            let checked = $(this).parent().children('input').prop('checked');
            let status = 0;
            if(checked) {
                status = 1;
            }
            social_publish(product_id, 'feature', status);
        });

        $('#product_datatable tbody').on('click', '.edit-quantity', function () {
            let tr = $(this).closest('tr');
            let td = tr.find("td");
            let product_id = $(td[1]).text();
            let product_name = $(td[3]).text();
            edit_quantity(product_id, product_name);
        });

    }

    function edit_quantity(productId, productName) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "find_detail",
                product_id: productId
            },
            success: function (res) {
                $("#modalEditQuantity").remove();
                dataUpdateQuantity = [];
                let data = res.data;
                dataUpdateQuantity = res.data;
                console.log("data: ", data);
                let contentModal = `<div id="modalEditQuantity" class="modal fade" role="dialog">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">${productName}</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 80px">Hình ảnh</th>
                                                            <th>Màu</th>
                                                            <th>Size</th>
                                                            <th>Tồn kho</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>`;
                                            $.each(data, function(k, value){
                                                $.each(value, function(k, v){
                                                    contentModal += `<tr>
                                                                        <td class="d-none">
                                                                            <input type="hidden" class="form-control" value="${v.product_id}" />
                                                                        </td>
                                                                        <td class="d-none">
                                                                            <input type="hidden" class="form-control" value="${v.sku}" />
                                                                        </td>`;
                                                                        if(k == 0 ) {
                                                        contentModal += `<td rowspan="${value.length}">
                                                                            <a href="${v.image}" target="_blank">
                                                                                <img src="${v.image}" width="100px" id="thumbnail" onerror="this.onerror=null;this.src='http://localhost/online/dist/img/img_err.jpg'">
                                                                            </a>
                                                                        </td>
                                                                        <td rowspan="${value.length}" style="white-space: nowrap;">${v.color}</td>`;
                                                                        }
                                                        contentModal += `<td style="white-space: nowrap;vertical-align: middle;">${v.size}</td>
                                                                        <td>
                                                                            <input type="number" class="form-control" min="0" id="quantity_update_${v.sku}" data="${v.sku}" value="${v.quantity}" style="width: 80px" />
                                                                        </td>
                                                                    </tr>`;
                                                });
                                            });
                                    contentModal += `</tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer d-inline-block">
                                                <button type="button" class="btn btn-danger float-left" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary float-right" id="updateQuantity">Cập nhật</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>`;
                $("body").append(contentModal);
                
                $("#modalEditQuantity").modal({
                    backdrop: "static",
                    keyboard: false
                });                

                btnUpdateQuantityClick();
                quantityChange();
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

    function quantityChange() {
        $("input[id^='quantity_update_']").change(function () {
            let sku = $(this).attr("data");
            let quantity = $(this).val();
            $.each(dataUpdateQuantity, function(key, value) {
                $.each(value, function(k, v) {
                    if(v.sku == sku) {
                        value[k].quantity = quantity;
                        dataUpdateQuantity[key] = value;
                    }
                });
            });
            console.log("dataUpdateQuantity: ", dataUpdateQuantity);
        });
    }

    function btnUpdateQuantityClick() {
        $("#updateQuantity").click(function(){
            console.log("dataUpdateQuantity: ", dataUpdateQuantity);
            Swal.fire({
                title: 'Bạn có chắc chắn muốn cập nhật tồn kho sản phẩm này?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    updateQuantity();
                }
            });
        });
    }

    function updateQuantity() {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "update_quantity",
                data: JSON.stringify(dataUpdateQuantity)
            },
            success: function () {
                let table = $('#product_datatable').DataTable();
                table.ajax.reload();
                toastr.success('Cập nhật thành công!');
                $("#modalEditQuantity").modal("hide");
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

    function format_gender(data) {
        let gender_id = data.type;
        for(let i=0; i<select_types.length; i++) {
            let id = select_types[i].id;
            if(id === gender_id) {
                return select_types[i].text;
            }
        }
        return '';
    }

    function format_category(data) {
        let category_id = data.category_id;
        for(let i=0; i<select_cats.length; i++) {
            let id = select_cats[i].id;
            if(id === category_id) {
                return select_cats[i].text;
            }
        }
        return '';
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
        let feature = social_publish.feature ? (social_publish.feature === 0 ? '' : 'checked') : '';
        btn += '<div class="custom-control custom-switch">' +
            '<input type="checkbox" class="custom-control-input feature-publish" id="feature_'+product_id+'" '+feature+'>' +
            '<label class="custom-control-label" for="feature_'+product_id+'">Nổi bật</label>' +
            '</div>';
        return btn;
    }

    function format_material(data) {
        let material = "";
        if(data.material != null) {
            select_material.forEach(function(item) {
                if(data.material === item.id) {
                    material = item.text;
                    return false;
                }
            });
        } else {
            let productId = data.product_id;
            material = "<select class='select-material form-control ml-2 col-sm-10' style='width: 70%;'></select>" +
                "<button type=\"button\" class=\"btn bg-gradient-info btn-sm mt-1 ml-1\" onclick=\"update_material(this, "+productId+")\"><i class=\"fas fa-save\"></i></button>";
        }
        return material;
    }

    function format_origin(data) {
        let origin = "";
        if(data.origin != null) {
            select_origin.forEach(function(item) {
                if(data.origin === item.id) {
                    origin = item.text;
                    return false;
                }
            });
        } else {
            let productId = data.product_id;
            origin = "<select class='select-origin form-control ml-2 col-sm-10' style='width: 70%;'></select>" +
                "<button type=\"button\" class=\"btn bg-gradient-info btn-sm mt-1 ml-1\" onclick=\"update_origin(this, "+productId+")\"><i class=\"fas fa-save\"></i></button>";
        }
        return origin;
    }

    function format_discount_display(data) {
        let discount = data.discount;
        if(!discount || discount === '' || discount === '0') {
            return '';
        }
        let retail = data.retail;
        let min_price = 0;
        let max_price = 0;
        if(retail.indexOf("-") > -1) {
            min_price = replaceComma(retail.split("-")[0]);
            max_price = replaceComma(retail.split("-")[1]);
        } else {
            retail = replaceComma(retail);
        }
        let salePrice = '';
        if (discount > 100) {
            if(min_price > 0 || max_price > 0) {
                salePrice = formatNumber(min_price - discount) +" - "+formatNumber(max_price - discount);
            } else {
                salePrice = formatNumber(retail - discount);
            }
        } else {
            if(min_price > 0 || max_price > 0) {
                salePrice = formatNumber(min_price - (min_price * discount) / 100) +" - "+formatNumber(max_price - (max_price * discount) / 100);
            } else {
                salePrice = formatNumber(retail - (retail * discount) / 100);
            }
        }
        return salePrice;
    }

    function format_quantity(data) {
        let totalQty = data.total_quantity;
        return `${totalQty} <br /><i class="fa fa-edit text-info c-pointer edit-quantity"></i>`;
    }

    function format_discount(data) {
        let discount = data.discount;
        if (!discount || discount === "0") {
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
        return '<input type="text" onchange="onchange_discount(this, \'' + profit + '\', \'' + retail + '\')" onblur="onchange_discount(this, \'' + profit + '\', \'' + retail + '\')" class="form-control col-md-12 float-left" value="' + discount + '"/>&nbsp;' +
            '<button type="button" class="btn bg-gradient-info btn-sm mt-1" onclick="update_discount(this, ' + product_id + ')" title="Lưu khuyến mãi"><i class="fas fa-save"></i></button>';
    }

    function onchange_discount(e, profit, retail) {
        $(e).removeClass("is-invalid");
        $("#update_discount").prop("disabled", true);
        let discount = $(e).val();
        if(!discount) {
            return;
        }
        discount = replaceComma(discount);
        discount = replacePercent(discount);
        let min_price = 0;
        let max_price = 0;
        if(retail.indexOf("-") > -1) {
            min_price = replaceComma(retail.split("-")[0]);
            max_price = replaceComma(retail.split("-")[1]);
        } else {
            retail = replaceComma(retail);
        }
        let min_profit = 0;
        let max_profit = 0;
        if(profit.indexOf("-") > -1) {
            min_profit = replaceComma(profit.split("-")[0]);
            max_profit = replaceComma(profit.split("-")[1]);
        } else {
            profit = replaceComma(profit);
        }
        let salePrice = '';

        if (!isNaN(discount) && discount > 0) {
            if (discount > 100) {
                if(min_price > 0 || max_price > 0) {
                    profit = formatNumber(Math.round(min_profit - discount)) +" - "+formatNumber(Math.round(max_profit - discount));
                    salePrice = formatNumber(min_price - discount) +" - "+formatNumber(max_price - discount);
                } else {
                    profit = formatNumber(Math.round(profit - discount));
                    salePrice = formatNumber(retail - discount);
                }
                $(e).val(formatNumber(discount));
            } else {

                // discount = replacePercent(discount);
                if(min_price > 0 || max_price > 0) {
                    // profit = '';
                    profit = formatNumber(Math.round(min_profit - min_profit * discount / 100)) +" - "+formatNumber(Math.round(max_profit - max_profit * discount / 100));
                    salePrice = formatNumber(min_price - (min_price * discount) / 100) +" - "+formatNumber(max_price - (max_price * discount) / 100);
                } else {
                    profit = formatNumber(Math.round(profit - retail * discount / 100));
                    salePrice = formatNumber(retail - (retail * discount) / 100);
                }
                // $("#update_discount").prop("disabled", "");
                $(e).val(discount+"%");
            }
            $("#update_discount").prop("disabled", "");
        } else {
            $(e).addClass("is-invalid");
            $("#update_discount").prop("disabled", true);
        }
        $(e).parent().next("td").html(formatNumber(salePrice)+'<br><small>'+formatNumber(profit)+'</small>');
    }

    function update_discount(e, product_id) {
        let discount = $(e).parent().find("input").val();
        discount = replaceComma(discount);
        discount = replacePercent(discount);
        if (!discount || discount < 0) {
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
                // console.log(res);
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

    function search() {
        generate_datatable();
    }

    function get_data_search(type) {
        let quantity = $("#search_qty").val();
        let operator = $("#search_operator").val();
        let sku = $("#search_sku").val();
        //let operator = "<?php //echo (isset($_GET['operator']) ? $_GET['operator'] : '=') ?>//";
        //let quantity = "<?php //echo (isset($_GET['qty']) ? $_GET['qty'] : '') ?>//";
        //let sku = "<?php //echo (isset($_GET['sku']) ? $_GET['sku'] : '') ?>//";
        //$("#search_sku").val(sku);
        return {
            method : 'findall',
            status : 0,
            quantity : quantity.trim(),
            operator : operator.trim(),
            sku : sku.trim(),
        }
        // if(type === 'qty') {
        //     return {
        //         method : 'findall',
        //         status : 0,
        //         quantity : quantity.trim(),
        //         operator : operator.trim(),
        //     }
        // } else {
        //     return {
        //         method : 'findall',
        //         status : 0,
        //         sku : sku.trim()
        //     }
        // }

    }

    function update_discount_all() {
        let discount = $("#discountAll").val();
        // console.log(discount);
        discount = replaceComma(discount);
        discount = replacePercent(discount);
        // console.log(discount);
        if (!discount || discount < 0) {
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
                // console.log(res);
                toastr.success('Cập nhật thành công!');
                let table = $('#product_datatable').DataTable();
                table.ajax.reload(init_select2, false);
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

    function update_material(e, product_id) {
        let material = $(e).parent().find("select").val();
        // console.log(material);
        if (typeof material === "undefined" || material < 0) {
           toastr.error('Bạn chưa chọn Chất liệu!');
           return false;
        }
        update_attr(product_id, material, 'material');
    }

    function update_origin(e, product_id) {
        let origin = $(e).parent().find("select").val();
        // console.log(origin);
        if (typeof origin === "undefined" || origin < 0) {
            toastr.error('Bạn chưa chọn Xuất xứ!');
            return false;
        }
        update_attr(product_id, origin, 'origin');
    }

    function update_attr(product_id, data, type) {
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
            type: "POST",
            dataType: "json",
            data: {
                method: "update_attr",
                product_id: product_id,
                data: data,
                type: type
            },
            success: function (res) {
                // console.log(res);
                toastr.success('Cập nhật thành công!');
                $("#product_datatable").DataTable().ajax.reload(init_select2, false);
            },
            error: function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                });
            }
        });
    }

    function init_select2() {
        custom_select2('.select-origin', select_origin);
        custom_select2('.select-material', select_material);
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
                // console.log(res);
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
                // console.log(res);
                if (res.response === "in_stock") {
                    Swal.fire({
                        type: 'error',
                        title: 'Số lượng sản phẩm vẫn còn',
                        text: "Bạn vui lòng kiểm tra lại trước khi cập nhật hết hàng."
                    });
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

    // function copyToOnline(e, product_id) {
    //     $.ajax({
    //         url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
    //         type: "POST",
    //         dataType: "json",
    //         data: {
    //             method: "copyToOnline",
    //             data: product_id
    //         },
    //         success: function (res) {
    //             console.log(res);
    //         },
    //         error: function (data, errorThrown) {
    //             console.log(data.responseText);
    //             console.log(errorThrown);
    //             toastr.error("Đã xảy ra lỗi");
    //         }
    //     });
    // }

    function update_out_of_stock(e, product_id, that) {
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
                toastr.success('Cập nhật thành công!');
                if(e && $(e)) {
                    $(e).parent().parent().hide(700);
                    // $(e).parent().parent().next().hide(700);
                }
                $(that).prop("disabled", '');
                $(that).children("i.show_loading_update").addClass("hidden");
                count_out_of_stock();
                $("#product_datatable").DataTable().ajax.reload(init_select2, false);
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
        if(IS_ADMIN) {
            let btn =  '<button type="button" class="btn bg-gradient-info btn-sm edit_product m-1" title="Sửa sản phẩm"><i class="fas fa-edit"></i></button>&nbsp;'
                + '<button type="button" class="btn bg-gradient-danger btn-sm out_of_stock m-1" title="Cập nhật hết hàng"><i class="fas fa-eye-slash"></i></button>';
            return btn;
        }
        return null;
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
        if(data.variant_image) {
            return "<a href='"+data.variant_image+"' target='_blank'><img src='" + data.variant_image + "' width='100px' id='thumbnail' onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"'></a>";
        } else {
            let image = !data.image || data.image === '[]' ? data.variant_image : data.image;
            try {
                let json = JSON.parse(image);
                let src = '';
                if(json.length > 0) {
                    src = json[0].src;
                    let type = json[0].type;
                    if (type === "upload") {
                        src = '<?php Common::path_img() ?>' + src;
                    }
                }
                return "<a href='"+src+"' target='_blank'><img src='" + src + "' width='100px' id='thumbnail' onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"'></a>";
            } catch (e) {
                return "<a href='"+image+"' target='_blank'><img src='" + image + "' width='100px' id='thumbnail' onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"'></a>";
            }
        }
    }

    function format_variation(productId, variations, discount, isNew) {
        let table = "";
        if(productId == 1079) {
            table += `<div class="row col-md-12">
                        <button class="btn btn-info mt-4 ml-4" data="${productId}" id="print_barcode_${productId}">
                            <i class="fa fa-barcode"></i> In mã vạch
                        </button>
                    </div>`;
        }
        table += "<div class=\"card card-outline card-danger\" style='margin: 20px'>\n" +
            "        <div class=\"card-body\" style='width: 100%;overflow: scroll;'>";
        table += `<table cellpadding="5" cellspacing="0" border="0" 
                    style="padding-left:50px;min-width: 1180px;overflow: scroll hidden;" 
                    class="table table-hover table-bodered" 
                    id="table_variations_${productId}">`;
        table += '<thead>' +
            '<tr>' +
            '<th style="width: 50px;" class="center"><input type="checkbox" id="selectall" onclick="checkAll(this)"></th>' +
            '<th style="width: 100px;">Hình ảnh</th>' +
            '<th style="width: 80px;">Màu</th>' +
            '<th style="width: 150px;">Mã sản phẩm</th>' +
            '<th style="width: 350px;">Size</th>' +
            '<th style="width: 80px;">Số lượng</th>' +
            '<th style="width: 60px;">Giá bán</th>' +
            '<th style="width: 100px;">Giá sale</th>' +
            '<th style="width: 130px;">Chiều dài</th>' +
            '<th style="width: 130px;">Cân nặng</th>' +
            '<th style="width: 130px;">Chiều cao</th>' +
            '<th style="width: 130px;">Tuổi</th>' +
            '<th style="width: 130px;">Kích thước</th>' +
            // '<th>Shopee</th>' +
            // '<th>Lazada</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
        let width_img = 35;
        for (let i = 0; i < variations.length; i++) {
            // let updated_qty = JSON.parse(variations[i].updated_qty);
            // let shopee = updated_qty.shopee === 0 ? '' : 'checked';
            // let lazada = updated_qty.lazada === 0 ? '' : 'checked';

            let len = variations[i].length;
            for(let j=0; j<len; j++) {
                table += '<tr class="' + variations[i][j].sku + '">';
                table += '<input type="hidden" class="product-id-' + variations[i][j].sku + '" value="' + variations[i][j].product_id + '">';
                table += '<td class="center"><input type="checkbox" id="' + variations[i][j].sku + '" onclick="check(this)" '+(variations[i][j].quantity === "0" ? "disabled" : "")+'></td>';
                if(j === 0) {
                    table += "<td rowspan=\""+variations[i].length+"\"><img onerror=\"this.onerror=null;this.src='<?php Common::image_error() ?>'\" width=\""+(width_img*len)+"\" src=\""+variations[i][j].image+"\" style=\"max-width: 70px;\"></td>";
                    table += '<td rowspan="'+variations[i].length+'">' + variations[i][j].color + '</td>';
                }
                table += '<td>' + variations[i][j].sku + '</td>';
                let size = `<strong>${variations[i][j].size}</strong>`;
                let ext = "";
                if(variations[i][j].weight) {  
                    ext += `${variations[i][j].weight}, `;
                }
                if(variations[i][j].height) {  
                    ext += `${variations[i][j].height}, `;
                }
                if(variations[i][j].age) {  
                    ext += `${variations[i][j].age}, `;
                }
                if(variations[i][j].dimension) {  
                    ext += `${variations[i][j].dimension}, `;
                }
                if(variations[i][j].length__) {  
                    ext += `${variations[i][j].length__}, `;
                }
                if(ext != "") {
                    ext = ext.substring(0, ext.length - 2);
                    size += ` (${ext})`;
                }
                table += `<td>${size}</td>`;
                if(variations[i][j].quantity === "0") {
                    table += '<td id="qty"><span class=\"text-danger\">Hết hàng</span></td>';
                } else if(variations[i][j].quantity > 0 && variations[i][j].quantity < 3) {
                    table += '<td id="qty" class="bg-warning">' +
                        '<span id="qty_'+variations[i][j].sku+'">'+variations[i][j].quantity+'</span>' +
                        '<input type="number" value="'+variations[i][j].quantity+'" class="hidden form-control" width="50px" id="text_qty_'+variations[i][j].sku+'" min="1" max="'+variations[i][j].quantity+'">' +
                        '</td>';
                } else if(variations[i][j].quantity < 0) {
                    table += '<td id="qty" class="bg-danger">' +
                        '<span id="qty_'+variations[i][j].sku+'">'+variations[i][j].quantity+'</span>' +
                        '<input type="number" value="'+variations[i][j].quantity+'" class="hidden form-control" width="50px" id="text_qty_'+variations[i][j].sku+'" min="1" max="'+variations[i][j].quantity+'">' +
                        '</td>';
                } else {    
                    table += '<td id="qty">' +
                        '<span id="qty_'+variations[i][j].sku+'">'+variations[i][j].quantity+'</span>' +
                        '<input type="number" value="'+variations[i][j].quantity+'" class="hidden form-control" width="50px" id="text_qty_'+variations[i][j].sku+'" min="1" max="'+variations[i][j].quantity+'">' +
                        '</td>';
                }
                table += '<td id="retail">' + variations[i][j].retail + '</td>';
                let sale_price = '';
                if(discount && discount > 0) {
                    if(discount < 100) {
                        sale_price = Number(replaceComma(variations[i][j].retail)) * (100 - Number(discount)) / 100;
                    } else {
                        sale_price = Number(replaceComma(variations[i][j].retail)) - Number(discount);
                    }
                }
                table += '<td id="sale_price">' + formatNumber(sale_price) + '</td>';
                table += `<td>${variations[i][j].length__ ? variations[i][j].length__ : ""}</td>`;
                table += `<td>${variations[i][j].weight ? variations[i][j].weight : ""}</td>`;
                table += `<td>${variations[i][j].height ? variations[i][j].height : ""}</td>`;
                table += `<td>${variations[i][j].age ? variations[i][j].age : ""}</td>`;
                table += `<td>${variations[i][j].dimension ? variations[i][j].dimension : ""}</td>`;

                // '<td><div class="custom-control custom-switch">' +
                // '<input type="checkbox" class="custom-control-input upd-qty-shopee" id="shopee_'+variations[i].sku+'" '+shopee+' onchange="updatedQty(this, \'shopee\', '+variations[i].sku+')">' +
                // '<label class="custom-control-label" for="shopee_'+variations[i].sku+'"></label>' +
                // '</div></td>' +
                // '<td><div class="custom-control custom-switch">' +
                // '<input type="checkbox" class="custom-control-input upd-qty-lazada" id="lazada_'+variations[i].sku+'" '+lazada+' onchange="updatedQty(this, \'lazada\', '+variations[i].sku+')">' +
                // '<label class="custom-control-label" for="lazada_'+variations[i].sku+'"></label>' +
                // '</div></td>' +
                table += '</tr>';
            }
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
        table += '</div>';
        table += '</div>';
        return table;
    }

    function prinrBarcodeProductCustom() {
        $("button[id^='print_barcode_']").click(function(){
            let dataPrint = [];
            $("table[id^='table_variations_'] tbody tr").each(function(k, v){
                let sku = $(v).attr("class");
                let checked = $(`#${sku}`).is(":checked");
                if(checked) {
                    let qty = $(`#text_qty_${sku}`).val();
                    let obj = {};
                    obj.id = sku;
                    obj.qty = qty;
                    dataPrint.push(obj);
                }
            });
            if(dataPrint.length == 0) {
                toastr.error("Bạn chưa chọn sản phẩm để In");
                return false;
            }
            console.log(dataPrint);
            printBarcode(dataPrint, true);
        });
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
                // console.log(res);
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
            let sku = $(e).attr("id");
            let qty = $("#qty_"+sku).text();
            $("#qty_"+sku).addClass("hidden");
            $("#text_qty_"+sku).val(qty).removeClass("hidden");
        } else {
            $(e).prop("checked", "");
            let sku = $(e).attr("id");
            let qty = $("#qty_"+sku).text();
            $("#qty_"+sku).removeClass("hidden");
            $("#text_qty_"+sku).val(qty).addClass("hidden");
        }
        countAllChecked();
    }

    function checkAll(e) {
        let isCheck = $(e).prop('checked');
        if (isCheck) {
            // $(e).parent().parent().parent().parent().find('td input:checkbox').prop("checked", "checked");
            $(e).parent().parent().parent().parent().find('td input:checkbox').trigger("click");
        } else {
            // $(e).parent().parent().parent().parent().find('td input:checkbox').prop("checked", "");
            $(e).parent().parent().parent().parent().find('td input:checkbox').trigger("click");
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



    // function getDataForChatBot() {
    //     $.ajax({
    //         url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
    //         type: "POST",
    //         dataType: "json",
    //         data: {
    //             method: "get_data_for_chat_bot"
    //         },
    //         success: function (res) {
    //             console.log(JSON.stringify(res));
    //         },
    //         error: function (data, errorThrown) {
    //             console.log(data.responseText);
    //             console.log(errorThrown);
    //             Swal.fire({
    //                 type: 'error',
    //                 title: 'Đã xảy ra lỗi',
    //                 text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
    //             })
    //         }
    //     });
    // }

</script>
</body>
</html>
