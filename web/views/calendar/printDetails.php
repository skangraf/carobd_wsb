<?php
use \feelcom\wsb as wsb ;
$uuid=$_POST['uuid'];

$pdf= new wsb\Pdf();
$pdf->getPdfOrder($uuid);