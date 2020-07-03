<?php
require_once("../../common/common.php");
Common::authen();
?>
<div class="modal fade" id="create-product">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="overlay d-flex justify-content-center align-items-center hidden">
                <i class="fas fa-2x fa-sync fa-spin"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title">Tạo mới sản phẩm</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="min-height: 300px;">
                <div class="row col-md-12">
                    <div class="col-md-12">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Thông tin sản phẩm</h3>
                            </div>
                            <div class="card-body">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-3">
                                        <label for="display_product_id">Mã sản phẩm:</label>
                                        <input type="text" class="form-control ml-2" id="display_product_id" value="" disabled>
                                        <input type="hidden" class="form-control ml-2 col-sm-10" id="product_id" value="0">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="name">Tên sản phẩm:</label>
                                        <input type="text" class="form-control ml-2" id="name" placeholder="Nhập tên sản phẩm" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="link">Link sản phẩm:</label>
                                        <input type="text" class="form-control ml-2" id="link" placeholder="Nhập link sản phẩm" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="fee">Phí vận chuyển:</label>
                                        <div class="input-group mb-1">
                                            <input type="text" class="form-control ml-2" id="fee" value="0" placeholder="Nhập phí vận chuyển" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="border-radius: 0;">đ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <div class="form-group col-md-3">
                                        <label for="qty">Số lượng:</label>
                                        <input type="number" class="form-control ml-2" id="qty" min="1" placeholder="Nhập số lượng" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="price">Giá nhập:</label>
                                        <div class="input-group mb-1">
                                            <input type="text" class="form-control ml-2" id="price" value="" placeholder="Nhập giá nhập sản phẩm" autocomplete="off">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="border-radius: 0;">đ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="retail">Giá bán lẻ:</label>
                                        <div class="input-group mb-1">
                                            <input type="text" class="form-control ml-2 col-sm-10" id="retail" placeholder="Nhập giá bán lẻ" autocomplete="off">
                                            <input type="text" class="form-control ml-2" id="percent" value="100">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="border-radius: 0;">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="profit">Profit:</label>
                                        <input type="text" class="form-control ml-2" id="profit" autocomplete="off" placeholder="Profit" readonly>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <div class="form-group col-md-3">
                                        <label for="select_cat">Danh mục:</label>
                                        <select class="select-cat form-control ml-2 col-sm-10" id="select_cat" data-placeholder="Chọn danh mục" style="width: 100%;"></select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="select_gender">Giới tính:</label>
                                        <div class="input-group mb-1">
                                            <select class="select-gender form-control ml-2 col-sm-10" id="select_gender" data-placeholder="Chọn giới tính" style="width: 100%;"></select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="select_material">Chất liệu:</label>
                                        <select class="select-material form-control ml-2 col-sm-10" id="select_material" data-placeholder="Chọn chất liệu sản phẩm" style="width: 100%;"></select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="select_origin">Xuất xứ:</label>
                                        <select class="select-origin form-control ml-2 col-sm-10" id="select_origin" data-placeholder="Chọn xuất xứ sản phẩm" style="width: 100%;"></select>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <div class="form-group col-md-3">
                                        <label for="select_colors">Màu sắc:</label>
                                        <div id="select_colors">
<!--                                            <input class="select_color_0 form-control" type="text" placeholder="Chọn màu sắc" autocomplete="off" spellcheck="false">-->
                                        </div>
                                        <button type="button" class="btn btn-info btn-flat mt-2" id="btn_add_color" title="Thêm màu">
                                            <i class="fa fa-plus-circle"></i> Thêm màu
                                        </button>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="select_sizes">Size:</label>
                                        <div id="select_sizes">
<!--                                            <input class="typeahead form-control" type="text" placeholder="Chọn size" autocomplete="off" spellcheck="false">-->
                                        </div>
                                        <button type="button" class="btn btn-info btn-flat mt-2" id="btn_add_size" title="Thêm size">
                                            <i class="fa fa-plus-circle"></i> Thêm size
                                        </button>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="image">Hình ảnh:</label>
                                        <div id="image"></div>
                                        <button type="button" class="btn btn-info btn-flat" id="btn_add_image" title="Thêm hình ảnh">
                                            <i class="fa fa-plus-circle"></i> Thêm hình ảnh
                                        </button>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="image">Hình ảnh theo màu sắc:</label>
                                        <div id="image_by_color">
<!--                                            <div class="input-group mb-1 image-by-color" style="margin-top: 10px;">-->
<!--                                                <img onerror="this.onerror=null;this.src='<?php //Common::image_error() ?>//'" width="40" src="" id="img_by_color_0" class="mr-1">
//                                                <input type="text" class="form-control" placeholder="Nhập link hình ảnh màu " onchange="onchange_image_link(0, 'byColor')" id="link_image_by_color_0" autocomplete="off">
//                                                <input type="hidden" class="form-control" id="image_type_by_color_0">
//                                            </div>-->
                                        </div>
                                    </div>
                                </div>
<!--                                <div class="row col-md-12">-->
<!--                                    <button class="btn btn-secondary btn-flat" id="create_variation">-->
<!--                                        Tạo biến thể-->
<!--                                    </button>-->
<!--                                </div>-->

                                        <!--                                <div class="table-responsive">-->
