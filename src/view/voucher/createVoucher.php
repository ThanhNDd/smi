
<div class="modal fade" id="create-voucher">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="overlay d-flex justify-content-center align-items-center">
          <i class="fas fa-2x fa-sync fa-spin"></i>
      </div>
      <div class="modal-header">
        <h4 class="modal-title">Tạo mới mã giảm giá</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row header-column">
            <div class="w30 center">
              <label>Stt</label>
            </div>
            <div class="pd-l-5 pd-r-5 w110">
              <label>Hình ảnh<span style="color:red">*</span></label>
            </div>
            <div class="pd-l-5 pd-r-5 w150">
              <label>Tên sản phẩm<span style="color:red">*</span></label>
            </div>
            <div class="pd-l-5 pd-r-5 w130">
              <label>Link sản phẩm</label>
            </div>
            <div class="pd-l-5 pd-r-5 w120">
              <label>Size<span style="color:red">*</span></label>
            </div>
            <div class="pd-l-5 pd-r-5 w120">
              <label>Màu sắc<span style="color:red">*</span></label>
            </div>
            <div class="pd-l-5 pd-r-5 w50">
              <label>SL<span style="color:red">*</span></label>
            </div>
            <div class="pd-l-5 pd-r-5 w100">
              <label>Giá nhập<span style="color:red">*</span></label>
            </div>
            <div class="pd-l-5 pd-r-5 w120">
              <label>Phí vận chuyển</label>
            </div>
            <div class="pd-l-5 pd-r-5 w70 center">
              <label>%</label>
            </div>
            <div class="pd-l-5 pd-r-5 w110">
              <label>Giá bán lẻ</label>
            </div>
            <div class="pd-l-5 pd-r-5 w70 center">
              <label>*</label>
            </div>
            <div class="pd-l-5 pd-r-5 w100 center">
              <label>Phân loại</label>
            </div>
            <div class="pd-l-5 pd-r-5 w130 center">
              <label>Danh mục</label>
            </div>
          </div>
          <input type="hidden" value="0" class="count-row" />
          <div class="form-group product-area"></div>
        </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success form-control add-new-prod w80" title="Thêm 10 bản ghi">
          <i class="fa fa-plus-circle" aria-hidden="true"> </i>
        </button>
        <button type="button" class="btn btn-primary create-new">Tạo mới</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  <?php include __PATH__.'src/common/js.php'; ?>
  <script>
    var flagError = 0;
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    
    $(document).ready(function () {
      $('.voucher-create').click(function(){
        clear();
        open_modal();
        add_new_product();
      });
      
      $('.add-new-prod').click(function(){
        add_new_product();
      });
      
      $('.create-new').click(function(){
        create_new();
      });
      $('#create-product').on('hidden.bs.modal', function () {
        location.reload();
        })
    });


    function open_modal() {
        $('#create-voucher').modal({
          backdrop : 'static',
          keyboard : false,
          show: true
        }); 
    }

    function reset_form()
    {
        clear();
        add_new_product();
    }

    function clear()
    {
      $('.count-row').val(0);
      $(".product-area").html("");
    }

    function add_new_product()
    {
      show_loading();
      var noRow = $('.count-row').val();
      for($i=0; $i<10; $i++) {
        noRow = Number(noRow) + 1;
        $('.count-row').val(noRow);
        var content = '<div class="row" id="product-'+noRow+'" row-index="'+noRow+'" style="padding-top: 10px;">' +
                        '<input type="hidden" id="product_id_'+noRow+'">'+
                        '<div class="w30 center">' +
                          '<span class="lineNo">'+noRow+'</span>' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w110">'+
                          '<input type="text" class="form-control" id="p_image_'+noRow+'">' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w150">' +
                          '<input type="text" class="form-control" id="p_name_'+noRow+'">' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w130">' +
                          '<input type="text" class="form-control" id="p_link_'+noRow+'">' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w120">' +
                          '<select class="select-size-'+noRow+' js-states form-control" id="select_size_'+noRow+'" multiple="multiple"></select>' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w120">' +
                          '<select class="select-color-'+noRow+' js-states form-control" id="select_color_'+noRow+'" multiple="multiple"></select>' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w50">' +
                          '<input type="text" class="form-control" id="p_qty_'+noRow+'" min="1" value="1">' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w100">' +
                          '<input type="text" class="form-control" id="p_price_'+noRow+'" min="1" onchange="onchange_price(this)">' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w120">' +
                          '<input type="text" class="form-control" id="p_fee_'+noRow+'" onchange="onchange_price(this)">' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w70 center">' +
                          '<input type="text" class="form-control" id="p_percent_'+noRow+'" value="80" onchange="onchange_percent(this)">' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w70 center hidden">' +
                          '<input type="text" class="form-control" id="p_retail_temp_'+noRow+'" onchange="onchange_retail_tmp(this)">' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w110">' +
                          '<input type="text" class="form-control" id="p_retail_'+noRow+'" onchange="onchange_retail(this)">' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 pd-t-5 w70">' +
                          '<span id="p_profit_'+noRow+'"></span>' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w100">' +
                          '<select class="select-type-'+noRow+' form-control" id="select_type_'+noRow+'"></select>' +
                        '</div>' +
                        '<div class="pd-l-5 pd-r-5 w130">' +
                          '<select class="select-cat-'+noRow+' form-control" id="select_cat_'+noRow+'"></select>' +
                        '</div>' +
                      '</div>';
        $(".product-area").append(content);
        generate_select2_size('.select-size-'+noRow);
        generate_select2_colors('.select-color-'+noRow);
        generate_select2_types('.select-type-'+noRow);
        generate_select2_cats('.select-cat-'+noRow);
      }
      hide_loading();
    }

    function generate_select2_size(el)
    {
        $(el).select2({
          data: size,
          theme: 'bootstrap4',
        });     
    }
    function generate_select2_colors(el)
    {
        $(el).select2({
          data: colors,
          theme: 'bootstrap4',
        });     
    }
    function generate_select2_types(el)
    {
        $(el).select2({
          data: types,
          theme: 'bootstrap4',
        });     
    }
    function generate_select2_cats(el)
    {
        $(el).select2({
          data: cats,
          theme: 'bootstrap4',
        });     
    }

    function onchange_retail_tmp(e)
    {
      var rowIndex = $(e).parent().parent().attr("row-index");
      var percent = $("[id=p_percent_"+rowIndex+"]").val();
      var price = $("[id=p_price_"+rowIndex+"]").val();
      price = replaceComma(price);
      var fee = $("[id=p_fee_"+rowIndex+"]").val();
      fee = replaceComma(fee);
      if(price !== "" && !isNaN(price))
      {
        price = Number(price);
      } else
      {
        price = 0;
      }
      if(fee !== "" && !isNaN(fee))
      {
        fee = Number(fee);
      } else
      {
        fee = 0;
      }
      if(percent !== "" && !isNaN(percent))
      {
        percent = Number(percent);
      } else 
      {
        percent = 0;
      }
      var retail = price + (price + fee)*percent/100;
      retail = formatNumber(retail);
      if(retail === '0')
      {
        retail = "";  
      }
      $("[id=p_retail_"+rowIndex+"]").val(retail);
    }

    function onchange_retail(e)
    {
      var rowIndex = $(e).parent().parent().attr("row-index");
      var val = $(e).val();
      val = replaceComma(val);
      if(isNaN(val) || val < 10) {
        $(e).addClass("is-invalid");  
      } else {
        $(e).removeClass("is-invalid");
        if(val.indexOf(".") > 0)
        {
          val = val.replace(/\./g, '');
          val = Number(val+"00");
        } else 
        {
          val = Number(val+"000");
        }
        $(e).val(formatNumber(val));  
        calc_profit(rowIndex);
        calc_percent(rowIndex);
      }
    }

    function calc_profit(rowIndex)
    {
      var retail = $("[id=p_retail_"+rowIndex+"]").val();
      retail = replaceComma(retail);
      var price = $("[id=p_price_"+rowIndex+"]").val();
      price = replaceComma(price);
      var fee = $("[id=p_fee_"+rowIndex+"]").val();
      fee = replaceComma(fee);
      var profit = Number(retail) - Number(price) - Number(fee);
      $("[id=p_profit_"+rowIndex+"]").text(formatNumber(profit));
    }

    function onchange_price(e)
    {
      var rowIndex = $(e).parent().parent().attr("row-index");
      var val = $(e).val();
      val = replaceComma(val);
      if(val.indexOf(".") > 0)
      {
        val = val.replace(/\./g, '');
        val = Number(val+"00");
      } else 
      {
        val = Number(val+"000");
      }
      if(isNaN(val) || val > 1000000) {
        $(e).addClass("is-invalid");  
      } else {
        $(e).removeClass("is-invalid");
        $(e).val(formatNumber(val));  
        $("[id=p_retail_temp_"+rowIndex+"]").trigger("change");
        calc_profit(rowIndex);
      }
    }

    function onchange_percent(e)
    {
      var rowIndex = $(e).parent().parent().attr("row-index");
      var val = $(e).val();
      if(isNaN(val) || val < 39) {
        $(e).addClass("is-invalid");  
        $(e).focus();
      } else {
        $(e).removeClass("is-invalid");
        $("[id=p_retail_temp_"+rowIndex+"]").trigger("change");
        calc_profit(rowIndex);
      }
    }

    function calc_percent(rowIndex)
    {
      var retail = $("[id=p_retail_"+rowIndex+"]").val();
      retail = replaceComma(retail);
      var price =  $("[id=p_price_"+rowIndex+"]").val();
      price = replaceComma(price);
      var fee =  $("[id=p_fee_"+rowIndex+"]").val();
      fee = replaceComma(fee);
      if(isNaN(retail)) {
        $("[id=p_retail_"+rowIndex+"]").addClass("is-invalid");  
        $("[id=p_retail_"+rowIndex+"]").focus();
      } else if(isNaN(price)) {
        $("[id=p_price_"+rowIndex+"]").addClass("is-invalid");  
        $("[id=p_price_"+rowIndex+"]").focus();
      } else if(isNaN(fee)) {
        $("[id=p_fee_"+rowIndex+"]").addClass("is-invalid");  
        $("[id=p_fee_"+rowIndex+"]").focus();
      }  else {
        $("[id=p_retail_"+rowIndex+"]").removeClass("is-invalid");
        $("[id=p_price_"+rowIndex+"]").removeClass("is-invalid");
        $("[id=p_fee_"+rowIndex+"]").removeClass("is-invalid");
        retail = Number(retail);
        price = Number(price);
        fee = Number(fee);
        var percent = (retail - price)*100 / (price + fee);
        percent = Math.round(percent);
        $("[id=p_percent_"+rowIndex+"]").val(percent);
      }
    }

    function create_new()
    {
      show_loading();
      var data = {};
      var rowProductNumber = $(".count-row").val();
      var products = [];
      for(var i=1; i<=rowProductNumber.length; i++)
      {
        var product_id = $("#product_id_"+i).val();
        var image = $("#p_image_"+i).val();
        var name = $("#p_name_"+i).val();
        var link = $("#p_link_"+i).val();
        var size = $("#select_size_"+i).val();
        var color = $("#select_color_"+i).val();
        var qty = $("#p_qty_"+i).val();
        var price = $("#p_price_"+i).val();
        var fee = $("#p_fee_"+i).val();
        var percent = $("#p_percent_"+i).val();
        var retail = $("#p_retail_"+i).val();
        var profit = $("#p_profit_"+i).text();
        var type = $("#select_type_"+i).val();
        var catId = $("#select_cat_"+i).val();
        if(image !== "" && name !== "" && price !== "" && type.length > 0 && catId.length > 0)
          {
          var product = {};
              product["image"] = image;  
              product["name"] = name;  
              product["link"] = link;  
              product["size"] = size;
              product["color"] = color;
              product["quantity"] = qty;
              product["price"] = replaceComma(price);
              product["fee"] = replaceComma(fee);
              product["retail"] = replaceComma(retail);
              product["percent"] = percent.replace("%","");
              product["profit"] = replaceComma(profit);
              product["type"] = type;
              product["catId"] = catId;
              product["product_id"] = product_id;
              products.push(product);        
        }
      }
      data["products"] = products;
      console.log(JSON.stringify(data));
      hide_loading();
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
          $.ajax({
            dataType : 'json',
            url      : '<?php echo __PATH__.'src/controller/product/ProductController.php' ?>',
            data : {
              type : 'addNew',
              data : JSON.stringify(data)
            },
            type : 'POST',
            success: function(data)
            {
              Swal.fire(
                'Thành công!',
                'Các sản phẩm đã được tạo thành công.',
                'success'
              )    
              reset_form();
              hide_loading();
            },
            error : function (data, errorThrown) {
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
      })
    }

    function show_loading()
    {
      $("#create-product .overlay").removeClass("hidden");
    }
    function hide_loading()
    {
      $("#create-product .overlay").addClass("hidden");
    }

    function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    function replaceComma(value)
    {
      return value.replace(/,/g, '');
    } 


    var size = [
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
              id: '3',
              text: '3m'
          },
          {
              id: '6',
              text: '6m'
          },
          {
              id: '9',
              text: '9m'
          },
          {
              id: 'Free Size',
              text: 'Free Size'
          }
      ];
      var colors = [
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
      var qty = [
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
      var types = [
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
          }
      ];
      var cats = [
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