<?php

class ExportDataProductDAO
{
    private $conn;

    const PATH_IMAGE = "https://banhang.shopmein.vn/dist/uploads/";
    const URI_API = "http://localhost:8000/api";

    function __construct($db) {
        $this->conn = $db->getConn();
    } 

     function updateSyncDate($productId) {

        try {
            $sql = "update smi_products SET sync_date = NOW() WHERE id = $productId";
            $stmt = $this->getConn()->prepare($sql);
            $result = $stmt->execute();
            if(!$result) { 
                throw new Exception($stmt->error);
            }
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function createProduct($token, $postData)
    {
        $url = ExportDataProductDAO::URI_API."/v2/products";
        $curl = curl_init($url);
        curl_setopt_array($curl, array( 
          CURLOPT_POST => TRUE,
          CURLOPT_RETURNTRANSFER => TRUE,
          CURLOPT_HTTPHEADER => array(
              'Authorization: Bearer '.$token,
              'Content-Type: application/json'
          ),
          CURLOPT_POSTFIELDS => json_encode($postData)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    function getToken()
    {
        $postdata = array(
            'username' => 'shopmein',
            'password' => 'In@682018'
        );
        $url = ExportDataProductDAO::URI_API."/login";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if(!empty($json_response)) {
            $response = json_decode($json_response);
            return $response->token;
        }
        return null;
    }

    function fetchProducts()
    {
        $token = $this->getToken();
        $url = ExportDataProductDAO::URI_API."/v2/products?limit=10&offset=0";
        $curl = curl_init($url);
        curl_setopt_array($curl, array( 
          CURLOPT_POST => FALSE,
          CURLOPT_RETURNTRANSFER => TRUE,
          CURLOPT_HTTPHEADER => array(
              'Authorization: Bearer '.$token,
              'Content-Type: application/json'
          ),
        ));
        $products = curl_exec($curl);
        curl_close($curl);
        return json_decode($products);
    }

    function getVariations(&$productData, $product_id)
    {
        try {
            $response = array();
            $response["variationsInfo"] = array();
            $response["variationsData"] = array();

            $variationsInfo = array();
            $variationsData = array();

            $variant1 = array();
            $variant1["name"] = "Màu sắc";
            $variant1["values"] = array();

            $variant2 = array();
            $variant2["name"] = "Size";
            $variant2["values"] = array();

            // $productIds = implode(",",$ids);
            $sql = "SELECT * FROM `smi_variations` WHERE product_id = $product_id";
            $result = mysqli_query($this->conn, $sql);
            if($result) {
                $productId = "";
                $color = "";
                $size = "";
                $colorArr = array();
                $sizeArr = array();
                foreach ($result as $k => $row) {
                    if($color != $row["color"]) {
                        $pathinfo = pathinfo($row["image"]);
                        $img = array();
                        $img["filename"] = $pathinfo['filename'];
                        $img["link"] = $row["image"];
                        $img["type"] = $row["image_type"];

                        $classify = [];
                        $classify["name"] = (string) trim($row["color"]);
                        $classify["link"] = null;
                        $classify["video"] = null;
                        $classify["images"] = array($img);
                        array_push($variant1["values"], $classify);
                    }
                    if($size != $row["size"]) {
                        $classify = [];
                        $classify["name"] = (string) trim($row["size"]);
                        $classify["link"] = null;
                        $classify["video"] = null;
                        $classify["images"] = array();
                        if(!in_array($classify, $variant2["values"])) {
                            array_push($variant2["values"], $classify);
                        }
                    }
                    $color = $row["color"];
                    $size = trim($row["size"]);   

                    $productVariant = array();
                    $productVariant["ID"] = $row["id"];
                    $productVariant["ATTR1"] = $row["color"];
                    $productVariant["images"] = [];
                    $productVariant["ATTR2"] = $row["size"];
                    $productVariant["SKU"] = $row["sku"];
                    $productVariant["IMPORT_PRICE_YUAN"] = 0;
                    $productVariant["EXCHANGE_RATE"] = 0;
                    $productVariant["IMPORT_PRICE_VN"] = $row["price"];
                    $productVariant["FEE"] = $row["fee"];
                    $productVariant["COST_PRICE"] = $row["cost_price"];
                    $productVariant["QUANTITY"] = $row["quantity"];
                    $productVariant["SALE_PRICE"] = $row["retail"];
                    $productVariant["PROFIT"] = $row["profit"];
                    array_push($response["variationsData"], $productVariant);
                }

                if(empty($productData["images"])) {
                    $productData["images"] = $variant1["values"][0]["images"];
                }

                array_push($response["variationsInfo"], $variant1);
                array_push($response["variationsInfo"], $variant2);

            }
            $productData["variationsInfo"] = $response["variationsInfo"];
            $productData["dataVariations"] = $response["variationsData"];
            return $response;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    function getProductData($product) {
        $gender = "FEMALE";
        if($product["gender"] == 0) {
            $gender = "MALE";
        } elseif ($product["gender"] == 1) {
            $gender = "FEMALE";
        } elseif ($product["gender"] == 2) {
            $gender = "UNISEX";
        } elseif ($product["gender"] == 3) {
            $gender = "NEW_BORN";
        }


        $origin = "TQ";
        if($product["origin"] == 1) {
            $origin = "VN";
        }

        $images = json_decode($product["image"]);
        // var_dump( $images);
        $image = array();
        if(count($images) > 0) {
            $img = $images[0];
            $url = trim($img->src);
            $pathinfo = pathinfo($url);
            $filename = isset($pathinfo['filename']) ? $pathinfo['filename'] : null;
            // $extension = isset($pathinfo['extension']) ? $pathinfo['extension'] : null;

            if($img->type == "upload") {
              $url = ExportDataProductDAO::PATH_IMAGE.$url; 
            }
            $image["filename"] = $filename;
            $image["type"] = $img->type;
            $image["link"] = $url;
        }

        $productData = [];
        $productData["productId"] = $product["id"];
        $productData["images"] = !empty($image) ? [$image] : null;
        $productData["name"] = $product["name"];
        $productData["link"] = $product["link"];
        $productData["video"] = null;
        $productData["categoryId"] = $product["category_id"];
        $productData["inventory"] = $product["inventory"];
        $productData["productType"] = "NORMAL";
        $productData["allowAccumulatePoints"] = 1;
        $productData["gender"] = $gender;
        $productData["origin"] = $origin;
        $productData["brandId"] = 0;
        $productData["created_at"] = $product["created_at"];
        $productData["channels"] = [2,5,7,12,18];
        // $productData["variationsInfo"] = [];
        // $productData["dataVariations"] = [];
        $this->getVariations($productData, $product["id"]);
        $productData["dataChannelPrices"] = [];
        $productData["dataAttributes"] = [];
        $productData["attributeIds"] = [];
        return $productData;
    }

    function getProducts($ids) {
        try {

            // update inventory before get data
            // $this->update_inventories($ids);

            if(count($ids) == 0) {
                $sql = "SELECT * FROM `smi_products` WHERE sync_date is null ORDER BY created_at DESC LIMIT 0 , 50";
            } else {
                $productIds = implode(",",$ids);
                $sql = "SELECT * FROM `smi_products` WHERE id in ($productIds)";
            }
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            // $data["sql"] = array($sql);
            // $data["products"] = array();
            if($result) {
                foreach ($result as $k => $row) {
                    array_push($data, $row);
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function countTotalProducts() {
        try {
            $sql = "SELECT count(*) as total FROM `smi_products` WHERE sync_date is not null  ORDER BY created_at DESC";
            $result = mysqli_query($this->conn, $sql);
            $row = $result->fetch_assoc();
            return $row['total'];
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function update_inventories($ids) {
        try {
            if(count($ids) == 0) {
                $sql = "UPDATE smi_products a,
                          (SELECT product_id, sum(quantity) AS inventory
                           FROM `smi_variations`
                           GROUP BY product_id) b
                        SET a.inventory = b.inventory
                        WHERE a.id = b.product_id";
            } else {
                $productIds = implode(",",$ids);
                $sql = "UPDATE smi_products a,
                          (SELECT product_id,
                                  sum(quantity) AS inventory
                           FROM `smi_variations`
                           GROUP BY product_id) b
                        SET a.inventory = b.inventory
                        WHERE a.id = b.product_id AND a.id in ($productIds)";
            }
            $stmt = $this->getConn()->prepare($sql);
            if(!$stmt->execute()) { 
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * Get the value of conn
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * Set the value of conn
     *
     * @return  self
     */
    public function setConn($conn)
    {
        $this->conn = $conn;

        return $this;
    }

}