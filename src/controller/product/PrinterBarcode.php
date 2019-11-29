<?php
require __DIR__ . '/../../../vendor/autoload.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once("../../common/constants.php");
/**
 * 
 */
class PrinterBarcode
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
                'margin_top' => 0,
                'margin_bottom' => 0,
                'tempDir' => __DIR__ . '/tmp'
            ]);
            $mpdf->SetDisplayMode('real');
            $mpdf->SetDisplayPreferences('/FitWindow/NoPrintScaling');

            // var_dump($data);
            if(count($data) == 1)
            {
                $content = $this->getHeader();
                $content .= '<table>
                            <tr>
                                <td colspan="3" class="center">
                                    <h3>'.$data[0]["name"].'</h3>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="center">
                                    <barcode code="'.$data[0]["sku"].'" type="C128A" size="2" height="0.5" class="barcode" />
                                </td>
                            </tr>
                            <tr>
                                <td class="left"><h3>'.$data[0]["size"].'</h3></td>
                                <td class="center"><h2>'.$data[0]["sku"].'</h2></td>
                                <td class="right"><h3>'.$data[0]["price"].' đ</h3></td>
                            </tr>
                        </table>';
                $content .= $this->getFooter();
                $mpdf->AddPage();
                $mpdf->WriteHTML($content);
            } else
            {
                $i = 0;
                foreach ($data as $d) {
                    if($i % 2 == 0)
                    {
                        $content = "";
                        $content = $this->getHeader();
                    } 
                    $content .= '<table>
                                    <tr>
                                        <td colspan="3" class="center">
                                            <h3>'.$d["name"].'</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="center">
                                            <barcode code="'.$d["sku"].'" type="C128A" size="2" height="0.5" class="barcode" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="left"><b>'.$d["size"].'</b></td>
                                        <td class="center"><h2>'.$d["sku"].'</h2></td>
                                        <td class="right"><b>'.$d["price"].' đ</b></td>
                                    </tr>
                                </table>';
                    if($i % 2 != 0 || count($data)-1 == $i)
                    {
                        $content .= $this->getFooter();
                        $mpdf->AddPage();
                        $mpdf->WriteHTML($content);
                        //$i = 0;
                    } 
                    $i++;                     
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
                        font-size: 15px;
                        font-family: sans-serif;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    td {
                        //border: 1px solid;
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