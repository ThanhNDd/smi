<?php define('__PATH__', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/admin/"); 

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bán hàng</title>
  	<?php include __PATH__.'src/common/css.php'; ?>
  	<?php include __PATH__.'src/common/js.php'; ?>
 	<link rel="stylesheet" href="<?php echo __PATH__?>plugins/typeahead/css/typeaheadjs.css">	
	<script src="<?php echo __PATH__?>plugins/typeahead/js/typeahead.jquery.min.js"></script>
	<script src="<?php echo __PATH__?>plugins/typeahead/js/bloodhound.min.js"></script>
	<style type="text/css">

	</style>
</head>  
<?php include __PATH__.'src/common/header.php'; ?>
<?php include __PATH__.'src/common/menu.php'; ?>
<section class="content">
	<div class="row" style="margin-bottom: 10px;padding-top: 10px;">
		<div class="col-md-4">
			<input class="form-control" id="productId" type="text" autofocus="autofocus" style="border-color: #28a745" autocomplete="off">
		</div>
		<div class="col-md-8 right">
            <button type="button" class="btn btn-success btn-flat order-create">
              <i class="fa fa-plus-circle" aria-hidden="true"></i> Tạo đơn Online
            </button>  
        </div>
	</div>
  	<div class="row">
	    <div class="col-md-9">
            <div class="card card-outline card-danger">
              <div class="card-header">
                <h3 class="card-title">Danh sách sản phẩm</h3>
              </div>
              <div class="card-body" style="min-height: 615px;">
              	<input type="hidden" id="noRow" value="0">
                <table class="table table-bordered table-head-fixed" id="tableProd">
                  <thead>                  
                    <tr>
                      <th class="w10">#</th>
                      <th class="hidden"></th>
                      <th class="hidden"></th>
                      <th class="w70">ID</th>
                      <th class="w150">Tên sản phẩm</th>
                      <th class="w50">Size</th>
                      <th class="w70">Màu</th>
                      <th class="w100">Đơn giá</th>
                      <th class="w120">Số lượng</th>
                      <th class="w150">Giảm trừ</th>
                      <th class="w120">Thành tiền</th>
                      <th class="w120">Hành động</th>
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
	    <div class="col-md-3">
            <div class="card card-outline card-warning">
				<div class="card-header">
					<h3 class="card-title">Thông tin thanh toán</h3>
				</div>
	            <div class="card-body" style="min-height: 615px;">
	                <table class="table table-hover">
	                  	<tbody>
		                    <tr>
								<td class="right w100">Tổng tiền</td>
								<td class="right"><b style="font-size: 20px;" id="totalAmount">0</b><b> đ</b></td>
		                    </tr>
		                    <tr>
								<td class="right">Tổng Giảm trừ</td>
								<td class="right"><span style="font-size: 20px;" id="totalReduce">0</span><span> đ</span></td>
		                    </tr>
		                    <tr>
								<td class="right">Chiết khấu</td>
								<td class="right w100"><input type="text" class="form-control" name="discount" id="discount" width="100px" style="text-align: right;"></td>
		                    </tr>
		                    <tr>
								<td class="right">Tổng thanh toán</td>
								<td class="right" style="color:red;"><h2><b id="totalCheckout">0</b><b> đ</b></h2></td>
		                    </tr>
		                    <tr>
								<td class="right">Khách thanh toán</td>
								<td class="right"><input type="text" class="form-control" name="payment" id="payment" width="100px" style="text-align: right;"></td>
		                    </tr>
		                    <tr>
								<td class="right">Trả lại</td>
								<td class="right"><span style="font-size: 20px;" id="repay">0</span><span> đ</span></td>
		                    </tr>
	                   	</tbody>
	                </table>
	                <div class="row">
	                	<div class="left skin-line">
		                    <input type="checkbox" id="flag_print_receipt">
		              		<label for="flat-checkbox-1">In hóa đơn</label>
		                </div>
		            </div>
		            <div class="row">
		                <button type="button" class="btn btn-success form-control" id="checkout" title="Thanh toán" disabled="disabled">
	                      <i class="fas fa-shopping-basket"></i> Thanh toán
	                    </button>
	                </div>
	            </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
  	</div>
</section>
<?php include __PATH__.'src/view/orders/createOrders.php'; ?>
<?php include __PATH__.'src/common/footer.php'; ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#productId").change(function(){
			var prodId = $(this).val();
			validateProdId(prodId, calculateTotal, findInJSON);
			$(this).val("");
		});  

		$("#discount").change(function(){
			var discount = $(this).val();
			discount = replaceComma(discount);	
			onchange_discount(discount);
		});
		$("#discount").blur(function(){
			var discount = $(this).val();
			discount = replaceComma(discount);
			onchange_discount(discount);
		});
		$('#discount').keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				var discount = $(this).val();
				discount = replaceComma(discount);
				onchange_discount(discount);
			}
		});

		$("#payment").change(function(){
			var payment = $(this).val();
			payment = replaceComma(payment);
			paymentChange(payment);
		});
		$("#payment").blur(function(){
			var payment = $(this).val();
			payment = replaceComma(payment);
			paymentChange(payment);
		});
		$('#payment').keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				var payment = $(this).val();
				payment = replaceComma(payment);
				paymentChange(payment);
			}
		});

		$("#checkout").click(function(){
			Swal.fire({
		        title: 'Bạn có chắc chắn muốn tạo đơn hàng này?',
		        text: "",
		        type: 'warning',
		        showCancelButton: true,
		        confirmButtonColor: '#3085d6',
		        cancelButtonColor: '#d33',
		        confirmButtonText: 'Ok'
		      }).then((result) => {
		        if (result.value) {
					
		        	// $("#create-order .overlay").removeClass("hidden");
					processDataCheckout();
					
		        }
		    });
		});

    });

	function onchange_discount(discount)
	{
		if(discount.indexOf("%") > -1)
		{
			discount = replacePercent(discount);
			if(discount < 1 || discount > 50)
			{
				$("#discount").addClass("is-invalid");
				disableCheckOutBtn();
	 			return;	
			} else 
			{
				$("#discount").removeClass("is-invalid");
			}
		} else 
		{
			if(!validateNumber(discount, 'discount'))
	 		{
	 			disableCheckOutBtn();
	 			return;
	 		}	
	 		var totalCheckout = replaceComma($("#totalCheckout").text());
	 		if(discount !== "" && discount < 1000)
	 		{
	 			discount += "000";
	 		} 
	 		$("#discount").val(formatNumber(discount));
	 		if(discount != "" && (discount < 1000 || discount > totalCheckout/2)) {
	 			$("#discount").addClass("is-invalid");
	 			disableCheckOutBtn();
	 			return;
	 		} else {
	 			$("#discount").removeClass("is-invalid");
	 		}
		}
		enableCheckOutBtn();
		calculateTotal();
	}

	function paymentChange(payment)
	{
		if(!validateNumber(payment, 'payment'))
 		{
 			disableCheckOutBtn();
 			return;
 		}
 		var totalCheckout = replaceComma($("#totalCheckout").text());
 		payment = replaceComma(payment);
 		if(payment !== "" && payment < 1000)
 		{
 			payment += "000";
 		}
 		$("#payment").val(formatNumber(payment));
 		if(payment != "" && Number(totalCheckout) > 0 && Number(payment) < Number(totalCheckout)) {
 			$("#payment").addClass("is-invalid");
 			disableCheckOutBtn();
 			return;
 		} else {
 			$("#payment").removeClass("is-invalid");
 		}
 		enableCheckOutBtn();
 		calculateTotal();
	}

	function processDataCheckout()
	{
		// order information
		$total_amount = replaceComma($("#totalAmount").text());
		$total_reduce = replaceComma($("#totalReduce").text());
		$discount = replaceComma($("#discount").val());
		$total_checkout = replaceComma($("#totalCheckout").text());
		$customer_payment = replaceComma($("#payment").val());
		$repay = replaceComma($("#repay").text());
		$flag_print_receipt = $("#flag_print_receipt").is(':checked');

		var data = {};
		data["total_amount"] = $total_amount;
		data["total_reduce"] = $total_reduce;
		data["discount"] = $discount;
		data["total_checkout"] = $total_checkout;
		data["customer_payment"] = $customer_payment;
		data["repay"] = $repay;
		data["customer_id"] = 0;
		data["type"] = 0;// Sale on shop
		data["flag_print_receipt"] = $flag_print_receipt;

		//order detail information
		var details = [];
		$.each($("#tableProd tbody tr"), function(key, value) {
			$product_id = $(value).find("input[name=prodId]").val();
			$variant_id = $(value).find("input[name=variantId]").val();
			$sku = $(value).find("input[name=sku]").val();
			$product_name = $(value).find("span.product-name").text();
			$price = replaceComma($(value).find("span.price").text());
			$quantity = $(value).find("input[name=qty]").val();
			$reduce = replaceComma($(value).find("input[name=reduce]").val());

			var product = {};
			product["product_id"] = $product_id;
			product["variant_id"] = $variant_id;
			product["sku"] = $sku;
			product["product_name"] = $product_name;
			product["price"] = $price;
			product["quantity"] = $quantity;
			product["reduce"] = $reduce;
			product["reduce_percent"] = Math.round($reduce*100/($price*$quantity));
			details.push(product);
		});
		
		if(jQuery.isEmptyObject(details[0]))
		{
			Swal.fire({
				type: 'error',
				title: 'Đã xảy ra lỗi',
				text: 'Bạn chưa chọn sản phẩm.'
			})
			return;
		}
		data["details"] = details;
		console.log(JSON.stringify(data));

		$.ajax({
			dataType : 'json',
			url      : '<?php echo __PATH__.'src/controller/sales/processCheckout.php' ?>',
			data : {
				method : "checkout",
				data: JSON.stringify(data)
			},
			type : 'POST',
			success: function(data)
			{
				var orderId = data.orderId;
				Swal.fire(
					'Thành công!',
					'Đơn hàng #'+orderId+' đã được tạo thành công.',
					'success'
				).then((result) => {
			        if (result.value) {
						resetData();
					}
		        });    
				
				$("#create-order .overlay").addClass("hidden");
			},
			error : function (data, errorThrown) {
				console.log(data.responseText);
				console.log(errorThrown);
				Swal.fire({
					type: 'error',
					title: 'Đã xảy ra lỗi',
					text: ""
				})
				$("#create-order .overlay").addClass("hidden");
			}
		});
	}

    function validateProdId(prodId, calculateTotal)
    {
    	var count = 0;
    	$.each($("#tableProd tbody").find("input[name=sku]"), function(k, v) {
      		if(v["value"] === prodId) {
      			count++;
      			var noId = v["id"];
      			noId = noId.split("_")[1];
      			var qty = $("[id=qty_"+noId+"]").val();
      			qty++;
      			$("[id=qty_"+noId+"]").val(qty);
      			$("[id=qty_"+noId+"]").trigger("change");
      			if(typeof calculateTotal  === 'function')
      			{
      				calculateTotal();	
      			}
      			return;
      		}
      	});
      	if(count == 0)
      	{
      		if(typeof findInJSON  === 'function')
	      	{
		      	findInJSON(prodId, 1);
		      	
	      	}
	      	if(typeof calculateTotal  === 'function')
	      	{
	      		calculateTotal();	
	      	}
      	}      	
    }

	function calculateTotal()
	{
		var noRow = $("#noRow").val();
		noRow = Number(noRow);
		var totalAmount = 0;
		var totalReduce = 0;
		for(var i=1; i<=noRow; i++)
		{			
			var price = get_price("price_"+i);
 			var qty = get_qty("qty_"+i);

			var intoMoney = qty*price;

			var reduce = 0;
			if(typeof $("[id=reduce_"+i+"]").val() !== "undefined") {
				var val = $("[id=reduce_"+i+"]").val();
				if(val.indexOf("%") > -1)
				{
					val = replacePercent(val);
					reduce = intoMoney*val/100;
				} else 
				{
					reduce = replaceComma(val);				
				}
			}
			totalAmount += intoMoney;
			totalReduce += Number(reduce);
		}
		$("#totalAmount").text(formatNumber(totalAmount));
		$("#totalReduce").text(formatNumber(totalReduce));


		var totalCheckout = totalAmount - totalReduce;

		var discount = $("#discount").val();
		if(discount.indexOf("%") > -1)
		{
			discount = replacePercent(discount);
			discount = totalCheckout*discount/100;
		} else 
		{
			discount = replaceComma(discount);
			discount = discount == "" ? 0 : Number(discount);
		}
		
		var totalCheckout = totalCheckout - discount;
		$("#totalCheckout").text(formatNumber(totalCheckout));

		var payment = replaceComma($("#payment").val());
		var repay = 0;
		if(payment != 0 && totalCheckout > 0)
		{
			repay = payment - totalCheckout;	
		}
		$("#repay").text(formatNumber(repay));
		if(payment == "" || payment == 0)
		{
			disableCheckOutBtn();
		} else 
		{
			enableCheckOutBtn();
		}
	}
	

	function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

	function findInJSON(sku, qty)
 	{
		$.ajax({
			url : '<?php echo __PATH__.'src/controller/sales/processCheckout.php' ?>',
			type : "POST",
			dataType : "json",
			data : {
				type : "find_product",
				sku : sku
			},
			success : function(products){
				console.log(JSON.stringify(products));
				var noRow = $("#noRow").val();
 				noRow = Number(noRow);
 				noRow++;
 				$("#noRow").val(noRow);
 				$("#tableProd tbody").append('<tr id="product-'+noRow+'">'
                      	+ '<td>'+noRow+'</td>'
                      	+ '<td class="hidden"><input type="hidden" name="prodId" id="prodId_'+noRow+'" class="form-control" value="'+products[0].product_id+'"></td>'
                      	+ '<td class="hidden"><input type="hidden" name="variantId" id="variantId_'+noRow+'" class="form-control" value="'+products[0].variant_id+'"></td>'
						  + '<td class="hidden"><input type="hidden" name="sku" id="sku_'+noRow+'" class="form-control" value="'+products[0].sku+'"></td>'
                      	+ '<td>'+products[0].sku+'</td>'
                      	+ '<td><span class="product-name" id="name_'+noRow+'">'+products[0].name+'</span></td>'
                      	+ '<td><span class="size" id="size_'+noRow+'">'+products[0].size+'</span></td>'
                      	+ '<td><span class="color" id="color_'+noRow+'">'+products[0].color+'</span></td>'
                      	+ '<td><span class="price" id="price_'+noRow+'">'+products[0].retail+'</span><span> đ</span></td>'
                      	+ '<td><input type="number" name="qty" id="qty_'+noRow+'" class="form-control" min="1" value="'+qty+'" onchange="on_change_qty(\'price_'+noRow+'\', \'qty_'+noRow+'\', \'intoMoney_'+noRow+'\', \'reduce_'+noRow+'\')"></td>'
                      	+ '<td><input type="text" name="reduce" id="reduce_'+noRow+'" class="form-control" onchange="on_change_reduce(\'price_'+noRow+'\',\'qty_'+noRow+'\', \'intoMoney_'+noRow+'\', \'reduce_'+noRow+'\')"></td>'
                      	+ '<td><span class="intoMoney" id="intoMoney_'+noRow+'">'+products[0].retail+'</span><span> đ</span></td>'
                      	+ '<td><button type="button" class="btn btn-danger form-control add-new-prod" title="Xóa"  onclick="del_product(this, \'product-'+noRow+'\')"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</button></td>'
                    	+ '</tr>');
 				$('[id=qty_'+noRow+']').trigger("change");
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

 	// function findInJSON(prodId, qty)
 	// {
 	// 	var products = <?php //include __PATH__."src/view/sales/products.json"?>;
 	// 	for(var i=0; i<products.length; i++)
 	// 	{
 	// 		if(products[i].variant_id === Number(prodId))
 	// 		{
 	// 			var noRow = $("#noRow").val();
 	// 			noRow = Number(noRow);
 	// 			noRow++;
 	// 			$("#noRow").val(noRow);
 	// 			$("#tableProd tbody").append('<tr id="product-'+noRow+'">'
    //                   	+ '<td>'+noRow+'</td>'
    //                   	+ '<td class="hidden"><input type="hidden" name="prodId" id="prodId_'+noRow+'" class="form-control" value="'+products[i].id+'"></td>'
    //                   	+ '<td class="hidden"><input type="hidden" name="variantId" id="variantId_'+noRow+'" class="form-control" value="'+products[i].variant_id+'"></td>'
    //                   	+ '<td>'+products[i].variant_id+'</td>'
    //                   	+ '<td><span class="product-name" id="name_'+noRow+'">'+products[i].text+'</span></td>'
    //                   	+ '<td><span class="price" id="price_'+noRow+'">'+products[i].price+'</span><span> đ</span></td>'
    //                   	+ '<td><input type="number" name="qty" id="qty_'+noRow+'" class="form-control" min="1" value="'+qty+'" onchange="on_change_qty(\'price_'+noRow+'\', \'qty_'+noRow+'\', \'intoMoney_'+noRow+'\', \'reduce_'+noRow+'\')"></td>'
    //                   	+ '<td><input type="text" name="reduce" id="reduce_'+noRow+'" class="form-control" onchange="on_change_reduce(\'price_'+noRow+'\',\'qty_'+noRow+'\', \'intoMoney_'+noRow+'\', \'reduce_'+noRow+'\')"></td>'
    //                   	+ '<td><span class="intoMoney" id="intoMoney_'+noRow+'">'+products[i].price+'</span><span> đ</span></td>'
    //                   	+ '<td><button type="button" class="btn btn-danger form-control add-new-prod" title="Xóa"  onclick="del_product(this, \'product-'+noRow+'\')"><i class="fa fa-minus-circle" aria-hidden="true"></i></button></td>'
    //                 	+ '</tr>');
 	// 			$('[id=qty_'+noRow+']').trigger("change");
 	// 		}
 	// 	}
 	// }

 	function del_product(e, p)
    {
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
          Swal.fire(
            'Xóa thành công!',
            'Sản phẩm đã được xóa.',
            'success'
          )
          reloadData(calculateTotal, findInJSON);
        }
      })
      
    }

    function reloadData(calculateTotal, findInJSON)
    {
    	$("#noRow").val(0);
    	var arr = [];
    	var qty = [];
      	$.each($("#tableProd tbody").find("input[name=sku]"), function(k, v) {
      		arr.push(v["value"]);
      	});
      	$.each($("#tableProd tbody").find("input[name=qty]"), function(k, v) {
      		qty.push(v["value"]);
      	});
      	if(arr.length == 0)
      	{
      		disableCheckOutBtn();
      	} else 
      	{
      		enableCheckOutBtn();
      	}
      	$("#tableProd tbody").html("");
      	if(typeof findInJSON  === 'function')
      	{
	      	for(var i=0; i<arr.length; i++)
	      	{
				  console.log("arr[i]: "+arr[i]);
				  console.log("qty[i]: "+qty[i]);
	      		findInJSON(arr[i], qty[i]);
	      	}
      	}
      	if(typeof calculateTotal  === 'function')
      	{
      		calculateTotal();	
      	}
      	
    }

    function on_change_reduce(priceId, qtyId, intoMoneyId, reduceId)
 	{
 		var price = get_price(priceId);
 		var qty = get_qty(qtyId);
		if(!validateQty(qty, qtyId)) {
			disableCheckOutBtn();
 			return;
 		}
 		var reduce = $("[id="+reduceId+"]").val();
 		reduce = replaceComma(reduce);
 		if(reduce.indexOf("%") > -1) 
 		{
 			reduce = replacePercent(reduce);
 			if(reduce <1 || reduce > 50)
 			{
 				$("[id="+reduceId+"]").addClass("is-invalid");
	 			disableCheckOutBtn();
	 			return;
 			}
 			$("[id="+reduceId+"]").removeClass("is-invalid");
 			reduce = price*qty*reduce / 100;
 		} else 
 		{
 			if(!validateNumber(reduce, reduceId))
	 		{
	 			disableCheckOutBtn();
	 			return;
	 		}
	 		if(reduce !== "" && reduce < 1000)
	 		{
	 			reduce = reduce+"000";
	 		}
	 		$("[id="+reduceId+"]").val(formatNumber(reduce));
	 		if(reduce !== "" && (reduce < 1000 || reduce > (price*qty) /2)) {
	 			$("[id="+reduceId+"]").addClass("is-invalid");
	 			disableCheckOutBtn();
	 			return;
	 		} else {
	 			$("[id="+reduceId+"]").removeClass("is-invalid");
	 		}
	 		
 		}
 		
 		enableCheckOutBtn();
 		var intoMoney = price*qty - reduce;
 		$("[id="+intoMoneyId+"]").text(formatNumber(intoMoney));
 		calculateTotal();
 	}

 	function validateNumber(value, id)
 	{
 		if(isNaN(value))
 		{
 			$("[id="+id+"]").addClass("is-invalid");
 			disableCheckOutBtn();
 			return false;
 		} else {
 			$("[id="+id+"]").removeClass("is-invalid");
 			//$("[id="+id+"]").val(formatNumber(value));
 			enableCheckOutBtn();
 			return true;
 		}
 	}

 	function on_change_qty(priceId, qtyId, intoMoneyId, reduceId)
 	{
 		var price = get_price(priceId);
 		var qty = get_qty(qtyId);
 		if(!validateQty(qty, qtyId)) {
 			disableCheckOutBtn();
 			return;
 		}
 		enableCheckOutBtn();
 		var intoMoney = price*qty;
 		$("[id="+intoMoneyId+"]").text(formatNumber(intoMoney));
 		$("[id="+reduceId+"]").trigger("change");
 		calculateTotal();
 	}


 	function get_qty(qtyId)
 	{
 		var qty = $("[id="+qtyId+"]").val();
 		qty = qty == "" ? 0 : Number(qty);
 		return qty;
 	}

 	function get_price(priceId)
 	{
 		var price = replaceComma($("[id="+priceId+"]").text());
 		price = price == "" ? 0 : Number(price);
 		return price;
 	}

 	function validateQty(qty, qtyId)
 	{
 		if(qty <= 0 || !Number.isInteger(qty))
 		{
 			$("[id="+qtyId+"]").addClass("is-invalid");
 			disableCheckOutBtn();
 			return false;
 		} else {
 			$("[id="+qtyId+"]").removeClass("is-invalid");
 			enableCheckOutBtn();
 			return true;
 		}
 	}

 	function disableCheckOutBtn()
 	{
 		$("#checkout").attr("disabled","disabled");
 	}

 	function enableCheckOutBtn()
 	{
 		$("#checkout").removeAttr("disabled");
 	}

	function replaceComma(value)
	{
		return value.replace(/,/g, '');
	} 
	
	function replacePercent(value)
	{
		return value.replace(/%/g, '');
	} 
	
	function resetData()
	{
		$("#tableProd tbody").html("");
		$("#totalAmount").text(0);
		$("#totalReduce").text(0);
		$("#discount").val("");
		$("#totalCheckout").text(0);
		$("#payment").val("");
		$("#repay").text(0);
		$("#noRow").val(0);
		disableCheckOutBtn();
	}
	 	//  var dataSource = new Bloodhound({
		//     datumTokenizer: Bloodhound.tokenizers.obj.whitespace('id', 'text'),
		//     queryTokenizer: Bloodhound.tokenizers.whitespace,
		//     local: <?php //include __PATH__."src/view/sales/products.json."?>
		    
		// });
		// dataSource.initialize();

		// $('#prefetch .typeahead').typeahead({
		//     minLength: 0,
		//     highlight: true
		// }, {
		//     name: 'countries',
		//     display: function(item){ 
		//     	console.log(item);
		//     	return item.id+'–'+item.text;
		// },
		//     source: dataSource.ttAdapter(),
		//     suggestion: function (data) {
		//     	console.log(data);
	 	//          return '<div>' +data.id  + '–' + data.text + '</div>';
	 	//     },
		//     autoselect: true
		// });


</script>
</body>
</html>