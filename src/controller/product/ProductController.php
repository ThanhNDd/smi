<?php
include("../../common/DBConnection.php");
include("../../model/Product/Product.php");
include("../../model/Product/Variations.php");
include("../../dao/ProductDAO.php");
include("../../controller/product/PrinterBarcode.php");

$db = new DBConnect();

$dao = new ProductDAO();
$dao->setConn($db->getConn());

$print_barcode = new PrinterBarcode();
if(isset($_POST["method"]) && $_POST["method"]=="print_barcode")   {
    $data = $_POST["data"];
    $data = json_decode($data);
    $skus = '';
    for($i=0; $i<count($data); $i++)
    {
        $skus .= '\''.$data[$i].'\',';
    }
    $skus = substr($skus, 0, strlen($skus) - 1);
    try 
    {
        $lists = $dao->get_data_print_barcode($skus);
        // echo json_encode($lists);
        $filename = $print_barcode->print($lists);
        $response_array['fileName'] = $filename;
        echo json_encode($response_array);
    } catch(Exception $ex)
    {
        throw new Exception($ex);
    }
    
}

if(isset($_POST["type"]) && $_POST["type"]=="del_product")   {
    try {
        $product_id = $_POST["product_id"];
        $products = $dao->find_variation_by_product_id($product_id);
        if($products->num_rows > 0)
        {
            $response_array['response'] = "error";
            echo json_encode($response_array);
        } else {
            $dao->delete_product($product_id);
            $response_array['response'] = "successfully";
            echo json_encode($response_array);
        }
    } catch(Exception $e) {
        throw new Exception("Delete product error exception: ".$e);
    }
}

if(isset($_POST["type"]) && $_POST["type"]=="edit_product")   {
    $product_id = $_POST["product_id"];
    $lists = $dao->find_by_id($product_id);
    echo json_encode($lists);
}

if(isset($_POST["type"]) && $_POST["type"]=="save_variation")   {
    $product_id = $_POST["product_id"];
    $sku = $_POST["sku"];
    $color = $_POST["color"];
    $size = $_POST["size"];
    $qty = $_POST["qty"];

    if(empty($product_id) || $product_id == 0)
    {
        throw new Exception("product_id is empty or equal zero");
    }
    try {
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
    } catch(Exception $e)
    {
        echo $e->getMessage();
    }    
}

if(isset($_POST["type"]) && $_POST["type"]=="update_variation")   {
    $sku = $_POST["sku"];
    $color = $_POST["color"];
    $size = $_POST["size"];
    $qty = $_POST["qty"];

    if(empty($sku) || $sku == 0)
    {
        throw new Exception("sku is empty or equal zero");
    }
    try {
        $dao->update_variation($sku, $color, $size, $qty);
        $response_array['success'] = "successfully";
        echo json_encode($response_array);
    } catch(Exception $e)
    {
        echo $e->getMessage();
    }    
}

if(isset($_POST["type"]) && $_POST["type"]=="delete_variation")   {
    $variation_id = $_POST["data"];
    if(empty($variation_id) || $variation_id == 0)
    {
        throw new Exception("variation_id is empty or equal zero");
    }
    try {
        $dao->delete_variation($variation_id);
        $response_array['success'] = "successfully";
        echo json_encode($response_array);
    } catch(Exception $e)
    {
        echo $e->getMessage();
    }    
}

if(isset($_GET["type"]) && $_GET["type"]=="findall")   {
    try {
        $lists = $dao->find_all();
        echo json_encode($lists);
    } catch(Exception $e)
    {
        echo $e -> getMessage();
    }    
}

if(isset($_POST["type"]) && $_POST["type"]=="addNew")   {
    $data = $_POST["data"];
    try {
        $result = 0;
        $data = json_decode($data);
        $products = $data->products;
        for($i=0; $i<count($products); $i++)
        {
            $product = new Product();
            $product->setName($products[$i]->name);
            $product->setImage($products[$i]->image);
            $product->setLink($products[$i]->link);
            $product->setPrice($products[$i]->price);
            $product->setFee_transport($products[$i]->fee);
            $product->setProfit($products[$i]->profit);
            $product->setPercent($products[$i]->percent);
            $product->setRetail($products[$i]->retail);
            $product->setType($products[$i]->type);
            $product->setCategory_id($products[$i]->catId);
            $product_id = $products[$i]->product_id;
            if(!empty($product_id)) {
                $product->setId($product_id);
                $dao->update_product($product);
                $result++;
            } else {
                $prodId = $dao->save_product($product);
                $count = 0;
                if(!empty($prodId) && $prodId != 0) {
                    $size = $products[$i]->size;
                    $color = $products[$i]->color;
                    $arr_variations = array();
                    for($j=0; $j<count($color); $j++)
                    {
                        for($k=0; $k<count($size); $k++)
                        {
                            $count++;
                            if($count < 10) {
                                $count = "0".$count;
                            }
                            $variation = new Variations();
                            $variation->setProduct_id($prodId);
                            $variation->setSize($size[$k]);
                            $variation->setColor($color[$j]);
                            $variation->setQuantity($products[$i]->quantity);
                            $variation->setSku($prodId."".$count);
                            array_push($arr_variations, $variation);
                        }
                    }
                    $varId = $dao->save_variations($arr_variations);
                    if(!empty($varId) && $varId != 0)
                    {
                        $result++;
                    } else 
                    {
                        throw new Exception("Insert variation is Failed!!!!");
                    }
                } else {
                    throw new Exception("Insert product is Failed!!!!");
                }   
            }            
        }
        if($result > 0)
        {
            $response_array['success'] = "successfully";
            echo json_encode($response_array);
        }
    } catch(Exception $e)
    {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }   
}

