<?php require_once("../../common/common.php") ?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo __PATH__?>dist/img/icon.png"/>
    <title>Kiểm hàng</title>
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
                                <td class="right"><h2 id="totalQty" style="color: red;">0</h2></td>
                            </tr>
                            <tr>
                                <td class="right w110">Tổng tiền</td>
                                <td class="right"><h2 id="totalMoney" style="color: red;">0<small> đ</small></h2></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <button type="button" class="btn btn-success form-control" id="update" title="Cập nhật">
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

        set_title("Kiểm hàng");

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
                qty = Number(qty);
                qty++;
                $("[id=qty_"+noId+"]").val(qty);
                calculateTotal();
                let product = {};
                product["sku"] = $("[id=sku_"+noId+"]").val();
                save(product);
                return;
            }
        });
        if(count == 0)
        {
            if(typeof find_product  === 'function')
            {
                find_product(prodId, 1);
            }
            if(typeof calculateTotal  === 'function')
            {
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
                    let noRow = $("#noRow").val();
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
                    let product = {};
                    product["product_id"] = products[0].product_id;
                    product["variant_id"] = products[0].variant_id;
                    product["sku"] = products[0].sku;
                    product["name"] = products[0].name;
                    product["price"] = replaceComma(products[0].price);
                    product["quantity"] = 1;
                    product["size"] = products[0].size;
                    product["color"] = products[0].color;
                    save(product);
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
            totalQty += Number(qty);

            let price =  $("[id=price_"+i+"]").text();
            price = Number(replaceComma(price));
            price = price*qty;
            totalMoney += price;
        }
        $("#totalQty").text(formatNumber(totalQty));
        $("#totalMoney").text(formatNumber(totalMoney));
    }

    function save(product)
    {
        console.log(JSON.stringify(product));
        $.ajax({
            dataType : 'json',
            url      : '<?php echo __PATH__.'src/controller/check/CheckController.php' ?>',
            data : {
                method : "save_check",
                data: JSON.stringify(product)
            },
            type : 'POST',
            success: function()
            {
                console.log("save success");
            },
            error : function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                }).then((result) => {
                    if (result.value) {

                    }
                });
            }
        });
    }

    function save_result_check()
    {
        let $total_qty = replaceComma($("#totalQty").text());
        let $total_money = replaceComma($("#totalMoney").text());
        let data = {};
        data["total_qty"] = $total_qty;
        data["total_money"] = $total_money;
        $.ajax({
            dataType : 'json',
            url      : '<?php echo __PATH__.'src/controller/check/CheckController.php' ?>',
            data : {
                method : "save_result_check",
                data: JSON.stringify(data)
            },
            type : 'POST',
            success: function()
            {
                toastr.success('Kết quả kiểm hàng đã được lưu thành công.');
            },
            error : function (data, errorThrown) {
                console.log(data.responseText);
                console.log(errorThrown);
                Swal.fire({
                    type: 'error',
                    title: 'Đã xảy ra lỗi',
                    text: "Vui lòng liên hệ quản trị hệ thống để khắc phục"
                }).then((result) => {
                    if (result.value) {

                    }
                });
            }
        });
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