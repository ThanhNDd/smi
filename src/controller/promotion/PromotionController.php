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
//        echo $data;
        $data = json_decode($data);
        $name = $data->name;
        $start_date = $data->start_date;
        $end_date = $data->end_date;
        $type = $data->type;
        $scope = $data->scope;
        $status = $data->status;
        $promotion_id = $data->promotion_id;
        $list_products = $data->list_products;

        $start_date = strtotime($start_date);
        $end_date = strtotime($end_date);
        $current_date = date("d/m/Y H:i");
        if ($current_date > $start_date && $current_date < $end_date) {
          $status = 1;// dang dien ra
        } else if ($current_date < $start_date) {
          $status = 0;// sap dien ra
        } else if ($current_date > $end_date) {
          $status = 2;// da ket thuc
        }
        if(empty($promotion_id)) {
          $name = $data->name;
          $existed_name = $dao->check_exist_name($name);
          if($existed_name > 0) {
            throw new Exception("Existed");
          }
        }

        $promotion = new Promotion();
        $promotion->setId($promotion_id);
        $promotion->setName($data->name);
        $promotion->setStartDate($data->start_date);
        $promotion->setEndDate($data->end_date);
        $promotion->setType($type);
        $promotion->setStatus($status);
        $promotion->setScope($scope);

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
        for ($i = 0; $i < count($list_products); $i++) {
            $promotion_detail = new PromotionDetail();
            $promotion_detail->setPromotionId($promotion_id);
            $promotion_detail->setProductId($list_products[$i]->product_id);
            $promotion_detail->setVariantId($list_products[$i]->variant_id);
            $promotion_detail->setSku($list_products[$i]->sku);
            $promotion_detail->setRetailPrice($list_products[$i]->price);
            $promotion_detail->setSalePrice($list_products[$i]->sale_price);
            $promotion_detail->setPercent($list_products[$i]->percent);
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
//        $list_product_using = $dao->find_all_products_using();
        $lists = $dao->find_all_products();
        echo json_encode($lists);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "end_promotion") {
  try {
    Common::authen_get_data();
    $id = $_POST["promotion_id"];
    $status = 2;// end promotion
    $dao->update_status_promotion($status, $id);
    echo "success";
  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }
  $db->commit();
}

if (isset($_GET["method"]) && $_GET["method"] == "find_variations") {
    try {
        Common::authen_get_data();
        $ids = $_GET["list_product_id"];
        $is_edit_promotion = $_GET["is_edit_promotion"];
        $lists = $dao->find_variations_by_product_id($ids, $is_edit_promotion);
        echo json_encode($lists);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "load_promotion_by_id") {
  try {
    Common::authen_get_data();
    $promotion_id = $_POST["promotion_id"];
    $promotion = $dao->find_by_id($promotion_id);
    $detail = $dao->find_detail_by_promotion_id($promotion_id);
    $data = array();
    $data["promotion"] = $promotion;
    $data["detail"] = $detail;
    echo json_encode($data);
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "update_status_promotion") {
  try {
    Common::authen_get_data();
    $status = "0,1";
    $promotion = $dao->find_all_by_status($status);
    for($i=0; $i<count($promotion); $i++) {
      $id = $promotion[$i]["id"];
      $status = $promotion[$i]["status"];
      $start_date = date($promotion[$i]["start_date"]);
      $end_date = date($promotion[$i]["end_date"]);
      $current_date = date("d/m/Y H:i");
      if ($current_date > $start_date && $current_date < $end_date) {
          $status = 1;// dang dien ra
      } else if ($current_date < $start_date) {
          $status = 0;// sap dien ra
      } else if ($current_date > $end_date) {
          $status = 2;// da ket thuc
      }
      $dao->update_status_promotion($status, $id);
    }
    echo json_encode("success");
  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }
  $db->commit();
}
if (isset($_POST["method"]) && $_POST["method"] == "check_exist_name") {
  try {
    Common::authen_get_data();
    $name = $_POST["name"];
    $result = $dao->check_exist_name($name);
    if ($result > 0) {
      $response_array['response'] = "existed";
    } else {
      $response_array['response'] = "not_exist";
    }
    echo json_encode($response_array);
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}
