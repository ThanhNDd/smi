<?php
$root = dirname(__FILE__, 3);
require_once($root."/common/common.php");
Common::authen();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Xuất dữ liệu hệ thống</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php Common::getPath() ?>dist/img/icon.png"/>
    <?php require_once($root.'/common/css.php'); ?>
    <?php require_once($root.'/common/js.php'); ?>
    <style>
        div#product_datatable {
            margin-top: 10px;
        }

        table.dataTable.no-footer {
            border-bottom: none;
        }

        div.dataTables_wrapper div.dataTables_info {
		    float: left;
		}

        .header-column {
            position: fixed;
            z-index: 999;
            background: #fff;
            top: 98px;
            height: 30px;
            margin: 0 -3px;
        }

        .card-body {
            padding: 0;
        }

        .table td, .table th {
            padding: 5px;
            border-top: none;
            margin: 0 !important;
            position: relative;
        }


        td, th {
            white-space: nowrap;
        }
        table#product_datatable {
            width: 100% !important;
        }
        img#thumbnail {
            width: 50px !important;
            border: 2px solid white;
            border-radius: 5px;
        }
        input[type="checkbox"] {
		    top: 0;
		    bottom: 0;
		    width: 20px;
		    position: absolute;
		}
        div#backdrop {
            position: absolute;
            background: white;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 9;
            opacity: .3;
            cursor: wait;
        }
    </style>
</head>
</head>
<?php require($root.'/common/header.php'); ?>   
<?php require($root.'/common/menu.php'); ?>
<section class="content pt-3">
<div class="card">
    <div class="m-3 p-0">
      <ul class="nav nav-pills">
        <li class="nav-item">
          <!-- <a class="nav-link active" data-toggle="tab" href="#products">Sản phẩm</a> -->
          <a href="<?php Common::getPath() ?>src/view/system/products.php" class="nav-link active">
            Sản phẩm
          </a>
        </li>
        <li class="nav-item">
          <!-- <a class="nav-link" data-toggle="tab" href="#orders">Đơn hàng</a> -->
          <a href="<?php Common::getPath() ?>src/view/system/orders.php" class="nav-link">
            Đơn hàng
          </a>
        </li>
        <li class="nav-item">
          <!-- <a class="nav-link" data-toggle="tab" href="#customers">Khách hàng</a> -->
          <a href="<?php Common::getPath() ?>src/view/system/customers.php" class="nav-link">
            Khách hàng
          </a>
        </li>
      </ul>
    </div>  
    <div class="card-body m-3">
        <div id="backdrop" style="display: none;"></div>
    	<div class="text-right mb-3">
            <button class="btn btn-success m-1 float-left" onclick="checkAPI()">Check API</button>
    		<button class="btn btn-primary m-1" id="exportAll" onclick="exportAll()">
                <div class="spinner-border mr-2" id="spinnerAll" style="width: 25px; height: 25px;display: none;"></div> 
                Xuất tất cả
            </button>
    		<button class="btn btn-info m-1 d-inline-flex" disabled id="exportSelectedProduct" onclick="exportCustom()">
                <div class="spinner-border mr-2" id="spinnerSelectedProduct" style="width: 25px; height: 25px;display: none;"></div> 
                <span class="label">Xuất sản phẩm đã chọn</span>
            </button>
		</div>

        <table id="product_datatable" class="table table-hovered table-striped">
            <thead>
            <tr>
                <th style="width: 50px;"></th>
                <th>ID</th>
                <th class="center">Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá bán lẻ</th>
                <th>Số lượng</th>
                <th>Thời gian đồng bộ</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<?php require_once('../../common/footer.php'); ?>
