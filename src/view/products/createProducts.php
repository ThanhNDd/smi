<?php
require_once("../../common/common.php");
Common::authen();
?>
<div class="modal fade" id="create_product">
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
                                    <div class="form-group col-md-3 select_material">
<!--                                        <label for="select_material">Chất liệu:</label>-->
<!--                                        <select class="select-material form-control ml-2 col-sm-10" id="select_material" data-placeholder="Chọn chất liệu sản phẩm" style="width: 100%;"></select>-->
<!--                                        <input id='select_material' class="form-control" type="text" placeholder="Chọn chất liệu" autocomplete="off" spellcheck="false">-->
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
                                        <button type="button" class="btn btn-default mt-2" id="btn_add_color" title="Thêm màu">
                                            <i class="fa fa-plus-circle"></i> Thêm màu
                                        </button>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="select_sizes">Size:</label>
                                        <div id="select_sizes">
<!--                                            <input class="typeahead form-control" type="text" placeholder="Chọn size" autocomplete="off" spellcheck="false">-->
                                        </div>
                                        <button type="button" class="btn btn-default mt-2" id="btn_add_size" title="Thêm size">
                                            <i class="fa fa-plus-circle"></i> Thêm size
                                        </button>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="image">Hình ảnh:</label>
                                        <div id="image"></div>
                                        <button type="button" class="btn btn-default" id="btn_add_image" title="Thêm hình ảnh">
                                            <i class="fa fa-plus-circle"></i> Thêm hình ảnh
                                        </button>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="image">Hình ảnh theo màu sắc:</label>
                                        <div id="image_by_color"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Danh sách biến thể sản phẩm</h3>
                            </div>
                            <div class="card-body" style="width: 100%;overflow: scroll;">
                                <div style="padding: 15px;width: 1660px;overflow: scroll hidden;">
                                    <table class="table table-list table-bordered table-striped" cellspacing="0" width="100%">
                                        <thead> </thead>
                                        <tbody> </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pad">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm hiển thị trên website:</label>
                                <input type="text" class="form-control" id="name_for_website" placeholder="Tên sản phẩm hiển thị trên website" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="short_description">Mô tả ngắn</label>
                                <textarea class="form-control" placeholder="Mô tả ngắn (tối đa 500 ký tự)" id="short_description" maxlength="500"></textarea>
                            </div>
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
                <button type="button" class="btn btn-primary create-new btn-flat">Tạo mới</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <?php require_once('../../common/js.php'); ?>
    <script>

        let length_of_colors = 0;
        let length_of_sizes = 0;

        let color_ids = [];
        let size_ids = [];

        $(document).ready(function () {

            $('.textarea').summernote({
                placeholder: 'Mô tả sản phẩm...'
            });
            $('.product-create').click(function () {
                open_modal_product_create();
                // get_max_id();
            });
            $('#create_product').on('hidden.bs.modal', function () {
                let table = $('#example').DataTable();
                table.ajax.reload(init_select2, false);
            });

            custom_select2('#select_gender', select_types);
            custom_select2('#select_cat', select_cats);
            custom_select2('#select_origin', select_origin);

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
                let qty = $(this).val();
                onchange_qty(qty);
            });

            $(".create-new").click(function () {
                create_product();
            });
            btn_upload(0);
            onpaste_image_link(0);
            onpaste_image_link(0, 'byColor');

            // load_size();
            $("#btn_add_color").click(async function () {
                await add_color();
                draw_table_variations();
            });
            $("#btn_add_size").click(function () {
                add_size();
                draw_table_variations();
                let color = get_color_length();
                for(let i=1; i<=color; i++) {
                    $("#select_color_"+i).trigger('change');
                }
            });
            $("#btn_add_image").click(function(){
                add_image();
            });
        });

        function randstr(prefix) {
            return Math.random().toString(36).replace('0.',prefix || '');
        }
        
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
            $("#product_id").val(0);
            $("#name").val('');
            $("#link").val('');
            $("#fee").val('');

            $("#select_gender").val(null).trigger('change');
            $("#select_cat").val(null).trigger('change');
            // $("#select_material").val(null).trigger('change');
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
            $("#image").html("");
            $("#image_by_color").html("");
            $(".add-new-prod").prop('disabled', true);
            $('#short_description').val('');
            $("#select_colors").html("");
            $("#select_sizes").html("");
            $(".select_material").html("");
            draw_table_variations();
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
                    // console.log(product);
                    $.ajax({
                        dataType: 'json',
                        url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                        data: {
                            method: 'add_new',
                            data: product
                        },
                        type: 'POST',
                        success: function (data) {
                            // console.log(data);
                            Swal.fire(
                                'Thành công!',
                                'Các sản phẩm đã được tạo thành công.',
                                'success'
                            ).then((result) => {
                                if (result.value) {
                                    close_modal('#create_product');
                                    reset_modal();
                                    $('#product_datatable').DataTable().ajax.reload();
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
            let name_for_website = $("#name_for_website").val();
            let link = $("#link").val();
            let fee = $("#fee").val();
            let price = $("#price").val();
            let retail = $("#retail").val();
            let profit = $("#profit").val();
            let percent = $("#percent").val();
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
                if(img) {
                    let type = $("#image_type_" + i).val();
                    if (type === "upload") {
                        img = img.replace('<?php echo Common::path_img()?>', '');
                    }
                    if (img !== "") {
                        let image1 = {};
                        image1["src"] = img;
                        image1["type"] = type;
                        link_image.push(image1);
                    }
                }
            }
            // if(link_image.length > 0) {
                link_image = JSON.stringify(link_image);
            // }

            let product = {};
            product['product_id'] = product_id;
            product['name'] = name;
            product['name_for_website'] = name_for_website ? name_for_website : name;
            product['link'] = link;
            product['image'] = link_image;
            product['fee'] = replaceComma(fee);
            product['price'] = replaceComma(price);
            product['retail'] = replaceComma(retail);
            product['profit'] = replaceComma(profit);
            product['percent'] = percent;
            product['gender'] = gender;
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
                    let _fee = $(".table-list tbody tr #fee_"+c+"_"+s).val();
                    let _profit = $(".table-list tbody tr #profit_"+c+"_"+s).val();
                    let _sku = $(".table-list tbody tr #sku_"+c+"_"+s).val();
                    let _weight = $(".table-list tbody tr #weight_"+c+"_"+s).val();
                    let _height = $(".table-list tbody tr #height_"+c+"_"+s).val();
                    let _length = $(".table-list tbody tr #length_"+c+"_"+s).val();
                    let _age = $(".table-list tbody tr #age_"+c+"_"+s).val();
                    let _dimension = $(".table-list tbody tr #dimension_"+c+"_"+s).val();

                    let variations = {};
                    variations['id'] = _id;
                    variations['image'] = _image;
                    variations['color'] = _color;
                    variations['size'] = _size;
                    variations['qty'] = _qty;
                    variations['price'] = replaceComma(_price);
                    variations['retail'] = replaceComma(_retail);
                    variations['percent'] = _percent;
                    variations['fee'] = replaceComma(_fee);
                    variations['profit'] = replaceComma(_profit);
                    variations['sku'] = _sku;
                    variations['weight'] = _weight;
                    variations['height'] = _height;
                    variations['length__'] = _length;
                    variations['age'] = _age;
                    variations['dimension'] = _dimension;
                    arr.push(variations);
                }
            }
            product['variations'] = arr;
            return JSON.stringify(product);
        }


        function get_color_length() {
            return $("#select_colors").children(".color-item").length;
        }

        function get_size_length() {
            return $("#select_sizes").find(".size-item").length;
        }

        function draw_table_variations(exclude_color_id = null) {
            return new Promise((resolve) => {


            // let color = get_color_length();
            // let size = get_size_length();
            let color = length_of_colors;
            let size = length_of_sizes;


            let qty = $("#qty").val();
            let price = $("#price").val();
            let retail = $("#retail").val();
            let percent = $("#percent").val();
            let fee = $("#fee").val();
            let profit = $("#profit").val();
            let product_id = $("#display_product_id").val();
            let length_ = "";
            let weight = "";
            let height = "";
            let age = "";
            let dimension = "";
            let sku = "";
            // $(".table-list tbody").html("");
            let width_img = 35;
            // let c = 1;
            let d = 1;
            let thead = `<tr>`;
                thead += `<th class="hidden">id</th>`;
                thead += `<th width="100px">Hình ảnh</th>`;
                thead += `<th width="100px">Màu sắc</th>`;
                thead += `<th width="150px">Size</th>`;
                thead += `<th width="100px">Số lượng</th>`;
                thead += `<th width="100px">Giá nhập</th>`;
                thead += `<th width="100px">Giá bán</th>`;
                thead += `<th width="80px">%</th>`;
                thead += `<th width="130px">Phí vận chuyển</th>`;
                thead += `<th width="100px">Profit</th>`;
                thead += `<th width="100px">SKU</th>`;
                thead += `<th width="150px">Chiều dài</th>`;
                thead += `<th width="150px">Cân nặng</th>`;
                thead += `<th width="150px">Chiều cao</th>`;
                thead += `<th width="150px">Tuổi</th>`;
                thead += `<th width="150px">Kích thước</th>`;
                thead += `</tr>`;
            $(".table-list thead").html(thead);
            if(color > 0) {
                let table = "";
                // let c = 1;
                for (let c = 1; c <= color; c++) {
                    // let s = 1;
                    if(c != exclude_color_id) {
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
                        let _fee = $(".table-list tbody tr #fee_"+c+"_"+s).val();
                        if(typeof _fee === 'undefined' || _fee === '') {
                            _fee = $("#fee").val();
                        }
                        let _profit = $(".table-list tbody tr #profit_"+c+"_"+s).val();
                        if(typeof _profit === 'undefined' || _profit === '') {
                            _profit = $("#profit").val();
                        }
                        let _weight = $(".table-list tbody tr #weight_"+c+"_"+s).val();
                        if(typeof _weight === 'undefined' || _weight === '') {
                            _weight = '';
                        }
                        let _length = $(".table-list tbody tr #length_"+c+"_"+s).val();
                        if(typeof _length === 'undefined' || _length === '') {
                            _length = '';
                        }
                        let _height = $(".table-list tbody tr #height_"+c+"_"+s).val();
                        if(typeof _height === 'undefined' || _height === '') {
                            _height = '';
                        }
                        let _age = $(".table-list tbody tr #age_"+c+"_"+s).val();
                        if(typeof _age === 'undefined' || _age === '') {
                            _age = '';
                        }
                        let _dimension = $(".table-list tbody tr #dimension_"+c+"_"+s).val();
                        if(typeof _dimension === 'undefined' || _dimension === '') {
                            _dimension = '';
                        }
                        let _sku = $(".table-list tbody tr #sku_"+c+"_"+s).val();
                        if(typeof _sku === 'undefined' || _sku === '') {
                            // _sku = product_id + (d < 10 ? "0" + d : d);
                            _sku = "";
                        }
                        table += "<tr class=\"" + d + "\">\n";
                        table += "<td class=\"hidden\" id='id_"+c+"_"+s+"'>"+_id+"</td>";
                        if(s === 1) {
                            table += `<td class='image_${c}' rowspan='${size}'>
                                        <img onerror="this.onerror=null;this.src='<?php Common::image_error() ?>'"  
                                        src="${_img}" id="img_variation_${c}" class="mr-1 img-variant">
                                    </td>\n`;
                            table += "<td class='color_"+c+"' rowspan='"+size+"'>"+_color+"</td>\n";
                        }
                        table += "<td class='size_"+c+"_"+s+"'>"+_size+"</td>\n" +
                            "<td class='qty_"+c+"_"+s+"'><input type='number' class='form-control' placeholder='Số lượng' value='"+_qty+"' id='qty_"+c+"_"+s+"' min='0'></td>\n" +
                            "<td class='price_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Giá nhâp' value='"+_price+"' id='price_"+c+"_"+s+"' style='width:100px' onchange='onchange_price_in_list("+c+", "+s+")' onkeyup='onchange_price_in_list("+c+", "+s+")'></td>\n" +
                            "<td class='retail_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Giá bán' value='"+_retail+"' id='retail_"+c+"_"+s+"' style='width:100px' onchange='onchange_retail_in_list("+c+", "+s+")' onkeyup='onchange_retail_in_list("+c+", "+s+")'></td>\n" +
                            "<td class='percent_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='%' value='"+_percent+"' id='percent_"+c+"_"+s+"' onchange='onchange_percent_in_list("+c+", "+s+")' onkeyup='onchange_percent_in_list("+c+", "+s+")'></td>\n" +
                            "<td class='fee_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Phí vận chuyển' value='"+_fee+"' id='fee_"+c+"_"+s+"' onchange='onchange_fee_in_list("+c+", "+s+")' onkeyup='onchange_fee_in_list("+c+", "+s+")'></td>\n" +
                            "<td class='profit_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Profit' value='"+_profit+"' id='profit_"+c+"_"+s+"' style='width:100px' readonly></td>\n" +
                            "<td class='sku_"+c+"_"+s+"'><input type='text' class='form-control' value='"+_sku+"' id='sku_"+c+"_"+s+"' style='width:100px'></td>\n" +
                            "<td class='length_"+c+"_"+s+"'><input type='text' class='form-control' value='"+_length+"' id='length_"+c+"_"+s+"' ></td>\n" +
                            "<td class='weight_"+c+"_"+s+"'><input type='text' class='form-control' value='"+_weight+"' id='weight_"+c+"_"+s+"' ></td>\n" +
                            "<td class='height_"+c+"_"+s+"'><input type='text' class='form-control' value='"+_height+"' id='height_"+c+"_"+s+"' ></td>\n" +
                            "<td class='age_"+c+"_"+s+"'><input type='text' class='form-control' value='"+_age+"' id='age_"+c+"_"+s+"' ></td>\n" +
                            "<td class='dimension_"+c+"_"+s+"'><input type='text' class='form-control' value='"+_dimension+"' id='dimension_"+c+"_"+s+"' ></td>\n" +
                            "</tr>";
                        $(".table-list tbody").append(table);
                        // s++;
                        d++;
                    }
                    // c++;
                    }
                }
                $(".table-list tbody").html(table);
            } else {
                // let sku = product_id + (d < 10 ? "0" + d : d);
                $(".table-list tbody").html("<tr class=\"" + d + "\">" +
                    "<td class='image_"+d+"' rowspan='"+size+"'>"+
                    "<img onerror=\"this.onerror=null;this.src='<?php Common::image_error() ?>'\" src=\"\" id=\"img_variation_"+d+"\" class=\"mr-1 img-variant\" >" +
                    "</td>\n" +
                    "<td class='color_"+d+"' colspan='"+size+"'>Màu "+d+"</td>\n" +
                    "<td class='size_1_"+d+"'>Size "+d+"</td>\n" +
                    "<td class='qty_1_"+d+"'><input type='number' class='form-control' value='"+qty+"' id='qty_1_"+d+"' min='0'></td>\n" +
                    "<td class='price_1_"+d+"'><input type='text' class='form-control' value='"+price+"' id='price_1_"+d+"'></td>\n" +
                    "<td class='retail_1_"+d+"'><input type='text' class='form-control' value='"+retail+"' id='retail_1_"+d+"'></td>\n" +
                    "<td class='percent_1_"+d+"'><input type='text' class='form-control' value='"+percent+"' id='percent_1_"+d+"'></td>\n" +
                    "<td class='fee_1_"+d+"'><input type='text' class='form-control' value='"+fee+"' id='fee_1_"+d+"'></td>\n" +
                    "<td class='profit_1_"+d+"'><input type='text' class='form-control' value='"+profit+"' id='profit_1_"+d+"' style='width:100px'></td>\n" +
                    "<td class='sku_1_"+d+"'><input type='text' class='form-control' value='"+sku+"' id='sku_1_"+d+"' style='width:100px'></td>\n" +
                    "<td class='length_1_"+d+"'><input type='text' class='form-control' value='"+length_+"' id='length_1_"+d+"'></td>\n" +
                    "<td class='weight_1_"+d+"'><input type='text' class='form-control' value='"+weight+"' id='weight_1_"+d+"'></td>\n" +
                    "<td class='height_1_"+d+"'><input type='text' class='form-control' value='"+height+"' id='height_1_"+d+"'></td>\n" +
                    "<td class='age_1_"+d+"'><input type='text' class='form-control' value='"+age+"' id='age_1_"+d+"'></td>\n" +
                    "<td class='dimension_1_"+d+"'><input type='text' class='form-control' value='"+dimension+"' id='dimension_1_"+d+"'></td>\n" +
                    "</tr>");
            }

            resolve();
            });
        }


        function draw_table_variations_by_edit_product(color, size, variations) {
            return new Promise((resolve) => {


            let qty = $("#qty").val();
            let price = $("#price").val();
            let retail = $("#retail").val();
            let percent = $("#percent").val();
            let fee = $("#fee").val();
            let profit = $("#profit").val();
            let product_id = $("#display_product_id").val();

            let thead = `<tr>`;
                thead += `<th class="hidden">id</th>`;
                thead += `<th width="100px">Hình ảnh</th>`;
                thead += `<th width="100px">Màu sắc</th>`;
                thead += `<th width="150px">Size</th>`;
                thead += `<th width="100px">Số lượng</th>`;
                if(IS_ADMIN) {
                    thead += `<th width="100px">Giá nhập</th>`;
                }
                thead += `<th width="100px">Giá bán</th>`;
                if(IS_ADMIN) {
                    thead += `<th width="80px">%</th>`;
                    thead += `<th width="130px">Phí vận chuyển</th>`;
                    thead += `<th width="100px">Profit</th>`;
                }
                thead += `<th width="100px">SKU</th>`;
                thead += `<th width="150px">Chiều dài</th>`;
                thead += `<th width="150px">Cân nặng</th>`;
                thead += `<th width="150px">Chiều cao</th>`;
                thead += `<th width="150px">Tuổi</th>`;
                thead += `<th width="150px">Kích thước</th>`;
                thead += `</tr>`;
            $(".table-list thead").html(thead);
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
                        let _fee = variations[i].fee;
                        let _length = variations[i].length__ ? variations[i].length__ : "";
                        let _weight = variations[i].weight ? variations[i].weight : "";
                        let _height = variations[i].height ? variations[i].height : "";
                        let _age = variations[i].age ? variations[i].age : "";
                        let _dimension = variations[i].dimension ? variations[i].dimension : "";
                        let sku = variations[i].sku;
                        table += "<tr class=\"" + d + "\">\n";
                        table += "<td class=\"hidden\" id='id_"+c+"_"+s+"'>"+_id+"</td>";
                        if(s === 1) {
                            table += "<td class='image_"+c+"' rowspan='"+size+"'>"+
                                "<img onerror=\"this.onerror=null;this.src='<?php Common::image_error() ?>'\" src=\""+_img+"\" id=\"img_variation_"+c+"\" class=\"mr-1 img-variant\" >" +
                                "</td>\n";
                            table += "<td class='color_"+c+"' rowspan='"+size+"'>"+_color+"</td>\n";
                        }
                        table += "<td class='size_"+c+"_"+s+"'>"+_size+"</td>";
                        table += "<td class='qty_"+c+"_"+s+"'><input type='number' class='form-control' placeholder='Số lượng' value='"+_qty+"' id='qty_"+c+"_"+s+"'></td>";
                        if(IS_ADMIN) {
                            table += "<td class='price_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Giá nhâp' value='"+_price+"' id='price_"+c+"_"+s+"' style='width:100px' onchange='onchange_price_in_list("+c+", "+s+")' onkeyup='onchange_price_in_list("+c+", "+s+")'></td>";
                        }
                        table += "<td class='retail_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Giá bán' value='"+_retail+"' id='retail_"+c+"_"+s+"' style='width:100px' onchange='onchange_retail_in_list("+c+", "+s+")' onkeyup='onchange_retail_in_list("+c+", "+s+")'></td>";
                        if(IS_ADMIN) {
                            table += "<td class='percent_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='%' value='"+_percent+"' id='percent_"+c+"_"+s+"' onchange='onchange_percent_in_list("+c+", "+s+")' onkeyup='onchange_percent_in_list("+c+", "+s+")'></td>";
                            table += "<td class='fee_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Phí vận chuyển' value='"+_fee+"' id='fee_"+c+"_"+s+"' onchange='onchange_fee_in_list("+c+", "+s+")' onkeyup='onchange_fee_in_list("+c+", "+s+")'></td>";
                            table += "<td class='profit_"+c+"_"+s+"'><input type='text' class='form-control' placeholder='Profit' value='"+_profit+"' id='profit_"+c+"_"+s+"' style='width:100px' readonly></td>";
                        }
                        table += "<td class='sku_"+c+"_"+s+"'><input type='text' class='form-control' value='"+sku+"' id='sku_"+c+"_"+s+"'  style='width:100px'></td>";
                        table += "<td class='length_"+c+"_"+s+"'><input type='text' class='form-control' value='"+_length+"' id='length_"+c+"_"+s+"' ></td>";
                        table += "<td class='weight_"+c+"_"+s+"'><input type='text' class='form-control' value='"+_weight+"' id='weight_"+c+"_"+s+"' ></td>";
                        table += "<td class='height_"+c+"_"+s+"'><input type='text' class='form-control' value='"+_height+"' id='height_"+c+"_"+s+"' ></td>";
                        table += "<td class='age_"+c+"_"+s+"'><input type='text' class='form-control' value='"+_age+"' id='age_"+c+"_"+s+"' ></td>";
                        table += "<td class='dimension_"+c+"_"+s+"'><input type='text' class='form-control' value='"+_dimension+"' id='dimension_"+c+"_"+s+"' ></td>";
                        table += "</tr>";
                        $(".table-list tbody").append(table);
                        // s++;
                        d++;
                        i++;
                    }
                    // c++;
                }
                $(".table-list tbody").html(table);
            } else {
                // let sku = product_id + (d < 10 ? "0" + d : d);
                let sku = "";
                $(".table-list tbody").append("<tr class=\"" + d + "\">" +
                    "<td class='image_"+c+"' rowspan='"+size+"'>"+
                    "<img onerror=\"this.onerror=null;this.src='<?php Common::image_error() ?>'\" width=\"80px\" src=\"\" id=\"img_variation_"+c+"\" class=\"mr-1\" style=\"max-width: 80px;\">" +
                    "</td>\n" +
                    "<td class='color_"+d+"' colspan='"+size+"'>Màu "+d+"</td>\n" +
                    "<td class='size_1_"+d+"'>Size "+d+"</td>\n" +
                    "<td class='qty_1_"+d+"'><input type='number' class='form-control' value='"+qty+"' id='qty_1_"+d+"'></td>\n" +
                    "<td class='price_1_"+d+"'><input type='text' class='form-control' value='"+price+"' id='price_1_"+d+"'></td>\n" +
                    "<td class='retail_1_"+d+"'><input type='text' class='form-control' value='"+retail+"' id='retail_1_"+d+"'></td>\n" +
                    "<td class='percent_1_"+d+"'><input type='text' class='form-control' value='"+percent+"' id='percent_1_"+d+"'></td>\n" +
                    "<td class='fee_1_"+d+"'><input type='text' class='form-control' value='"+fee+"' id='fee_1_"+d+"'></td>\n" +
                    "<td class='profit_1_"+d+"'><input type='text' class='form-control' value='"+profit+"' id='profit_1_"+d+"'></td>\n" +
                    "<td class='sku_1_"+d+"'><input type='text' class='form-control' value='"+sku+"' id='sku_1_"+d+"'></td>\n" +
                    "<td class='length_1_"+d+"'><input type='text' class='form-control' id='length_1_"+d+"'></td>\n" +
                    "<td class='weight_1_"+d+"'><input type='text' class='form-control' id='weight_1_"+d+"'></td>\n" +
                    "<td class='height_1_"+d+"'><input type='text' class='form-control' id='height_1_"+d+"'></td>\n" +
                    "<td class='age_1_"+d+"'><input type='text' class='form-control' id='age_1_"+d+"'></td>\n" +
                    "<td class='dimension_1_"+d+"'><input type='text' class='form-control' id='dimension_1_"+d+"'></td>\n" +
                    "<td><i class='fa fa-trash'></i></td>\n" +
                    "</tr>");
            }
        });
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
                                    // console.log(res);
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
                                    // console.log(res);
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
                $("[id=image_type_" + no + "]").val("");
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
                $("[id=image_type_" + no + "]").val("");
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

            let name_for_website = $("#name_for_website").val();
            if(name_for_website === "") {
                name_for_website = name;
            }

            // let fee = $("#fee").val();
            // if (!validate_number(fee)) {
            //     // toastr.error("Phí vận chuyển phải là số");
            //     $("#fee").addClass("is-invalid");
            //     is_valid = false;
            // } else {
            //     $("#fee").removeClass("is-invalid").val(formatNumber(fee));
            // }

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
            if (percent !== "" && !validate_number(percent)) {
                $("#percent").addClass("is-invalid");
                is_valid = false;
            } else if(percent < 0) {
                $("#percent").addClass("is-invalid");
                is_valid = false;
            } else {
                $("#percent").removeClass("is-invalid").val(formatNumber(percent));
            }

            let color = get_color_length();
            if(color > 0) {
                for(let i=1; i<=color; i++) {
                    let c = $("#select_color_"+i).val();
                    if(c === '') {
                        $("#select_color_"+i).addClass("is-invalid");
                        is_valid = false;
                    } else {
                        $("#select_color_"+i).removeClass("is-invalid");
                    }
                }
            } else {
                toastr.error("Không tồn tại màu !!!");
                is_valid = false;
            }

            let size = get_size_length();
            if(size > 0) {
                for (let i = 1; i <= size; i++) {
                    let c = $("#select_size_" + i).val();
                    if (c === '') {
                        $("#select_size_" + i).addClass("is-invalid");
                        is_valid = false;
                    } else {
                        $("#select_size_" + i).removeClass("is-invalid");
                    }
                }
            } else {
                toastr.error("Không tồn tại size !!!");
                is_valid = false;
            }

            // let image = $("#image").children(".image").length;
            // for(let i=1; i<=image; i++) {
            //     let c = $("#link_image_"+i).val();
            //     if(c === '') {
            //         $("#link_image_"+i).addClass("is-invalid");
            //         is_valid = false;
            //     } else {
            //         $("#link_image_"+i).removeClass("is-invalid");
            //     }
            // }

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
                    let _fee = $(".table-list tbody tr #fee_"+c+"_"+s).val();
                    if(typeof _fee === 'undefined' || _fee === '') {
                        $(".table-list tbody tr #fee_"+c+"_"+s).addClass("is-invalid");
                        is_valid = false;
                    } else {
                        $(".table-list tbody tr #fee_"+c+"_"+s).removeClass("is-invalid");
                    }
                }
            }
            if(!is_valid) {
                toastr.error("Đã xảy ra lỗi");
            }
            return is_valid;
        }

        function open_modal_product_create() {
            reset_modal();
            load_size();
            load_color();
            load_material();
            c = 1; // color
            s = 1; // size
            image = 1; // image

            // add_color();
            // add_size();
            add_image();
            // $('#create_product').modal({
            //     backdrop: 'static',
            //     keyboard: false,
            //     show: true
            // });

            open_modal('#create_product');
        }

        let sequence_of_color = 1;
        function add_color(value) {
            return new Promise((resolve) => {

                // $("#select_colors").append(`<div id='w_select_color_${c}'>
                //                             <input id='select_color_${c}' class="select_color_${c} form-control" type="text" 
                //                             placeholder=\"Chọn màu "+c+"\" autocomplete=\"off\" spellcheck=\"false\">" +
                //     "<button class='btn btn-secondary btn-flat' id='delete_color_"+c+"'><i class='fa fa-trash'></i></button></div>`);

                $("#select_colors").append(`<div class="input-group mb-1 color-item" id='w_select_color_${sequence_of_color}'>
                                                <input id='select_color_${sequence_of_color}' class="select_color_${sequence_of_color} form-control" type="text" placeholder="Nhập tên màu ${sequence_of_color}">
                                                <div class="input-group-append">
                                                    <button class='btn btn-secondary input-group-text' id='delete_color_${sequence_of_color}'>
                                                        <i class='fa fa-trash'></i>
                                                    </button>
                                                </div>
                                            </div>`);
                // $('#select_color_'+c).typeahead({
                //     hint: true,
                //     highlight: true,
                //     minLength: 1
                // },
                // {
                //     name: 'color',
                //     source: substringMatcher(colors),
                //     limit: 10
                // });
                if(value) {
                    // $('#select_color_'+c).typeahead('val', value);
                    $('#select_color_'+sequence_of_color).val(value);
                }
                
                onchange_select_color(sequence_of_color);
                add_image_by_color(sequence_of_color);
                delete_color(sequence_of_color);
                sequence_of_color++;
                length_of_colors++;
            resolve();
            })
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
                }).then(async (result) => {
                    if (result.value) {

                        await draw_table_variations(color);


                        // get all value of color
                        let colors = [];
                        let images = [];
                        for(let i=1; i<=length_of_colors; i++) {
                            if(i != color) {
                                let color_value = $("#select_color_"+i).val();
                                colors.push(color_value);
                                let image_value = $("#link_image_by_color_"+i).val();
                                images.push(image_value);
                            }
                        }

                        // delete all colors
                        $("#select_colors").html("");
                        $("#image_by_color").html("");

                        // reset length_of_colors
                        length_of_colors = 0;

                        // reset sequence_of_color
                        sequence_of_color = 1;

                        // recreate colors
                        if(colors.length > 0) {
                            for(let i=0; i < colors.length; i++) {
                                await add_color(colors[i]);
                                add_image_by_color(i+1, images[i]);
                            }
                        } else {
                            add_color();
                        }


                        
                        // $("#image_by_color_"+color).remove();

                        // $("#select_colors").html("");
                        
                        // let arr_color = [];
                        // let color_length = get_color_length();
                        // console.log("color_length: ", color_length);
                        // if(length_of_colors > 1) {
                        //     for(let i=1; i<=color_length; i++) {
                        //         let color = $("#select_color_"+i).val();
                        //         console.log("color: ", color);
                        //     //     // arr_color.push(color);
                        //     //     $("#select_color_"+i).trigger('change');
                        //     //     // add_color(color);
                        //     }
                        // }
                        // arr_color.splice(color-1,1);
                        
                        // $("#select_colors").html("");
                        // c = 1;
                        // for(let i=0; i<arr_color.length; i++) {
                        //     add_color(arr_color[i]);
                        //     $("#select_color_"+(i+1)).trigger('change');
                        // }

                        

                       
                    }
                });
            });
        }

        function add_image_by_color(c, src) {
            if(!src) {
                src = '';
            }
            $("#image_by_color .image-by-color").each((k, v) => {
                let sequence = $(v).attr("id").replace("image_by_color_","");
                if(c == sequence) {
                    $(`#image_by_color_${c}`).remove();
                }
            });
            $("#image_by_color").append(`<div class="input-group mb-1 image-by-color" id="image_by_color_${c}">
                <img onerror="this.onerror=null;this.src='<?php Common::image_error() ?>'" width="40" src="${src}" id="img_by_color_${c}" class="mr-1">
                <input type="text" class="form-control" placeholder="Nhập link hình ảnh màu ${c}" value="${src}" onchange="onchange_image_link(${c}, 'byColor')" 
                    id="link_image_by_color_${c}">
                <input type="hidden" class="form-control" id="image_type_by_color_${c}">
                </div>`);
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
            // $("#select_sizes").append("<div id='w_select_size_"+s+"'><input id='select_size_"+s+"' class=\"select_size_"+s+" form-control\" type=\"text\" placeholder=\"Chọn size "+s+"\" autocomplete=\"off\" spellcheck=\"false\">" +
            //     "<button class='btn btn-secondary btn-flat' id='delete_size_"+s+"'><i class='fa fa-trash'></i></button></div>");
            $("#select_sizes").append(`<div class="input-group mb-1 size-item" id='w_select_size_${s}'>
                                            <input id='select_size_${s}' class="select_size_${s} form-control" type="text" placeholder="Nhập tên size ${s}">
                                            <div class="input-group-append">
                                                <button class='btn btn-secondary input-group-text' id='delete_size_${s}'><i class='fa fa-trash'></i></button>
                                            </div>
                                        </div>`);
                // $('#select_size_'+s).typeahead({
            //         hint: true,
            //         highlight: true,
            //         minLength: 1
            //     },
            //     {
            //         name: 'size',
            //         source: substringMatcher(size),
            //         limit: 10
            //     });
            if(value) {
                $('#select_size_'+s).val(value);
            }
            onchange_select_size(s);
            delete_size(s);
            // draw_table_variations();
            s++;
            length_of_sizes++;
        }

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


                        length_of_sizes = 0;

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
            $("#image").append("<div class=\"input-group mb-1 image\" style=\"margin-bottom: 10px;\">\n" +
                "<img onerror=\"this.onerror=null;this.src='<?php Common::image_error() ?>'\" width=\"40\" src=\""+src+"\" id=\"img_"+idx_image+"\" class=\"mr-1\">\n" +
                "<input type=\"text\" class=\"form-control\" placeholder=\"Nhập link hình ảnh "+idx_image+"\" value=\""+src+"\" onchange=\"onchange_image_link("+idx_image+")\" id=\"link_image_"+idx_image+"\" autocomplete=\"off\">\n" +
                "<input type=\"hidden\" class=\"form-control\" id=\"image_type_"+idx_image+"\" value=\""+type+"\">\n" +
                "<div class=\"input-group-append\">\n" +
                "<form id=\"form_0\" action=\"\" method=\"post\" enctype=\"multipart/form-data\">\n" +
                "<input id=\"image_"+idx_image+"\" type=\"file\" accept=\"image/*\" name=\"image\" class=\"hidden\"/>\n" +
                "<button type=\"button\" class=\"btn btn-default btn-flat\" id=\"btn_upload_"+idx_image+"\" style=\"height: 38px;\">\n" +
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
                    // console.log(response);
                    size = response;
                    // $('#select_sizes .typeahead').typeahead({
                    //         hint: true,
                    //         highlight: true,
                    //         minLength: 1
                    //     },
                    //     {
                    //         name: 'size',
                    //         source: substringMatcher(response)
                    //     });
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
                success: async function (response) {
                    colors = response;
                    // console.log(response);
                    // $('.select_color_0').typeahead({
                    //     hint: true,
                    //     highlight: true
                    // },
                    // {
                    //     name: 'size',
                    //     source: substringMatcher(response),
                    //     limit: 10
                    // });
                    let product_id = $("#product_id").val();
                    if(product_id === '0') {
                        await add_color();
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

        let materials = [];
        function load_material() {
            $.ajax({
                dataType: 'json',
                url: '<?php Common::getPath() ?>src/controller/product/ProductController.php',
                data: {
                    method: 'load_material'
                },
                type: 'POST',
                success: function (response) {
                    materials = response;
                    // console.log(response);
                    $(".select_material").html("<label for=\"select_material\">Chất liệu:</label><input id='select_material' class=\"form-control\" type=\"text\" placeholder=\"Chọn chất liệu\" autocomplete=\"off\" spellcheck=\"false\">");
                    // $('#select_material').typeahead({
                    //     hint: true,
                    //     highlight: true
                    // },
                    // {
                    //     name: 'size',
                    //     source: substringMatcher(response),
                    //     limit: 10
                    // });
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

        // function substringMatcher (strs) {
        //     return function findMatches(q, cb) {
        //         let matches = [];
        //         let substrRegex = new RegExp(q, 'i');
        //         $.each(strs, function (i, str) {
        //             if (substrRegex.test(str)) {
        //                 matches.push(str);
        //             }
        //         });
        //         cb(matches);
        //     };
        // }
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

        function onchange_fee() {
            let fee = $("#fee").val();
            if(!fee) {
                return;
            }
            fee = format_money(replaceComma(fee));
            if (isNaN(fee)) {
                $("#fee").addClass("is-invalid");
            } else {
                $("#fee").removeClass("is-invalid").val(formatNumber(fee));

                let retail = $("#retail").val();
                if(retail) {
                    retail = format_money(replaceComma(retail));
                }
                let price = $("#price").val();
                if(price) {
                    price = format_money(replaceComma(price));
                }
                if(price > 0 && retail > 0) {
                    let profit = retail - price - fee;
                    $("#profit").val(formatNumber(profit));
                }
                calculate_all_profit_in_list();
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

        function onchange_retail() {
            let retail = $("#retail").val();
            retail = format_money(retail);
            if (isNaN(retail)) {
                $("#retail").addClass("is-invalid");
            } else {
                $("#retail").removeClass("is-invalid").val(formatNumber(retail));
                calc_percent();
                calc_profit();
                calculate_all_price_in_list();
            }
        }

        function onchange_percent() {
            let percent = $("#percent").val();
            percent = format_money(percent);
            if (isNaN(percent)) {
                $("#percent").addClass("is-invalid");
            } else {
                $("#percent").removeClass("is-invalid").val(percent);
                // calc_percent();
                calc_retail();
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

        function calculate_all_profit_in_list() {
            let fee = $("#fee").val();
            if(!fee) {
                return;
            }
            fee = format_money(replaceComma(fee));
            let color = get_color_length();
            let size = get_size_length();
            for(let i=1; i<=color; i++) {
                for(let j=1; j<=size; j++) {
                    // let price = $("[id=price_" + i +"_" + j + "]").val();
                    // if(!price) {
                    //     continue;
                    // }
                    // price = format_money(replaceComma(price));
                    // let retail = $("[id=retail_" + i +"_" + j + "]").val();
                    // if(!retail) {
                    //     continue;
                    // }
                    // retail = format_money(replaceComma(retail));
                    // let fee = $("[id=fee_" + i +"_" + j + "]").val();
                    // if(!fee) {
                    //     continue;
                    // }
                    // fee = format_money(replaceComma(fee));
                    // let profit = retail - price - fee;
                    $("[id=fee_" + i +"_" + j + "]").val(formatNumber(fee)).trigger('change');
                }
            }
        }

        // function onchange_retail() {
        //     let val = $("#retail").val();
        //     val = format_money(val);
        //     if (isNaN(val)) {
        //         $("#retail").addClass("is-invalid");
        //     } else {
        //         $("#retail").removeClass("is-invalid");
        //         $("#retail").val(formatNumber(val));
        //         calc_percent();
        //         calc_profit();
        //     }
        // }

        // function onchange_percent() {
        //     let val = $("#percent").val();
        //     if (isNaN(val)) {
        //         $("#percent").addClass("is-invalid");
        //         $("#percent").focus();
        //     } else {
        //         $("#percent").removeClass("is-invalid");
        //         // calc_profit(rowIndex);
        //
        //         let price = $("#price").val();
        //         price = replaceComma(price);
        //         price = Number(price);
        //         let fee = Number(replaceComma($("#fee").val()));
        //         let retail = Math.round((price + fee) * val / 100) + price + fee;
        //         $("#retail").val(formatNumber(retail));
        //         calc_profit();
        //     }
        // }

        // function onchange_fee() {
        //     let val = $("#fee").val();
        //     if(!val) {
        //         return;
        //     }
        //     val = format_money(val);
        //     if (isNaN(val)) {
        //         $("#fee").addClass("is-invalid");
        //     } else {
        //         $("#fee").removeClass("is-invalid");
        //         $("#fee").val(formatNumber(val));
        //         // let fee = Number(val);
        //         // $("#fee").val(formatNumber(fee));
        //         calc_profit();
        //     }
        // }

        function calc_percent() {
            let retail = $("[id=retail]").val();
            if(!retail) {
                return;
            }
            retail = replaceComma(retail);
            let price = $("[id=price]").val();
            if(!price) {
                return;
            }
            price = replaceComma(price);
            let fee = $("[id=fee]").val();
            if(!fee) {
                return;
            }
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
            if(!retail) {
                return;
            }
            retail = replaceComma(retail);
            let price = $("[id=price]").val();
            if(!price) {
                return;
            }
            price = replaceComma(price);
            let fee = $("[id=fee]").val();
            if(!fee) {
                return;
            }
            fee = replaceComma(fee);
            let profit = Number(retail) - Number(price) - Number(fee);
            $("[id=profit]").val(profit > 0 ? formatNumber(profit) : '');
        }

        function calc_retail() {
            let percent = $("[id=percent]").val();
            if(!percent) {
                return;
            }
            let price = $("[id=price]").val();
            if(!price) {
                return;
            }
            price = Number(replaceComma(price));
            let fee = $("[id=fee]").val();
            if(!fee) {
                return;
            }
            fee = Number(replaceComma(fee));
            let retail = Math.round((price+fee) * percent / 100) + price + fee;
            $("[id=retail]").val(retail > 0 ? formatNumber(retail) : '');
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
                let fee = $("#fee_"+c+"_"+s).val();
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
                let fee = Number(replaceComma($("#fee_"+c+"_"+s).val()));
                let retail = Math.round((price + fee) * val / 100) + price + fee;
                $(".table-list tbody tr td #retail_"+c+"_"+s).val(formatNumber(retail));
                calc_profit_in_list(c, s);
            }
        }

        function onchange_fee_in_list(c, s) {
            let fee = $(".table-list tbody tr td #fee_"+c+"_"+s).val();
            if(!fee) {
                return;
            }
            fee = format_money(replaceComma(fee));
            if (isNaN(fee)) {
                $(".table-list tbody tr td #fee_"+c+"_"+s).addClass("is-invalid").focus();
            } else {
                $(".table-list tbody tr td #fee_"+c+"_"+s).removeClass("is-invalid").val(formatNumber(fee));

                let price = $(".table-list tbody tr td #price_"+c+"_"+s).val();
                if(!price) {
                    return;
                }
                price = Number(replaceComma(price));
                let retail = $(".table-list tbody tr td #retail_"+c+"_"+s).val();
                if(!retail) {
                    return;
                }
                retail = Number(replaceComma(retail));
                let profit = retail - price - fee;
                $(".table-list tbody tr td #profit_"+c+"_"+s).val(formatNumber(profit));
                // calc_profit_in_list(c, s);
            }
        }

        function calc_profit_in_list(c, s) {
            let retail = $(".table-list tbody tr td #retail_"+c+"_"+s).val();
            retail = replaceComma(retail);
            let price = $(".table-list tbody tr td #price_"+c+"_"+s).val();
            price = replaceComma(price);
            let fee = $("#fee_"+c+"_"+s).val();
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
            if(!retail) {
                return;
            }
            retail = replaceComma(retail);
            let price = $(".table-list tbody tr td #price_"+c+"_"+s).val();
            if(!price) {
                return;
            }
            price = replaceComma(price);
            let fee = $("#fee_"+c+"_"+s).val();
            if(!fee) {
                return;
            }
            fee = replaceComma(fee);
            if (isNaN(retail)) {
                $(".table-list tbody tr td #retail_"+c+"_"+s).addClass("is-invalid").focus();
            } else if (isNaN(price)) {
                $(".table-list tbody tr td #price_"+c+"_"+s).addClass("is-invalid").focus();
            } else if (isNaN(fee)) {
                $("#fee_"+c+"_"+s).addClass("is-invalid").focus();
            } else {
                $(".table-list tbody tr td #retail_"+c+"_"+s).removeClass("is-invalid");
                $(".table-list tbody tr td #price_"+c+"_"+s).removeClass("is-invalid");
                $("#fee_"+c+"_"+s).removeClass("is-invalid");
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

        // function show_loading() {
        //     $("#create-product .overlay").removeClass("hidden");
        // }
        //
        // function hide_loading() {
        //     $("#create-product .overlay").addClass("hidden");
        // }

        function onerror_img() {
            return '';
        }


    </script>
    <?php require_once('attribute.php'); ?>

