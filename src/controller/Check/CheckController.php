<?php
include("../../common/DBConnection.php");
include("../../model/Check/Check.php");
include("../../model/Check/ResultCheck.php");
include("../../dao/CheckDAO.php");

$db = new DBConnect();

$dao = new CheckDAO();
$dao->setConn($db->getConn());

if(isset($_POST["method"]) && $_POST["method"]=="save_check")   {
    $data = $_POST["data"];
    $data = json_decode($data);
    $sku = $data->sku;
    try {
        $is_exist_sku = $dao->is_exist_sku($sku);
        if(empty($is_exist_sku)) {
            $product_id = $data->product_id;
            $variation_id = $data->variant_id;
            $color = $data->color;
            $size = $data->size;
            $qty = $data->quantity;
            $name = $data->name;
            $price = $data->price;

            $check = new Check();
            $check->setProductId($product_id);
            $check->setVariationId($variation_id);
            $check->setSku((int) $sku);
            $check->setQuantity($qty);
            $check->setSize($size);
            $check->setColor($color);
            $check->setName($name);
            $check->setPrice($price);
            $dao->save_check($check);
        } else {
            $dao->update_qty_by_sku((int) $sku);
        }
        $response_array['success'] = "successfully";
        echo json_encode($response_array);
    } catch(Exception $e)
    {
        $db->rollback();
        echo $e->getMessage();
    }
    $db->commit();
}

if(isset($_POST["method"]) && $_POST["method"]=="save_result_check")   {
    $data = $_POST["data"];
    $data = json_decode($data);
    $total_qty = $data->total_qty;
    $total_money = $data->total_money;
    try {
        // update all new qty
        $dao->update_qty_variations();

        // save result check
        $resultCheck = new ResultCheck();
        $resultCheck->setTotalQty($total_qty);
        $resultCheck->setTotalMoney($total_money);
        $dao->save_result_check($resultCheck);

        // return result
        $response_array['success'] = "successfully";
        echo json_encode($response_array);
    } catch(Exception $e)
    {
        $db->rollback();
        echo $e->getMessage();
    }
    $db->commit();
}