<script>
    let table;
    let productsSelected = [];
    $(document).ready(function () {
        generate_datatable();
    });

    async function fetchProducts(){
        console.log("fetchProducts");
        $.ajax({
            url: '<?php Common::getPath() ?>src/controller/system/ExportDataProductsController.php',
            type: "POST",
            data: {
                method: "fetchProducts"
            },
            dataType: "json",
            success: function (response) {
                console.log("response: ", response);
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

    async function checkAPI() {
        await getToken();
        if(token) {
            toastr.success('Kết nối API thành công');
        } else {
            toastr.error('Kết nối API không thành công');
        }
    }

    function getToken(){
        console.log("getToken");
        return new Promise(resolve => {
            $.ajax({
                url: '<?php Common::getPath() ?>src/controller/system/ExportDataProductsController.php',
                type: "POST",
                dataType: "json",
                data: {
                    method: "getToken"
                },
                success: function (response) {
                    console.log("response: ", response);
                    if(response) {
                        token = response;
                    } else {
                        token = null;
                    }
                    resolve();
                },
                error: function (data, errorThrown) {
                    console.log(data.responseText);
                    console.log(errorThrown);
                    token = null;
                    Swal.fire({
                        type: 'error',
                        title: 'Đã xảy ra lỗi',
                        text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                    });
                    resolve();
                }
            });
        });
    }

    async function exportAll() {
        console.log("exportAll");
        $("#backdrop").show();
        $("#spinnerAll").show();
        $("#exportAll").attr("disabled", true);

        Swal.fire({
            title: 'Xác nhận?',
            text: "Hành động này sẽ xuất tất cả sản phẩm nhưng không bao gồm các sản phẩm đã được xuất trước dó. Bạn có muốn tiếp tục?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then(async (result) => {
            if (result.value) {
                await exportProducts("all");
            }
            $("#backdrop").hide();
            $("#spinnerAll").hide();
            $("#exportAll").removeAttr("disabled");
        });
    }

    async function exportCustom() {
        $("#backdrop").show();
        $("#spinnerSelectedProduct").show();
        $("#exportSelectedProduct").attr("disabled", true); 
        
        await exportProducts("custom");

        $("#spinnerSelectedProduct").hide();
        $("#exportSelectedProduct").removeAttr("disabled");
        $("#backdrop").hide();
    }

    function exportProducts(exportType) {
    	console.log("exportProducts");
        return new Promise(resolve => {
            $.ajax({
                url: '<?php Common::getPath() ?>src/controller/system/ExportDataProductsController.php',
                type: "POST",
                dataType: "json",
                data: {
                    method: "exportProducts",
                    productIds: exportType == "all" ? [] : productsSelected
                },
                success: function (response) {
                    console.log("response: ", response);
                    if(response  > 0) {
                        // toastr.success(`Có ${response} sản phẩm đã được tạo`);
                        // if ($.fn.dataTable.isDataTable('#product_datatable')) {
                        //     let dt =  $('#product_datatable').DataTable();
                        //     dt.destroy();
                        //     dt.clear();
                        //     dt.ajax.reload();
                        // }
                        // productsSelected = [];
                        // $("#spinnerSelectedProduct").hide();
                        // $("#exportSelectedProduct").attr("disabled", true); 
                        // $("#backdrop").hide();

                        Swal.fire({
                            type: 'success',
                            title: 'Tạo sản phẩm thành công',
                            text: `Có ${response} sản phẩm đã được tạo`
                        });
                        // setTimeout(function(){
                        //     window.location.reload();
                        // },1000);
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Đã xảy ra lỗi',
                            text: `Có ${response} sản phẩm đã được tạo`
                        });
                    }
                    resolve();
                },
                error: function (data, errorThrown) {
                    console.log(data.responseText);
                    console.log(errorThrown);
                    Swal.fire({
                        type: 'error',
                        title: 'Đã xảy ra lỗi',
                        text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                    });
                    $("#spinnerSelectedProduct").hide();
                    $("#exportSelectedProduct").removeAttr("disabled");
                    $("#backdrop").hide();
                    resolve();
                }
            });
        })
    	
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
                "data": {
                    method : 'findall',
                    // sorted: "sync_date",
                    visibility: '',
                    status: ''
                }
            },
            ordering: false,
            "dom": '<"top"flp<"clear">>rt<"bottom"ip<"clear">>',
            select: "single",
            deferRender: true,
            rowId: 'extn',
            "columns": [
                {
                    "data": format_checkbox,
                    "width": "50px",
                    "class": "align-middle center"
                },
                {
                    "data": "product_id",
                    "className": 'hidden',
                    width: "5px"
                },
                {
                    "data": format_image,
                    "width": "70px",
                    "class": "center"
                },
                {
                    "data": format_name,
                    width: "150px",
                    "class": "align-middle"
                },
                {
                    "data": format_display_price,
                    width: "50px",
                    "class": "align-middle"
                },
                {
                    "data": "total_quantity",
                    "class": "align-middle center",
                    width: "100px"
                },
                {
                    "data": "sync_date",
                    width: "50px",
                    "class": "align-middle"
                }
            ],
            "lengthMenu": [[100, 200, 500], [100, 200, 500]]
        });
    }
    function format_checkbox(data) {
		return `<input type="checkbox" value="${data.product_id}" onchange="choiceProduct(${data.product_id})">`;
    }
    function choiceProduct(productId) {
    	let check = productsSelected.findIndex(p => p == productId);
    	if(check == -1) {
    		productsSelected.push(productId);
    	}  else {
    		productsSelected.splice(check, 1);
    	}
    	// console.log(productsSelected);
    	if(productsSelected.length > 0) {
			$("#exportSelectedProduct span.label").text(`Xuất ${productsSelected.length} sản phẩm đã chọn`).removeAttr("disabled");
            $("#exportSelectedProduct").removeAttr("disabled");
    	} else {
    		$("#exportSelectedProduct span.label").text(`Xuất sản phẩm đã chọn`);
            $("#exportSelectedProduct").attr("disabled", true);
    	}
    }
    function format_name(data) {
        if(!IS_ADMIN || data.link == null || data.link == "") {
            return `${data.name}
                    <br>
                    <small>ID: <strong>${data.product_id}</strong></small>`;
        } else {
            return `
                        <a href="${data.link}" target="_blank">${data.name}</a>
                        <br>
                        <small>ID: <strong>${data.product_id}</strong></small>
                        <br>
                        <div class="form-group d-none " id="edit_category_form_${data.product_id}">
                            <div class="d-inline-block w-100">
                                <label for="select_cat_${data.product_id}">Danh mục:</label>
                                <select class="select-cat form-control ml-2 col-sm-10" id="select_cat_${data.product_id}" data-placeholder="Chọn danh mục" style="width: 100%;"></select>
                            </div>
                            <div class="d-inline-block w-100 mt-2">
                                <button type="button" class="btn btn-danger float-left">Close</button>
                                <button type="button" class="btn btn-primary float-right" id="updateCategory_${data.product_id}">Cập nhật</button>
                            </div>
                        </div>
                   `;
        }
    }
    function format_display_price(data) {
        if(data.displayPrice != data.retail)  {
            return `<p class="mb-0 font-weight-bold">${data.displayPrice}</p>
                <p style="text-decoration: line-through;font-style: italic;">${data.retail}</p>`;
        } else {
            return `<p class="mb-0 font-weight-bold">${data.displayPrice}</p>`;
        }
    }
    function format_image(data) {
        if(data.variant_image) {
            return `<img src='${data.variant_image}' id='thumbnail' class="c-pointer show-more-images" onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"'>`;
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
                return `<img src='${src}' width='100px' id='thumbnail' class="c-pointer show-more-images" onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"'>`;
            } catch (e) {
                return `<img src='${image}' width='100px' id='thumbnail' class="c-pointer show-more-images" onerror='this.onerror=null;this.src=\"<?php Common::image_error()?>\"'>`;
            }
        }
    }
</script>
