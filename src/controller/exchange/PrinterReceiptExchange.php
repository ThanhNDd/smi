<?php
require __DIR__ . '/../../../vendor/autoload.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
/**
 * 
 */
class PrinterReceiptExchange
{   
    function __construct()
    {
        
    }  

    function print(Order $order, array $exchange_arr, array $curr_arr, array $add_new_arr, array $return_arr)
    {
        try {
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'tempDir' => __DIR__ . '/tmp'
            ]);
            $no = 1;
            $is_curr = false;
            $is_exchange = false;
            $is_return = false;
            $is_add_new = false;
            $html = $this->getHeader($order);
            $html .= '<table class="center">
                    <thead>
                        <tr>
                            <td class="center" style="width: 30px;">Stt</td>
                            <td class="left" style="width: 70px;">Mã sản phẩm</td>
                            <td colspan="3" class="left">Tên sản phẩm</td>
                        </tr>
                        <tr>
                            <td class="left"></td>
                            <td class="center" style="width: 30px;">SL</td>
                            <td class="center" style="width: 65px;">Giá</td>
                            <td class="center" style="width: 50px;">Giảm giá</td>
                            <td class="center" style="width: 65px;">Thành tiền</td>
                        </tr>
                    </thead>
                    <tbody>';
            if(count($exchange_arr) > 0) {
                $html .= $this->getBody('Sản phẩm đổi', $exchange_arr, $no);
                $no++;
                $is_exchange = true;
            }
            if(count($curr_arr) > 0) {
                $html .= $this->getBody('Sản phẩm đã mua', $curr_arr, $no);
                $no++;
                $is_curr = true;
            }
            if(count($return_arr) > 0) {
                $html .= $this->getBody('Sản phẩm trả lại',$return_arr, $no);
                $no++;
                $is_return = true;
            }
            if(count($add_new_arr) > 0) {
                $html .= $this->getBody('Sản phẩm mua mới',$add_new_arr, $no);
                $is_add_new = true;
            }
            $html .=    '</tbody></table>';
            $html .= $this->getFooter($order, $is_curr, $is_exchange, $is_return, $is_add_new);

            $mpdf->SetDisplayMode('real');
            $mpdf->SetDisplayPreferences('/FitWindow/NoPrintScaling');
            $mpdf->WriteHTML($html);
            $mpdf->AddPage();

//             $this->rrmdir("pdf");
             $folder_path = "pdf";
             $files = glob($folder_path.'/*');
             foreach($files as $file) {
                 if(is_file($file))  {
                     unlink($file);
                 }
             }

            $filename = "receiptExchange".time().".pdf";
            $mpdf->Output("pdf/".$filename, 'F');
            chmod("pdf/".$filename, 0777);

            $myfile = fopen("pdf/receipt.html", "w") or die("Unable to open file!");
            fwrite($myfile, $html);
            fclose($myfile);

