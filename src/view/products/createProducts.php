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
                    <div class="col-md-4">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Thông tin sản phẩm</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-info-product">
                                        <tr>
                                            <td width="150px">Mã sản phẩm</td>
                                            <td>
                                                <input type="text" class="form-control ml-2" id="display_product_id"
                                                       value="" disabled>
                                                <input type="hidden" class="form-control ml-2 col-sm-10" id="product_id"
                                                       value="0">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tên sản phẩm</td>
                                            <td>
                                                <input type="text" class="form-control ml-2"
                                                       id="name" placeholder="Nhập tên sản phẩm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Link sản phẩm</td>
                                            <td>
                                                <input type="text" class="form-control ml-2" id="link"
                                                       placeholder="Nhập link sản phẩm">

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Hình ảnh</td>
                                            <td>
                                                <?php for($i=0; $i<4; $i++) {?>
                                                    <div class="input-group mb-1">
                                                        <input type="text" class="form-control" placeholder="Nhập link hình ảnh" onchange="onchange_image_link(<?php echo $i; ?>)" id="link_image_<?php echo $i; ?>">
                                                        <input type="hidden" class="form-control" id="image_type_<?php echo $i; ?>">
                                                        <div class="input-group-append">
                                                            <form id="form_<?php echo $i; ?>" action="" method="post" enctype="multipart/form-data">
                                                                <input id="image_<?php echo $i; ?>" type="file" accept="image/*" name="image" class="hidden"/>
                                                                <button type="button" class="btn btn-info btn-flat" id="btn_upload_<?php echo $i; ?>">
                                                                    <span class="spinner-border spinner-border-sm hidden" id="spinner_<?php echo $i; ?>"></span>
                                                                    <i class="fa fa-upload"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="input-group mb-1">
                                                    <?php for($i=0; $i<4; $i++) {?>
                                                        <img onerror="this.onerror=null;this.src='<?php Common::image_error() ?>'" width="80" id="img_<?php echo $i; ?>" class="hidden mr-1">
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phí vận chuyển</td>
                                            <td>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control ml-2" id="fee" value="0"
                                                           placeholder="Nhập phí vận chuyển">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"
                                                              style="border-radius: 0;">đ</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Giá nhập</td>
                                            <td>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control ml-2" id="price" value="">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"
                                                              style="border-radius: 0;">đ</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Giá bán lẻ</td>
                                            <td>
                                                <div class="input-group mb-1">
                                                        <input type="text" class="form-control ml-2 col-sm-10" id="retail">
                                                        <input type="text" class="form-control ml-2" id="percent" value="100">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" style="border-radius: 0;">%</span>
                                                        </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td></td>
                                            <td>
                                                <input type="text" class="form-control ml-2" id="profit">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Giới tính</td>
                                            <td>
                                                <select class="select-type form-control ml-2 col-sm-10" id="select_type"
                                                      style="width: 100%;"></select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Danh mục</td>
                                            <td>
                                                <select class="select-cat form-control ml-2 col-sm-10" id="select_cat"
                                                      style="width: 100%;"></select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Size</td>
                                            <td>
                                                <div class="input-group mb-1">
                                                    <select class="select-size form-control ml-2 mr-2" id="select_size" multiple="multiple"></select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-info btn-flat" id="add_size" title="Thêm size">
                                                            <i class="fa fa-plus-circle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Màu sắc</td>
                                            <td>
                                                <div class="input-group mb-1">
                                                    <select class="select-color form-control ml-2 mr-2" id="select_color" multiple="multiple"></select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-info btn-flat" id="add_color" title="Thêm màu sắc">
                                                            <i class="fa fa-plus-circle"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Số lượng</td>
                                            <td>
                                                <input type="number" class="form-control ml-2" id="qty" min="1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: center;">
                                                <button class="btn btn-secondary btn-flat" id="create_variation">Tạo
                                                    biến thể
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Danh sách biến thể sản phẩm</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-list">
                                        <thead>
                                        <tr>
                                            <th width="50">STT</th>
                                            <th width="150px">SKU</th>
                                            <th width="150px">Size</th>
                                            <th width="150px">Màu sắc</th>
                                            <th width="100px">SL</th>
                                            <th width="150px">*</th>
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
                table.ajax.reload();
            });

            custom_select2('#select_size', select_size);
            custom_select2('#select_color', select_colors);
            custom_select2('#select_type', select_types);
            custom_select2('#select_cat', select_cats);

            $("#create_variation").click(function () {
                create_variation();
            });

            $("#price").change(function () {
                onchange_price();
            });

            $("#retail").change(function () {
                onchange_retail();
            });

            $("#percent").change(function () {
                onchange_percent();
            });

            $("#fee").change(function () {
                onchange_fee();
            });

            $(".add-new-prod").click(function () {
                let no_row = $('.table-list tr:last').attr('class');
                let sku = $('.table-list tr:last').find('[id=sku_' + no_row + ']').val();
                sku = Number(sku) + 1;
                no_row++;
                generate_variations(no_row, 1, 0, '', '', sku);
            });

            $(".create-new").click(function () {
                create_product();
            });
            for(let i=0; i<4; i++) {
                btn_upload(i);
                onpaste_image_link(i);
            }
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

        function create_product() {
            if (!validate_product()) {
                return;
            }
            if (!validate_variations()) {
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

        function reset_modal() {
            $("#display_product_id").val('');
            get_max_id();
            $("#product_id").val(0);
            $("#name").val('');
            $("#link").val('');
            for(let i=0; i<number_image_upload; i++) {
                $("[id=link_image_"+i+"]").val('');
                $("[id=image_type_"+i+"]").val('');
                $("[id=img_"+i+"]").prop("src",'').addClass("hidden");
            }
            $("#img_0").val('').addClass('hidden');
            $("#fee").val('');
            $("#select_type").val(null).trigger('change');
            $("#select_cat").val(null).trigger('change');
            $("#price").val('');
            $("#retail").val('');
            $("#percent").val(100);
            $("#profit").val('');
            $("#select_size").val(null).prop('disabled', '').trigger('change');
            $("#select_color").val(null).prop('disabled', '').trigger('change');
            $("#qty").val('').prop('disabled', '');
            $("#create_variation").prop('disabled', '');
            $(".add-new-prod").prop('disabled', true);
            $(".table-info-product > tbody > tr").find('input').removeClass('is-invalid');
            $(".table-list > tbody").html('');
            $('#description').summernote('code', '');
        }

        function get_data_inform() {
            let product_id = $("#product_id").val();
            let name = $("#name").val();
            let link = $("#link").val();
            let image = [];
            for(let i=0; i<number_image_upload; i++) {
                let img = $("[id=link_image_"+i+"]").val();
                let type = $("[id=image_type_"+i+"]").val();
                if(type === "upload") {
                    img = img.replace('<?php echo Common::path_img()?>', '');
                }
                if(img !== "") {
                    let image1 = {};
                    image1["src"] = img;
                    image1["type"] = type;
                    image.push(image1);
                }
            }
            image = JSON.stringify(image);
            let fee = $("#fee").val();
            let type = $("#select_type").val();
            let cat = $("#select_cat").val();
            let price = $("#price").val();
            let retail = $("#retail").val();
            let percent = $("#percent").val();
            let profit = $("#profit").val();
            let description = $("#description").summernote('code');

            let product = {};
            product['product_id'] = product_id;
            product['name'] = name;
            product['link'] = link;
            product['image'] = image;
            product['fee'] = replaceComma(fee);
            product['type'] = type;
            product['cat'] = cat;
            product['price'] = replaceComma(price);
            product['retail'] = replaceComma(retail);
            product['profit'] = replaceComma(profit);
            product['percent'] = percent;
            product['description'] = description;

            let arr = [];
            $(".table-list > tbody > tr").each(function () {
                let no = $(this).attr('class');
                let id = $("[id=variation_id_" + no + "]").val();
                let sku = $("[id=sku_" + no + "]").val();
                // let image = $("[id=link_image_" + no + "]").val();
                // let image_type = $("[id=image_type_" + no + "]").val();
                let size = $("[id=select_size_" + no + "]").val();
                let color = $("[id=select_color_" + no + "]").val();
                let qty = $("[id=qty_" + no + "]").val();

                let variations = {};
                variations['id'] = id;
                variations['sku'] = sku;
                // variations['image'] = image;
                // variations['image_type'] = image_type;
                variations['size'] = size;
                variations['color'] = color;
                variations['qty'] = qty;
                arr.push(variations);
            });
            product['variations'] = arr;

            return JSON.stringify(product);
        }

        function create_variation() {
            if (!validate_product()) {
                return;
            }
            let size = $("#select_size").val();
            let color = $("#select_color").val();
            let qty = $("#qty").val();
            let variations = size.length * color.length;
            if (variations == 0) {
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: 'Không có biến thể nào đươc tạo ',
                });
                return;
            }
            let msg = "Sẽ có " + variations + " biến thể sản phẩm được tạo ra!";
            Swal.fire({
                title: 'Bạn chắc chắn chứ?',
                text: msg,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý'
            }).then((result) => {
                if (result.value) {
                    let count = 1;
                    let product_id = $("#display_product_id").val();
                    for (let i = 0; i < color.length; i++) {
                        for (let j = 0; j < size.length; j++) {
                            console.log(size[j]);
                            console.log(color[i]);
                            let sku = "";
                            if (count < 10) {
                                sku = product_id + "0" + count;
                            } else {
                                sku = product_id + count;
                            }
                            generate_variations(count, qty, 0, color[i], size[j], sku);
                            count++;
                            $('.add-new-prod').prop('disabled', '');
                        }
                    }
                    $("#create_variation").prop('disabled', true);
                }
            });

        }

        function generate_variations(no, qty, id, color, size, sku) {
            $(".table-list tbody").append('<tr class="' + no + '">\n' +
                '                     <input type="hidden" class="form-control col-md-10" value="' + id + '" id="variation_id_' + no + '">\n' +
                '                    <td align="center">' + no + '</td>\n' +
                '                    <td align="center">' +
                '                     <input type="text" class="form-control col-md-10" value="' + sku + '" id="sku_' + no + '" disabled>\n' +
                '                    </td>\n' +
                //'                    <td >\n' +
                //'                      <img src="https://via.placeholder.com/100" onerror="this.onerror=null;this.src=\'<?php //Common::image_error()?>//\'" width="100" id="img_' + no + '" style="justify-content: left;float: left;">\n' +
                //'                      <div class="input-group mb-3 col-md-8" style="float: left;">\n' +
                //'                        <input type="text" class="form-control col-md-10" placeholder="Nhập link hình ảnh" onchange="onchange_image_link(' + no + ')" id="link_image_' + no + '" >\n' +
                //'                          <input id="image_type_' + no + '" type="hidden" value=""/>\n' +
                //'                        <div class="input-group-append">\n' +
                //'                       <form id="form_' + no + '" action="" method="post" enctype="multipart/form-data">' +
                //'                          <input id="image_' + no + '" type="file" accept="image/*" name="image" class="hidden"/>\n' +
                //'                          <button type="button" class="btn btn-info btn-flat" id="btn_upload_' + no + '">\n' +
                //'                            <span class="spinner-border spinner-border-sm hidden" id="spinner_' + no + '"></span>\n' +
                //'                            <i class="fa fa-upload"></i> Upload\n' +
                //'                          </button>\n' +
                //'                        </form>\n' +
                //'                        </div>\n' +
                //'                      </div>\n' +
                //'                    </td>\n' +
                '                    <td >\n' +
                '                       <select class="form-control ml-2 mr-2 col-sm-10" id="select_size_' + no + '" style="width: 100%"></select>' +
                '                    </td>\n' +
                '                    <td >\n' +
                '                       <select class="form-control ml-2 mr-2 col-sm-10" id="select_color_' + no + '"  style="width: 100%"></select>' +
                '                    </td>\n' +
                '                    <td >\n' +
                '                       <input type="number" class="form-control " id="qty_' + no + '" value="' + qty + '">\n' +
                '                    </td>\n' +
                '                    <td>\n' +
                '                       <button type="button" class="btn btn-danger btn-flat" id="delete_product_' + no + '" ' + (id != '' ? 'disabled' : '') + '>\n' +
                '                            <i class="fa fa-trash"></i>\n' +
                '                          </button>' +
                '                    </td>\n' +
                '                  </tr>');
            custom_select2("[id=select_size_" + no + "]", select_size);
            custom_select2("[id=select_color_" + no + "]", select_colors);
            $("[id=select_size_" + no + "]").val(size).trigger('change');
            $("[id=select_color_" + no + "]").val(color).trigger('change');
            // onpaste_image_link(no);
            // btn_upload(no);
            delete_product(no);
        }

        function delete_product(no) {
            $("[id=delete_product_" + no + "]").click(function () {
                $(this).closest('tr').remove();
                reindex();
            });
        }

        function reindex() {
            let no = 0;
            $(".table-list > tbody > tr").each(function () {
                no++;
                let curr_class = $(this).attr('class');
                $(this).removeClass("" + curr_class + "");
                $(this).addClass("" + no + "");
                $(this).find("td:first").text(no);
            });
            if (no == 0) {
                $("#create_variation").prop('disabled', '');
            } else {
                $("#create_variation").prop('disabled', true);
            }
        }

        function btn_upload(no) {
            $("[id=btn_upload_" + no + "]").click(function () {
                $(this).prop('disabled', true);
                $("[id=image_" + no + "]").click();
                upload_image(no);
            });
        }

        function upload_image(no) {
            $("[id=image_" + no + "]").change(function () {
                let file_data = $(this).prop('files')[0];
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
            });
        }

        function onpaste_image_link(no) {
            $("[id=link_image_" + no + "]").bind("paste", function (e) {
                let pastedData = e.originalEvent.clipboardData.getData('text');
                $("[id=img_" + no + "]").prop('src', pastedData).removeClass('hidden');
            });
        }

        function onchange_image_link(no) {
            let val = $("[id=link_image_" + no + "]").val();
            if (val == '') {
                val = 'https://via.placeholder.com/100';
                if (no == 0) {
                    $("[id=img_" + no + "]").addClass('hidden');
                }
            }
            $("[id=img_" + no + "]").prop('src', val);
        }

        function validate_variations() {

            let valid = true;
            $(".table-list > tbody > tr").each(function () {
                let no = $(this).attr('class');
                let size = $("[id=select_size_" + no + "]").val();
                if (size == null || size == '-1') {
                    $("[id=select_size_" + no + "]").addClass('is-invalid').focus();
                    toastr.error('Đã xảy ra lỗi');
                    valid = false;
                } else {
                    $("[id=select_size_" + no + "]").removeClass('is-invalid');
                }
                let color = $("[id=select_color_" + no + "]").val();
                if (color == null || color == '-1') {
                    $("[id=select_color_" + no + "]").addClass('is-invalid').focus();
                    toastr.error('Đã xảy ra lỗi');
                    valid = false;
                } else {
                    $("[id=select_color_" + no + "]").removeClass('is-invalid');
                }

                let qty = $("[id=qty_" + no + "]").val();
                if (qty == '' || !regExp.test(qty) || qty < 0) {
                    $("[id=qty_" + no + "]").addClass('is-invalid').focus();
                    toastr.error('Đã xảy ra lỗi');
                    valid = false;
                } else {
                    $("[id=qty_" + no + "]").removeClass('is-invalid');
                }
            });
            return valid;
        }

        function validate_product() {
            let product_id = $("#product_id").val();
            console.log(product_id);

            let name = $("#name").val();
            if (name == "") {
                toastr.error("Tên sản phẩm không được để trống");
                $("#name").focus();
                $("#name").addClass("is-invalid");
                return false;
            } else {
                $("#name").removeClass("is-invalid");
            }

            let link_image = $("#link_image_0").val();
            if (link_image == "") {
                toastr.error("Hình ảnh sản phẩm không được để trống");
                $("#link_image_0").focus();
                $("#link_image_0").addClass("is-invalid");
                return false;
            } else {
                $("#link_image_0").removeClass("is-invalid");
            }

            let fee = $("#fee").val();
            if (!validate_number(fee)) {
                toastr.error("Phí vận chuyển phải là số");
                $("#fee").focus();
                $("#fee").addClass("is-invalid");
                return false;
            } else {
                $("#fee").removeClass("is-invalid");
                $("#fee").val(formatNumber(fee));
            }

            let type = $("#select_type").val();
            if (type == "" || type == "-1") {
                toastr.error("Bạn chưa chọn giới tính");
                $("#select_type").focus();
                $("#select_type").addClass("is-invalid");
                return false;
            } else {
                $("#select_type").removeClass("is-invalid");
            }

            let cat = $("#select_cat").val();
            if (cat == "" || cat == "-1") {
                toastr.error("Bạn chưa chọn danh mục");
                $("#select_cat").focus();
                $("#select_cat").addClass("is-invalid");
                return false;
            } else {
                $("#select_cat").removeClass("is-invalid");
            }

            let price_import = $("#price").val();
            if (price_import == "") {
                toastr.error("Giá nhập sản phẩm không được bỏ trống");
                $("#price").focus();
                $("#price").addClass("is-invalid");
                return false;
            } else if (!validate_number(price_import)) {
                toastr.error("Giá nhập phải là số");
                $("#price").focus();
                $("#price").addClass("is-invalid");
                return false;
            } else {
                $("#price").removeClass("is-invalid");
                $("#price").val(formatNumber(price_import));
            }

            let price_retail = $("#retail").val();
            if (price_retail == "") {
                toastr.error("Giá bán lẻ sản phẩm không được bỏ trống");
                $("#retail").focus();
                $("#retail").addClass("is-invalid");
                return false;
            } else if (!validate_number(price_retail)) {
                toastr.error("Giá bán lẻ phải là số");
                $("#retail").focus();
                $("#retail").addClass("is-invalid");
                return false;
            } else {
                $("#retail").removeClass("is-invalid");
                $("#retail").val(formatNumber(price_retail));
            }

            let percent = $("#percent").val();
            if (percent === "") {
                $("#percent").focus().addClass("is-invalid");
                return false;
            } else if (!validate_number(percent)) {
                $("#percent").focus().addClass("is-invalid");
                return false;
            } else if(percent < 0) {
                $("#percent").focus().addClass("is-invalid");
                return false;
            } else {
                $("#percent").removeClass("is-invalid").val(formatNumber(percent));
            }

            let size = $("#select_size").val();
            if (product_id == 0 && size == "") {
                toastr.error("Bạn chưa chọn size");
                $("#select_size").focus();
                $("#select_size").addClass("is-invalid");
                return false;
            } else {
                $("#select_size").removeClass("is-invalid");
            }
            let color = $("#select_color").val();
            if (product_id == 0 && color == "") {
                toastr.error("Bạn chưa chọn màu sắc");
                $("#select_color").focus();
                $("#select_color").addClass("is-invalid");
                return false;
            } else {
                $("#select_color").removeClass("is-invalid");
            }

            let qty = $("#qty").val();
            if (product_id == 0 && qty != "" && !validate_number(qty)) {
                toastr.error("Số lượng phải là số");
                $("#qty").focus();
                $("#qty").addClass("is-invalid");
                return false;
            } else {
                $("#qty").removeClass("is-invalid");
            }

            return true;
        }

        function open_modal() {
            reset_modal();
            $('#create-product').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }

        function onchange_price() {
            let val = $("#price").val();
            val = replaceComma(val);
            if (isNaN(val)) {
                $("#price").addClass("is-invalid");
            } else {
                $("#price").removeClass("is-invalid");
                $("#price").val(formatNumber(val));

                let price = Number(val);
                let percent = $("#percent").val();
                percent = Number(percent);
                let retail = Math.round(price * percent / 100) + price;
                $("#retail").val(formatNumber(retail));
                calc_profit();
            }
        }

        function onchange_retail() {
            let val = $("#retail").val();
            val = replaceComma(val);
            if (isNaN(val) || val < 10) {
                $("#retail").addClass("is-invalid");
            } else {
                $("#retail").removeClass("is-invalid");
                if (val.indexOf(",") == -1) {
                    val = val + "000";
                }
                $("#retail").val(formatNumber(val));
                calc_percent();
                calc_profit();
            }
        }

        function onchange_percent() {
            let val = $("#percent").val();
            if (isNaN(val) || val < 39) {
                $("#percent").addClass("is-invalid");
                $("#percent").focus();
            } else {
                $("#percent").removeClass("is-invalid");
                // calc_profit(rowIndex);

                let price = $("#price").val();
                price = replaceComma(price);
                price = Number(price);
                let retail = Math.round(price * val / 100) + price;
                $("#retail").val(formatNumber(retail));
                calc_profit();
            }
        }

        function onchange_fee() {
            let val = $("#fee").val();
            val = replaceComma(val);
            if (isNaN(val)) {
                $("#fee").addClass("is-invalid");
            } else {
                $("#fee").removeClass("is-invalid");
                $("#fee").val(formatNumber(val));

                let fee = Number(val);
                $("#fee").val(formatNumber(fee));
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
                let percent = (retail - price) * 100 / (price + fee);
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
            $("[id=profit]").val(formatNumber(profit));
        }

        function show_loading() {
            $("#create-product .overlay").removeClass("hidden");
        }

        function hide_loading() {
            $("#create-product .overlay").addClass("hidden");
        }

        function onerror_img() {
            return '';
        }

        let select_size = [
            {
                id: '60',
                text: '60 cm (3kg-6kg)'
            },
            {
                id: '73',
                text: '73 cm (6kg-8kg)'
            },
            {
                id: '80',
                text: '80 cm (8kg-10kg)'
            },
            {
                id: '90',
                text: '90 cm (11kg-13kg)'
            },
            {
                id: '100',
                text: '100 cm (14kg-16kg)'
            },
            {
                id: '110',
                text: '110 cm (17kg-18kg)'
            },
            {
                id: '120',
                text: '120 cm (19kg-20kg)'
            },
            {
                id: '130',
                text: '130 cm (21kg-23kg)'
            },
            {
                id: '140',
                text: '140 cm (24kg-27kg)'
            },
            {
                id: '150',
                text: '150 cm (28kg-32kg)'
            },
            {
                id: '160',
                text: '160 cm (33kg-40kg)'
            },
            {
                id: '3m',
                text: '3m'
            },
            {
                id: '6m',
                text: '6m'
            },
            {
                id: '9m',
                text: '9m'
            },
            {
                id: 'Free Size',
                text: 'Free Size'
            },
            {
                id: '1',
                text: '1'
            },
            {
                id: '2',
                text: '2'
            },
            {
                id: '3',
                text: '3'
            },
            {
                id: '4',
                text: '4'
            },
            {
                id: '5',
                text: '5'
            },
            {
                id: '6',
                text: '6'
            },
            {
                id: '7',
                text: '7'
            },
            {
                id: '8',
                text: '8'
            },
            {
                id: '9',
                text: '9'
            },
            {
                id: '10',
                text: '10'
            },
            {
                id: '11',
                text: '11'
            },
            {
                id: '12',
                text: '12'
            },
            {
                id: '13',
                text: '13'
            },
            {
                id: '14',
                text: '14'
            },
            {
                id: '15',
                text: '15'
            },
            {
                id: '16',
                text: '16'
            },
            {
                id: '17',
                text: '17'
            },
            {
                id: '18',
                text: '18'
            },
            {
                id: '19',
                text: '19'
            },
            {
                id: '20',
                text: '20'
            },
            {
                id: '1T',
                text: '1T'
            },
            {
                id: '2T',
                text: '2T'
            },
            {
                id: '3T',
                text: '3T'
            },
            {
                id: '4T',
                text: '4T'
            },
            {
                id: '5T',
                text: '5T'
            },
            {
                id: '6T',
                text: '6T'
            },
            {
                id: '7T',
                text: '7T'
            },
            {
                id: '8T',
                text: '8T'
            },
            {
                id: '9T',
                text: '9T'
            },
            {
                id: '10T',
                text: '10T'
            },
            {
                id: '11T',
                text: '11T'
            },
            {
                id: '12T',
                text: '12T'
            },
            {
                id: '13T',
                text: '13T'
            },
            {
                id: '14T',
                text: '14T'
            },
            {
                id: '15T',
                text: '15T'
            },
            {
                id: '16T',
                text: '16T'
            },
            {
                id: '17T',
                text: '17T'
            },
            {
                id: '18T',
                text: '18T'
            },
            {
                id: '19T',
                text: '19T'
            },
            {
                id: '20T',
                text: '20T'
            }
        ];
        let select_colors = [
            {
                id: 'Trắng',
                text: 'Trắng'
            },
            {
                id: 'Xanh',
                text: 'Xanh'
            },
            {
                id: 'Đỏ',
                text: 'Đỏ'
            },
            {
                id: 'Tím',
                text: 'Tím'
            },
            {
                id: 'Vàng',
                text: 'Vàng'
            },
            {
                id: 'Xám',
                text: 'Xám'
            },
            {
                id: 'Hồng',
                text: 'Hồng'
            },
            {
                id: 'Đen',
                text: 'Đen'
            },
            {
                id: 'Nâu',
                text: 'Nâu'
            },
            {
                id: 'Kem',
                text: 'Kem'
            },
            {
                id: 'Bạc',
                text: 'Bạc'
            },
            {
                id: 'Cam',
                text: 'Cam'
            },
            {
                id: 'Kẻ',
                text: 'Kẻ'
            }
        ];
        let select_qty = [
            {
                id: '0',
                text: '0'
            },
            {
                id: '1',
                text: '1'
            },
            {
                id: '2',
                text: '2'
            },
            {
                id: '3',
                text: '3'
            },
            {
                id: '4',
                text: '4'
            },
            {
                id: '5',
                text: '5'
            },
            {
                id: '6',
                text: '6'
            },
            {
                id: '7',
                text: '7'
            },
            {
                id: '8',
                text: '8'
            },
            {
                id: '9',
                text: '9'
            },
            {
                id: '10',
                text: '10'
            },
            {
                id: '11',
                text: '11'
            },
            {
                id: '12',
                text: '12'
            },
            {
                id: '13',
                text: '13'
            },
            {
                id: '14',
                text: '14'
            }
        ];
        let select_types = [
            {
                id: '-1',
                text: ''
            },
            {
                id: '0',
                text: 'Bé trai'
            },
            {
                id: '1',
                text: 'Bé gái'
            },
            {
                id: '2',
                text: 'Trai gái'
            },
            {
                id: '3',
                text: 'Sơ sinh'
            }
        ];
        let select_cats = [
            {
                id: '-1',
                text: ''
            },
            {
                id: '1',
                text: 'Bộ quần áo'
            },
            {
                id: '2',
                text: 'Áo'
            },
            {
                id: '3',
                text: 'Quần'
            },
            {
                id: '4',
                text: 'Váy'
            },
            {
                id: '5',
                text: 'Giày'
            },
            {
                id: '6',
                text: 'Dép'
            },
            {
                id: '7',
                text: 'Mũ'
            },
            {
                id: '8',
                text: 'Phụ kiện'
            }
        ];
    </script>
