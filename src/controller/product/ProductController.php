<?php
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../model/Product/Product.php");
include("../../model/Product/Variations.php");
include("../../dao/ProductDAO.php");
include("../../controller/product/PrinterBarcode.php");
include("../../controller/product/PrinterBarcodeShoes.php");

$db = new DBConnect();

$dao = new ProductDAO($db);
// $dao->setConn($db->getConn());

if (isset($_POST["method"]) && $_POST["method"] == "update_quantity") {
    try {
        Common::authen_get_data();
        $data = $_POST["data"];
        $data = json_decode($data);
        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                $variant_id = $v->id;
                $qty = $v->quantity;
                $dao->update_quantity($qty, $variant_id);
            }
        }
        $response_array['response'] = "success";
        echo json_encode($response_array);
    } catch (Exception $ex) {
        $db->rollback();
        throw new Exception($ex);
    }
    $db->commit();
}

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
    if ($_FILES["file"]["size"] > 200000) {//200kb
        echo "file_too_large";
        return;
    }
    $ext = explode('.', $_FILES['file']['name']);
    $new_file_name = round(microtime(true)) . '.' . end($ext);
    $ext = $ext[(count($ext) - 1)];
    if ($ext === 'jpg' || $ext === 'png' || $ext === 'jpeg') {
        if (move_uploaded_file($_FILES['file']['tmp_name'], Common::dir_upload_img() . $new_file_name)) {
            echo Common::path_img() . $new_file_name;
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
        $customPrint = $_POST["customPrint"];
        
        $data = $_POST["data"];
        $data = json_decode($data);
        $skus = '';
        for ($i = 0; $i < count($data); $i++) {
            $skus .= '\'' . $data[$i]->id . '\',';
        }
        $skus = substr($skus, 0, strlen($skus) - 1);
        $lists = $dao->get_data_print_barcode($skus);
        if($customPrint == "true") {
            $printBarcodeShoes = new PrinterBarcodeShoes();
            $filename = $printBarcodeShoes->print($lists, $data);
        } else {
            $filename = $print_barcode->print($lists, $data);
        }
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
        $data = $_POST["data"];
        // $product_id = $data["product_id"];
        // $saleValue = $data["saleValue"];
        // $saleType = $data["saleType"];

        $result = $dao->update_discount($data);
        $response_array['response'] = $result;
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        throw new Exception("Update discount error exception: " . $e);
    }
    $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "update_attr") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $data = $_POST["data"];
        $type = $_POST["type"];
        $response_array['response'] = "success";
        $dao->update_attr((int)$product_id, (int)$data, $type);
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

if (isset($_POST["method"]) && $_POST["method"] == "update_visibility") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $dao->update_visibility((int)$product_id);
        $response_array['response'] = "success";
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        throw new Exception("update_out_of_stock error exception: " . $e);
    }
    $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "delete_product") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $dao->delete_product((int)$product_id);
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
        throw new Exception($e);
    }
}

