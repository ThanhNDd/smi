<?php require_once("../../common/constants.php") ?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo __PATH__?>dist/img/icon.png"/>
  <title>Quản lý đơn hàng</title>
  <?php require ('../../common/css.php'); ?>
  <?php require ('../../common/js.php'); ?>
  <style>
  
    td.details-control {
      text-align:center;
      color:forestgreen;
      cursor: pointer;
    }
    tr.shown td.details-control {
      text-align:center; 
      color:red;
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
  </style>
</head>  
<?php require ('../../common/header.php'); ?>
<?php require ('../../common/menu.php'); ?>
<section class="content">
  <div class="row pt-2">
    <div class="col-8">
      <div class="card">
        <div class="card-header border-transparent pb-0">
          <div class="form-group col-md-4 float-left mb-0">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control float-left" id="reservation">
              </div>
              <!-- /.input group -->
            </div>
            <div class="float-right">
              <a href="javascript:void(0)" class="btn btn-sm btn-info float-left order-create">Tạo mới</a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pt-0">
          <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th>Mã đơn hàng</th>
                  <!-- <th>Khách hàng</th> -->
                  <!-- <th>Số điện thoại</th>
                  <th>Địa chỉ</th> -->
                  <!-- <th class="right">Phí ship</th>
                  <th class="right">Chiết khấu</th> -->
                  <th class="right">Tổng tiền</th>
                  <th class="center">Ngày mua hàng</th>
                  <th class="left">Loại đơn</th>
                  <th class="left">Thanh toán</th>
                  <th class="left">Hành động</th>
                </tr>
              </thead>
            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <div class="col-4">
      <div class="card">
        <div class="card-body">
          <div class="col-12 col-sm-6 col-md-12">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dollar-sign"></i></span>
              <div class="info-box-content col-12 row">
                <div class="col-8">
                  <span class="info-box-text">Tổng tiền</span>
                  <span class="info-box-number">
                    <h5 class="total_money">
                      <small>đ</small>
                    </h5>
                  </span>
                </div>
                <div class="col-4">
                  <h1 class="display-5 text-danger text-right total_orders"></h1>
                </div>
              </div>
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-12">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-store"></i></span>
              <div class="info-box-content col-12 row">
                <div class="col-8">
                  <span class="info-box-text">Shop</span>
                  <span class="info-box-number">
                    <h5 class="total_on_shop">
                      <small>đ</small>
                    </h5>
                    
                  </span>
                </div>
                <div class="col-4">
                  <h1 class="display-5 text-right count_on_shop">12</h1>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>
          <div class="col-12 col-sm-6 col-md-12">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-globe"></i></span>
              <div class="info-box-content col-12 row">
                <div class="col-8">
                  <span class="info-box-text">Online</span>
                  <span class="info-box-number">
                    <h5 class="total_online">
                      <small>đ</small>
                    </h5>
                  </span>
                </div>
                <div class="col-4">
                  <h1 class="display-5 text-right count_online"></h1>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>      
        </div>      
      </div>
      <div class="card">
        <div class="card-body">
          <div class="col-12 col-sm-6 col-md-12">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="far fa-money-bill-alt"></i></span>
              <div class="info-box-content">
                  <span class="info-box-text">Tiền mặt</span>
                  <span class="info-box-number">
                    <h5 class="total_cash">
                      <small>đ</small>
                    </h5>
                  </span>
              </div>
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-12">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-credit-card"></i></span>
              <div class="info-box-content">
                  <span class="info-box-text">Chuyển khoản</span>
                  <span class="info-box-number">
                    <h5 class="total_transfer">
                      <small>đ</small>
                    </h5>
                    
                  </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>      
      </div>
    </div>
</section>
<div class="iframeArea hidden"></div>
    <!-- /.content -->
<?php include 'createOrders.php'; ?>
<input type="hidden" id="startDate">
<input type="hidden" id="endDate">
</div>
<?php include __PATH__.'src/common/footer.php'; ?>
  <script>
    $(document).ready(function () {
        // set title for page
        set_title("Danh sách đơn hàng");

        var currentDate = new Date()
        var day = currentDate.getDate()
        var month = currentDate.getMonth() + 1
        var year = currentDate.getFullYear()
        var start_date = year + "-" + month + "-" + day;
        var end_date = year + "-" + month + "-" + day;
        $("#startDate").val(start_date);
        $("#endDate").val(end_date);
        generate_datatable();
        get_info_total_checkout(start_date, end_date);

        //Date range picker
      $('#reservation').daterangepicker({
          dateFormat: 'dd/MM/yyyy'
      }, function(start, end, label) {
        var start_date = start.format('YYYY-MM-DD');
        var end_date = end.format('YYYY-MM-DD');
        $("#startDate").val(start_date);
        $("#endDate").val(end_date);
        generate_datatable();
        get_info_total_checkout(start_date, end_date);
      });
    });
    var table;
    function generate_datatable() {
      if ( $.fn.dataTable.isDataTable('#example') ) {
        table.destroy();
        table.clear();
        table.ajax.reload();
      }
        table = $('#example').DataTable({
            'ajax': {
              "type"   : "GET",
              "url"    : "<?php echo __PATH__.'src/controller/orders/OrderController.php'?>",
              "data"   : function( d ) {
                d.method = 'find_all';
                d.start_date = $("#startDate").val();
                d.end_date = $("#endDate").val();
              }
            },
            scrollY:        '50vh',
            scrollCollapse: true,
            "language": {
              "emptyTable": "Không có dữ liệu"
            },
             select:"single",
             "columns": [
                 {
                     "className": 'details-control',
                     "orderable": false,
                     "data": null,
                     "defaultContent": '',
                     "render": function () {
                         return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                     },
                     width:"5px"
                },
                { 
                    "data": "order_id",
                     width:"30px",
                }
                ,
                // { 
                //     "data": format_customer_name,
                //      width:"150px" 
                // }
                // ,
                // { 
                //     "data": "phone",
                //      width:"70px" 
                // },
                // { 
                //     "data": "address",
                //      width:"100px",
                //      class: 'right'
                // }
                // ,
                // { 
                //     "data": "shipping",
                //      width:"50px",
                //      class: 'right'
                // }
                // ,
                // { 
                //     "data": "discount",
                //      width:"50px"  ,
                //      class: 'right'
                // },
                { 
                    "data": "total_checkout",
                     width:"50px"  ,
                     class: 'right'
                },
                { 
                    "data": "created_date",
                     width:"70px"  ,
                     class: 'center'
                },
                { 
                    "data": format_type,
                     width:"30px" 
                },
                { 
                    "data": format_payment,
                     width:"30px" 
                },
                { 
                    "data": format_action,
                     width:"50px" 
                }     
             ],
            "lengthMenu": [[50, 100, -1], [50, 100, "All"]]
         });
         
         // Add event listener for opening and closing details
         $('#example tbody').off('click').on('click', '.details-control', function (event) {
             var tr = $(this).closest('tr');
             var tdi = tr.find("i.fa");
             var row = table.row(tr);
             if (row.child.isShown()) {
                 // This row is already open - close it
                 row.child.hide();
                 tr.removeClass('shown');
                 tdi.first().removeClass('fa-minus-square');
                 tdi.first().addClass('fa-plus-square');
             }
             else {
                 // Open this row
                 row.child(format_order_detail(row.data())).show();
                 tr.addClass('shown');
                 tdi.first().removeClass('fa-plus-square');
                 tdi.first().addClass('fa-minus-square');
             }
             event.preventDefault();
         });

         
         $('#example tbody').on('click', '.print_receipt', function () {
            show_loading();
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var order_id = row.data().order_id;
            console.log(order_id);
            $.ajax({
                url : '<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>',
                type : "POST",
                dataType : "json",
                data : {
                  method : "print_receipt",
                  order_id : order_id
                },
                success : function(res){
                  var filename = res.fileName;
                  $(".iframeArea").html("");
                  if(typeof filename !== "underfined" && filename !== "")
                  {
                      $(".iframeArea").html('<iframe src="<?php echo __PATH__?>src/controller/orders/pdf/'+filename+'" id="receiptContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
                      var objFra = document.getElementById('receiptContent');
                         objFra.contentWindow.focus();
                         objFra.contentWindow.print();
                          // window.open("<?php echo __PATH__?>src/controller/product/pdf/"+filename, "_blank");
                  }
                },
                error : function(data, errorThrown) {
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

         $('#example tbody').on('click', '.delete_order', function () {
          Swal.fire({
            title: 'Bạn có chắc chắn muốn xoá đơn hàng này?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
          }).then((result) => {
            if (result.value) {
                show_loading();
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var order_id = row.data().order_id;
                $.ajax({
                    url : '<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>',
                    type : "POST",
                    dataType : "json",
                    data : {
                      method : "delete_order",
                      order_id : order_id
                    },
                    success : function(res){
                      Swal.fire(
                        'Thành công!',
                        'Đơn hàng đã được xoá thành công. Nếu cần khôi phục lại, hãy liên hệ quản trị hệ thống.',
                        'success'
                      ).then((result) => {
                          table.ajax.reload();
                          get_info_total_checkout($("#startDate").val(), $("#endDate").val());
                      });
                    },
                    error : function(data, errorThrown) {
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


    function format_order_detail(data){
        var details = data.details;
        var table = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
        table += '<thead>' +
                    '<tr>' +
                        '<th>Mã</th>' +
                        '<th>Tên</th>' +
                        '<th>Số lượng</th>' +
                        '<th class="right">Giá</th>' +
                        '<th class="right">Giảm trừ</th>' +
                        '<th class="right">Thành tiền</th>' +
                  '</tr>' +
                '</thead>';
        for(var i=0; i<details.length; i++) {
          table += '<tr>' +
                '<input type="hidden" id="product_id_'+i+'" value="'+details[i].product_id+'"/>' +
                '<input type="hidden" id="variant_id_'+i+'" value="'+details[i].variant_id+'"/>' +
                '<td>'+details[i].sku+'</td>' +
                '<td>'+details[i].product_name+'</td>' +
                '<td>'+details[i].quantity+'</td>' +
                '<td class="right">'+details[i].price+'&nbsp;</td>' +
                '<td class="right">'+details[i].reduce+'&nbsp;</td>' +
                '<td class="right">'+details[i].intoMoney+'&nbsp;</td>' +
              '</tr>';
        }
        table += '</table>';  
      return table;         
    }
    
    function format_customer_name(data){
         if(data.customer_name == "" || data.customer_name  == null)
         {
           return "Khách lẻ";
         } else {
           return "<a href='javascript:void(0)'>"+data.customer_name+"</a>";
         }
    }

    function format_action(data) {
      var content = '';
      if(data.type == 1) {
        content += '<a href="javascript:void(0);" class="print_receipt mr-1 text-info" title="In hoá đơn"><i class="fa fa-print"></i></a>';
      }
      // content += '<a href="javascript:void(0);" class="edit_order mr-1 text-primary" title="Sửa đơn hàng"><i class="fa fa-edit"></i></a>';
      content += '<a href="javascript:void(0);" class="delete_order mr-1 text-danger" title="Xoá đơn hàng"><i class="fa fa-trash"></i></a>';
      return content;
    }
    
    function format_type(data) {
        var type = data.type;
        switch(type) {
        case '0' :
          return '<span class="badge badge-warning">Shop</span>';
          break;
        case '1':
          return '<span class="badge badge-success">Online</span>';
          break;
        default:
          return '';
          break;
      }
    }
    function format_payment(data) {
        var type = data.payment_type;
        switch(type) {
        case '0' :
          return '<span class="badge badge-info">Tiền mặt</span>';
          break;
        case '1':
          return '<span class="badge badge-success">Chuyển khoản</span>';
          break;
        case '2':
          return '<span class="badge badge-warning">Nợ</span>';
          break;
        default:
          return '';
          break;
      }
    }
    function format_status(data) {
      if(data.status === null)
      {
        return;
      }
      var status = data.status;
      switch(status) {
        case '0' :
          return '<span class="badge badge-warning">Đang đợi</span>';
          break;
        case '1':
          return '<span class="badge badge-primary">Đang xử lý</span>';
          break;
        case '2':
          return '<span class="badge badge-info">Tạm giữ</span>';
          break;
        case '3':
          return '<span class="badge badge-success">Thành công</span>';
          break;
        case '4':
          return '<span class="badge badge-secondary">Đã hủy</span>';
          break;
        case '5':
          return '<span class="badge badge-danger">Thất bại</span>';
          break;
        default:
          break;
      }
    }

    // function order_search(start_date, end_date)
    // {
    //   show_loading();
      
    //   $.ajax({
    //       url : '<?php //echo __PATH__.'src/controller/orders/OrderController.php' ?>',
    //       type : "POST",
    //       dataType : "json",
    //       data : {
    //         method : "find_all",
    //         start_date : start_date,
    //         end_date : end_date
    //       },
    //       success : function(res){
            
    //       },
    //       error : function(data, errorThrown) {
    //         console.log(data.responseText);
    //         console.log(errorThrown);
    //         Swal.fire({
    //           type: 'error',
    //           title: 'Đã xảy ra lỗi',
    //           text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
    //         })
    //         hide_loading();
    //       }
    //     }); 
    // }

    function get_info_total_checkout(start_date, end_date)
    { 
      $.ajax({
          url : '<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>',
          type : "POST",
          dataType : "json",
          data : {
            method : "get_info_total_checkout",
            start_date : start_date,
            end_date : end_date
          },
          success : function(res){
              $(".total_money").html(res.total_checkout + " <small>đ</small>");
              $(".total_orders").html(res.count_total);
              $(".total_on_shop").html(res.total_on_shop + " <small>đ</small>");
              $(".count_on_shop").html(res.count_on_shop);
              $(".total_online").html(res.total_online + " <small>đ</small>");
              $(".count_online").html(res.count_online);
              $(".total_cash").html(res.total_cash + " <small>đ</small>");
              $(".total_transfer").html(res.total_transfer + " <small>đ</small>");
          },
          error : function(data, errorThrown) {
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

    // function get_order_detail_by_order_id(order_id)
    // { 
    //   $.ajax({
    //       url : '<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>',
    //       type : "POST",
    //       dataType : "json",
    //       data : {
    //         method : "get_order_detail_by_order_id",
    //         order_id : order_id
    //       },
    //       success : function(res){
    //           var table = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
    //           table += '<thead>' +
    //                       '<tr>' +
    //                           '<th>Mã</th>' +
    //                           '<th>Tên</th>' +
    //                           '<th>Số lượng</th>' +
    //                           '<th class="right">Giá</th>' +
    //                           '<th class="right">Giảm trừ</th>' +
    //                           '<th class="right">Thành tiền</th>' +
    //                     '</tr>' +
    //                   '</thead>';
    //                   $.each(res, function(key, value){
    //                     table += '<tr>' +
    //                         '<input type="hidden" id="product_id_'+i+'" value="'+details[i].product_id+'"/>' +
    //                         '<input type="hidden" id="variant_id_'+i+'" value="'+details[i].variant_id+'"/>' +
    //                         '<td>'+details[i].sku+'</td>' +
    //                         '<td>'+details[i].product_name+'</td>' +
    //                         '<td>'+details[i].quantity+'</td>' +
    //                         '<td class="right">'+details[i].price+'&nbsp;</td>' +
    //                         '<td class="right">'+details[i].reduce+'&nbsp;</td>' +
    //                         '<td class="right">'+details[i].intoMoney+'&nbsp;</td>' +
    //                       '</tr>';
    //                   }); 
    //           table += '</table>';  
    //           return table;   
    //       },
    //       error : function(data, errorThrown) {
    //         console.log(data.responseText);
    //         console.log(errorThrown);
    //         Swal.fire({
    //           type: 'error',
    //           title: 'Đã xảy ra lỗi',
    //           text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
    //         })
    //         hide_loading();
    //       }
    //     }); 
    // }

    function show_loading()
    {
      $("#create-product .overlay").removeClass("hidden");
    }
    function hide_loading()
    {
      $("#create-product .overlay").addClass("hidden");
    }
    function update_data() {
        $(".loading").removeClass("hidden");
        $.ajax({
            url : '<?php echo __PATH__."src/controller/orders/data.php" ?>',
            dataType : "json",
            data : {
              orders: 'update'
            },
            type : 'GET',
            success : function (res) {
                alert("Cập nhật dữ liệu thành công!");
                // window.location.reload();
            },
            error : function (data, errorThrown) {
              console.log(data.responseText);
              alert("Đã có lỗi xảy ra");
              $(".loading").addClass("hidden");
            }
        });
    }
   
  </script>
</body>
</html>
