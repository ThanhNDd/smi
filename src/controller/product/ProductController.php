<?php
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../model/Product/Product.php");
include("../../model/Product/Variations.php");
include("../../dao/ProductDAO.php");
include("../../controller/product/PrinterBarcode.php");

$db = new DBConnect();

$dao = new ProductDAO();
$dao->setConn($db->getConn());

if (isset($_POST["method"]) && $_POST["method"] == "get_max_id") {
    try {
        Common::authen_get_data();
        $max_id = $dao->get_max_id();
        $response_array['max_id'] = $max_id;
        echo json_encode($response_array);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}

if (isset($_POST) && !empty($_FILES['file'])) {
    if ($_FILES["file"]["size"] > 100000) {//100kb
        echo "file_too_large";
        return;
    }
    $ext = explode('.', $_FILES['file']['name']);
    $new_file_name = round(microtime(true)) . '.' . end($ext);
    $ext = $ext[(count($ext) - 1)];
    if ($ext === 'jpg' || $ext === 'png' || $ext === 'jpeg') {
        if (move_uploaded_file($_FILES['file']['tmp_name'], '../../../dist/uploads/' . $new_file_name)) {
            echo Common::path() . 'dist/uploads/' . $new_file_name;
        } else {
            $response_array['response'] = "error";
            echo json_encode($response_array);
        }
    } else {
        $response_array['response'] = "not_image";
        echo json_encode($response_array);
    }
}

$print_barcode = new PrinterBarcode();
if (isset($_POST["method"]) && $_POST["method"] == "print_barcode") {
    try {
        Common::authen_get_data();
        $data = $_POST["data"];
        $data = json_decode($data);
        $skus = '';
        for ($i = 0; $i < count($data); $i++) {
            $skus .= '\'' . $data[$i] . '\',';
        }
        $skus = substr($skus, 0, strlen($skus) - 1);

        $lists = $dao->get_data_print_barcode($skus);
        // echo json_encode($lists);
        $filename = $print_barcode->print($lists);
        $response_array['fileName'] = $filename;
        echo json_encode($response_array);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}

if (isset($_POST["type"]) && $_POST["type"] == "del_product") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $products = $dao->find_variation_by_product_id($product_id);
        if ($products->num_rows > 0) {
            $response_array['response'] = "error";
            echo json_encode($response_array);
        } else {
            $dao->delete_product($product_id);
            $response_array['response'] = "successfully";
            echo json_encode($response_array);
        }
    } catch (Exception $e) {
        $db->rollback();
        throw new Exception("Delete product error exception: " . $e);
    }
    $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "update_discount") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $discount = $_POST["discount"];
        $dao->update_discount((int)$discount, (int)$product_id);
        $response_array['response'] = "success";
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        throw new Exception("Update discount error exception: " . $e);
    }
    $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "update_discount_all") {
    try {
        Common::authen_get_data();
        $discount = $_POST["discount"];
        $dao->update_discount_all((int)$discount);
        $response_array['response'] = "success";
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        throw new Exception("Update discount all error exception: " . $e);
    }
    $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "check_update_out_of_stock") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $result = $dao->check_stock((int)$product_id);
        if ($result > 0) {
            $response_array['response'] = "in_stock";
        } else {
            $response_array['response'] = "success";
        }
        echo json_encode($response_array);
    } catch (Exception $e) {
        throw new Exception("Update discount error exception: " . $e);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "check_update_in_stock") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $result = $dao->check_stock((int)$product_id);
        if ($result > 0) {
            $response_array['response'] = "success";
        } else {
            $response_array['response'] = "out_stock";
        }
        echo json_encode($response_array);
    } catch (Exception $e) {
        throw new Exception("Update discount error exception: " . $e);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "count_out_of_stock") {
    try {
        Common::authen_get_data();
        $result = $dao->count_out_of_stock();
        $response_array['response'] = $result;
        echo json_encode($response_array);
    } catch (Exception $e) {
        throw new Exception("Update discount error exception: " . $e);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "update_stock") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $status = $_POST["status"];
        $dao->update_stock((int)$status, (int)$product_id);
        $response_array['response'] = "success";
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        throw new Exception("update_out_of_stock error exception: " . $e);
    }
    $db->commit();
}