if (isset($_GET["method"]) && $_GET["method"] == "findall") {
    try {
        Common::authen_get_data();
        $status = isset($_GET["status"]) ? $_GET["status"] : '0';
        $operator = isset($_GET["operator"]) ? $_GET["operator"] : '';
        $quantity = isset($_GET["quantity"]) ? $_GET["quantity"] : '';
        $sku = isset($_GET["sku"]) ? $_GET["sku"] : '';
        $product_type = isset($_GET["product_type"]) ? $_GET["product_type"] : '';
        $sorted = isset($_GET["sorted"]) ? $_GET["sorted"] : '';

//        var_dump($status."\n");
//        var_dump($operator."\n");
//        var_dump($quantity."\n");
//        var_dump($sku."\n");

        $lists = $dao->find_all($status, $operator, $quantity, $sku, $product_type, $sorted);
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
        $product->setNameForWebsite($data->name_for_website);
        $product->setLink($data->link);
        $product->setFee_transport($data->fee);
        $product->setPrice($data->price);
        $product->setProfit($data->profit);
        $product->setPercent($data->percent);
        $product->setRetail($data->retail);
        $product->setGender($data->gender);
        $product->setCategory_id($data->cat);
        $product->setImage($data->image);
        $product->setDescription($data->description);
        $product->setMaterial($data->material);
        $product->setOrigin($data->origin);
        $product->setShortDescription($data->short_description);

        if (empty($prodId)) {
            $prodId = $dao->save_product($product);
            if (empty($prodId)) {
                throw new Exception("Insert product has Failed!!!!");
            }
        } else {
            $dao->update_product($product);
        }
        try {
            $dao->delete_variation_by_product_id($prodId);
        } catch (Exception $e) {
            throw new Exception("Delete variation failed!!");
        }
        $number = 0;
        $variations = $data->variations;
        for ($i = 0; $i < count($variations); $i++) {
            if($number < 10) {
                $new_sku = (int) $prodId."00".$number;
            } else if($number >= 10 && $number < 100) {
                $new_sku = (int) $prodId."0".$number;
            } else {
                $new_sku = (int) $prodId.$number;
            }
            $number++;

            $variation = new Variations();
            $variation->setProductId($prodId);
            $variation->setSize($variations[$i]->size);
            $variation->setColor($variations[$i]->color);
            $variation->setQuantity($variations[$i]->qty);
            $variation->setSku(empty($variations[$i]->sku) ? $new_sku : $variations[$i]->sku);
            $variation->setPrice($variations[$i]->price);
            $variation->setFee($variations[$i]->fee);
            $variation->setCostPrice($variations[$i]->costPrice);
            $variation->setRetail($variations[$i]->retail);
            $variation->setSalePrice($variations[$i]->salePrice);
            $variation->setPercentSale($variations[$i]->percentSale);
            $variation->setProfit($variations[$i]->profit);
            $variation->setPercent($variations[$i]->percent);
            $variation->setLength__($variations[$i]->length__);
            $variation->setWeight($variations[$i]->weight);
            $variation->setHeight($variations[$i]->height);
            $variation->setAge($variations[$i]->age);
            $variation->setDimension($variations[$i]->dimension);
            $variation->setImage($variations[$i]->image);
            $dao->save_variation($variation);
        }
        $response_array['success'] = $prodId;
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        throw new Exception('Caught exception: '. $e->getMessage());
    }
    $db->commit();

}

if (isset($_POST["method"]) && $_POST["method"] == "update_product_type") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $product_type = $_POST["product_type"];
        $dao->update_product_type($product_id, $product_type);
        $response_array['success'] = 'success';
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        throw new Exception($e);
    }
    $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "social_publish") {
    try {
        Common::authen_get_data();
        $product_id = $_POST["product_id"];
        $type = $_POST["type"];
        $status = $_POST["status"];
        $dao->social_publish($product_id, $type, $status);
        $response_array['success'] = 'success';
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        throw new Exception($e);
    }
    $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "updated_qty") {
  try {
      Common::authen_get_data();
      $sku = $_POST["sku"];
      $type = $_POST["type"];
      $status = $_POST["status"];
      $dao->updated_qty($sku, $type, $status);
      $response_array['success'] = 'success';
      echo json_encode($response_array);
  } catch (Exception $e) {
      $db->rollback();
      throw new Exception($e);
  }
  $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "load_size") {
    try {
        Common::authen_get_data();
        $size = $dao->get_sizes();
        echo json_encode($size);
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "load_color") {
    try {
        Common::authen_get_data();
        $color = $dao->get_colors();
        echo json_encode($color);
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "load_material") {
    try {
        Common::authen_get_data();
        $color = $dao->get_materials();
        echo json_encode($color);
    } catch (Exception $e) {
        throw new Exception($e);
    }
}




if (isset($_POST["method"]) && $_POST["method"] == "get_data_for_chat_bot") {
    try {
        Common::authen_get_data();
        $data = $dao->get_data_for_chat_bot();
        $response_array['data'] = $data;
        echo json_encode($response_array);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}