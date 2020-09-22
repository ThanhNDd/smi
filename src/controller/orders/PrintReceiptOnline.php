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

    function print(array $data)
    {
        try {  
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'tempDir' => __DIR__ . '/tmp'
            ]);
            $html = $this->getContent($data);

//            echo $html;

            $mpdf->SetDisplayMode('real');
            $mpdf->SetDisplayPreferences('/FitWindow/NoPrintScaling');
            $mpdf->WriteHTML($html);
            $mpdf->AddPage();
            $folder_path = "pdf"; 
            $files = glob($folder_path.'/*');  
            foreach($files as $file) { 
                if(is_file($file))  {
                    unlink($file);  
                }
            } 
            //mkdir("pdf", 0777, true);
            $filename = "receiptonline".time().".pdf";
            $mpdf->Output("pdf/".$filename, 'F');
            chmod("pdf/".$filename, 0775);


            $myfile = fopen("pdf/receipt.html", "w") or die("Unable to open file!");
            fwrite($myfile, $html);
            fclose($myfile);


            return $filename;
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            throw new Exception($e);
        }
    }

    function getContent($data)
    {
        $content = '
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
                        //border: 1px solid;
                        padding: 4px 0;
                        vertical-align: top;
                    }
                    table thead {
                        font-weight: bold;
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
                                        <h1 style="margin-top:0px; margin-bottom: 0px;">'.$data[0]['bill'].'</h1>
                                        <p>('.$data[0]['shipping_unit'].')</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="left" style="width:50px">Họ tên</td>
                                    <td class="left"><b>'.$data[0]['name'].'</b></td>
                                </tr>
                                <tr>
                                    <td class="left">SĐT</td>
                                    <td class="left">'.$data[0]['phone'].'</td>
                                </tr>
                                <tr>
                                    <td class="left">Địa chỉ</td>
                                    <td class="left">'.$data[0]['address'].'</td>
                                </tr>
                        </table>
                    </div>
                </div>
            </body>
        </html>';  
        return $content;
    }
}