            return "receipt.html";
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }

    function getHeader($order)
    {
        $header = '
            <!DOCTYPE>
            <html>
            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title>Receipt Template</title>
                <script type="text/javascript" src="../connectcode-javascript-code128a.js"></script>
                <style type="text/css">
                    @font-face {
						font-family: "Pony";
						src: url("../fonts/Pony.ttf");
					}
					@font-face {
						font-family: "Roboto-Regular";
						src: url("../fonts/Roboto-Regular.ttf");
					}
					@font-face {
						font-family: "EAN-13";
						src: url("../fonts/EAN-13.ttf");
					}
                    body {
						margin: 20px 40px 20px 20px !important;
						font-size: 12px !important;
					}
                    #barcode {font-weight: normal; font-style: normal; line-height:normal; sans-serif; font-size: 12pt}
                    .center {
                        text-align: center;
                    }
                    .left {
                        text-align: left;
                        padding-left: 3px;
                    }
                    .right {
                        text-align: right;
                        padding-right: 3px;
                    }
                    p {
                        margin: 5px;
						font-family: Roboto-Regular;
                    }
                    .container, table {
                        font-family: Roboto-Regular;
                    }
                    .custom-font {
                        font-size: 12px !important;
                        font-family: Roboto-Regular !important;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
						font-size: 12px !important;
                    }
                    td {
                        border: 1px solid;
                        padding: 4px 0;
                    }
                    table thead {
                        font-weight: bold;
                    }
                    
                    .note {
                        font-size: 11px;
                        font-family: Roboto-Regular;
                    }
					h4.shop-name {
						margin-bottom: 2px;
						font-size: 25px;
						font-family: Pony;
						letter-spacing: 3px;
					}
					.headline {
						font-size: 11px;
						font-family: Roboto-Regular;
						letter-spacing: 3px;
						margin: 0 !important;
					}
					.bg-gray {
					    background-color: #e5e5e5 !important;
					}
                </style>
            </head>
            <body>
                <div class="container p-0 float-left">
                    <div class="header row">
                        <div class="center col-12 p-0 m-0">
                            <h4 class="shop-name">Shop Mẹ Ỉn</h4>
                            <p class="headline">Thời trang trẻ em</p>
                            <span>* * * * * * * * * * * *</span>
                            <p style="margin: 5px 0;">Đ/c: 227 Phố Huyện - TT.Quốc Oai - Hà Nội</p>
                            <p>Hotline: 0962.926.302</p>
                            <p>Website: www.shopmein.vn</p>
                            <p>Facebook: Shop Mẹ Ỉn</p>
                            <span>* * * * * * * * * * * *</span>
                            <h4 style="font-size: 15px;margin: 5px;">HÓA ĐƠN THANH TOÁN</h4>
                            <div id="barcodecontainer" style="width:100%">
								<div id="barcode" >'.date('Ymd', strtotime($order->getOrder_date())).$order->getId().'</div>
							</div>';
                    if(!empty($order->getCustomerName())) {
                        $header .= '<p style="display: inline-block;float: left;width:100%;text-align:left;margin-bottom: 0;margin-top: 10px;">
                                <span>Khách hàng:</span>
                                <span>'.$order->getCustomer_id().' - '.$order->getCustomerName().'</span>
                            </p>';
                    }
                    $header .= '<p style="display: inline-block; float: left;width:100%;text-align:left;margin-bottom: 0;">
                                Mã đơn đổi: '.$order->getOrderRefer().'
                            </p>';
                    $header .= '<p style="display: inline-block; float: left;width:100%;text-align:left">
                                Ngày tháng: '.date('d/m/Y - H:i:s', strtotime($order->getOrder_date())).'
                            </p>
                        </div>
                    </div>
                    <div class="body">';
        return $header;
    }

    function getBody($title, $details, $no)
    {
//        $body = '<h4 class="left" style="margin: 5px 0;">'.$title.'</h4>
//                <table class="center">
//                    <thead>
//                        <tr>
//                            <td class="center" style="width: 30px;">Stt</td>
//                            <td class="left" style="width: 60px;">Mã sản phẩm</td>
//                            <td colspan="3" class="left">Tên sản phẩm</td>
//                        </tr>
//                        <tr>
//                            <td class="left"></td>
//                            <td class="center" style="width: 30px;">SL</td>
//                            <td class="center" style="width: 65px;">Giá</td>
//                            <td class="center" style="width: 40px;">Giảm giá</td>
//                            <td class="center" style="width: 65px;">Thành tiền</td>
//                        </tr>
//                    </thead>
//                    <tbody>';
        $body = "<tr class='bg-gray'><td colspan='5'><h4 class='left' style='margin: 5px 0;'>".$title."</h4></td></tr>";
        $total = 0;
        $c = 0;
        foreach($details as $key => $value)
        {
            $reduce = '';
            if(!empty($value->getReduce())) {
                $reduce_type = $value->getReduceType();
                if($reduce_type == 0) {
                    $reduce_percent = $value->getReduce_percent();
                    if(empty($reduce_percent) && !empty($reduce)) {
                        $reduce_percent = round($reduce*100/$value->getPrice());
                    }
                    $reduce = $reduce_percent."%";
                } else {
                    $reduce = number_format($value->getReduce())."<sup>đ</sup>";
                }
            }
            $intoMoney = (empty($value->getPrice()) ? 0 : $value->getPrice()) * (empty($value->getQuantity()) ? 0 : $value->getQuantity()) - (empty($value->getReduce()) ? 0 : $value->getReduce());
            $c++;
            $body .= '<tr>
                        <td class="center">'.$c.'</td>
                        <td class="left">'.$value->getSku().'</td>
                        <td colspan="3" class="left">'.$value->getProductName().'</td>
                    </tr>
                    <tr>
                        <td class="left"></td>
                        <td class="center">'.$value->getQuantity().'</td>
                        <td class="right">'.number_format($value->getPrice()).'<sup>đ</sup></td>
                        <td class="right">'.$reduce.'</td>
                        <td class="right">'.number_format($intoMoney).'<sup>đ</sup></td>
                    </tr>';
            $total += $intoMoney;
        }
        $body .= '<tr><td colspan="4" class="right">Tổng tiền<sup>('.$no.')</sup></td><td class="right">'.number_format($total).'<sup>đ</sup></td></tr>';
//        $body .=    '</tbody></table>';
        return $body;
    }


    function getFooter(Order $order, $is_exchange, $is_curr, $is_return, $is_add_new)
    {
        $reduce = 0;
        if(!empty($order->getTotal_reduce()) && $order->getTotal_reduce() != 'NULL')
        {
           $reduce = $order->getTotal_reduce(); 
        }
        $paymentType = '';
        if(!empty($order->getPayment_type())) {
            if($order->getPayment_type() == 0) {
                $paymentType = 'Tiền mặt';
            } else if($order->getPayment_type() == 1) {
                $paymentType = 'Chuyển khoản';
            } else if($order->getPayment_type() == 2) {
                $paymentType = 'Nợ';
            }
        }
        $no = 1;
        $str = "";
        if($is_exchange) {
            $str .= "($no)";
            $no++;
        }
        if($is_curr) {
            $str .= "-($no)";
            $no++;
        }
        if($is_return) {
            $str .= "-($no)";
            $no++;
        }
        if($is_add_new) {
            $str .= "+($no)";
        }
        $footer =   '<h4 class="left" style="margin: 5px 0;">Tổng hóa đơn</h4>
                    <table>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="right">Tổng tiền<sup>'.$str.'</sup></td>
                                <td class="right">'.number_format(empty($order->getTotal_amount()) || $order->getTotal_amount() == 'NULL' ? 0 : $order->getTotal_amount()).'<sup>đ</sup></td>
                            </tr>';
                if(!empty($order->getDiscount())) {
                    $footer .= '<tr>
                                <td colspan="4" class="right">Giảm trên tổng đơn</td>
                                <td class="right">'.($order->getDiscount() > 0 && $order->getDiscount() < 100 ? $order->getDiscount()."%" : number_format($order->getDiscount())."<sup>đ</sup>").'</td>
                            </tr>';
                } else {
                    $footer .= '<tr>
                                <td colspan="4" class="right">Giảm trên tổng đơn</td>
                                <td class="right">0<sup>đ</sup></td>
                            </tr>';
                }

                if(!empty($order->getCustomerName())) {
                    $footer .= '<tr>
                                <td colspan="4" class="right">Trừ trong ví</td>
                                <td class="right">' . number_format(empty($order->getWallet()) || $order->getWallet() == 'NULL' ? 0 : $order->getWallet()) . '<sup>đ</sup></td>
                            </tr>';
                }
                $footer .=   '<tr>
                                <td colspan="4" class="right">Tổng Giảm trừ</td>
                                <td class="right">'.number_format($reduce).'<sup>đ</sup></td>
                            </tr>';
                $footer .=   '<tr>
                                <td colspan="4" class="right">Tổng thanh toán</td>';
                    if(!empty($order->getTotal_checkout())) {
                        if($order->getPaymentExchangeType() == 2) {
                            if(strpos($order->getTotal_checkout(),"-") == false) {
                                $footer .=   '<td class="right">'.number_format($order->getTotal_checkout()).'<sup>đ</sup></td>';
                            }  else {
                                $footer .=   '<td class="right">-'.number_format($order->getTotal_checkout()).'<sup>đ</sup></td>';
                            }
                        } else {
                            $footer .=   '<td class="right">'.number_format($order->getTotal_checkout()).'<sup>đ</sup></td>';
                        }
                    } else {
                        $footer .=   '<td class="right">0<sup>đ</sup></td>';
                    }
                $footer .=   '</tr>';
                $footer .=   '<tr>
                                <td colspan="4" class="right">Khách thanh toán</td>
                                <td class="right"><p style="margin-right: 0">'.number_format(empty($order->getCustomer_payment()) || $order->getCustomer_payment() == 'NULL' ? 0 : $order->getCustomer_payment()).'<sup>đ</sup></p>
                                    <small style="margin-top:0">'.$paymentType.'</small>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" rowspan="2" class="right">Trả lại</td>
                                <td class="right">Tiền mặt</td>
                                <td class="right">
                                    <p style="margin-right: 0;margin-bottom:0;">'.number_format(empty($order->getRepay()) || $order->getRepay() == 'NULL' ? 0 : $order->getRepay()).'<sup>đ</sup></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="right">Chuyển vào ví</td>
                                <td class="right">
                                    <p style="margin-right: 0;margin-bottom:0;">'.number_format(empty($order->getTransferToWallet()) || $order->getTransferToWallet() == 'NULL' ? 0 : $order->getTransferToWallet()).'<sup>đ</sup></p>
                                </td>
                            </tr>';
                if(!empty($order->getCustomerName())) {
                    $footer .= '<tr>
                                <td colspan="4" class="right">Tiền tích lũy</td>
                                <td class="right">
									' . number_format(empty($order->getPointSave()) || $order->getPointSave() == 'NULL' ? 0 : $order->getPointSave()) . '<sup>đ</sup>
								</td>
                            </tr>';
                }
                $footer .= '</tfoot>
                    </table>
                    <p class="left">Lưu ý:</p>
                    <p class="left note">- Hàng đổi trả kèm theo hóa đơn trong vòng 2 ngày</p>
                    <p class="left note">- Hàng sale không được đổi trả</p>
                    <p class="left note">- Kiểm tra hàng trước khi ra về</p>';
            if(!empty($order->getCustomerName())) {
                $footer .= '<p class="left note">- Tiền tích lũy sẽ được cộng vào ví trong vòng 24h</p>
					<p class="left note">- Tiền trả lại được chuyển vào ví sẽ có hiệu lực ngay</p>';
            }
            $footer .= '<p class="center">* * * * * * * * * * * *</p>
                    <p class="center">Xin cám ơn Quý khách</p>
                    <p class="center">Hẹn gặp lại</p>
                </div>
            </div>
            <script type="text/javascript">
                /* <![CDATA[ */
                  function get_object(id) {
                   var object = null;
                   if (document.layers) {
                    object = document.layers[id];
                   } else if (document.all) {
                    object = document.all[id];
                   } else if (document.getElementById) {
                    object = document.getElementById(id);
                   }
                   return object;
                  }
                get_object("barcode").innerHTML=DrawHTMLBarcode_Code128A(get_object("barcode").innerHTML,"yes","in",0,1.5,0.3,"bottom","center","","black","white");
                /* ]]> */
            </script>
        </body>
        </html>';
        return $footer;
    }
    function rrmdir($src) {
        if (file_exists($src)) {
            $dir = opendir($src);
            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    $full = $src . '\\' . $file;
                    if (is_dir($full)) {
                        rrmdir($full);
                    } else {
                        unlink($full);
                    }
                }
            }
            closedir($dir);
            rmdir($src);
        }
    }
    function vn_to_str($str){
        $unicode = array(
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D'=>'Đ',
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
         
        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return $str;
    }

    function generate_barcode_value($value)
    {
        $length = strlen($value);
        $number_zero = 10 - $length;
        $zero = "";
        for($i = 0; $i<$number_zero; $i++)
        {
            $zero .= "0";
        }
        return "HD".$zero.$value;
    }
}

