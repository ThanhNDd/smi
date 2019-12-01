<?php require_once("../../common/constants.php") ?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Quản lý sản phẩm</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo __PATH__?>dist/img/icon.png"/>
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
    #thumbnail:hover {
        /*width: 100% !important;*/
        /*transform: scale(1.2);
            -webkit-transform: scale(1.2); 
            -moz-transform: scale(1.2); 
            -o-transform: scale(1.2);
            -ms-transform: scale(1.2);
        cursor: pointer; */
    }
  </style> 
</head>  
<?php require ('../../common/header.php'); ?>
<?php require ('../../common/menu.php'); ?>
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Danh sách sản phẩm</h3>
        </div>
        <div class="row col-12" style="display: inline-block;float: right;">
          <section style="display: inline-block;float: right;padding-top: 1.25rem;">
            <button type="button" class="btn btn-success btn-flat product-create">
              <i class="fa fa-plus-circle" aria-hidden="true"></i> Tạo mới
            </button>    
            <button type="button" class="btn btn-info btn-flat print-barcode">
              <i class="fa fa-barcode" aria-hidden="true"></i> In mã vạch  <span class="badge badge-light number-checked">0</span>
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
                <th class="center">*</th>
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
<?php include __PATH__.'src/common/footer.php'; ?>
  <script>
    $(document).ready(function () {
        generate_datatable();

        $(".print-barcode").on("click",function(){
          var data = [];
          $.each($("#example tbody td input[type='checkbox']:checked"), function(){
            var id = $(this).attr("id");
            if(id != "selectall")
            {
              data.push($(this).attr("id")); 
            }
          });
          if(data.length > 0)
          {
            printBarcode(data);
          }
        });
        $(".clearAll").on("click",function(){
          clearAll();
        });

        

    });
    function clearAll()
    {
      $.each($("#example tbody td input[type='checkbox']:checked"), function(){
        $(this).prop("checked",false);
      });
      $(".number-checked").text(0);
    }
    function countAllChecked()
    {
      var count = 0;
      $.each($("#example tbody td input[type='checkbox']:checked"), function(){
        var id = $(this).attr("id");
        if(id != "selectall")
        {
          count++;
        }
      });
      $(".number-checked").text(count);
    }
    function printBarcode(data)
    {
      $(".iframeArea").html("");
      $.ajax({
			url : '<?php echo __PATH__.'src/controller/product/ProductController.php' ?>',
			type : "POST",
			dataType : "json",
			data : {
				method : "print_barcode",
				data : JSON.stringify(data)
			},
			success : function(res){
				var filename = res.fileName;
				$(".iframeArea").html("");
				if(typeof filename !== "underfined" && filename !== "")
				{
    				$(".iframeArea").html('<iframe src="<?php echo __PATH__?>src/controller/product/pdf/'+filename+'" id="barcodeContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
    				// var objFra = document.getElementById('barcodeContent');
        //     		objFra.contentWindow.focus();
        //     		objFra.contentWindow.print();
                window.open("<?php echo __PATH__?>src/controller/product/pdf/"+filename, "_blank");
				}
        // $(".iframeArea").html('<iframe src="<?php echo __PATH__?>src/controller/product/barcode.pdf" id="barcodeContent" frameborder="0" style="border:0;" width="300" height="300"></iframe>');
        // var objFra = document.getElementById('barcodeContent');
        // objFra.contentWindow.focus();
        // objFra.contentWindow.print();
			},
			error : function(data, errorThrown) {
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
        var table = $('#example').DataTable({
            "ajax": '<?php echo __PATH__.'src/controller/product/ProductController.php?type=findall' ?>',
             select:"single",
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
                     width:"5px"
                },
                { 
                    "data": "product_id",
                    "className": 'hidden',
                     width:"5px" 
                },
                { 
                    "data": format_image,
                     width:"70px" 
                },
                { 
                    "data": format_name,
                     width:"150px" 
                },
                // { 
                //     "data": "price",
                //      width:"50px" 
                // },
                // { 
                //     "data": "fee_transport",
                //      width:"70px" 
                // },
                // { 
                //     "data": format_intomoney,
                //      width:"50px" 
                // },
                { 
                    "data": "retail",
                     width:"50px" 
                },
                { 
                    "data": "profit",
                     width:"50px" 
                },
                { 
                    "data": format_action,
                     width:"50px" 
                }      
             ],
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
         });

         // Add event listener for opening and closing details
         $('#example tbody').on('click', '.details-control', function () {
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
                 var variations = row.data().variations;
                 row.child(format_variation(variations, "")).show();
                 tr.addClass('shown');
                 tdi.first().removeClass('fa-plus-square');
                 tdi.first().addClass('fa-minus-square');
             }
         });

         $('#example tbody').on('click', '.del_product', function () {
            var tr = $(this).closest('tr');
            var row_index = tr.index();
            var td = tr.find("td");
            var product_id = $(td[1]).text();
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
                $.ajax({
                  url : '<?php echo __PATH__.'src/controller/product/ProductController.php' ?>',
                  type : "POST",
                  dataType : "json",
                  data : {
                    type : "del_product",
                    product_id : product_id
                  },
                  success : function(res){
                    var response = res.response;
                    console.log(response);
                    if(response == "error") 
                    {
                      Swal.fire({
                        type: 'error',
                        title: 'Đã xảy ra lỗi',
                        text: "Bạn cần xóa biến thể sản phẩm trước khi xóa sản phẩm!"
                      })
                    } else if(response == "successfully")
                    {
                      Swal.fire(
                        'Thành công!',
                        'Sản phẩm đã được xóa thành công.',
                        'success'
                      );
                      hide_loading();
                      table.ajax.reload();
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
              }
            });  
          });

         $('#example tbody').on('click', '.edit_product', function () {
            var tr = $(this).closest('tr');
            var row_index = tr.index();
            var td = tr.find("td");
            var product_id = $(td[1]).text();
            clear();
            open_modal();
            add_new_product();
            $.ajax({
                url : '<?php echo __PATH__.'src/controller/product/ProductController.php' ?>',
                type : "POST",
                dataType : "json",
                data : {
                  type : "edit_product",
                  product_id : product_id
                },
                success : function(res){
                  var arr = res.data;
                  $("#product_id_1").val(arr[0].product_id);
                  $("#p_image_1").val(arr[0].image);
                  $("#p_name_1").val(arr[0].name);
                  $("#p_link_1").val(arr[0].link);
                  $("#p_price_1").val(arr[0].price);
                  $("#p_fee_1").val(arr[0].fee_transport);
                  $("#p_percent_1").val(arr[0].percent);
                  $("#p_retail_1").val(arr[0].retail);
                  $("#p_retail_temp_1").val(arr[0].retail);
                  $("#p_profit_1").text(arr[0].profit);
                  $("#select_type_1").val(arr[0].type).trigger("change");
                  $("#select_cat_1").val(arr[0].category_id).trigger("change");
                  $("#select_size_1").attr("disabled","disabled");
                  $("#select_color_1").attr("disabled","disabled");
                  $("#p_qty_1").attr("disabled","disabled");
                  
                  for(var i=2; i<=10; i++)
                  {
                    $("#p_image_"+i).attr("disabled","disabled");
                    $("#p_name_"+i).attr("disabled","disabled");
                    $("#p_link_"+i).attr("disabled","disabled");
                    $("#p_price_"+i).attr("disabled","disabled");
                    $("#p_fee_"+i).attr("disabled","disabled");
                    $("#p_percent_"+i).val("");
                    $("#p_percent_"+i).attr("disabled","disabled");
                    $("#p_retail_"+i).attr("disabled","disabled");
                    $("#p_retail_temp_"+i).attr("disabled","disabled");
                    $("#p_profit_"+i).attr("disabled","disabled");
                    $("#select_type_"+i).attr("disabled","disabled");
                    $("#select_cat_"+i).attr("disabled","disabled");
                    $("#select_size_"+i).attr("disabled","disabled");
                    $("#select_color_"+i).attr("disabled","disabled");
                    $("#p_qty_"+i).val("");
                    $("#p_qty_"+i).attr("disabled","disabled");
                  }
                  $(".add-new-prod").attr("disabled","disabled");
                  $(".create-new").text("Cập nhật");
                  
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

         // Event click add new row variation
         $('#example tbody').on('click', '.add_variation', function () {
             var tr = $(this).closest('tr');
             var tdi = tr.find("i.fa");
             var row = table.row(tr);
            //  if (!row.child.isShown()) {
                 // Open this row
                var variations = row.data().variations;
                var new_sku = Number(variations[variations.length-1].sku) < 10 ? "0"+variations[variations.length-1].sku : Number(variations[variations.length-1].sku)+1;
                row.child(format_variation(variations, "isNew")).show();
                tr.addClass('shown');
                tdi.first().removeClass('fa-plus-square');
                tdi.first().addClass('fa-minus-square');

                generate_select2(".select-qty-"+new_sku, qty, "");
                generate_select2(".select-color-"+new_sku, colors, "");
                generate_select2(".select-size-"+new_sku, size, "");
            //  }
         });

          // Event click Edit variation
          $('#example tbody').on('click', '.edit_variation', function () {
            var tr = $(this).closest('tr');
            var td = tr.find("td");
            var sku = tr.attr("class");
            var color_text = $(td[2]).text();
            var size_text = $(td[3]).text();
            var size_value = size_text;
            if(size_text.indexOf(" ") >-1) {
              size_value = size_text.split(" ")[0];
            } else {
              size_value = size_text.split("m")[0];
            }
            var qty_text = $(td[4]).text();
            var input_color = '<select class="select-color-'+sku+' form-control w100" id="select_color_'+sku+'"></select>';
            var input_size = '<select class="select-size-'+sku+' form-control w200" id="select_size_'+sku+'"></select>';
            var input_qty = '<select class="select-qty-'+sku+' form-control w100" id="select_qty_'+sku+'"></select>';
            var btn_gr = '<button type="button" class="btn bg-gradient-primary btn-sm update_variation"><i class="fas fa-save"></i> Lưu</button>&nbsp;'+
                          '<button type="button" class="btn bg-gradient-danger btn-sm cancel_variation" "><i class="fas fa-trash"></i> Hủy</button>';
            var gr_input_hidden = '<input type="hidden" id="curr_color_'+sku+'" value="'+color_text+'">' +
                                  '<input type="hidden" id="curr_size_'+sku+'" value="'+size_text+'">' +
                                  '<input type="hidden" id="curr_qty_'+sku+'" value="'+qty_text+'">';
            $(td[2]).html(input_color);
            $(td[3]).html(input_size);
            $(td[4]).html(input_qty);
            $(td[5]).html(btn_gr);
            $(tr).append(gr_input_hidden);
            generate_select2(".select-qty-"+sku, qty, qty_text);
            generate_select2(".select-color-"+sku, colors, color_text);
            generate_select2(".select-size-"+sku, size, size_value);
          });

          // Event click Save new variation
          $('#example tbody').on('click', '.save_variation', function () {
            show_loading();
            var tr = $(this).closest('tr');
            var td = tr.find("td");
            var sku = tr.attr("class");
            var product_id = $(".product-id-"+sku).val();
            var color = $(".select-color-"+sku).val();
            var size = $(".select-size-"+sku).val();
            var qty = $(".select-qty-"+sku).val();
            $.ajax({
                url : '<?php echo __PATH__.'src/controller/product/ProductController.php' ?>',
                type : "POST",
                dataType : "json",
                data : {
                  type : "save_variation",
                  product_id : product_id,
                  sku : sku,
                  color : color,
                  size : size,
                  qty : qty
                },
                success : function(res){
                  Swal.fire(
                    'Thành công!',
                    'Sản phẩm đã được tạo thành công.',
                    'success'
                  );
                  hide_loading();
                  table.ajax.reload();
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

          // Event click update variation
          $('#example tbody').on('click', '.update_variation', function () {
            show_loading();
            var tr = $(this).closest('tr');
            var td = tr.find("td");
            var sku = tr.attr("class");
            var color = $(".select-color-"+sku).val();
            var size = $(".select-size-"+sku).val();
            var txtsize = $(".select-size-"+sku+' option:selected').text();
            var qty = $(".select-qty-"+sku).val();
            $.ajax({
                url : '<?php echo __PATH__.'src/controller/product/ProductController.php' ?>',
                type : "POST",
                dataType : "json",
                data : {
                  type : "update_variation",
                  sku : sku,
                  color : color,
                  size : size,
                  qty : qty
                },
                success : function(res){
                  Swal.fire(
                      'Thành công!',
                      'Cập nhật thành công!',
                      'success'
                    );
                  var btn_gr = '<button type="button" class="btn bg-gradient-info btn-sm edit_variation"><i class="fas fa-edit"></i> Sửa</button>&nbsp;';
                  $(td[2]).html(color);
                  $(td[3]).html(txtsize);
                  $(td[4]).html(qty);
                  $(td[5]).html(btn_gr);
                  hide_loading();
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

          // Event click cancel edit variation
          $('#example tbody').on('click', '.cancel_variation', function () {
            var tr = $(this).closest('tr');
            var td = tr.find("td");
            var sku = tr.attr("class");
            var color = $("#curr_color_"+sku).val();
            var size = $("#curr_size_"+sku).val();
            var qty = $("#curr_qty_"+sku).val();
            var btn_gr = '<button type="button" class="btn bg-gradient-info btn-sm edit_variation"><i class="fas fa-edit"></i> Sửa</button>&nbsp;';
                          // '<button type="button" class="btn bg-gradient-danger btn-sm delete_variation"><i class="fas fa-trash"></i> Xóa</button>';
                          
            $(td[2]).html(color);
            $(td[3]).html(size);
            $(td[4]).html(qty);
            $(td[5]).html(btn_gr);

            $("#curr_color_"+sku).remove();
            $("#curr_size_"+sku).remove();
            $("#curr_qty_"+sku).remove();
          });

          // Event click delete product
          $('#example tbody').on('click', '.delete_variation', function () {
            var tr = $(this).closest('tr');
            var sku = $(tr).attr("class");

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
                  url : '<?php echo __PATH__.'src/controller/product/ProductController.php' ?>',
                  type : "POST",
                  dataType : "json",
                  data : {
                    type : "delete_variation",
                    data : sku
                  },
                  success : function(res){
                    console.log(res);
                    Swal.fire(
                      'Thành công!',
                      'Xóa thành công.',
                      'success'
                    );
                    

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

          $('#example tbody').on('click', '.cancal_add_new', function () {
            var tr = $(this).closest('tr');
            var sku = $(tr).attr("class");

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

          $('input.chk').on('change', function () {
              alert('checkbox clicked'); // it is never shown
              cb = $(this).prop('checked');
              console.log(cb)
          });
    }

    function format_action()
    {
      return '<button type="button" class="btn bg-gradient-success btn-sm add_variation"><i class="fas fa-plus-circle"></i> Thêm</button>&nbsp;'+
      '<button type="button" class="btn bg-gradient-info btn-sm edit_product"><i class="fas fa-edit"></i> Sửa</button>&nbsp;';
      //'<button type="button" class="btn bg-gradient-danger btn-sm del_product" "><i class="fas fa-trash"></i> Xóa</button>';
    }

    function format_intomoney(data)
    {
      var price = replaceComma(data.price);
      var fee = replaceComma(data.fee_transport);
      var into_money = Number(price)+Number(fee);
      if(!isNaN(into_money))
      {
        return formatNumber(into_money);
      } else 
      {
        return "";
      }
      
    }
    function format_name(data)
    {
      return "<a href='"+data.link+"' target='_blank'>"+data.name+"</a>";
    }

    function format_image(data) 
    {
      return "<img src="+data.image+" width='100px' id='thumbnail'>";
    }
    function format_variation(variations, isNew){
        var table = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
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
        for(var i=0; i<variations.length; i++) {
          table += '<tr class="'+variations[i].sku+'">' +
            '<td class="center"><input type="checkbox" id="'+variations[i].sku+'" onclick="check(this)"></td>' +
                '<input type="hidden" class="product-id-'+variations[i].sku+'" value="'+variations[i].product_id+'">' +
                '<td>'+variations[i].sku+'</td>' +
                '<td>'+variations[i].color+'</td>' +
                '<td>'+variations[i].size+'</td>' +
                '<td id="qty">'+variations[i].quantity+'</td>' +
                '<td>' +
                  '<button type="button" class="btn bg-gradient-info btn-sm edit_variation"><i class="fas fa-edit"></i> Sửa</button>&nbsp;'+
                  //'<button type="button" class="btn bg-gradient-danger btn-sm delete_variation"><i class="fas fa-trash"></i> Xóa</button>' +
                '</td>' +
              '</tr>';
        }
        if(isNew === "isNew")
        {
          var new_sku = Number(variations[variations.length-1].sku) < 10 ? "0"+variations[variations.length-1].sku : Number(variations[variations.length-1].sku)+1;
          table += '<tr class="'+new_sku+'">' +
            '<td>'+new_sku+'</td>' +
            '<td><select class="select-color-'+new_sku+' form-control w100" id="select_color_'+new_sku+'"><option value="-1"></option></select></td>' +
            '<td><select class="select-size-'+new_sku+' form-control w100" id="select_size_'+new_sku+'"><option value="-1"></option></select></td>' +
            '<td><select class="select-qty-'+new_sku+' form-control w100" id="select_qty_'+new_sku+'"><option value="-1"></option></select></td>' +
            '<td>' +
              '<button type="button" class="btn bg-gradient-primary btn-sm save_variation"><i class="fas fa-save"></i> Lưu</button>&nbsp;'+
              //'<button type="button" class="btn bg-gradient-danger btn-sm cancal_add_new"><i class="fas fa-trash"></i> Hủy</button>' +
            '</td>' +
            '<input type="hidden" class="product-id-'+new_sku+'" value="'+variations[variations.length-1].product_id+'">' +
          '</tr>';
        }
        table += '</tbody>';
        table += '</table>';  
      return table;         
    }

    function check(e)
    {
      var isCheck = $(e).prop('checked');
      if(isCheck)
      {
        $(e).prop("checked", "checked");
      } 
      else
      {
        $(e).prop("checked", "");
      }
      countAllChecked();
    } 

    function checkAll(e)
    {
      var isCheck = $(e).prop('checked');
      if(isCheck)
      {
        $(e).parent().parent().parent().parent().find('td input:checkbox').prop("checked", "checked");
      } 
      else
      {
        $(e).parent().parent().parent().parent().find('td input:checkbox').prop("checked", "");
      }
      countAllChecked();
    }
    function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    function replaceComma(value)
    {
      return value.replace(/,/g, '');
    }
    function generate_select2(el, data, value)
    {
      $(el).select2({
        data: data
      });
      if(value !== "")
      {
        $(el).val(value).trigger('change');
      }
    } 
    // function delete_variation(variation_id, table)
    // {
    //   Swal.fire({
    //     title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
    //     text: "",
    //     type: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Ok'
    //   }).then((result) => {
    //     if (result.value) {
    //       show_loading();
    //       $.ajax({
    //         url : '<?php echo __PATH__.'src/controller/product/ProductController.php' ?>',
    //         type : "POST",
    //         dataType : "json",
    //         data : {
    //           type : "delete_variation",
    //           variation_id : $variation_id
    //         },
    //         success : function(res){
    //           console.log(res);
    //           Swal.fire(
    //             'Thành công!',
    //             'Sản phẩm đã được xóa thành công.',
    //             'success'
    //           );
              
    //         },
    //         error : function(data, errorThrown) {
    //           console.log(data.responseText);
    //           console.log(errorThrown);
    //           Swal.fire({
    //             type: 'error',
    //             title: 'Đã xảy ra lỗi',
    //             text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
    //           })
    //           hide_loading();
    //         }
    //       });
    //     }
    //   })
    // }
   
  </script>
</body>
</html>
