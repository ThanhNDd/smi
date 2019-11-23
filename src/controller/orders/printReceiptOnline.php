<?php
require __DIR__ . '/../../../vendor/autoload.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
/**
 * 
 */
class PrintReceiptOnline
{   
    function __construct()
    {
        
    }  

    function print()
    {
        try {  
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 5,
                'margin_bottom' => 5
            ]);
            $html = $this->getHeader();
            // $html .= $this->getBody($details);    
            // $html .= $this->getFooter($order);

            $mpdf->SetDisplayMode('real');
            $mpdf->SetDisplayPreferences('/FitWindow/NoPrintScaling');
            $mpdf->WriteHTML($html);
            $mpdf->AddPage();
            $mpdf->Output("receiptOnline.pdf", 'F');
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            throw new Exception($e);
        }
    }

    function getHeader()
    {
        $header = '
            <!DOCTYPE>
            <html>
            <head>
                <title>Receipt Template</title>
                <meta charset="utf-8">
                <style type="text/css">
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
                        width: 219px;
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
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="body center">
                        <table class="center">
                                <tr>
                                    <td colspan="2" class="center">
                                        <span>Mã vận đơn</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="center">
                                        <h1>1591442421834</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="left" style="200px">Người nhận</td>
                                    <td class="left"><b>Nguyễn Thanh Sang</b></td>
                                </tr>
                                <tr>
                                    <td class="left">SĐT</td>
                                    <td class="left">0983051533</td>
                                </tr>
                                <tr>
                                    <td class="left">Địa chỉ</td>
                                    <td class="left">
                                        Đội 9, Xóm giữa, Ngọc than, Ngọc mỹ, Quốc Oai, Hà nội
                                    </td>
                                </tr>
                        </table>
                    </div>
                </div>
            </body>
        </html>';  
        return $header;
    }
}

