<?php
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../model/Customer/Customer.php");
include("../../dao/CustomerDAO.php");
include("../../common/cities/Zone.php");

$db = new DBConnect();

$dao = new CustomerDAO();
$dao->setConn($db->getConn());

if (isset($_GET["method"]) && $_GET["method"] == "findall") {
    try {
        Common::authen_get_data();
        $lists = $dao->find_all();
        echo json_encode($lists);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

//if (isset($_POST["method"]) && $_POST["method"] == "find_detail") {
//  try {
//    Common::authen_get_data();
//    $product_id = $_POST["product_id"];
//    $variations = $dao->find_detail($product_id);
//    echo json_encode($variations);
//  } catch (Exception $e) {
//    throw new Exception($e);
//  }
//}

if (isset($_POST) && !empty($_FILES['file'])) {
  if ($_FILES["file"]["size"] > 200000) {//200kb
    echo "file_too_large";
    return;
  }
  $ext = explode('.', $_FILES['file']['name']);
  $new_file_name = round(microtime(true)) . '.' . end($ext);
  $ext = $ext[(count($ext) - 1)];
  if ($ext === 'jpg' || $ext === 'png' || $ext === 'jpeg') {
    if (move_uploaded_file($_FILES['file']['tmp_name'], Common::dir_upload_avatar() . $new_file_name)) {
      echo Common::path_avatar() . $new_file_name;
    } else {
      echo "error";
    }
  } else {
    echo "not_image";
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "find_customer") {
  try {
    Common::authen_get_data();
    $value = $_POST["value"];
    $type = $_POST["type"];
    $customer = $dao->find_customer($value, $type);
    echo json_encode($customer);
  } catch (Exception $e) {
    throw new Exception($e);
  }
}

if (isset($_GET["method"]) && $_GET["method"] == "get_all_customer") {
    try {
        Common::authen_get_data();
        $customer = $dao->find_customers_for_suggestion();
        echo json_encode($customer);
    } catch (Exception $e) {
        throw new Exception($e);
    }
}


if (isset($_POST["method"]) && $_POST["method"] == "add_new") {
  try {
      Common::authen_get_data();
      $data = $_POST["data"];
      $data = json_decode($data);

      $customer_id = $data->id;
      if(!$customer_id) {
        $phone = $data->phone;
        if(empty($phone)) {
            echo 'not_existed_phone';
            return;
        } else {
            $checkExist = $dao->find_customer($phone, 'phone');
            if ($checkExist) {
                echo 'existed_phone';
                return;
            }
        }

        $email = $data->email;
        if(!empty($email)) {
            $checkExist = $dao->find_customer($email, 'email');
            if ($checkExist) {
                echo 'existed_email';
                return;
            }
        }
      }
      $customer = new Customer();
      $customer->setName($data->name);
      $customer->setAvatar($data->avatar);
      $customer->setPhone($data->phone);
      $customer->setEmail($data->email);
      $customer->setFacebook($data->facebook);
      $customer->setLinkFb($data->linkFB);
      $customer->setAddress($data->address);
      $customer->setBirthday($data->birthday);
      $customer->setCityId($data->cityId);
      $customer->setDistrictId($data->districtId);
      $customer->setVillageId($data->villageId);
      if ($data->id > 0) {
        $customer->setId($data->id);
        $dao->update_customer($customer);
        echo 'success';
      } else {
        $cusId = $dao->save_customer($customer);
        if (empty($cusId)) {
          throw new Exception("Insert customer is failure", 1);
        } else {
          echo 'success';
        }
      }
  } catch (Exception $e) {
    $db->rollback();
    echo 'error';
    throw new Exception($e);
  }
  $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "edit_customer") {
  try {
    Common::authen_get_data();
    $customer_id = $_POST["customerId"];
    $customer = $dao->find_by_id($customer_id);
    echo json_encode($customer);
  } catch (Exception $e) {
    throw new Exception($e);
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "active_customer") {
  try {
    Common::authen_get_data();
    $customer_id = $_POST["customerId"];
    $status = $_POST["status"];
    $dao->active_customer($customer_id, $status);
    echo 'success';
  } catch (Exception $e) {
    $db->rollback();
    echo 'error';
    throw new Exception("Active customer error exception: " . $e);
  }
  $db->commit();
}

