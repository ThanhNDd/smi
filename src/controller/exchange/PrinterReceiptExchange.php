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

    function print(Order $order, array $details)
    {
        try {  
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'tempDir' => __DIR__ . '/tmp'
            ]);
            $html = $this->getHeader($order);
            $html .= $this->getBody($details);
            $html .= $this->getFooter($order);

            echo $html;

            $mpdf->SetDisplayMode('real');
            $mpdf->SetDisplayPreferences('/FitWindow/NoPrintScaling');
            $mpdf->WriteHTML($html);
            $mpdf->AddPage();

            // $this->rrmdir("pdf");
            $folder_path = "pdf"; 
            $files = glob($folder_path.'/*');  
            // Deleting all the files in the list 
            foreach($files as $file) { 
                if(is_file($file))  {
                    // Delete the given file 
                    unlink($file);  
                }
            } 
            
            // mkdir("pdf", 0777, true);
            $filename = "receipt".time().".pdf";
            $mpdf->Output("pdf/".$filename, 'F');
            chmod("pdf/".$filename, 0777);
            return $filename;
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            throw new Exception($e);
        }
    }

    function getHeader($order)
    {
        $header = '
            <!DOCTYPE>
            <html>
            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title>Receipt Template</title>
                <style type="text/css">
                    @page bigger { sheet-size: 58mm 100mm; }
                    #barcode {font-weight: normal; font-style: normal; line-height:normal; font-family: sans-serif; font-size: 12pt}
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
                    p, h3 {
                        margin: 5px;
                    }
                    .container, table {
                        width: 300px;
                        font-size: 13px;
                        font-family: sans-serif;
                    }
                    .custom-font {
                        font-size: 13px !important;
                        font-family: sans-serif !important;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    td {
                        border: 1px solid;
                        padding: 4px 0;
                    }
                    table thead {
                        font-weight: bold;
                    }
                    @media print {
                        body {transform: scale(.7);}
                        table {page-break-inside: avoid;}
                    }
                    .note {
                        font-size: 11px;
                        font-family: sans-serif;
                    }
                </style>
            </head>
            <body>
                <div class="container p-0 float-left">
                    <div class="header row">
                        <div class="center col-12 p-0 m-0">
                            <h4>SHOP MẸ ỈN</h4>
                            <p>Thời trang trẻ em cao cấp</p>
                            <span>* * * * * * * * * * * *</span>
                            <p style="margin: 5px 0;">Đ/c: 227 Phố Huyện - Thị Trấn Quốc Oai - Hà Nội</p>
                            <p>Hotline: 0962.926.302</p>
                            <p>Website: www.shopmein.net</p>
                            <p>Facebook: Shop Mẹ Ỉn</p>
                            <span>* * * * * * * * * * * *</span>
                            <h4>HÓA ĐƠN THANH TOÁN</h4>
                            <barcode code="'.$order->getId().'" type="C128A" class="barcode" />
                            <p>HD'.$order->getId().'</p>
                            <span>
                                <span class="float-left">Ngày tháng:</span>
                                <span class="float-right mr-2">'.date('d/m/Y - H:i:s').'</span>
                            </span>
                        </div>
                    </div>
                    <div class="body center">
                        <table class="center">
                            <thead>
                                <tr>
                                    <td class="center" style="width: 30px;">Stt</td>
                                    <td colspan="4" class="left">Tên sản phẩm</td>
                                </tr>
                                <tr>
                                    <td class="left"></td>
                                    <td class="center" style="width: 30px;">SL</td>
                                    <td class="right" style="width: 65px;">Giá</td>
                                    <td class="right" style="width: 40px;">%</td>
                                    <td class="right" style="width: 65px;">Thành tiền</td>
                                </tr>
                            </thead>';
        return $header;
    }
    function getBody($details)
    {
        $body = '<tbody>';
        $c = 0;
        foreach($details as $key => $value)
        {
            $intoMoney = $value->getPrice()*$value->getQuantity() - (empty($value->getReduce()) ? 0 : $value->getReduce());
            $c++;
            $body .= '<tr>
                        <td class="center">'.$c.'</td>
                        <td colspan="4" class="left">'.$value->getProductId().'</td>
                    </tr>
                    <tr>
                        <td class="left"></td>
                        <td class="center">'.$value->getQuantity().'</td>
                        <td class="right">'.number_format($value->getPrice()).'</td>
                        <td class="right">'.((!empty($value->getReducePercent()) && $value->getReducePercent() != 0) ? ("-".$value->getReducePercent()."%") : "").'</td>
                        <td class="right">'.number_format($intoMoney).'</td>
                    </tr>';
        }
        $body .= '</tbody>';
        return $body;
    }
    function getFooter($order)
    {
        $reduce = 0;
        if(!empty($order->getTotal_reduce()) && $order->getTotal_reduce() != 'NULL')
        {
           $reduce = $order->getTotal_reduce(); 
        }
        // $discount = 0;
        // if(!empty($order->getDiscount()) && $order->getDiscount() != 'NULL')
        // {
        //    $discount = $order->getDiscount(); 
        // }
        // $reduce = $reduce + $discount;
        $footer =   '<tfoot>
                            <tr>
                                <td colspan="4" class="right">Tổng tiền:</td>
                                <td class="right">'.number_format(empty($order->getTotal_amount()) || $order->getTotal_amount() == 'NULL' ? 0 : $order->getTotal_amount()).'</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="right">Giảm trên tổng đơn:</td>
                                <td class="right">'.($order->getDiscount() < 100 ? $order->getDiscount()."%" : number_format($order->getDiscount())).'</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="right">Tổng Giảm trừ:</td>
                                <td class="right">'.number_format($reduce).'</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="right">Tổng thanh toán:</td>
                                <td class="right">'.number_format(empty($order->getTotal_checkout()) || $order->getTotal_checkout() == 'NULL' ? 0 : $order->getTotal_checkout()).'</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="right">Khách thanh toán:</td>
                                <td class="right">'.number_format(empty($order->getCustomer_payment()) || $order->getCustomer_payment() == 'NULL' ? 0 : $order->getCustomer_payment()).'</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="right">Trả lại:</td>
                                <td class="right">'.number_format(empty($order->getRepay()) || $order->getRepay() == 'NULL' ? 0 : $order->getRepay()).'</td>
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                    <p class="left">Lưu ý:</p>
                    <p class="left note">- Hàng đổi trả kèm theo hóa đơn trong vòng 2 ngày</p>
                    <p class="left note">- Hàng sale không được đổi trả</p>
                    <p class="left note">- Kiểm tra hàng trước khi ra về</p>
                    <br>
                    <p class="center">Xin cám ơn Quý khách</p>
                    <p class="center">Hẹn gặp lại</p>
                </div>
            </div>
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
        $number_zero = 13 - $length;
        $zero = "";
        for($i = 0; $i<$number_zero; $i++)
        {
            $zero .= "0";
        }
        return $zero.$value;
    }
}

