<?php
namespace feelcom\wsb;

require_once ('../vendor/tcpdf/tcpdf/tcpdf.php');

use TCPDF;



class Pdf extends Model
{

    public function getPdfOrder($uuid=''){

        $cal = new Calendar();

        $data = '';
        $details = '';
        $servicesHtml = '';
        $reservation = $cal->getReservationsAdm(0,0,$uuid);

        if(!empty($reservation)){
            $details = $reservation[0];
            $data = sprintf("%02d-%02d-%04d", $details['f_day'], $details['f_month'], $details['f_year']);
            $data = $data.' | '.$details['houre'];

            $services = explode(',',$details['service']);

            $i=0;
            foreach ($services as $service){
                $i++;

                $service = trim(preg_replace('/\s+/', ' ', $service));

                $servicesHtml .= '<tr>
                                    <td height="20">'.$i.'</td>
                                    <td>'.$service.'</td>
                                    <td></td>
                                    <td></td>
                                </tr>';

            }

        }

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Protokół naprawy');
        $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 0, 0), array(0, 64, 128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->setHeaderFont(array('dejavusans', '', 6));
        $pdf->setFooterFont(Array('dejavusans', '', 7));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // ---------------------------------------------------------
        // set default font subsetting mode
        $pdf->setFont('dejavusans', '', 14, '', true);
        $pdf->AddPage();
        $html = <<<EOF
            <style>
                .details {
                        font-family: dejavusans;
                        font-size: 9pt;
                        margin-top: 200px;
                }
                
                .services {
                    font-family: dejavusans;
                    font-size: 9pt;
                    margin-top: 200px;
                }
                
                .services td {
                    border: 1px solid grey;
                }
                
                .notices {
                    font-family: dejavusans;
                    font-size: 9pt;
                    margin-top: 200px;
                }
                
                .notices td {
                    border: 1px solid grey;
                }
                
                .signatures {
                    font-family: dejavusans;
                    font-size: 9pt;
                }
                
                
                .margintop {
                    height: 800pt;
                }
            
            </style>
            <h3>Protokół naprawy</h3>
            <br>
            <h6>{$data} </h6>
            <br>
            <div class="margintop"></div>
            <table class="details" cellspacing='0' cellpadding='1' border='0'>
                <tr>
                    <td>Klient: {$details['cusName']}<br>telefon: {$details['cusPhone']}</td>
                    <td>Samochód: {$details['make']} {$details['model']}<br>nr rej.: {$details['carRegNo']}</td>
                </tr>
            </table>
            <br>
            <div class="margintop"></div>
            <br>
            <table class="services" cellspacing='1' cellpadding='1' border='0'>
                <tr align="center" >
                    <td width="30" height="20">Lp.</td>
                    <td width="410">Usługa</td>
                    <td width="100" >wykonana</td>
                    <td width="100" >niewykonana</td>
                </tr>
                {$servicesHtml}
            </table>
            <br>
            <div class="margintop"></div>
            <h6>Uwagi: </h6>
            <table class="notices" cellspacing='1' cellpadding='1' border='0'>
                <tr align="center" >
                    <td height="200"></td>
                </tr>
            </table>
            <br>
            <div class="margintop"></div>
            <br>
            <br>
            <div class="margintop"></div>
            <br>
            <table class="signatures" cellspacing='1' cellpadding='1' border='0'>
                <tr align="center" >
                    <td width="320">..................<br>podpis klienta</td>
                    <td width="320">..................<br>podpis obsługującego</td>
                </tr>
            </table>

EOF;
        $pdf->writeHTML($html);
        ob_end_clean();
        $pdf->Output('d:\www\dev.carobd.local\carobd_wsb\web\test.pdf', 'D');
    }

    public function getPdfConfirmation($uuid=''){

        $cal = new Calendar();

        $data = '';
        $details = '';
        $servicesHtml = '';
        $sum=0.00;
        $reservation = $cal->getReservationsAdm(0,0,$uuid);

        if(!empty($reservation)){
            $details = $reservation[0];
            $data = sprintf("%02d-%02d-%04d", $details['f_day'], $details['f_month'], $details['f_year']);
            $data = $data.' | '.$details['houre'];

            $serviceId = explode('|',$details['serviceList']);

            $i=0;
            foreach ($serviceId as $sId){
                $i++;

                $service = $cal->getServiceDetails($sId);

                if(!empty($service)){
                    $service = $service[0];


                    $servicesHtml .= '<tr>
                                    <td height="20">'.$i.'</td>
                                    <td>'.$service['name'].'</td>
                                    <td class="right">'.$service['price'].' zł</td>
                                </tr>';
                    $sum =  $sum + $service['price'];
                }
            }
            $sum = number_format($sum,2);
        }

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetTitle('Potwierdzenie rezerwacji');
        $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0, 0, 0), array(0, 64, 128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->setHeaderFont(array('dejavusans', '', 6));
        $pdf->setFooterFont(Array('dejavusans', '', 7));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // ---------------------------------------------------------
        // set default font subsetting mode
        $pdf->setFont('dejavusans', '', 14, '', true);
        $pdf->AddPage();
        $html = <<<EOF
            <style>
                .details {
                        font-family: dejavusans;
                        font-size: 9pt;
                        margin-top: 200px;
                }
                
                .services {
                    font-family: dejavusans;
                    font-size: 9pt;
                    margin-top: 200px;
                    vertical-align: center;
                }
                
                .services td {
                    border: 1px solid grey;
                    vertical-align:center;
                }
                
                .notices {
                    font-family: dejavusans;
                    font-size: 9pt;
                    margin-top: 200px;
                }
                
                .notices td {
                    border: 1px solid grey;
                }
                
                .right {
                    text-align: right;
                }
                
                
                .margintop {
                    height: 800pt;
                }
            
            </style>
            <h3>Potwierdzenie rezerwacji</h3>
            <br>
            <h6>{$data} </h6>
            <br>
            <div class="margintop"></div>
            <table class="details" cellspacing='0' cellpadding='1' border='0'>
                <tr>
                    <td>Klient: {$details['cusName']}<br>telefon: {$details['cusPhone']}</td>
                    <td>Samochód: {$details['make']} {$details['model']}<br>nr rej.: {$details['carRegNo']}</td>
                </tr>
            </table>
            <br>
            <div class="margintop"></div>
            <br>
            <table class="services" cellspacing='1' cellpadding='1' border='0'>
                <tr align="center" >
                    <td width="30" height="20">Lp.</td>
                    <td width="500">Usługa</td>
                    <td width="100" >cena</td>
                </tr>
                {$servicesHtml}
                <tr>
                    <td class="right" colspan="2" height="20"> wartość:</td>
                    <td class="right">{$sum} zł</td>
                </tr>
            </table>
            <br>
            <div class="margintop"></div>
            <h6>Uwagi: </h6>
            <table class="notices" cellspacing='1' cellpadding='1' border='0'>
                <tr align="center" >
                    <td height="200"></td>
                </tr>
            </table>
EOF;
        $pdf->writeHTML($html);
        ob_end_clean();
        $pdf->Output('d:\www\dev.carobd.local\carobd_wsb\web\test.pdf', 'D');
    }


}