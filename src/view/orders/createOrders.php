<?php require_once("../../common/common.php") ?>
<div class="modal fade" id="create-order">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="overlay d-flex justify-content-center align-items-center">
          <i class="fas fa-2x fa-sync fa-spin"></i>
      </div>
      <div class="modal-header">
        <h4 class="modal-title">Tạo mới đơn hàng Online</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <input type="hidden" class="form-control" id="order_id" value="">
            <input type="hidden" class="form-control" id="customer_id" value="">
            <input type="hidden" class="form-control" id="payment_type" value="">
            <input type="hidden" class="order_type" value="-1" />
            <div class="row">
              <div class="col-4">
                <label>Mã vận đơn</label>
                <input type="text" class="form-control" id="bill_of_lading_no" placeholder="Mã vận đơn" autocomplete="off">
              </div>
              <div class="col-4">
                <label>Phí ship (trả cho đơn vị vận chuyển)</label>
                <input type="text" class="form-control" id="shipping_fee" placeholder="Phí ship trả cho đơn vị vận chuyển" autocomplete="off">
              </div>
              <div class="col-4">
                <label>Đơn vị vận chuyển</label>
                <select class="select-shipping-unit form-control">
                  <option value="Viettel Post" selected="selected">Viettel Post</option>
                </select>
              </div>
              <div class="col-4">
                <label>Họ tên <span style="color:red">*</span></label>
                <input type="text" class="form-control" id="customerName" placeholder="Họ tên" autocomplete="off">
              </div>
              <div class="col-4">
                <label>Số điện thoại</label>
                <input type="number" class="form-control" id="phoneNumber" placeholder="Nhập số điện thoại" min="0">
              </div>
              <div class="col-4">
                <label>Email</label>
                <input type="text" class="form-control" id="email" placeholder="Email" autocomplete="off">
              </div>
              <div class="col-4">
                <label>Tỉnh / Thành phố</label>
                <select class="select-city form-control">
                  <option value="">Lựa chọn</option>
                </select>
              </div>
              <div class="col-4">
                <label>Quận / Huyện</label>
                <select class="select-district form-control">
                  <option value="">Lựa chọn</option>
                </select>
              </div>
              <div class="col-4">
                <label>Phường xã</label>
                <select class="select-village form-control">
                  <option value="">Lựa chọn</option>
                </select>
              </div>
              <div class="col-8">
                <label>Địa chỉ</label>
                <input type="text" class="form-control" id="address" placeholder="Nhập số nhà, thôn xóm ... " autocomplete="off">
              </div>
            </div>
          </div>
           <div class="form-group">
              <input type="hidden" value="0" class="count-row" />
              <div class="row product">
                <div class="w130">
                  <label>Mã sản phẩm</label>
                </div>
                <div class="col-4">
                  <label for="product_name_1">Tên sản phẩm</label>
                </div>
                <input type="hidden" id="variantId_1">
                <div class="w130">
                  <label>Đơn giá</label>
                </div>
                <div class="col-1">
                  <label>Số lượng</label>
                </div>
                <div class="w130">
                  <label>Giảm trừ</label>
                </div>
                <div class="w130">
                  <label>Tổng</label>
                </div>
                <div class="col-1 center">
                  <label>Chọn</label>
                </div>
              </div>
              <div class="form-group product-area">
                
              </div>
            </div>
            
            <div class="form-group total-area">
              <div class="row pd-t-5">
                <div class="col-9 right pd-t-10">
                  <label class="pd-t-5">Tổng tiền hàng</label>
                </div>
                <div class="col-2 right pd-t-10">
                  <label id="total_amount">0</label>
                </div>
              </div>
              <div class="row pd-t-5">
                <div class="col-9 right pd-t-10">
                  <label>Phí ship (KH trả)</label>
                </div>
                <div class="col-2 right pd-t-5">
                  <input type="text" class="form-control" id="shipping" placeholder="Phí ship" autocomplete="off">
                </div>
              </div>
              <div class="row pd-t-5">
                <div class="col-9 right pd-t-10">
                  <label>Chiết khấu</label>
                </div>
                <div class="col-2 right pd-t-5">
                  <input type="text" class="form-control" id="discount" placeholder="Giảm trừ" autocomplete="off">
                </div>
              </div>
              <div class="row pd-t-5">
                <div class="col-9 right pd-t-10">
                  <label>Tổng thanh toán</label>
                </div>
                <div class="col-2 right pd-t-5">
                  <label style="font-size: 23px;color: red;" id="total_checkout">0</label>
                </div>
              </div>
            </div>  
        </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary create-new" >Tạo mới</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  <?php include __PATH__.'src/common/js.php'; ?>
  <script>
    var data_products;
    var flagError = 0;
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    $(document).ready(function () {
      $('.order-create').click(function(){
        reset_data();
        $(".order_type").val(1);//order online
        $("#payment_type").val(1);//transfer
        add_new_product();
        generate_select2_city();
        open_modal();
      });
      $('.order-update').click(function(){
        update_data();
      });

      $('.select-city').on('select2:select', function (e) {
          var data = e.params.data;
          var cityId = data.id;
          generate_select2_district(cityId);
      });
      $('.select-district').on('select2:select', function (e) {
          var data = e.params.data;
          var districtId = data.id;
          generate_select2_village(districtId);
          check_products_list();
      });
      
      $('.create-new').click(function(){
        create_new();
      });
      $("#shipping").change(function(){
        var e = this;
        var val = $(e).val();
        val = replaceComma(val);
        if(isNaN(val)) {
          $(e).addClass("is-invalid");  
          disable_btn_add_new();
        } else {
          $(e).removeClass("is-invalid");
          check_products_list();
          // if(val < 1000)
          // {
          //   if(val.indexOf(".") > 0)
          //   {
          //     val = val.replace(".","");
          //     val = val+"00";
          //   } else {
          //     val = val+"000";
          //   }
          // }
          val = Number(val);
          $(e).val(formatNumber(val));  
          on_change_total();
        }
      });
      $("#discount").change(function(){
        var e = this;
        var val = $(e).val();
        val = replaceComma(val);
        if(isNaN(val)) {
          $(e).addClass("is-invalid");  
          disable_btn_add_new();
        } else {
          $(e).removeClass("is-invalid");
          check_products_list();
          // if(val < 1000)
          // {
          //   if(val.indexOf(".") > 0)
          //   {
          //     val = val.replace(".","");
          //     val = val+"00";
          //   } else {
          //     val = val+"000";
          //   }
          // }
          val = Number(val);
          $(e).val(formatNumber(val));  
          on_change_total();
        }
      });

      $("#email").change(function(){
        var val = $(this).val();
        if(val != "" && !validateEmail(val))
        {
          $(this).addClass("is-invalid");
          disable_btn_add_new();
        } else {
          $(this).removeClass("is-invalid");
          check_products_list();
        }
      });
      $("#shipping_fee").change(function(){
        var e = this;
        var val = $(e).val();
        val = replaceComma(val);
        if(isNaN(val)) {
          $(e).addClass("is-invalid");  
          disable_btn_add_new();
        } else {
          $(e).removeClass("is-invalid");
          check_products_list();
          // if(val < 1000)
          // {
          //   if(val.indexOf(".") > 0)
          //   {
          //     val = val.replace(".","");
          //     val = val+"00";
          //   } else {
          //     val = val+"000";
          //   }
          // }
          val = Number(val);
          $(e).val(formatNumber(val));  
        }
      });
      $(".add-new-prod").on("click", function(){
        $(".add-new-prod").prop("disabled", true);
        add_new_product();
      });

    });
    
    function validate() {
      var count_error = 0;
      var order_type = $('.order_type').val();
      if(order_type == 1) {
        var customerName = $("#customerName").val();
        if(customerName === "")
        {
          $("#customerName").addClass("is-invalid");
          disable_btn_add_new();
          // return false;
          count_error++;
        } else {
          $("#customerName").removeClass("is-invalid");
          check_products_list();
        }
        var phoneNumber = $("#phoneNumber").val();
        if(phoneNumber === "")
        {
          $("#phoneNumber").addClass("is-invalid");
          disable_btn_add_new();
          // return false;
          count_error++;
        } else {
          $("#phoneNumber").removeClass("is-invalid");
          check_products_list();
        }
        var cityId = $(".select-city").val();
        if(cityId === "")
        {
          $(".select-city").addClass("is-invalid");
          disable_btn_add_new();
          // return false;
          count_error++;
        } else {
          $(".select-city").removeClass("is-invalid");
          check_products_list();
          var districtId = $(".select-district").val();
          if(districtId === "")
          {
            $(".select-district").addClass("is-invalid");
            disable_btn_add_new();
            // return false;
            count_error++;
          } else {
            $(".select-district").removeClass("is-invalid");
            check_products_list();
            var villageId = $(".select-village").val();
            if(villageId === "")
            {
              $(".select-village").addClass("is-invalid");
              disable_btn_add_new();
              // return false;
              count_error++;
            } else {
              $(".select-village").removeClass("is-invalid");
              check_products_list();
              var add = $("#address").val();
              if(add === "")
              {
                $("#address").addClass("is-invalid");
                disable_btn_add_new();
                // return false;
                count_error++;
              } else {
                $("#address").removeClass("is-invalid");
                check_products_list();
              }
            }
            
          }
        }
      }
      
      // var rowProductNumber = $(".count-row").val();
      // for(var i=1; i<=rowProductNumber.length; i++)
      // {
      //   var sku = $("#sku_"+i).val();
      //   if(sku !== "") {
      //     var prodId = $("#prod_"+i).val();
      //     if(prodId === "-1") {
      //       $("#prod_"+i).addClass("is-invalid");
      //       // return false;
      //       count_error++;
      //     } else {
      //       $("#prod_"+i).removeClass("is-invalid");
      //       var qty = $("#prodQty_"+i).val();
      //       if(qty === "")
      //       {
      //         $("#prodQty_"+i).addClass("is-invalid");
      //         // return false;
      //         count_error++;
      //       } else {
      //         $("#prodQty_"+i).removeClass("is-invalid");
      //       }  
      //     }
      //   } else {
      //     $("#sku_"+i).addClass("is-invalid");
      //     return;
      //   }
      // }
      if(count_error > 0)
      {
        return false;
      }
      return true; 
    }

    function check_products_list(){
      var rowProductNumber = $(".count-row").val();
      for(var i=1; i<=rowProductNumber; i++)
      {
        var prodId = $("#prod_"+i).val();
        console.log(prodId);
        if(typeof prodId != "undefined" && prodId == "") {
          $("#prod_"+i).focus();
          disable_btn_add_new();
          return;
        }
        $(".add-new-prod").prop("disabled",false);
        enable_btn_add_new();
      }
    }

    function create_new()
    {
      if(!validate())
      {
        return;
      }
      var data = {};
      data["order_type"] = $('.order_type').val();
      data["order_id"] = $("#order_id").val();
      data["customer_id"] = $("#customer_id").val();
      data["bill_of_lading_no"] = $("#bill_of_lading_no").val();
      data["shipping_fee"] = replaceComma($("#shipping_fee").val());
      data["shipping_unit"] = $(".select-shipping-unit").val();
      data["customerName"] = $("#customerName").val();
      data["phoneNumber"] = $("#phoneNumber").val();
      data["email"] = $("#email").val();
      data["cityId"] = $(".select-city").val();
      data["districtId"] = $(".select-district").val();
      data["villageId"] = $(".select-village").val();
      data["address"] = $("#address").val();
      data["shipping"] = replaceComma($("#shipping").val());
      data["discount"] = replaceComma($("#discount").val());
      data["total_amount"] = replaceComma($("#total_amount").text());
      data["total_checkout"] = replaceComma($("#total_checkout").text());
      data["payment_type"] = $("#payment_type").val();
      var rowProductNumber = $(".count-row").val();

      var products = [];
      for(var i=1; i<=rowProductNumber; i++)
      {
        var product = {};
        var sku = $("#sku_"+i).val();
        if(typeof sku !== "undefined" && sku !== "")
        {
          product["sku"] = $("#sku_"+i).val();   
        } else {
          continue;
        }
        
        var detailId = $("#detailId_"+i).val();
        if(typeof detailId !== "undefined" && detailId !== "") {
          product["detail_id"] = $("#detailId_"+i).val();  
        }
        var prodId = $("#prod_"+i).val();
        if(typeof prodId !== "undefined" && prodId !== "") {
          product["product_id"] = $("#prod_"+i).val();  
        }
        var variantId = $("#variantId_"+i).val();
        if(typeof variantId !== "undefined" && variantId !== "")
        {
          product["variant_id"] = $("#variantId_"+i).val();   
        }
        
        var qty = $("#prodQty_"+i).val();
        if(typeof qty !== "undefined" && qty !== "")
        {
          product["quantity"] = $("#prodQty_"+i).val();  
        }
        var price = $("#prodPrice_"+i).val();
        if(typeof price !== "undefined" && price !== "")
        {
          product["price"] = replaceComma($("#prodPrice_"+i).val());  
        }
        var reduce = $("#prodReduce_"+i).val();
        if(typeof reduce !== "undefined" && reduce !== "")
        {
          product["reduce"] = replaceComma($("#prodReduce_"+i).val());  
        }
        products.push(product);
      }
      data["products"] = products;
      console.log(JSON.stringify(data));
      var title = 'Bạn có chắc chắn muốn tạo đơn hàng này?';
      var order_id = $("#order_id").val();
      if(order_id != "underfined" && order_id != "") {
        title = 'Bạn có chắc chắn muốn cập nhật đơn hàng này?';
      }
      Swal.fire({
        title: title,
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
      }).then((result) => {
        if (result.value) {
          $("#create-order .overlay").removeClass("hidden");
          $.ajax({
            dataType : 'json',
            url      : '<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>',
            data : {
              orders : 'new',
              data : JSON.stringify(data)
            },
            type : 'POST',
            success: function(data)
            {
              console.log(data);
              var order_id = $("#order_id").val();
              var msg;
              if(order_id != "underfined" && order_id != "") {
                msg = "Đơn hàng #"+order_id+" đã được cập nhật thành công.!!!";
              } else {
                msg = "Đơn hàng #"+data.order_id+" đã được tạo thành công.!!!";
              }
                toastr.success(msg);
                reset_data();
                $("#create-order .close").click();
                $("#create-order .overlay").addClass("hidden");
                table.ajax.reload();
                get_info_total_checkout($("#startDate").val(), $("#endDate").val());
            },
            error : function (data, errorThrown) {
              console.log(data.responseText);
              console.log(errorThrown);
              Swal.fire({
                type: 'error',
                title: 'Đã xảy ra lỗi',
                text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
              })
              $("#create-order .overlay").addClass("hidden");
            }
          });
          
        }
      })
    }
    function reset_data()
    {
      $(".modal-title").text("Tạo mới đơn hàng");
      $(".create-new").text("Tạo mới");
      $("#payment_type").val("");
      $("#customer_id").val("");
      $("#bill_of_lading_no").val("");
      $("#shipping_fee").val("");
      // $(".select-shipping-unit").val(-1).trigger("change");
      $("#customerName").val("");
      $("#phoneNumber").val("");
      $("#email").val("");
      $(".select-city").val(-1).trigger("change");
      $(".select-district").val(-1).trigger("change");
      $(".select-village").val(-1).trigger("change");
      $("#address").val("");
      $("#shipping").val("");
      $("#discount").val("");
      $("#total_amount").text("");
      $("#total_checkout").text("");
      $(".product-area").html("");
      $('.count-row').val("");
      $('#order_id').val("");
      disable_btn_add_new();
      $("#bill_of_lading_no").prop("disabled", false);
      $("#shipping_fee").prop("disabled", false);
      $("#customerName").prop("disabled", false);
      $("#phoneNumber").prop("disabled", false);
      $("#email").prop("disabled", false);
      $(".select-shipping-unit").prop("disabled", false);
      $(".select-city").prop("disabled", false);
      $(".select-district").prop("disabled", false);
      $(".select-village").prop("disabled", false);
      $("#address").prop("disabled", false);
      $("#shipping").prop("disabled", false);
    }
    function disable_btn_add_new() {
      $(".create-new").prop("disabled", true);
    }
    function enable_btn_add_new() {
      $(".create-new").prop("disabled", false);
    }
    function new_product(e, rowIndex) {
      var val = $(e).parent().parent().find("#sku_"+rowIndex).val();
      if(val == "") {
        $(e).parent().parent().find("#sku_"+rowIndex).focus();
      } else {
        add_new_product();
        $(".add-new-prod").prop("disabled", true);
        disable_btn_add_new();
      }
      
    }
    function add_new_product()
    {
      var noRow = $('.count-row').val();
      noRow = Number(noRow) + 1;
      $('.count-row').val(noRow);
      var content = '<div class="row" id="product-'+noRow+'" style="padding-top: 10px;">' +
                    '<div class="w130">' +
                    '<input type="hidden" class="form-control" id="detailId_'+noRow+'">' +
                    '<input type="hidden" class="form-control" id="prod_'+noRow+'">' +
                    '<input type="text" class="form-control" id="sku_'+noRow+'" placeholder="Nhập mã sản phẩm" onchange="on_change_product_2(this, '+noRow+')" onblur="blur_check(this)" onfocus="onfocus_check(this)">' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<input type="text" class="form-control" id="product_name_'+noRow+'" disabled="disabled">' +
                    '</div>' +
                    '<input type="hidden" id="variantId_'+noRow+'">' +
                    '<div class="w130">' +
                    '<input type="text" class="form-control" id="prodPrice_'+noRow+'" placeholder="0" disabled="disabled" onchange="on_change_qty(\'prodQty_'+noRow+'\', \'prodPrice_'+noRow+'\', \'prodTotal_'+noRow+'\')">' +
                    '</div><div class="col-1">' +
                    '<input type="number" class="form-control" id="prodQty_'+noRow+'" placeholder="0" disabled="disabled"  min="1" onchange="on_change_qty(\'prodQty_'+noRow+'\', \'prodPrice_'+noRow+'\', \'prodTotal_'+noRow+'\', '+noRow+', \'prodReduce_'+noRow+'\')">' +
                    '</div>' +
                    '<div class="w130 mr-2">' + 
                    '<input type="text" class="form-control" id="prodReduce_'+noRow+'" placeholder="0" min="0" disabled="disabled" onchange="on_change_reduce(this, \'prodQty_'+noRow+'\', \'prodPrice_'+noRow+'\', \'prodTotal_'+noRow+'\', '+noRow+')">' +
                    '</div>' +
                    '<div class="w130">' + 
                    '<input type="text" class="form-control" id="prodTotal_'+noRow+'" placeholder="0" min="0" disabled="disabled">' +
                    '</div>' +
                    '<div class="col-1">';
                    if(noRow == 1) {
                      content += '<button type="button" class="btn btn-success form-control add-new-prod" title="Thêm sản phẩm" onclick="new_product(this, '+noRow+');">' +
                                  '<i class="fa fa-plus-circle" aria-hidden="true"></i>' +
                                  '</button>';
                    } else {
                      content += '<button type="button" class="btn btn-danger form-control" onclick="del_product(this, \'product-'+noRow+'\','+noRow+')" title="Xóa sản phẩm">' +
                                  '<i class="fa fa-minus-circle" aria-hidden="true"></i>' +
                                  '</button>';
                    }
                    
                    // '</div>' +
                    content += '</div></div>';
      $(".product-area").append(content);
      $('#sku_'+noRow).focus();
      
      // generate_select2_products('.select-product-'+noRow);
    }

    function on_change_total(rowIndex)
    {
      var total_amount = 0;
      var rowProductNumber = $(".count-row").val();
      for(var i=1; i<=rowProductNumber; i++)
      {
        var prodTotal = $("#prodTotal_"+i).val();
          if(typeof prodTotal !== "undefined" && prodTotal !== "")
          {
            prodTotal = Number(replaceComma(prodTotal));
            total_amount += prodTotal;
          }
      }
      $("#total_amount").text(formatNumber(total_amount));
      var shipping = $("#shipping").val();
      if(shipping !== "")
      {
        shipping  = Number(replaceComma(shipping));
      }
      var discount = $("#discount").val();
      if(discount !== "")
      {
        discount  = Number(replaceComma(discount));
      }
      var total_checkout = total_amount + shipping - discount;
      $("#total_checkout").text(formatNumber(total_checkout));
    }

    function on_change_qty(qtyId, priceId, totalId, rowIndex, reduceId)
    {
      var qty = $("[id="+qtyId+"]").val();
      var price = $("[id="+priceId+"]").val();
      var reduce = $("[id="+reduceId+"]").val();
      var total = Number(qty)*Number(replaceComma(price)) - Number(replaceComma(reduce));
      if(total > 0) {
        $("[id="+totalId+"]").val(formatNumber(total)); 
      } else
      {
        $("[id="+totalId+"]").val(0);
      }
      $("[id="+totalId+"]").trigger("change");
      on_change_total(rowIndex);
    }

    function on_change_reduce(e, qtyId, priceId, totalId, rowIndex) {
        var val = $(e).val();
        if(val.indexOf("%") > -1) {
            val = replacePercent(val);
        } else {
            val = replaceComma(val);
        }
        if(isNaN(val)) {
          $(e).addClass("is-invalid");  
          disable_btn_add_new();
        } else {
          $(e).removeClass("is-invalid");
          check_products_list();
          val = Number(val);
          $(e).val(formatNumber(val));  
          var qty = $("[id="+qtyId+"]").val();
          var price = $("[id="+priceId+"]").val();
          var total = Number(qty)*Number(replaceComma(price)) - Number(val);
          if(total > 0) {
            $("[id="+totalId+"]").val(formatNumber(total)); 
          } else
          {
            $("[id="+totalId+"]").val(0);
          }
          $("[id="+totalId+"]").trigger("change");
          on_change_total(rowIndex);
        }
    }


    function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    function replaceComma(value)
    {
      return value.replace(/,/g, '');
    }
    function replacePercent(value)
    {
        return value.replace(/%/g, '');
    }

    function onfocus_check(e) {
      $(e).removeClass("is-invalid");
    }
    function blur_check(e) {
      if($(e).val() === "") {
        $(e).addClass("is-invalid");
        disable_btn_add_new();
      }
    }
    function on_change_product_2(e, rowIndex) 
    {
      var val = $(e).val();
      var priceId = "prodPrice_"+rowIndex;
      var productName = "product_name_"+rowIndex;
      var prodQty = "prodQty_"+rowIndex;
      var variantId = "variantId_"+rowIndex;
      var totalId = "totalId_"+rowIndex;
      $(e).removeClass("is-invalid");
      $.ajax({
        dataType : "json",
          url      : "<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>",
          data : {
            method : 'find_product_by_sku',
            sku : val
          },
          type : 'POST',
          success: function(data)
          {
            if(data.length > 0) {
              $.each(data, function(k, v){
                var name = v.name +" - "+ v.size + " - " + v.color;
                $("[id=prod_"+rowIndex+"]").val(v.product_id);
                $("[id=sku_"+rowIndex+"]").val(v.sku);
                $("[id="+productName+"]").val(name);
                $("[id="+priceId+"]").val(v.retail);
                $("[id="+variantId+"]").val(v.variant_id);
                $("[id=prodReduce_"+rowIndex+"]").prop("disabled", false);
                if(v.retail.replace(",","") > 0) {
                  var qty = $("[id="+prodQty+"]").val();
                  if(qty == "underfined" || qty == "") {
                    $("[id="+prodQty+"]").val(1);
                  }
                  $("[id="+prodQty+"]").removeAttr("disabled");
                } else {
                  $("[id="+prodQty+"]").val(0);
                  $("[id="+prodQty+"]").attr("disabled", "disabled");
                }
                $("[id="+prodQty+"]").trigger("change");
                on_change_total(rowIndex); 
                $(".add-new-prod").prop("disabled", false);
                check_products_list();
              });
            } else {
              $(e).addClass("is-invalid");
              disable_btn_add_new();
            }
          },
          error : function (data, errorThrown) {
            console.log(data.responseText);
            console.log(errorThrown);
            $(e).addClass("is-invalid");
            disable_btn_add_new();
          }
      });
    }

    function on_change_product(prodId)
    {
      var no = prodId.split("_");
      var priceId = "prodPrice_"+no[1];
      var prodQty = "prodQty_"+no[1];
      var variantId = "variantId_"+no[1];
      var totalId = "totalId_"+no[1];
      $("[id='"+prodId+"']").on('select2:select', function (e) {
          var data = e.params.data;
          $("[id="+priceId+"]").val(data.price);
          $("[id="+variantId+"]").val(data.variant_id);
          if(data.price.replace(",","") > 0) {
            $("[id="+prodQty+"]").val(1);
            $("[id="+prodQty+"]").removeAttr("disabled");
          } else {
            $("[id="+prodQty+"]").val(0);
            $("[id="+prodQty+"]").attr("disabled", "disabled");
          }
          $("[id="+prodQty+"]").trigger("change");
          // $("[id="+totalId+"]").trigger("change");
          on_change_total(); 
      });
    }

    function del_product(e, p, rowIndex)
    {
      var sku = $("#sku_"+rowIndex).val();
      if(sku != "") {
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
            $(e).closest("[id='"+p+"']").remove();  
            toastr.success('Sản phẩm đã được xóa thành công.');
            on_change_total(rowIndex);
            check_products_list();
          }
        })
      } else {
        $(e).closest("[id='"+p+"']").remove();  
        // $(".add-new-prod").prop("disabled", false);
        check_products_list();
      }
    }

    function open_modal() {
        $('#create-order').modal({
          backdrop : 'static',
          keyboard : false,
          show: true
        }); 
    }

    function generate_select2_city(city_id)
    {
      $("#create-order .overlay").removeClass("hidden");
      $.ajax({
          dataType : "json",
          url      : "<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>",
          data : {
            orders : 'loadDataCity'
          },
          type : 'GET',
          success: function(data)
          {
            $('.select-city').select2({
              placeholder: {
                id: '-1', // the value of the option
                text: 'Select an option'
              },
              data: data.results,
              theme: 'bootstrap4',
            });        
            if(city_id !== "underfined" && city_id !== "") {
              $(".select-city").val(city_id).trigger("change");
            }
            $("#create-order .overlay").addClass("hidden");
          },
          error : function (data, errorThrown) {
            console.log(data.responseText);
            console.log(errorThrown);
            $("#create-order .overlay").addClass("hidden");
          }
      });
    }

    function generate_select2_district(cityId)
    {
      $("#create-order .overlay").removeClass("hidden");
      $('.select-district').empty();
      $.ajax({
          dataType : "json",
          url      : "<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>",
          data : {
            orders : 'loadDataDistrict',
            cityId : cityId
          },
          type : 'GET',
          success: function(data)
          {
            $('.select-district').select2({
              placeholder: {
                id: '-1', // the value of the option
                text: 'Select an option'
              },
              data: data.results,
              theme: 'bootstrap4',
            });        
            $("#create-order .overlay").addClass("hidden");
          },
          error : function (data, errorThrown) {
            console.log(data.responseText);
            console.log(errorThrown);
            $("#create-order .overlay").addClass("hidden");
          }
      });
    }

    function generate_select2_village(districtId)
    {
      $("#create-order .overlay").removeClass("hidden");
      $('.select-village').empty();
      $.ajax({
          dataType : "json",
          url      : "<?php echo __PATH__.'src/controller/orders/OrderController.php' ?>",
          data : {
            orders : 'loadDataVillage',
            districtId : districtId
          },
          type : 'GET',
          success: function(data)
          {
            $('.select-village').select2({
              placeholder: {
                id: '-1', // the value of the option
                text: 'Select an option'
              },
              data: data.results,
              theme: 'bootstrap4',
            });        
            $("#create-order .overlay").addClass("hidden");
          },
          error : function (data, errorThrown) {
            console.log(data.responseText);
            console.log(errorThrown);
            $("#create-order .overlay").addClass("hidden");
          }
      });
    }

    function generate_select2_products(el)
    {
      // $.getJSON("<?php //echo __PATH__.'src/controller/orders/products.json' ?>",function(data){
        $(el).select2({
          data: data_products.results,
          theme: 'bootstrap4',
        });     
      // });
    }
  </script>