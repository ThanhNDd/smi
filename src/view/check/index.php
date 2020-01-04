<?php require_once("../../common/constants.php") ?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo __PATH__?>dist/img/icon.png"/>
    <title>Bán hàng</title>
    <?php require_once ('../../common/css.php'); ?>
    <?php require_once ('../../common/js.php'); ?>
</head>
<?php require_once ('../../common/header.php'); ?>
<?php require_once ('../../common/menu.php'); ?>
<section class="content">
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-4">
            <input class="form-control" id="productId" type="text" autofocus="autofocus" style="border-color: #28a745" autocomplete="off">
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
                            <th class="w120">Giá</th>
                            <th class="w120">Số lượng</th>
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
                    <h3 class="card-title">Tổng số</h3>
                </div>
                <div class="card-body" style="min-height: 615px;">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td class="right w110">Tổng số lượng</td>
                                <td class="right"><b style="font-size: 20px;color: red;" id="totalQty">0</b></td>
                            </tr>
                            <tr>
                                <td class="right w110">Tổng tiền</td>
                                <td class="right"><b style="font-size: 20px;color: red;" id="totalMoney">0</b><b style="color: red;"> đ</b></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <button type="button" class="btn btn-success form-control" id="update" title="Cập nhật" disabled="disabled">
                            <i class="fas fa-shopping-basket"></i> Cập nhật
                        </button>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
<div class="iframeArea hidden">
</div>
<?php require_once ('../../common/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#productId").change(function(){
            var prodId = $(this).val();
            if(prodId.indexOf('SP') > -1)
            {
                prodId = prodId.replace("SP","");
                prodId = parseInt(prodId);
            }
            validateProdId(prodId, calculateTotal, find_product, 1);
            $(this).val("");
        });
        // end document ready
    });

    function validateProdId(prodId)
    {
        var count = 0;
        $.each($("#tableProd tbody").find("input[name=sku]"), function(k, v) {
            if(v["value"] === prodId) {
                count++;
                var noId = v["id"];
                noId = noId.split("_")[1];
                var qty = $("[id=qty_"+noId+"]").val();
                // qty = Number(replaceComma(qty));
                qty = Number(qty);
                qty++;
                $("[id=qty_"+noId+"]").val(qty);
                console.log("qty: "+qty);
                console.log("vao day 1 calculate total");
                calculateTotal();
                return;
            }
        });
        if(count == 0)
        {
            if(typeof find_product  === 'function')
            {
                console.log("vao day 2 find_product");
                find_product(prodId, 1);

            }
            if(typeof calculateTotal  === 'function')
            {
                console.log("vao day 2 calculate total");
                calculateTotal();
            }
        }
    }

    function find_product(sku)
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
                // console.log(JSON.stringify(products));
                if(products.length > 0)
                {
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
                        + '<td><span class="price" id="price_'+noRow+'">'+products[0].price+'</span><span> đ</span></td>'
                        + '<td><input type="number" name="qty" id="qty_'+noRow+'" class="form-control" min="1" value="1" ></td>'
                        + '<td></td>'
                        + '</tr>');
                    calculateTotal();
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
            }
        });
    }

    function calculateTotal()
    {
        $("#totalQty").text("");
        $("#totalMoney").text("");
        var noRow = $("#noRow").val();
        noRow = Number(noRow);
        let totalQty = 0;
        let totalMoney = 0;
        for(var i=1; i<=noRow; i++)
        {
            let qty =  $("[id=qty_"+i+"]").val();
            // qty = Number(replaceComma(qty));
            totalQty += Number(qty);

            console.log("qty: "+qty);

            let price =  $("[id=price_"+i+"]").text();
            price = Number(replaceComma(price));

            console.log("price: "+price);

            price = price*qty;
            totalMoney += price;

            console.log("totalMoney: "+totalMoney);
        }
        $("#totalQty").text(formatNumber(totalQty));
        $("#totalMoney").text(formatNumber(totalMoney));
    }
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    function replaceComma(value)
    {
        value = value.trim();
        return value.replace(/,/g, '');
    }
</script>
</body>
</html>