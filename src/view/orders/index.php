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
  <div class="row">
    <div class="col-12">
      <div class="card">
        <!-- <div class="card-header">
          <h3 class="card-title">Danh sách đơn hàng</h3>
        </div> -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="form-group col-md-12 mb-0">
          <!-- <section class="form-group"> -->
            <div class="form-group col-md-3 float-left mb-0">
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
              <button type="button" class="btn btn-success btn-flat order-create">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Tạo mới
              </button>   
            </div>
            <!-- <button type="button" class="btn btn-info btn-flat order-update">
              <i class="fas fa-sync-alt"></i> Cập nhật
            </button> -->            
          <!-- </section> -->
        </div>
        </nav>
        
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th></th>
                <th class="hidden">ID</th>
                <th>Khách hàng</th>
                <!-- <th>Số điện thoại</th>
                <th>Địa chỉ</th> -->
                <th class="right">Phí ship</th>
                <th class="right">Chiết khấu</th>
                <th class="right">Tổng tiền</th>
                <th class="center">Ngày mua hàng</th>
                <th class="left">Loại đơn</th>
                <!-- <th class="left">Trạng thái</th> -->
                <th class="left">Hành động</th>
              </tr>
            </thead>
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

        //Date range picker
      $('#reservation').daterangepicker({
          dateFormat: 'dd/MM/yyyy'
      }, function(start, end, label) {
        var start_date = start.format('YYYY-MM-DD');
        var end_date = end.format('YYYY-MM-DD');
        $("#startDate").val(start_date);
        $("#endDate").val(end_date);
        generate_datatable();
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

            // destroy: true,
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
                     width:"70px",
                     class: 'hidden'
                },
                { 
                    "data": format_customer_name,
                     width:"150px" 
                }
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
                ,
                { 
                    "data": "shipping",
                     width:"50px",
                     class: 'right'
                }
                ,
                { 
                    "data": "discount",
                     width:"50px"  ,
                     class: 'right'
                },
                { 
                    "data": "total_checkout",
                     width:"50px"  ,
                     class: 'right'
                },
                { 
                    "data": "created_date",
                     width:"80px"  ,
                     class: 'center'
                },
                { 
                    "data": format_type,
                     width:"80px" 
                },
                // { 
                //     "data": format_status,
                //      width:"80px" 
                // },
                { 
                    "data": format_print_receipt,
                     width:"30px" 
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

    function format_print_receipt(data) {
      if(data.type == 1) {
        return '<button type="button" class="btn btn-secondary print_receipt" title="In hoá đơn"><i class="fa fa-print"></i></button>';

      } else {
        return "";
      }
    }
    
    function format_type(data) {
        var type = data.type;
        switch(type) {
        case '0' :
          return '<span class="badge badge-warning">Shop</span>';
          break;
        case '1':
          return '<span class="badge badge-info">Online</span>';
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

    function order_search(start_date, end_date)
    {
      show_loading();
      
      $.ajax({
          url : '<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>',
          type : "POST",
          dataType : "json",
          data : {
            method : "find_all",
            start_date : start_date,
            end_date : end_date
          },
          success : function(res){
            
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