if (isset($_POST["type"]) && $_POST["type"] == "edit_product") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $lists = $dao->find_by_id($product_id);
        echo json_encode($lists);
    } catch (Exception $e) {
        throw new Exception("update_out_of_stock error exception: " . $e);
    }
}

if (isset($_POST["type"]) && $_POST["type"] == "save_variation") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $sku = $_POST["sku"];
        $color = $_POST["color"];
        $size = $_POST["size"];
        $qty = $_POST["qty"];

        if (empty($product_id) || $product_id == 0) {
            throw new Exception("product_id is empty or equal zero");
        }

        $variation = new Variations();
        $variation->setProduct_id($product_id);
        $variation->setSku($sku);
        $variation->setQuantity($qty);
        $variation->setColor($color);
        $variation->setSize($size);
        $arr = array();
        array_push($arr, $variation);
        $dao->save_variations($arr);
        $response_array['success'] = "successfully";
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        echo $e->getMessage();
    }
    $db->commit();
}

if (isset($_POST["type"]) && $_POST["type"] == "update_variation") {
    try {
        Common::authen_get_data();
        $sku = $_POST["sku"];
        $color = $_POST["color"];
        $size = $_POST["size"];
        $qty = $_POST["qty"];

        if (empty($sku) || $sku == 0) {
            throw new Exception("sku is empty or equal zero");
        }
        $dao->update_variation($sku, $color, $size, $qty);
        $response_array['success'] = "successfully";
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        echo $e->getMessage();
    }
    $db->commit();
}

if (isset($_POST["type"]) && $_POST["type"] == "delete_variation") {
    try {
        Common::authen_get_data();
        $variation_id = $_POST["data"];
        if (empty($variation_id) || $variation_id == 0) {
            throw new Exception("variation_id is empty or equal zero");
        }
        $dao->delete_variation($variation_id);
        $response_array['success'] = "successfully";
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        echo $e->getMessage();
    }
    $db->commit();
}

if (isset($_GET["method"]) && $_GET["method"] == "findall") {
    try {
        Common::authen_get_data();
        $status = $_GET["status"];
        $lists = $dao->find_all($status);
        echo json_encode($lists);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "find_detail") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $variations = $dao->find_detail($product_id);
        echo json_encode($variations);
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "add_new") {
    try {
        Common::authen_get_data();
        $data = $_POST["data"];
        $result = 0;
        $data = json_decode($data);

        $product = new Product();
        $prodId = $data->product_id;
        $product->setId($data->product_id);
        $product->setName($data->name);
        $product->setImage($data->image);
        $product->setLink($data->link);
        $product->setPrice($data->price);
        $product->setFee_transport($data->fee);
        $product->setProfit($data->profit);
        $product->setPercent($data->percent);
        $product->setRetail($data->retail);
        $product->setType($data->type);
        $product->setCategory_id($data->cat);

        if (empty($prodId)) {
            $prodId = $dao->save_product($product);
            if (empty($prodId)) {
                throw new Exception("Insert product has Failed!!!!");
            }
        } else {
          $affect_row = $dao->update_product($product);
        }
        $variations = $data->variations;
        for ($i = 0; $i < count($variations); $i++) {
            $variation = new Variations();
            $variation->setProduct_id($prodId);
            $variation->setSize($variations[$i]->size);
            $variation->setColor($variations[$i]->color);
            $variation->setQuantity($variations[$i]->qty);
            $variation->setSku($variations[$i]->sku);
            $variation->setImage($variations[$i]->image);
            $variation_id = $variations[$i]->id;
            if(empty($variation_id)) {
                $affected_rows = $dao->save_variation($variation);
                if (empty($affected_rows)) {
                  throw new Exception("Insert variation has Failed!!!!");
                }
            } else {
              $dao->update_variation($variation);
            }
        }
        $response_array['success'] = $prodId;
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
    $db->commit();
}

