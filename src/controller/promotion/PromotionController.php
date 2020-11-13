<?php
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../model/Promotion/Promotion.php");
include("../../model/Promotion/PromotionDetail.php");
include("../../dao/PromotionDAO.php");

$db = new DBConnect();

$dao = new PromotionDAO();
$dao->setConn($db->getConn());


if (isset($_POST["type"]) && $_POST["type"] == "del_promotion_detail") {
    try {
        Common::authen_get_data();
        $promotion_id = $_POST["promotion_id"];
        $dao->delete_promotion_detail($promotion_id);
        $response_array['response'] = "success";
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        echo $e->getMessage();
    }
    $db->commit();
}

if (isset($_POST["type"]) && $_POST["type"] == "find_detail") {
    try {
        Common::authen_get_data();
        $promotion_id = $_POST["promotion_id"];
        $lists = $dao->find_detail($promotion_id);
        echo json_encode($lists);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_GET["method"]) && $_GET["method"] == "findall") {
    try {
        Common::authen_get_data();
        $lists = $dao->find_all();
        echo json_encode($lists);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "add_new") {
    try {
        Common::authen_get_data();
        $data = $_POST["data"];
        $result = 0;
        $data = json_decode($data);
        $promotion_id = $data->promotion_id;

        $promotion = new Promotion();
        $promotion->setName($data->name);
        $promotion->setStartDate($data->start_date);
        $promotion->setEndDate($data->end_date);
        $promotion->setStatus($data->status);

        if (empty($promotion_id)) {
            $promotion_id = $dao->save_promotion($promotion);
            if (empty($promotion_id)) {
                throw new Exception("Insert promotion Failed!!!!");
            }
        } else {
            $dao->update_promotion($promotion);
        }
        try {
            $dao->delete_promotion_detail($promotion_id);
        } catch (Exception $e) {
            throw new Exception("Delete promotion detail failed!!");
        }
        $promotion_detail = $data->promotion_detail;
        for ($i = 0; $i < count($promotion_detail); $i++) {
            $promotion_detail = new PromotionDetail();
            $promotion_detail->setPromotionId($promotion_detail[$i]->promotion_id);
            $promotion_detail->setProductId($promotion_detail[$i]->product_id);
            $promotion_detail->setVariantId($promotion_detail[$i]->variant_id);
            $promotion_detail->setSku($promotion_detail[$i]->sku);
            $promotion_detail->setRetailPrice($promotion_detail[$i]->retail_price);
            $promotion_detail->setSalePrice($promotion_detail[$i]->sale_price);
            $dao->save_promotion_detail($promotion_detail);
        }
        $response_array['success'] = $promotion_id;
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        echo $e->getMessage();
    }
    $db->commit();
}

if (isset($_GET["method"]) && $_GET["method"] == "find_products") {
    try {
        Common::authen_get_data();
        $lists = $dao->find_all_products();
        echo json_encode($lists);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "find_variations") {
    try {
        Common::authen_get_data();
        $ids = $_POST["list_product_id"];
        $lists = $dao->find_variations_by_product_id($ids);
        echo json_encode($lists);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
