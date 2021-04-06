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

    function print(array $datas)
    {
        try {  
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'tempDir' => __DIR__ . '/tmp'
            ]);
            var_dump($datas);
            foreach ($datas as $data) {
                $html = $this->getContent($data);
                $mpdf->SetDisplayMode('real');
                $mpdf->SetDisplayPreferences('/FitWindow/NoPrintScaling');
                $mpdf->AddPage();
                $mpdf->WriteHTML($html);
            }

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
        $d = $data['data'][0];
        $content = '<!DOCTYPE html>
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
                p,
                h3 {
                    margin: 5px;
                }
        
                .container,
                table {
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
                    vertical-align: top;
                    padding-left: 10px !important;
                }
                table thead {
                    font-weight: bold;
                }
                body, .container {
                    width: 220px;
                    height: 151px;
                    overflow: hidden;
                    padding-left: 10px !important;
                    padding-right: 10px !important;
                    margin: 0 !important;
                }
                .barcode {
                	margin: 0;
                	vertical-align: top;
                	color: #000000;
                	text-align: center;
                }
                .barcodecell {
                	text-align: center;
                	vertical-align: middle;
                	padding: 0;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="body">
                    <table>';
                        $content .= '<tr>';
                        $content .= '<td class="left" style="vertical-align: middle;">';
                        $shipping_unit = "";
                        switch($d['shipping_unit']) {
                            case 'VTP':
                                $shipping_unit = 'VIETTEL';
                                break;
                            case 'J&T':
                                $shipping_unit = 'J&T';
                                break;
                            case 'GHN':
                                $shipping_unit = 'GHN';
                                break;
                            case 'GHTK':
                                $shipping_unit = 'GHTK';
                                break;
                            case 'VNP':
                            case 'VNPN':
                                $shipping_unit = 'VNPOST';
                                break;
                            case 'NINJAVAN':
                                $shipping_unit = 'NINJA';
                                break;
                            case 'BESTEXPRESS':
                                $shipping_unit = 'BEST';
                                break;
                            default:
                                $shipping_unit = '';
                                break;
                        }
                        $source = "";
                        switch($d['source']) {
                            case 1:
                                $source = "WEB-";
                                break;
                            case 2:
                                $source = "FB-";
                                break;
                            case 3:
                                $source = "SHOPEE-";
                                break;
                            default:
                                $source = "";
                                break;
                        }
                        $content .= $source.$shipping_unit;
                        $content .= '</td>';
                        $content .= '<td class="right" style="padding-right:15px;">'.$d['bill'].'</td>';
                        $content .= '</tr>';
                        $content .= '<tr>';
                        $content .= '<td colspan="2" align="left">
                                <barcode code="'.$d['bill'].'" type="C128B" class="barcode"></barcode>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="left" style="padding: 0;padding-top: 5px;">
                                <b style="font-size: 12px;">'.$d['customer_name'].' - '.$d['phone'].'</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="left" style="border-bottom: 1px solid #b1b1b1;font-size: 11px;padding: 0;padding-bottom: 2px;padding-right:10px;">
                                '.$d['address'].
                            '</td>
                        </tr>';
                        $c = 1;
                        $details = $data['details'];
                        $content .= '<tr><td colspan="2" class="left" style="font-size: 10px;padding: 0;padding-top:5px;font-weight: bold;">Tổng số sản phẩm: '.count($details).'</td></tr>';
                        foreach ($details as $d) {
                            $content .= '<tr>';
                            $content .= '<td colspan="2" class="left" style="font-size: 10px;padding: 0;">';
                            $content .= $c.'.'.$d["name"].', '.$d["color"].', '.$d["size"].'. SL:'.$d["quantity"];
                            $content .= '</td>';
                            $content .= '</tr>';
                            $c++;
                        }
                        
        $content .= '</table>
                </div>
            </div>
        </body>
        
        </html>';
        return $content;
    }
}

