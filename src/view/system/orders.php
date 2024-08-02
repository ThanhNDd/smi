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
          <a href="<?php Common::getPath() ?>src/view/system/products.php" class="nav-link ">
            Sản phẩm
          </a>
        </li>
        <li class="nav-item">
          <!-- <a class="nav-link" data-toggle="tab" href="#orders">Đơn hàng</a> -->
          <a href="<?php Common::getPath() ?>src/view/system/orders.php" class="nav-link active">
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
    		<button class="btn btn-info m-1 d-inline-flex" disabled id="exportSelected" onclick="exportCustom()">
                <div class="spinner-border mr-2" id="spinnerSelected" style="width: 25px; height: 25px;display: none;"></div> 
                <span class="label">Xuất đơn hàng đã chọn</span>
            </button>
		</div>

        <table id="datatable" class="table table-hovered table-striped">
            <thead>
            <tr>
                <th style="width: 50px;"></th>
                <th>ID</th>
                <th>ID Khách hàng</th>
                <th>Ngày đặt hàng</th>
                <th>Nguồn đặt hàng</th>
                <th>Trạng thái</th>
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
    let ordersSelected = [];
    let URL_CONTROLLER = "<?php Common::getPath() ?>src/controller/system/ExportDataOrdersController.php";
    $(document).ready(function () {
        generate_datatable_orders();
    });

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
                url: URL_CONTROLLER,
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
            text: "Hành động này sẽ xuất tất cả đơn hàng nhưng không bao gồm các đơn hàng đã được xuất trước dó. Bạn có muốn tiếp tục?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then(async (result) => {
            if (result.value) {
                ordersSelected = [];
                await exportOrders("all");
            }
            $("#backdrop").hide();
            $("#spinnerAll").hide();
            $("#exportAll").removeAttr("disabled");
        });
    }

    async function exportCustom() {
        $("#backdrop").show();
        $("#spinnerSelected").show();
        $("#exportSelected").attr("disabled", true); 
        
        await exportOrders("custom");

        $("#spinnerSelected").hide();
        $("#exportSelected").removeAttr("disabled");
        $("#backdrop").hide();
    }

    function exportOrders(exportType) {
    	console.log("exportOrders");
        return new Promise(resolve => {
            $.ajax({
                url: URL_CONTROLLER,
                type: "POST",
                dataType: "json",
                data: {
                    method: "exportOrders",
                    orderIds: exportType == "all" ? [] : ordersSelected,
                },
                success: function (response) {
                    console.log("response: ", response);
                    if(response.numberOrdersProcessed > 0) {
                        // toastr.success(`Có ${response} đơn hàng đã được tạo`);
                        Swal.fire({
                            type: 'success',
                            title: 'Thành công',
                            text: `Đã tạo ${response.numberOrdersProcessed}/${response.numberOrders} đơn hàng`
                        });
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'Không thành công',
                            text: `Đã tạo ${response.numberOrdersProcessed}/${response.numberOrders} đơn hàng`
                        });
                    }
                    // console.log("response.data: ", response.data);
                    // if(response.result && response.result.length > 0) {
                    //     toastr.success('Tạo đơn hàng thành công');
                    //     if ($.fn.dataTable.isDataTable('#datatable')) {
                    //         let dt =  $('#datatable').DataTable();
                    //         dt.destroy();
                    //         dt.clear();
                    //         dt.ajax.reload();
                    //     }
                    //     ordersSelected = [];
                    //     $("#spinnerSelected").hide();
                    //     $("#backdrop").hide();
                    //     $("#exportSelected span.label").text(`Xuất đơn hàng đã chọn`);
                    //     $("#exportSelected").attr("disabled", true);
                    // }
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
                    $("#spinnerSelected").hide();
                    $("#backdrop").hide();
                    $("#exportSelected").removeAttr("disabled");
                    resolve();
                }
            });
        })
    	
    }

    function generate_datatable_orders() {
        if ($.fn.dataTable.isDataTable('#datatable')) {
            let dt =  $('#datatable').DataTable();
            dt.destroy();
            dt.clear();
            dt.ajax.reload();
        }
        $('#datatable').DataTable({
            'ajax': {
                "type": "GET",
                "url": URL_CONTROLLER,
                "data": {
                    method : 'fetchOrders'
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
                    "data": "order_id",
                    "width": "70px",
                    "class": "center"
                },
                {
                    "data": "customer_id",
                    "width": "70px",
                    "class": "center"
                },
                {
                    "data": "order_date",
                    width: "150px",
                    "class": "align-middle"
                },
                {
                    "data": format_source,
                    width: "100px",
                    "class": "align-middle"
                },
                {
                    "data": format_status,
                    width: "100px",
                    "class": "align-middle"
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
    function format_status(data) {
	    let status = data.status;
	    switch (status) {
	        case '0' :
	            return '<span class="badge badge-warning" style="font-weight: normal;">Chưa xử lý</span>';
	        case '1':
	            return '<span class="badge badge-primary" style="font-weight: normal;">Đã gói hàng</span>';
	        case '2':
	            return '<span class="badge badge-info" style="font-weight: normal;">Đã giao</span>';
	        case '3':
	            return '<span class="badge badge-success" style="font-weight: normal;">Hoàn thành</span>';
	        case '4':
	            return '<span class="badge badge-danger" style="font-weight: normal;">Đổi size</span>';
	        case '5':
	            return '<span class="badge badge-secondary" style="font-weight: normal;">Chuyển hoàn</span>';
	        case '6':
	            return '<span class="badge badge-danger" style="font-weight: normal;">Huỷ</span>';
	        case '7':
	            return '<span class="badge badge-warning" style="font-weight: normal;">Giao hàng sau</span>';
	        case '8':
	            return '<span class="badge badge-secondary" style="font-weight: normal;">Đợi hàng về</span>';
	        case '9':
	            return '<span class="badge badge-danger" style="font-weight: normal;">Chờ duyệt hoàn</span>';
	        case '10':
	            return '<span class="badge badge-secondary" style="font-weight: normal;">Đã duyệt hoàn</span>';
	        case '11':
	            return '<span class="badge badge-danger" style="font-weight: normal;">Chờ đổi size</span>';
	        case '12':
	            return '<span class="badge badge-danger" style="font-weight: normal;">Đã đổi size</span>';
	        case '13':
	            return '<span class="badge badge-info" style="font-weight: normal;">Đã tạo đơn</span>';
	        default:
	        	return '';
	    }
	}
    function format_checkbox(data) {
		return `<input type="checkbox" value="${data.order_id}" onchange="choice(${data.order_id})">`;
    }
    function choice(orderId) {
    	let check = ordersSelected.findIndex(o => o == orderId);
    	if(check == -1) {
    		ordersSelected.push(orderId);
    	}  else {
    		ordersSelected.splice(check, 1);
    	}
    	// console.log(ordersSelected);
    	if(ordersSelected.length > 0) {
			$("#exportSelected span.label").text(`Xuất ${ordersSelected.length} đơn hàng đã chọn`).removeAttr("disabled");
            $("#exportSelected").removeAttr("disabled");
    	} else {
    		$("#exportSelected span.label").text(`Xuất đơn hàng đã chọn`);
            $("#exportSelected").attr("disabled", true);
    	}
    }
    function format_source(data) {
    	switch(data.source) {
	    	case "0": 
	    		return `<span class="badge badge-pill badge-warning">Shop</span>`;
	    		break;
	    	case "2": 
	    		return `<span class="badge badge-pill badge-primary">Facebook</span>`;
	    		break;
	    	case "3": 
	    		return `<span class="badge badge-pill badge-danger">Shopee</span>`;
	    		break;
            case "4": 
                return `<span class="badge badge-pill badge-primary">FB TTTE</span>`;
                break;
            case "5": 
                return `<span class="badge badge-pill badge-success">Lazada</span>`;
                break;
            case "6": 
                return `<span class="badge badge-pill badge-info">Zalo</span>`;
                break;
            case "7": 
                return `<span class="badge badge-pill badge-success">Tiki</span>`;
                break;
	    	default: 
	    		return "";
	    		break;
    	}
    }
</script>
