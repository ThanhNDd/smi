<?php
require __DIR__ . '/../../../vendor/autoload.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once("../../common/common.php");
/**
 *
 */
class PrinterBarcode
{
    function __construct()
    {

    }

    function print(array $list, array $data)
    {
        try {
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0,
                'tempDir' => __DIR__ . '/tmp'
            ]);
            $mpdf->SetDisplayMode('real');
            $mpdf->SetDisplayPreferences('/FitWindow/NoPrintScaling');

            if(count($list) == 1)
            {
                $sku = $list[0]["sku"];
                $qty = 1;
                for($i =0; $i < count($data); $i++) {
                    if($data[$i]->id == $sku) {
                        $qty = $data[$i]->qty;
                    }
                }
                for($i=0; $i < $qty; $i++) {
                    $content = $this->getHeader();
                    $content .= $this->getContent($list[0]);
                    $content .= $this->getFooter();
                    $mpdf->AddPage();
                    $mpdf->WriteHTML($content);
                }
//                $content = $this->getHeader();
//                $content .= $this->getContent($list[0]);
//                $content .= $this->getFooter();
//                $mpdf->AddPage();
//                $mpdf->WriteHTML($content);
            } else
            {
                foreach ($list as $d) {
                    $sku = $d["sku"];
                    $qty = 1;
                    for($i =0; $i < count($data); $i++) {
                        if($data[$i]->id == $sku) {
                            $qty = $data[$i]->qty;
                        }
                    }
                    for($i=0; $i < $qty; $i++) {
                        $content = $this->getHeader();
                        $content .= $this->getContent($d);
                        $content .= $this->getFooter();
                        $mpdf->AddPage();
                        $mpdf->WriteHTML($content);
                    }

                }
            }

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
            //mkdir("pdf", 0777, true);
            $filename = "barcode".time().".pdf";
            $mpdf->Output("pdf/".$filename, 'F');
            chmod("pdf/".$filename, 0775);
            return $filename;
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
            throw new Exception($e);
        }
    }

    function getContent($data) {
        return '<table>
                        <tr>
                            <td colspan="3" class="center">
                                <h3>'.$data["name"].'</h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="center">
                                <barcode code="'.$data["sku"].'" type="C128A" size="2" height="0.5" class="barcode" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="center"><h2>'.$data["sku"].'</h2></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="left">Size: <b>'.$data["size"].'</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="left">Màu: <b>'.$data["color"].'</b></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="left">Giá: <b>'.$data["price"].' <sup>đ</sup></b></td>
                        </tr>
                    </table>';
    }

    function getHeader()
    {
        $content = '<!DOCTYPE>
            <html>
            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title>Receipt Template</title>
                
                <style type="text/css">
                    .center {
                        text-align: center;
                    }
                    .left {
                        text-align: left;
                        padding-left: 20px;
                    }
                    .right {
                        text-align: right;
                        padding-right: 20px;
                    }
                    p, h3, h2 {
                        margin: 5px;
                    }
                    .container, table {
                        width: 150px;
                        font-size: 17px;
                        font-family: sans-serif;
                        margin-top: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    td {
                        padding: 4px 0;
                    }
                    table thead {
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div class="container">';
        return $content;
    }

    function getFooter()
    {
        $content = '</div>
            </body>
        </html>';
        return $content;
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
}