<!--                                    <table class="table table-info-product">-->
<!--                                        <tr>-->
<!--                                            <td width="150px">Mã sản phẩm</td>-->
<!--                                            <td>-->
<!--                                                <input type="text" class="form-control ml-2" id="display_product_id"-->
<!--                                                       value="" disabled>-->
<!--                                                <input type="hidden" class="form-control ml-2 col-sm-10" id="product_id"-->
<!--                                                       value="0">-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Tên sản phẩm</td>-->
<!--                                            <td>-->
<!--                                                <input type="text" class="form-control ml-2"-->
<!--                                                       id="name" placeholder="Nhập tên sản phẩm">-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Link sản phẩm</td>-->
<!--                                            <td>-->
<!--                                                <input type="text" class="form-control ml-2" id="link"-->
<!--                                                       placeholder="Nhập link sản phẩm">-->
<!---->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Phí vận chuyển</td>-->
<!--                                            <td>-->
<!--                                                <div class="input-group mb-1">-->
<!--                                                    <input type="text" class="form-control ml-2" id="fee" value="0"-->
<!--                                                           placeholder="Nhập phí vận chuyển">-->
<!--                                                    <div class="input-group-append">-->
<!--                                                        <span class="input-group-text"-->
<!--                                                              style="border-radius: 0;">đ</span>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Giá nhập</td>-->
<!--                                            <td>-->
<!--                                                <div class="input-group mb-1">-->
<!--                                                    <input type="text" class="form-control ml-2" id="price" value="" placeholder="Nhập giá nhập sản phẩm">-->
<!--                                                    <div class="input-group-append">-->
<!--                                                        <span class="input-group-text"-->
<!--                                                              style="border-radius: 0;">đ</span>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Giá bán lẻ</td>-->
<!--                                            <td>-->
<!--                                                <div class="input-group mb-1">-->
<!--                                                        <input type="text" class="form-control ml-2 col-sm-10" id="retail" placeholder="Nhập giá bán lẻ">-->
<!--                                                        <input type="text" class="form-control ml-2" id="percent" value="100">-->
<!--                                                        <div class="input-group-append">-->
<!--                                                            <span class="input-group-text" style="border-radius: 0;">%</span>-->
<!--                                                        </div>-->
<!--                                                </div>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr class="">-->
<!--                                            <td></td>-->
<!--                                            <td>-->
<!--                                                <input type="text" class="form-control ml-2" id="profit">-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Giới tính</td>-->
<!--                                            <td>-->
<!--                                                <select class="select-type form-control ml-2 col-sm-10" id="select_type" data-placeholder="Chọn giới tính"-->
<!--                                                      style="width: 100%;"></select>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Danh mục</td>-->
<!--                                            <td>-->
<!--                                                <select class="select-cat form-control ml-2 col-sm-10" id="select_cat" data-placeholder="Chọn danh mục"-->
<!--                                                      style="width: 100%;"></select>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Màu sắc</td>-->
<!--                                            <td>-->
<!--                                                <div id="select_colors">-->
<!--                                                    <input class="select_color form-control" type="text" placeholder="Chọn màu sắc">-->
<!--                                                </div>-->
<!--                                                <button type="button" class="btn btn-info btn-flat mt-2" id="btn_add_color" title="Thêm màu">-->
<!--                                                    <i class="fa fa-plus-circle"></i>-->
<!--                                                </button>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Size</td>-->
<!--                                            <td>-->
<!--                                                <div id="select_sizes">-->
<!--                                                    <input class="typeahead form-control" type="text" placeholder="Chọn size">-->
<!--                                                    <button type="button" class="btn btn-info btn-flat mt-2" id="btn_add_size" title="Thêm size">-->
<!--                                                        <i class="fa fa-plus-circle"></i>-->
<!--                                                    </button>-->
<!--                                                </div>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Hình ảnh</td>-->
<!--                                            <td>-->
<!--                                                --><?php //for ($i = 0; $i < 8; $i++) { ?>
<!--                                                    <div class="input-group mb-1">-->
<!--                                                        <input type="text" class="form-control"-->
<!--                                                               placeholder="Nhập link hình ảnh --><?php //echo $i+1; ?><!--"-->
<!--                                                               onchange="onchange_image_link(--><?php //echo $i; ?><!--)"id="link_image_<?php //echo $i; ?>">-->
<!--                                                        <input type="hidden" class="form-control"-->
<!--                                                               id="image_type_--><?php //echo $i; ?><!--">-->
<!--                                                        <div class="input-group-append">-->
<!--                                                            <form id="form_--><?php //echo $i; ?><!--" action="" method="post"-->
<!--                                                                  enctype="multipart/form-data">-->
<!--                                                                <input id="image_--><?php //echo $i; ?><!--" type="file"-->
<!--                                                                       accept="image/*" name="image" class="hidden"/>-->
<!--                                                                <button type="button" class="btn btn-info btn-flat"-->
<!--                                                                        id="btn_upload_--><?php //echo $i; ?><!--">-->
<!--                                                                    <span class="spinner-border spinner-border-sm hidden"-->
<!--                                                                          id="spinner_--><?php //echo $i; ?><!--"></span>-->
<!--                                                                    <i class="fa fa-upload"></i>-->
<!--                                                                </button>-->
<!--                                                            </form>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                --><?php //} ?>
<!--                                                <div class="input-group mb-1">-->
<!--                                                    --><?php //for ($i = 0; $i < 8; $i++) { ?>
<!--                                                        <img onerror="this.onerror=null;this.src='--><?php //Common::image_error() ?><!--'"width="80" id="img_<?php //echo $i; ?>" class="hidden mr-1">-->
<!--                                                    --><?php //} ?>
<!--                                                </div>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Số lượng</td>-->
<!--                                            <td>-->
<!--                                                <input type="number" class="form-control ml-2" id="qty" min="1" placeholder="Nhập số lượng">-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Chất liệu</td>-->
<!--                                            <td>-->
<!--                                                <select class="select-material form-control ml-2 col-sm-10" id="select_material" data-placeholder="Chọn chất liệu sản phẩm"-->
<!--                                                        style="width: 100%;"></select>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td>Xuất xứ</td>-->
<!--                                            <td>-->
<!--                                                <select class="select-origin form-control ml-2 col-sm-10" id="select_origin" data-placeholder="Chọn xuất xứ sản phẩm"-->
<!--                                                        style="width: 100%;"></select>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                        <tr>-->
<!--                                            <td colspan="2" style="text-align: center;">-->
<!--                                                <button class="btn btn-secondary btn-flat" id="create_variation">Tạo-->
<!--                                                    biến thể-->
<!--                                                </button>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                    </table>-->
<!--                                </div>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Danh sách biến thể sản phẩm</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" style="padding: 15px;">
                                    <table class="table table-list table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="hidden">id</th>
                                            <th width="150px">Hình ảnh</th>
                                            <th width="150px">Màu sắc</th>
                                            <th width="150px">Size</th>
                                            <th width="100px">Số lượng</th>
                                            <th width="150px">Giá nhập</th>
                                            <th width="150px">Giá bán</th>
                                            <th width="150px">%</th>
                                            <th width="150px">Profit</th>
                                            <th width="150px">SKU</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pad">
                            <div class="mb-3">
                                <textarea class="textarea" placeholder="Mô tả sản phẩm" id="description"
                                      style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="short_description">Mô tả ngắn</label>
                                <input type="text" class="form-control" placeholder="Mô tả ngắn" id="short_description" maxlength="255">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success form-control add-new-prod w80 btn-flat"
                        title="Thêm biến thể sản phẩm" disabled>
                    <i class="fa fa-plus-circle" aria-hidden="true"> </i>
                </button>
                <button type="button" class="btn btn-primary create-new btn-flat">Tạo mới</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <?php require_once('../../common/js.php'); ?>
    <script>
        let flagError = 0;
        let number_image_upload = 4;
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $(document).ready(function () {
            $('.textarea').summernote({
                placeholder: 'Mô tả sản phẩm...'
            });
            $('.product-create').click(function () {
                open_modal();
            });
            $('#create-product').on('hidden.bs.modal', function () {
                let table = $('#example').DataTable();
                table.ajax.reload(init_select2, false);
            });

            // custom_select2('#select_size', select_size);
            // custom_select2('#select_color', select_colors);
            custom_select2('#select_gender', select_types);
            custom_select2('#select_cat', select_cats);
            custom_select2('#select_material', select_material);
            custom_select2('#select_origin', select_origin);

            // $("#create_variation").click(function () {
            //     create_variation();
            // });

            $("#price").on('keyup keypress blur change', function () {
                onchange_price();
            });

            $("#retail").on('keyup keypress blur change', function () {
                onchange_retail();
            });

            $("#percent").on('keyup keypress blur change', function () {
                onchange_percent();
            });

            $("#fee").on('keyup keypress blur change', function () {
                onchange_fee();
                calculate_profit_in_list();
            });

            $("#qty").on('keyup keypress blur change', function () {
                console.log('keyup');
                let qty = $(this).val();
                onchange_qty(qty);
            });

            // $(".add-new-prod").click(function () {
            //     let no_row = $('.table-list tr:last').attr('class');
            //     let sku = $('.table-list tr:last').find('[id=sku_' + no_row + ']').val();
            //     sku = Number(sku) + 1;
            //     no_row++;
            //     generate_variations(no_row, 1, 0, '', '', sku);
            // });

            $(".create-new").click(function () {
                create_product();
            });
            // for(let i=0; i<4; i++) {
                btn_upload(0);
                onpaste_image_link(0);
                // btn_upload(0, 'byColor');
                onpaste_image_link(0, 'byColor');
            // }

            // load_size();
            $("#btn_add_color").click(function () {
                add_color();
                draw_table_variations();
            });
            $("#btn_add_size").click(function () {
                add_size();
                draw_table_variations();
            });
            $("#btn_add_image").click(function(){
                add_image();
            });
            // add_color();
            // add_size();
            // add_image();
            // draw_table_variations();
        });
        
        function get_max_id() {
            $.ajax({
                dataType: 'json',
                url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                data: {
                    method: 'get_max_id'
                },
                type: 'POST',
                success: function (response) {
                    console.log(response.max_id);
                    $("#display_product_id").val(response.max_id);
                    draw_table_variations();
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


        function reset_modal() {
            $("#display_product_id").val('');
            get_max_id();
            $("#product_id").val(0);
            $("#name").val('');
            $("#link").val('');
            $("#fee").val('');

            $("#select_gender").val(null).trigger('change');
            $("#select_cat").val(null).trigger('change');
            $("#select_material").val(null).trigger('change');
            $("#select_origin").val(null).trigger('change');
            if($("#price")) {
                $("#price").val('');
            }
            if($("#retail")){
                $("#retail").val('');
            }
            if($("#percent")) {
                $("#percent").val(100);
            }
            if($("#profit")) {
                $("#profit").val('');
            }
            if($("#qty")) {
                $("#qty").val('');
            }
            // $("#select_size").val(null).prop('disabled', '').trigger('change');
            // $("#select_color").val(null).prop('disabled', '').trigger('change');

            // for(let i=0; i<number_image_upload; i++) {
            //     $("[id=link_image_"+i+"]").val('');
            //     $("[id=image_type_"+i+"]").val('');
            //     $("[id=img_"+i+"]").prop("src",'');
            // }

            // $("#create_variation").prop('disabled', '');


            $("#image").html("");
            $("#image_by_color").html("");
            $(".add-new-prod").prop('disabled', true);
            // $(".table-info-product > tbody > tr").find('input').removeClass('is-invalid');
            // $('#description').summernote('code', null);
            $('#short_description').val('');
            $("#select_colors").html("");
            $("#select_sizes").html("");
        }


        function create_product() {
            if (!validate_product()) {
                return;
            }
            Swal.fire({
                title: 'Bạn có chắc chắn muốn tạo các sản phẩm này?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    show_loading();
                    let product = get_data_inform();
                    console.log(product);
                    $.ajax({
                        dataType: 'json',
                        url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                        data: {
                            method: 'add_new',
                            data: product
                        },
                        type: 'POST',
                        success: function (data) {
                            console.log(data);
                            Swal.fire(
                                'Thành công!',
                                'Các sản phẩm đã được tạo thành công.',
                                'success'
                            ).then((result) => {
                                if (result.value) {
                                    $('#create-product').modal('hide');
                                    reset_modal();
                                }
                            });
                            hide_loading();
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
            });
        }
        
        function get_data_inform() {
            let product_id = $("#product_id").val();
            let name = $("#name").val();
            let link = $("#link").val();
            let fee = $("#fee").val();
            // let price = $("#price").val();
            // let retail = $("#retail").val();
            // let profit = $("#profit").val();
            // let percent = $("#percent").val();
            let gender = $("#select_gender").val();
            let cat = $("#select_cat").val();
            let material = $("#select_material").val();
            let origin = $("#select_origin").val();
            let description = $("#description").summernote('code');
            let short_description = $('#short_description').val();

            let link_image = [];
            let image = $("#image").children(".image").length;
            for(let i=1; i<=image; i++) {
                let img = $("#link_image_"+i).val();
                let type = $("#image_type_"+i).val();
                if(type === "upload") {
                    img = img.replace('<?php echo Common::path_img()?>', '');
                }
                if(img !== "") {
                    let image1 = {};
                    image1["src"] = img;
                    image1["type"] = type;
                    link_image.push(image1);
                }
            }
            link_image = JSON.stringify(link_image);

            let product = {};
            product['product_id'] = product_id;
            product['name'] = name;
            product['link'] = link;
            product['image'] = link_image;
            product['fee'] = replaceComma(fee);
            // product['price'] = replaceComma(price);
            // product['retail'] = replaceComma(retail);
            // product['profit'] = replaceComma(profit);
            // product['percent'] = percent;
            product['type'] = gender;
            product['cat'] = cat;
            product['description'] = description;
            product['material'] = material;
            product['origin'] = origin;
            product['short_description'] = short_description;

            let color = get_color_length();
            let size = get_size_length();
            // validate variation
            let arr = [];
            for(let c=1; c<=color; c++) {
                for(let s=1; s<=size; s++) {
                    let _id = $(".table-list tbody tr #id_"+c+"_"+s).text();
                    let _image = $(".table-list tbody tr td #img_variation_"+c).attr("src");
                    let _color = $(".table-list tbody tr .color_"+c).text();
                    let _size  = $(".table-list tbody tr .size_"+c+"_"+s).text();
                    let _qty = $(".table-list tbody tr #qty_"+c+"_"+s).val();
                    let _price = $(".table-list tbody tr #price_"+c+"_"+s).val();
                    let _retail = $(".table-list tbody tr #retail_"+c+"_"+s).val();
                    let _percent = $(".table-list tbody tr #percent_"+c+"_"+s).val();
                    let _profit = $(".table-list tbody tr #profit_"+c+"_"+s).val();
                    let _sku = $(".table-list tbody tr .sku_"+c+"_"+s).text();

                    let variations = {};
                    variations['id'] = _id;
                    variations['image'] = _image;
                    variations['color'] = _color;
                    variations['size'] = _size;
                    variations['qty'] = _qty;
                    variations['price'] = replaceComma(_price);
                    variations['retail'] = replaceComma(_retail);
                    variations['percent'] = _percent;
                    variations['profit'] = replaceComma(_profit);
                    variations['sku'] = _sku;
                    arr.push(variations);
                }
            }
            product['variations'] = arr;
            return JSON.stringify(product);
        }

        // function create_variation() {
        //     if (!validate_product()) {
        //         return;
        //     }
        //     let size = $("#select_size").val();
        //     let color = $("#select_color").val();
        //     let qty = $("#qty").val();
        //     let variations = size.length * color.length;
        //     if (variations == 0) {
        //         Swal.fire({
        //             type: 'error',
        //             title: 'Đã xảy ra lỗi',
        //             text: 'Không có biến thể nào đươc tạo ',
        //         });
        //         return;
        //     }
        //     let msg = "Sẽ có " + variations + " biến thể sản phẩm được tạo ra!";
        //     Swal.fire({
        //         title: 'Bạn chắc chắn chứ?',
        //         text: msg,
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Đồng ý'
        //     }).then((result) => {
        //         if (result.value) {
        //             let count = 1;
        //             let product_id = $("#display_product_id").val();
        //             for (let i = 0; i < color.length; i++) {
        //                 for (let j = 0; j < size.length; j++) {
        //                     console.log(size[j]);
        //                     console.log(color[i]);
        //                     let sku = "";
        //                     if (count < 10) {
        //                         sku = product_id + "0" + count;
        //                     } else {
        //                         sku = product_id + count;
        //                     }
        //                     generate_variations(count, qty, 0, color[i], size[j], sku);
        //                     count++;
        //                     $('.add-new-prod').prop('disabled', '');
        //                 }
        //             }
        //             $("#create_variation").prop('disabled', true);
        //         }
        //     });
        //
        // }

        // function generate_variations(no, qty, id, color, size, sku) {
        //     $(".table-list tbody").append('<tr class="' + no + '">\n' +
        //         '                     <input type="hidden" class="form-control col-md-10" value="' + id + '" id="variation_id_' + no + '">\n' +
        //         '                    <td align="center">' + no + '</td>\n' +
        //         '                    <td align="center">' +
        //         '                     <input type="text" class="form-control col-md-10" value="' + sku + '" id="sku_' + no + '" disabled>\n' +
        //         '                    </td>\n' +
        //         '                    <td >\n' +
        //         '                       <select class="form-control ml-2 mr-2 col-sm-10" id="select_size_' + no + '" style="width: 100%"></select>' +
        //         '                    </td>\n' +
        //         '                    <td >\n' +
        //         '                       <select class="form-control ml-2 mr-2 col-sm-10" id="select_color_' + no + '"  style="width: 100%"></select>' +
        //         '                    </td>\n' +
        //         '                    <td >\n' +
        //         '                       <input type="number" class="form-control " id="qty_' + no + '" value="' + qty + '">\n' +
        //         '                    </td>\n' +
        //         '                    <td>\n' +
        //         '                       <button type="button" class="btn btn-danger btn-flat" id="delete_product_' + no + '" ' + (id != '' ? 'disabled' : '') + '>\n' +
        //         '                            <i class="fa fa-trash"></i>\n' +
        //         '                          </button>' +
        //         '                    </td>\n' +
        //         '                  </tr>');
        //     custom_select2("[id=select_size_" + no + "]", select_size);
        //     custom_select2("[id=select_color_" + no + "]", select_colors);
        //     $("[id=select_size_" + no + "]").val(size).trigger('change');
        //     $("[id=select_color_" + no + "]").val(color).trigger('change');
        //     delete_product(no);
        // }

        // function delete_product(no) {
        //     $("[id=delete_product_" + no + "]").click(function () {
        //         $(this).closest('tr').remove();
        //         reindex();
        //     });
        // }

        // function reindex() {
        //     let no = 0;
        //     $(".table-list > tbody > tr").each(function () {
        //         no++;
        //         let curr_class = $(this).attr('class');
        //         $(this).removeClass("" + curr_class + "");
        //         $(this).addClass("" + no + "");
        //         $(this).find("td:first").text(no);
        //     });
        //     if (no === 0) {
        //         $("#create_variation").prop('disabled', '');
        //     } else {
        //         $("#create_variation").prop('disabled', true);
        //     }
        // }

        function get_color_length() {
            return $("#select_colors").find(".twitter-typeahead").length;
        }

        function get_size_length() {
            return $("#select_sizes").find(".twitter-typeahead").length;
        }

        function draw_table_variations() {
            let color = get_color_length();
            let size = get_size_length();
            let qty = $("#qty").val();
            let price = $("#price").val();
            let retail = $("#retail").val();
            let percent = $("#percent").val();
            let profit = $("#profit").val();
            let product_id = $("#display_product_id").val();
            // $(".table-list tbody").html("");
            let width_img = 35;
            let d = 1;
            if(color > 0) {
                let table = "";
                // let c = 1;
                for (let c = 1; c <= color; c++) {
                    // let s = 1;
                    for (let s = 1; s <= size; s++) {
                        let _id = $(".table-list tbody tr #id_"+c+"_"+s).text();
                        if(typeof _id === 'undefined' || _id === '') {
                            _id = '';
                        }
                        let _img = $(".table-list tbody tr #img_variation_"+c).attr("src");
                        if(typeof _img === 'undefined' || _img === '') {
                            _img = $("#link_image_by_color_"+c).val();
                        }
                        let _color = $(".table-list tbody tr .color_"+c).text();
                        if(typeof _color === 'undefined' || _color === '') {
                            _color = 'Màu '+c;
                        }
                        let _size = $(".table-list tbody tr .size_"+c+"_"+s).text();
                        if(typeof _size == 'undefined' || _size === '') {
                            let size_select = $("#select_size_"+s).val();
                            if(typeof size_select == 'undefined' || size_select === '') {
                                _size = "Size " + s;
                            } else {
                                _size = size_select;
                            }
                        }
                        let _qty = $(".table-list tbody tr #qty_"+c+"_"+s).val();
                        if(typeof _qty === 'undefined' || _qty === '') {
                            _qty = $("#qty").val();
                        }
                        let _price = $(".table-list tbody tr #price_"+c+"_"+s).val();
                        if(typeof _price === 'undefined' || _price === '') {
                            _price = $("#price").val();
                        }
                        let _retail = $(".table-list tbody tr #retail_"+c+"_"+s).val();
                        if(typeof _retail === 'undefined' || _retail === '') {
                            _retail = $("#retail").val();
                        }
                        let _percent = $(".table-list tbody tr #percent_"+c+"_"+s).val();
                        if(typeof _percent === 'undefined' || _percent === '') {
                            _percent = $("#percent").val();
                        }
                        let _profit = $(".table-list tbody tr #profit_"+c+"_"+s).val();
                        if(typeof _profit === 'undefined' || _profit === '') {
                            _profit = $("#profit").val();
                        }

                        let sku = product_id + (d < 10 ? "0" + d : d);
                        table += "<tr class=\"" + d + "\">\n";
                        table += "<td class=\"hidden\" id='id_"+c+"_"+s+"'>"+_id+"</td>";
                        if(s === 1) {
                            table += "<td class='image_"+c+"' rowspan='"+size+"'>"+
                                "<img onerror=\"this.onerror=null;this.src='<?php Common::image_error() ?>'\" width=\""+(width_img*size)+"\" src=\""+_img+"\" id=\"img_variation_"+c+"\" class=\"mr-1\" style=\"max-width: 120px;\">" +
                                "</td>\n";
                            table += "<td class='color_"+c+"' rowspan='"+size+"'>"+_color+"</td>\n";
                        }
                        table += "<td class='size_"+c+"_"+s+"'>"+_size+"</td>\n" +
                            "<td class='qty_"+c+"_"+s+"'><input type='number' class='form-control' placeholder='Số lượng' value='"+_qty+"' id='qty_"+c+"_"+s+"'></td>\n" +
                            "<td class='price_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Giá nhâp' value='"+_price+"' id='price_"+c+"_"+s+"' onchange='onchange_price_in_list("+c+", "+s+")' onkeyup='onchange_price_in_list("+c+", "+s+")'></td>\n" +
                            "<td class='retail_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Giá bán' value='"+_retail+"' id='retail_"+c+"_"+s+"' onchange='onchange_retail_in_list("+c+", "+s+")' onkeyup='onchange_retail_in_list("+c+", "+s+")'></td>\n" +
                            "<td class='percent_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='%' value='"+_percent+"' id='percent_"+c+"_"+s+"' onchange='onchange_percent_in_list("+c+", "+s+")' onkeyup='onchange_percent_in_list("+c+", "+s+")'></td>\n" +
                            "<td class='profit_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Profit' value='"+_profit+"' id='profit_"+c+"_"+s+"' readonly></td>\n" +
                            "<td class='sku_"+c+"_"+s+"'>"+sku+"</td>\n" +
                            "</tr>";
                        $(".table-list tbody").append(table);
                        // s++;
                        d++;
                    }
                    // c++;
                }
                $(".table-list tbody").html(table);
            } else {
                let sku = product_id + (d < 10 ? "0" + d : d);
                $(".table-list tbody").html("<tr class=\"" + d + "\">" +
                    "<td class='image_"+c+"' rowspan='"+size+"'>"+
                    "<img onerror=\"this.onerror=null;this.src='<?php Common::image_error() ?>'\" width=\""+width_img+"\" src=\"\" id=\"img_variation_"+c+"\" class=\"mr-1\" style=\"max-width: 120px;\">" +
                    "</td>\n" +
                    "<td class='color_"+d+"' colspan='"+size+"'>Màu "+d+"</td>\n" +
                    "<td class='size_1_"+d+"'>Size "+d+"</td>\n" +
                    "<td class='qty_1_"+d+"'><input type='number' class='form-control' value='"+qty+"' id='qty_1_"+d+"'></td>\n" +
                    "<td class='price_1_"+d+"'><input type='text' class='form-control' value='"+price+"' id='price_1_"+d+"'></td>\n" +
                    "<td class='retail_1_"+d+"'><input type='text' class='form-control' value='"+retail+"' id='retail_1_"+d+"'></td>\n" +
                    "<td class='percent_1_"+d+"'><input type='text' class='form-control' value='"+percent+"' id='percent_1_"+d+"'></td>\n" +
                    "<td class='profit_1_"+d+"'><input type='text' class='form-control' value='"+profit+"' id='profit_1_"+d+"'></td>\n" +
                    "<td class='sku_1_"+d+"'>"+sku+"</td>\n" +
                    "<td><i class='fa fa-trash'></i></td>\n" +
                    "</tr>");
            }
        }


        function draw_table_variations_by_edit_product(color, size, variations) {
            let qty = $("#qty").val();
            let price = $("#price").val();
            let retail = $("#retail").val();
            let percent = $("#percent").val();
            let profit = $("#profit").val();
            let product_id = $("#display_product_id").val();

            let width_img = 35;
            let d = 1;
            if(color > 0) {
                let table = "";
                let i = 0;
                for (let c = 1; c <= color; c++) {
                    // let s = 1;
                    for (let s = 1; s <= size; s++) {
                        let _id = variations[i].id;
                        let _img = variations[i].image;
                        let _color = variations[i].color;
                        let _size = variations[i].size;
                        let _qty = variations[i].quantity;
                        let _price = variations[i].price;
                        let _retail = variations[i].retail;
                        let _percent = variations[i].percent;
                        let _profit = variations[i].profit;
                        let sku = variations[i].sku;
                        table += "<tr class=\"" + d + "\">\n";
                        table += "<td class=\"hidden\" id='id_"+c+"_"+s+"'>"+_id+"</td>";
                        if(s === 1) {
                            table += "<td class='image_"+c+"' rowspan='"+size+"'>"+
                                "<img onerror=\"this.onerror=null;this.src='<?php Common::image_error() ?>'\" width=\""+(width_img*size)+"\" src=\""+_img+"\" id=\"img_variation_"+c+"\" class=\"mr-1\" style=\"max-width: 120px;\">" +
                                "</td>\n";
                            table += "<td class='color_"+c+"' rowspan='"+size+"'>"+_color+"</td>\n";
                        }
                        table += "<td class='size_"+c+"_"+s+"'>"+_size+"</td>\n" +
                            "<td class='qty_"+c+"_"+s+"'><input type='number' class='form-control' placeholder='Số lượng' value='"+_qty+"' id='qty_"+c+"_"+s+"'></td>\n" +
                            "<td class='price_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Giá nhâp' value='"+_price+"' id='price_"+c+"_"+s+"' onchange='onchange_price_in_list("+c+", "+s+")' onkeyup='onchange_price_in_list("+c+", "+s+")'></td>\n" +
                            "<td class='retail_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Giá bán' value='"+_retail+"' id='retail_"+c+"_"+s+"' onchange='onchange_retail_in_list("+c+", "+s+")' onkeyup='onchange_retail_in_list("+c+", "+s+")'></td>\n" +
                            "<td class='percent_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='%' value='"+_percent+"' id='percent_"+c+"_"+s+"' onchange='onchange_percent_in_list("+c+", "+s+")' onkeyup='onchange_percent_in_list("+c+", "+s+")'></td>\n" +
                            "<td class='profit_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Profit' value='"+_profit+"' id='profit_"+c+"_"+s+"' readonly></td>\n" +
                            "<td class='sku_"+c+"_"+s+"'>"+sku+"</td>\n" +
                            "</tr>";
                        $(".table-list tbody").append(table);
                        // s++;
                        d++;
                        i++;
                    }
                    // c++;
                }
                $(".table-list tbody").html(table);
            } else {
                let sku = product_id + (d < 10 ? "0" + d : d);
                $(".table-list tbody").append("<tr class=\"" + d + "\">" +
                    "<td class='image_"+c+"' rowspan='"+size+"'>"+
                    "<img onerror=\"this.onerror=null;this.src='<?php Common::image_error() ?>'\" width=\""+width_img+"\" src=\"\" id=\"img_variation_"+c+"\" class=\"mr-1\" style=\"max-width: 120px;\">" +
                    "</td>\n" +
                    "<td class='color_"+d+"' colspan='"+size+"'>Màu "+d+"</td>\n" +
                    "<td class='size_1_"+d+"'>Size "+d+"</td>\n" +
                    "<td class='qty_1_"+d+"'><input type='number' class='form-control' value='"+qty+"' id='qty_1_"+d+"'></td>\n" +
                    "<td class='price_1_"+d+"'><input type='text' class='form-control' value='"+price+"' id='price_1_"+d+"'></td>\n" +
                    "<td class='retail_1_"+d+"'><input type='text' class='form-control' value='"+retail+"' id='retail_1_"+d+"'></td>\n" +
                    "<td class='percent_1_"+d+"'><input type='text' class='form-control' value='"+percent+"' id='percent_1_"+d+"'></td>\n" +
                    "<td class='profit_1_"+d+"'><input type='text' class='form-control' value='"+profit+"' id='profit_1_"+d+"'></td>\n" +
                    "<td class='sku_1_"+d+"'>"+sku+"</td>\n" +
                    "<td><i class='fa fa-trash'></i></td>\n" +
                    "</tr>");
            }
        }

        function btn_upload(no, type) {
            if(type === 'byColor') {
                $("[id=btn_upload_by_color_" + no + "]").click(function () {
                    // $(this).prop('disabled', true);
                    $("[id=image_by_color_" + no + "]").click();
                    upload_image(no, type);
                });
            } else {
                $("[id=btn_upload_" + no + "]").click(function () {
                    // $(this).prop('disabled', true);
                    $("[id=image_" + no + "]").click();
                    upload_image(no);
                });
            }
        }

        function upload_image(no, type) {
            if(type === 'byColor') {
                $("[id=image_by_color_" + no + "]").change(function () {
                    let file_data = $(this).prop('files')[0];
                    if(typeof file_data !== "undefined") {
                        let type = file_data.type;
                        let match = ["image/png", "image/jpg", "image/jpeg",];
                        if (type == match[0] || type == match[1] || type == match[2]) {
                            let form_data = new FormData();
                            form_data.append('file', file_data);
                            $("[id=spinner_by_color_" + no + "]").removeClass('hidden');
                            $.ajax({
                                url: "<?php Common::getPath() ?>src/controller/product/ProductController.php",
                                dataType: 'text',
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: form_data,
                                type: 'post',
                                success: function (res) {
                                    console.log(res);
                                    $("[id=btn_upload_by_color_" + no + "]").prop('disabled', '');
                                    $("[id=spinner_by_color_" + no + "]").addClass('hidden');
                                    if (res === 'file_too_large') {
                                        toastr.error('File có dung lượng quá lớn.');
                                        return;
                                    } else if (res === 'file_too_large') {
                                        toastr.error('Chỉ được upload file ảnh');
                                        return;
                                    }
                                    $("[id=img_by_color_" + no + "]").prop('src', res).removeClass('hidden');
                                    $("[id=link_image_by_color_" + no + "]").val(res);
                                    $("[id=image_type_by_color_" + no + "]").val('upload');

                                }
                            });
                        } else {
                            toastr.error('Chỉ được upload file ảnh');
                            return;
                        }
                    }
                });
            } else {
                $("[id=image_" + no + "]").change(function () {
                    let file_data = $(this).prop('files')[0];
                    if (typeof file_data !== "undefined") {
                        let type = file_data.type;
                        let match = ["image/png", "image/jpg", "image/jpeg",];
                        if (type == match[0] || type == match[1] || type == match[2]) {
                            let form_data = new FormData();
                            form_data.append('file', file_data);
                            $("[id=spinner_" + no + "]").removeClass('hidden');
                            $.ajax({
                                url: "<?php Common::getPath() ?>src/controller/product/ProductController.php",
                                dataType: 'text',
                                cache: false,
                                contentType: false,
                                processData: false,
                                data: form_data,
                                type: 'post',
                                success: function (res) {
                                    console.log(res);
                                    $("[id=btn_upload_" + no + "]").prop('disabled', '');
                                    $("[id=spinner_" + no + "]").addClass('hidden');
                                    if (res === 'file_too_large') {
                                        toastr.error('File có dung lượng quá lớn.');
                                        return;
                                    } else if (res === 'file_too_large') {
                                        toastr.error('Chỉ được upload file ảnh');
                                        return;
                                    }
                                    $("[id=img_" + no + "]").prop('src', res).removeClass('hidden');
                                    $("[id=link_image_" + no + "]").val(res);
                                    $("[id=image_type_" + no + "]").val('upload');

                                }
                            });
                        } else {
                            toastr.error('Chỉ được upload file ảnh');
                            return;
                        }
                    }
                });
            }
        }

        function onpaste_image_link(no, type) {
            if(type === 'byColor') {
                $("[id=link_image_by_color_" + no + "]").bind("paste", function (e) {
                    let pastedData = e.originalEvent.clipboardData.getData('text');
                    $("[id=img_by_color_" + no + "]").prop('src', pastedData).removeClass('hidden');
                    onchange_image_color(no, pastedData);
                });
            } else {
                $("[id=link_image_" + no + "]").bind("paste", function (e) {
                    let pastedData = e.originalEvent.clipboardData.getData('text');
                    $("[id=img_" + no + "]").prop('src', pastedData).removeClass('hidden');
                });
            }
        }

        function onchange_image_link(no, type) {
            if(type === 'byColor') {
                let val = $("[id=link_image_by_color_" + no + "]").val();
                if (val == '') {
                    val = 'https://via.placeholder.com/100';
                    if (no == 0) {
                        $("[id=img_by_color_" + no + "]").addClass('hidden');
                    }
                }
                $("[id=img_by_color_" + no + "]").prop('src', val);
                onchange_image_color(no, val);
            } else {
                let val = $("[id=link_image_" + no + "]").val();
                if (val == '') {
                    val = 'https://via.placeholder.com/100';
                    if (no == 0) {
                        $("[id=img_" + no + "]").addClass('hidden');
                    }
                }
                $("[id=img_" + no + "]").prop('src', val);
            }

        }

        // function validate_variations() {
        //
        //     let valid = true;
        //     $(".table-list > tbody > tr").each(function () {
        //         let no = $(this).attr('class');
        //         let size = $("[id=select_size_" + no + "]").val();
        //         if (size == null || size == '-1') {
        //             $("[id=select_size_" + no + "]").addClass('is-invalid').focus();
        //             toastr.error('Đã xảy ra lỗi');
        //             valid = false;
        //         } else {
        //             $("[id=select_size_" + no + "]").removeClass('is-invalid');
        //         }
        //         let color = $("[id=select_color_" + no + "]").val();
        //         if (color == null || color == '-1') {
        //             $("[id=select_color_" + no + "]").addClass('is-invalid').focus();
        //             toastr.error('Đã xảy ra lỗi');
        //             valid = false;
        //         } else {
        //             $("[id=select_color_" + no + "]").removeClass('is-invalid');
        //         }
        //
        //         let qty = $("[id=qty_" + no + "]").val();
        //         if (qty == '' || !regExp.test(qty) || qty < 0) {
        //             $("[id=qty_" + no + "]").addClass('is-invalid').focus();
        //             toastr.error('Đã xảy ra lỗi');
        //             valid = false;
        //         } else {
        //             $("[id=qty_" + no + "]").removeClass('is-invalid');
        //         }
        //     });
        //     return valid;
        // }

        function validate_product() {
            let is_valid = true;
            let product_id = $("#product_id").val();
            console.log(product_id);

            let name = $("#name").val();
            if (name === "") {
                // toastr.error("Tên sản phẩm không được để trống");
                $("#name").addClass("is-invalid");
                is_valid = false;
            } else {
                $("#name").removeClass("is-invalid");
            }

            let fee = $("#fee").val();
            if (!validate_number(fee)) {
                // toastr.error("Phí vận chuyển phải là số");
                $("#fee").addClass("is-invalid");
                is_valid = false;
            } else {
                $("#fee").removeClass("is-invalid").val(formatNumber(fee));
            }

            let qty = $("#qty").val();
            if (qty !== "" && !validate_number(qty)) {
                // toastr.error("Số lượng phải là số");
                $("#qty").addClass("is-invalid");
                is_valid = false;
            } else {
                $("#qty").removeClass("is-invalid");
            }

            let gender = $("#select_gender").val();
            if (gender === null || gender === "" || gender === "-1") {
                // toastr.error("Bạn chưa chọn giới tính");
                $("#select_gender").addClass("is-invalid");
                is_valid = false;
            } else {
                $("#select_gender").removeClass("is-invalid");
            }

            let cat = $("#select_cat").val();
            if (cat === null || cat === "" || cat === "-1") {
                // toastr.error("Bạn chưa chọn danh mục");
                $("#select_cat").addClass("is-invalid");
                is_valid = false;
            } else {
                $("#select_cat").removeClass("is-invalid");
            }

            let price_import = $("#price").val();
            if (price_import !== '' && !validate_number(price_import)) {
                // toastr.error("Giá nhập phải là số");
                $("#price").addClass("is-invalid");
                is_valid = false;
            } else {
                $("#price").removeClass("is-invalid").val(formatNumber(price_import));
            }

            let price_retail = $("#retail").val();
            if (price_retail !== '' && !validate_number(price_retail)) {
                // toastr.error("Giá bán lẻ phải là số");
                $("#retail").addClass("is-invalid");
                is_valid = false;
            } else {
                $("#retail").removeClass("is-invalid").val(formatNumber(price_retail));
            }

            let percent = $("#percent").val();
            if (!validate_number(percent)) {
                $("#percent").addClass("is-invalid");
                is_valid = false;
            } else if(percent < 0) {
                $("#percent").addClass("is-invalid");
                is_valid = false;
            } else {
                $("#percent").removeClass("is-invalid").val(formatNumber(percent));
            }

            let color = get_color_length();
            for(let i=1; i<=color; i++) {
                let c = $("#select_color_"+i).val();
                if(c === '') {
                    $("#select_color_"+i).addClass("is-invalid");
                    is_valid = false;
                } else {
                    $("#select_color_"+i).removeClass("is-invalid");
                }
            }

            let size = get_size_length();
            for(let i=1; i<=size; i++) {
                let c = $("#select_size_"+i).val();
                if(c === '') {
                    $("#select_size_"+i).addClass("is-invalid");
                    is_valid = false;
                } else {
                    $("#select_size_"+i).removeClass("is-invalid");
                }
            }

            let image = $("#image").children(".image").length;
            for(let i=1; i<=image; i++) {
                let c = $("#link_image_"+i).val();
                if(c === '') {
                    $("#link_image_"+i).addClass("is-invalid");
                    is_valid = false;
                } else {
                    $("#link_image_"+i).removeClass("is-invalid");
                }
            }

            let image_by_color = $("#image_by_color").children(".image-by-color").length;
            for(let i=1; i<=image_by_color; i++) {
                let c = $("#link_image_by_color_"+i).val();
                if(c === '') {
                    $("#link_image_by_color_"+i).addClass("is-invalid");
                    is_valid = false;
                } else {
                    $("#link_image_by_color_"+i).removeClass("is-invalid");
                }
            }

            // validate variation
            for(let c=1; c<=color; c++) {
                for(let s=1; s<=size; s++) {
                    let _qty = $(".table-list tbody tr #qty_"+c+"_"+s).val();
                    if(typeof _qty === 'undefined' || _qty === '') {
                        $(".table-list tbody tr #qty_"+c+"_"+s).addClass("is-invalid");
                        is_valid = false;
                    } else {
                        $(".table-list tbody tr #qty_"+c+"_"+s).removeClass("is-invalid");
                    }
                    let _price = $(".table-list tbody tr #price_"+c+"_"+s).val();
                    if(typeof _price === 'undefined' || _price === '') {
                        $(".table-list tbody tr #price_"+c+"_"+s).addClass("is-invalid");
                        is_valid = false;
                    } else {
                        $(".table-list tbody tr #price_"+c+"_"+s).removeClass("is-invalid");
                    }
                    let _retail = $(".table-list tbody tr #retail_"+c+"_"+s).val();
                    if(typeof _retail === 'undefined' || _retail === '') {
                        $(".table-list tbody tr #retail_"+c+"_"+s).addClass("is-invalid");
                        is_valid = false;
                    } else {
                        $(".table-list tbody tr #retail_"+c+"_"+s).removeClass("is-invalid");
                    }
                }
            }

            if(!is_valid) {
                toastr.error("Đã xảy ra lỗi");
            }
            return is_valid;
        }

        function open_modal() {
            reset_modal();
            load_size();
            load_color();
            c = 1; // color
            s = 1; // size
            image = 1; // image

            // add_color();
            // add_size();
            add_image();
            $('#create-product').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }

        let c = 1;
        function add_color(value) {
            // $("#btn_add_color").click(function () {
            $("#select_colors").append("<div id='w_select_color_"+c+"'><input id='select_color_"+c+"' class=\"select_color_"+c+" form-control\" type=\"text\" placeholder=\"Chọn màu "+c+"\" autocomplete=\"off\" spellcheck=\"false\">" +
                "<button class='btn btn-secondary btn-flat' id='delete_color_"+c+"'><i class='fa fa-trash'></i></button></div>");
            $('.select_color_'+c).typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: 'color',
                source: substringMatcher(colors)
            });
            if(value) {
                $('.select_color_'+c).typeahead('val', value);
            }
            onchange_select_color(c);
            add_image_by_color(c);
            delete_color(c);
            // draw_table_variations();
            c++;
            // });
        }
        function delete_color(color) {
            $("#delete_color_"+color).on('click', function(){
                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xoá size này?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.value) {
                        let arr_color = [];
                        let color_length = get_color_length();
                        for(let i=1; i<=color_length; i++) {
                            let color = $("#select_color_"+i).val();
                            arr_color.push(color);
                        }
                        arr_color.splice(color-1,1);
                        $(this).parent("#w_select_color_"+color).remove();
                        $("#select_colors").html("");
                        c = 1;
                        for(let i=0; i<arr_color.length; i++) {
                            add_color(arr_color[i]);
                            $("#select_color_"+(i+1)).trigger('change');
                        }
                        draw_table_variations();
                    }
                });
            });
        }

        function add_image_by_color(c, src) {
            if(!src) {
                src = '';
            }
            $("#image_by_color").append("<div class=\"input-group mb-1 image-by-color\" style=\"margin-top: 10px;\">\n" +
                "<img onerror=\"this.onerror=null;this.src='<?php Common::image_error() ?>'\" width=\"40\" src=\""+src+"\" id=\"img_by_color_"+c+"\" class=\"mr-1\">\n" +
                "<input type=\"text\" class=\"form-control\" placeholder=\"Nhập link hình ảnh màu "+c+"\" value=\""+src+"\" onchange=\"onchange_image_link("+c+", 'byColor')\" id=\"link_image_by_color_"+c+"\" autocomplete=\"off\">\n" +
                "<input type=\"hidden\" class=\"form-control\" id=\"image_type_by_color_"+c+"\">\n" +
                "</div>");
            onpaste_image_link(c, 'byColor');
        }

        function onchange_select_color(c) {
            $(".select_color_"+c).on('keyup keypress blur change', function(){
                let value = $(this).val();
                $("#link_image_by_color_"+c).attr("placeholder","Nhập link hình ảnh màu "+value);
                onchange_color(c, value);
            });
        }

        let s = 1;
        function add_size(value) {
            $("#select_sizes").append("<div id='w_select_size_"+s+"'><input id='select_size_"+s+"' class=\"select_size_"+s+" form-control\" type=\"text\" placeholder=\"Chọn size "+s+"\" autocomplete=\"off\" spellcheck=\"false\">" +
                "<button class='btn btn-secondary btn-flat' id='delete_size_"+s+"'><i class='fa fa-trash'></i></button></div>");
            $('.select_size_'+s).typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1
                },
                {
                    name: 'size',
                    source: substringMatcher(size)
                });
            if(value) {
                $('.select_size_'+s).typeahead('val', value);
            }
            onchange_select_size(s);
            delete_size(s);
            // draw_table_variations();
            s++;
        };

        function delete_size(size) {
            $("#delete_size_"+size).on('click', function(){
                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xoá size này?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.value) {
                        let arr_size = [];
                        let size_length = get_size_length();
                        for(let i=1; i<=size_length; i++) {
                            let size = $("#select_size_"+i).val();
                            arr_size.push(size);
                        }
                        arr_size.splice(size-1,1);
                        $(this).parent("#w_select_size_"+size).remove();
                        $("#select_sizes").html("");
                        s = 1;
                        for(let i=0; i<arr_size.length; i++) {
                            add_size(arr_size[i]);
                            $("#select_size_"+(i+1)).trigger('change');
                        }
                        draw_table_variations();
                    }
                });
            });
        }


        function onchange_select_size(s) {
            $(".select_size_"+s).on('keyup keypress blur change', function(){
                let value = $(this).val();
                onchange_size(s, value);
            });
        }

        let idx_image = 1;
        function add_image(src, type) {
            if(!src) {
                src = '';
            }
            if(!type) {
                type = '';
            }
            $("#image").append("<div class=\"input-group mb-1 image\" style=\"margin-top: 10px;\">\n" +
                "<img onerror=\"this.onerror=null;this.src='<?php Common::image_error() ?>'\" width=\"40\" src=\""+src+"\" id=\"img_"+idx_image+"\" class=\"mr-1\">\n" +
                "<input type=\"text\" class=\"form-control\" placeholder=\"Nhập link hình ảnh "+idx_image+"\" value=\""+src+"\" onchange=\"onchange_image_link("+idx_image+")\" id=\"link_image_"+idx_image+"\" autocomplete=\"off\">\n" +
                "<input type=\"hidden\" class=\"form-control\" id=\"image_type_"+idx_image+"\" value=\""+type+"\">\n" +
                "<div class=\"input-group-append\">\n" +
                "<form id=\"form_0\" action=\"\" method=\"post\" enctype=\"multipart/form-data\">\n" +
                "<input id=\"image_"+idx_image+"\" type=\"file\" accept=\"image/*\" name=\"image\" class=\"hidden\"/>\n" +
                "<button type=\"button\" class=\"btn btn-info btn-flat\" id=\"btn_upload_"+idx_image+"\">\n" +
                "<span class=\"spinner-border spinner-border-sm hidden\" id=\"spinner_"+idx_image+"\"></span>\n" +
                "<i class=\"fa fa-upload\"></i>\n" +
                "</button>\n" +
                "</form>\n" +
                "</div>\n" +
                "</div>");
            btn_upload(idx_image);
            onpaste_image_link(idx_image);
            idx_image++;
        }


        let size = [];
        function load_size() {
            $.ajax({
                dataType: 'json',
                url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                data: {
                    method: 'load_size'
                },
                type: 'POST',
                success: function (response) {
                    console.log(response);
                    size = response;
                    let substringMatcher = function (strs) {
                        return function findMatches(q, cb) {
                            let matches = [];
                            let substrRegex = new RegExp(q, 'i');
                            $.each(strs, function (i, str) {
                                if (substrRegex.test(str)) {
                                    matches.push(str);
                                }
                            });
                            cb(matches);
                        };
                    };
                    $('#select_sizes .typeahead').typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                        },
                        {
                            name: 'size',
                            source: substringMatcher(response)
                        });
                    let product_id = $("#product_id").val();
                    if(product_id === '0') {
                        // add new product
                        add_size();
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
                }
            });
        }
        let colors = [];
        function load_color() {
            $.ajax({
                dataType: 'json',
                url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                data: {
                    method: 'load_color'
                },
                type: 'POST',
                success: function (response) {
                    colors = response;
                    console.log(response);
                    $('.select_color_0').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        name: 'size',
                        source: substringMatcher(response)
                    });
                    let product_id = $("#product_id").val();
                    if(product_id === '0') {
                        add_color();
                    }
                    onchange_select_color(0);
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

        function substringMatcher (strs) {
            return function findMatches(q, cb) {
                let matches = [];
                let substrRegex = new RegExp(q, 'i');
                $.each(strs, function (i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                });
                cb(matches);
            };
        };

        function onchange_image_color(no, value) {
            $(".table-list > tbody > tr").each(function () {
                $("[id=img_variation_" + no + "]").attr("src", value);
            });
        }

        function onchange_size(no, value) {
            let color = get_color_length();
            for(let i=1; i<=color; i++) {
                $("[class=size_"+ i + "_" + no + "]").text(value);
            }
        }

        function onchange_color(no, value) {
            $(".table-list > tbody > tr").each(function () {
                $("[class=color_" + no + "]").text(value);
            });
        }

        function onchange_qty(qty) {
            let color = get_color_length();
            let size = get_size_length();
            for(let i=1; i<=color; i++) {
                for(let j=1; j<=size; j++) {
                    $(".table-list tbody tr td #qty_"+i+"_" + j).val(qty);
                }
            }
        }

        function onchange_price() {
            let price = $("#price").val();
            price = format_money(price);
            if (isNaN(price)) {
                $("#price").addClass("is-invalid");
            } else {
                $("#price").removeClass("is-invalid").val(formatNumber(price));
                let percent = $("#percent").val();
                let fee = $("#fee").val();
                fee = replaceComma(fee);
                let retail = Math.round((Number(price)+Number(fee)) * Number(percent) / 100) + Number(price) + Number(fee);
                $("#retail").val(retail > 0 ? formatNumber(retail) : '');
                calc_profit();
                calculate_all_price_in_list();
            }
        }

        function calculate_all_price_in_list() {
            let price = $("#price").val();
            let retail = $("#retail").val();
            let percent = $("#percent").val();
            let profit = $("#profit").val();
            let color = get_color_length();
            let size = get_size_length();
            for(let i=1; i<=color; i++) {
                for(let j=1; j<=size; j++) {
                    $("[id=price_" + i +"_" + j + "]").val(price);
                    $("[id=retail_" + i +"_" + j +"]").val(retail);
                    $("[id=percent_" + i +"_" + j + "]").val(percent);
                    $("[id=profit_" + i +"_" + j + "]").val(profit);
                }
            }
        }

        function onchange_retail() {
            let val = $("#retail").val();
            val = format_money(val);
            if (isNaN(val)) {
                $("#retail").addClass("is-invalid");
            } else {
                $("#retail").removeClass("is-invalid");
                $("#retail").val(formatNumber(val));
                calc_percent();
                calc_profit();
            }
        }

        function onchange_percent() {
            let val = $("#percent").val();
            if (isNaN(val)) {
                $("#percent").addClass("is-invalid");
                $("#percent").focus();
            } else {
                $("#percent").removeClass("is-invalid");
                // calc_profit(rowIndex);

                let price = $("#price").val();
                price = replaceComma(price);
                price = Number(price);
                let fee = Number(replaceComma($("#fee").val()));
                let retail = Math.round((price + fee) * val / 100) + price + fee;
                $("#retail").val(formatNumber(retail));
                calc_profit();
            }
        }

        function onchange_fee() {
            let val = $("#fee").val();
            val = format_money(val);
            if (isNaN(val)) {
                $("#fee").addClass("is-invalid");
            } else {
                $("#fee").removeClass("is-invalid");
                $("#fee").val(formatNumber(val));
                // let fee = Number(val);
                // $("#fee").val(formatNumber(fee));
                calc_profit();
            }
        }

        function calc_percent() {
            let retail = $("[id=retail]").val();
            retail = replaceComma(retail);
            let price = $("[id=price]").val();
            price = replaceComma(price);
            let fee = $("[id=fee]").val();
            fee = replaceComma(fee);
            if (isNaN(retail)) {
                $("[id=retail]").addClass("is-invalid");
                $("[id=retail]").focus();
            } else if (isNaN(price)) {
                $("[id=price]").addClass("is-invalid");
                $("[id=price]").focus();
            } else if (isNaN(fee)) {
                $("[id=fee]").addClass("is-invalid");
                $("[id=fee]").focus();
            } else {
                $("[id=retail]").removeClass("is-invalid");
                $("[id=price]").removeClass("is-invalid");
                $("[id=fee]").removeClass("is-invalid");
                retail = Number(retail);
                price = Number(price);
                fee = Number(fee);
                let percent = (retail - price - fee) * 100 / (price + fee);
                percent = Math.round(percent);
                $("[id=percent]").val(percent);
            }
        }

        function calc_profit() {
            let retail = $("[id=retail]").val();
            retail = replaceComma(retail);
            let price = $("[id=price]").val();
            price = replaceComma(price);
            let fee = $("[id=fee]").val();
            fee = replaceComma(fee);
            let profit = Number(retail) - Number(price) - Number(fee);
            $("[id=profit]").val(profit > 0 ? formatNumber(profit) : '');

        }


        function onchange_price_in_list(c, s) {
            let val = $(".table-list tbody tr td #price_"+c+"_"+s).val();
            val = format_money(val);
            if (isNaN(val)) {
                $(".table-list tbody tr td #price_"+c+"_"+s).addClass("is-invalid");
            } else {
                $(".table-list tbody tr td #price_"+c+"_"+s).removeClass("is-invalid").val(val > 0 ? formatNumber(val) : '');
                let price = Number(val);
                let percent = $(".table-list tbody tr td #percent_"+c+"_"+s).val();
                percent = Number(percent);
                let fee = $("#fee").val();
                fee = replaceComma(fee);
                fee = Number(fee);
                let retail = Math.round((price+fee) * percent / 100) + price + fee;
                $(".table-list tbody tr td #retail_"+c+"_"+s).val(retail > 0 ? formatNumber(retail) : '');
                calc_profit_in_list(c, s);
            }
        }

        function onchange_retail_in_list(c, s) {
            let val = $(".table-list tbody tr td #retail_"+c+"_"+s).val();
            val = format_money(val);
            if (isNaN(val)) {
                $(".table-list tbody tr td #retail_"+c+"_"+s).addClass("is-invalid");
            } else {
                $(".table-list tbody tr td #retail_"+c+"_"+s).removeClass("is-invalid").val(formatNumber(val));
                calc_percent_in_list(c, s);
                calc_profit_in_list(c, s);
            }
        }

        function onchange_percent_in_list(c, s) {
            let val = $(".table-list tbody tr td #percent_"+c+"_"+s).val();
            if (isNaN(val)) {
                $(".table-list tbody tr td #percent_"+c+"_"+s).addClass("is-invalid").focus();
            } else {
                $(".table-list tbody tr td #percent_"+c+"_"+s).removeClass("is-invalid");

                let price = $(".table-list tbody tr td #price_"+c+"_"+s).val();
                price = replaceComma(price);
                price = Number(price);
                let fee = Number(replaceComma($("#fee").val()));
                let retail = Math.round((price + fee) * val / 100) + price + fee;
                $(".table-list tbody tr td #retail_"+c+"_"+s).val(formatNumber(retail));
                calc_profit_in_list(c, s);
            }
        }

        function calc_profit_in_list(c, s) {
            let retail = $(".table-list tbody tr td #retail_"+c+"_"+s).val();
            retail = replaceComma(retail);
            let price = $(".table-list tbody tr td #price_"+c+"_"+s).val();
            price = replaceComma(price);
            let fee = $("#fee").val();
            fee = replaceComma(fee);
            let profit = Number(retail) - Number(price) - Number(fee);
            $(".table-list tbody tr td #profit_"+c+"_"+s).val(formatNumber(profit));
        }

        function calculate_profit_in_list() {
            let fee = $("#fee").val();
            fee = replaceComma(fee);
            let color = get_color_length();
            let size = get_size_length();
            for(let c=1; c<=color; c++) {
                for(let s=1; s<=size; s++) {
                    let retail = $(".table-list tbody tr td #retail_"+c+"_"+s).val();
                    retail = replaceComma(retail);
                    let price = $(".table-list tbody tr td #price_"+c+"_"+s).val();
                    price = replaceComma(price);
                    let profit = Number(retail) - Number(price) - Number(fee);
                    $(".table-list tbody tr td #profit_"+c+"_" + s).val(formatNumber(profit));
                }
            }
        }

        function calc_percent_in_list(c, s) {
            let retail = $(".table-list tbody tr td #retail_"+c+"_"+s).val();
            retail = replaceComma(retail);
            let price = $(".table-list tbody tr td #price_"+c+"_"+s).val();
            price = replaceComma(price);
            let fee = $("#fee").val();
            fee = replaceComma(fee);
            if (isNaN(retail)) {
                $(".table-list tbody tr td #retail_"+c+"_"+s).addClass("is-invalid").focus();
            } else if (isNaN(price)) {
                $(".table-list tbody tr td #price_"+c+"_"+s).addClass("is-invalid").focus();
            } else if (isNaN(fee)) {
                $("#fee").addClass("is-invalid").focus();
            } else {
                $(".table-list tbody tr td #retail_"+c+"_"+s).removeClass("is-invalid");
                $(".table-list tbody tr td #price_"+c+"_"+s).removeClass("is-invalid");
                $("#fee").removeClass("is-invalid");
                retail = Number(retail);
                price = Number(price);
                fee = Number(fee);
                let percent = (retail - price - fee) * 100 / (price + fee);
                percent = Math.round(percent);
                $(".table-list tbody tr td #percent_"+c+"_"+s).val(percent);
            }
        }



        // function format_money(val) {
        //     if(val.indexOf('k') > -1 || val.indexOf('K') > -1) {
        //         val = val.replace('k','000');
        //         val = val.replace('K','000');
        //     } else if(val.indexOf('m') > -1 || val.indexOf('M') > -1) {
        //         val = val.replace('m','000000');
        //         val = val.replace('M','000000');
        //     } else {
        //         val = replaceComma(val);
        //     }
        //     return val;
        // }

        function show_loading() {
            $("#create-product .overlay").removeClass("hidden");
        }

        function hide_loading() {
            $("#create-product .overlay").addClass("hidden");
        }

        function onerror_img() {
            return '';
        }


    </script>
    <?php require_once('attribute.php'); ?>

