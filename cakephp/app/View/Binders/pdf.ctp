<?php
App::import('Vendor', 'tcpdf/tcpdf');

$fileWidth=$ehon["Attachment"][0]["width"];
$fileHeight=$ehon["Attachment"][0]["height"];

$a4size=array(297,210);

$pdfMargin=5;

$isWriteText=true;

$pdfOri="L";
if($fileWidth<$fileHeight) $pdfOri="P";

$pdf = new TCPDF($pdfOri, 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("EHON");
$pdf->SetTitle('EHON - ');
$pdf->SetSubject('JAPANESE');
$pdf->SetKeywords('ehon,JAPANESE');
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetImageScale(PDF_IMAGE_SCALE_RATIO); 
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetFillColor(255);


$pageCount=1;
foreach ($ehon["Attachment"]as $att) {

	$fileName="files/attachment/file/".$att["id"]."/".$att["file"];

	$pdf->AddPage();
	// all size set
	$imgXmargin=$pdfMargin;
	$imgYmargin=$pdfMargin;
	if($pdfOri=="L"){
		$imgWidth=$a4size[0]-$pdfMargin*2;
		$imgHeight=$imgWidth*($fileHeight/$fileWidth);
		if($imgHeight>$a4size[1]){
			$imgHeight=$a4size[1]-$pdfMargin*2;
			$imgWidth=$imgHeight*($fileWidth/$fileHeight);
			$imgXmargin=($a4size[0]-$pdfMargin*2-$imgWidth)/2;
		}else{
			$imgYmargin=($a4size[1]-$pdfMargin*2-$imgHeight)/2;
		}
	}else{
		$imgWidth=$a4size[1]-$pdfMargin*2;
		$imgHeight=$imgWidth*($fileHeight/$fileWidth);
		if($imgHeight>$a4size[0]){
			$imgHeight=$a4size[0]-$pdfMargin*2;
			$imgWidth=$imgHeight*($fileWidth/$fileHeight);
			$imgXmargin=($a4size[1]-$pdfMargin*2-$imgWidth)/2;
		}else{
			$imgYmargin=($a4size[0]-$pdfMargin*2-$imgHeight)/2;
		}
	}
	// drow image
	$pdf->Image($fileName,$imgXmargin,$imgYmargin, $imgWidth, $imgHeight, "JPEG", '', '', true, 300, '', false, false, 0);

	if($isWriteText){
		// drow text
		foreach ($masksAll[$att["seq"]] as $mask) {
			foreach ($mask["Translation"]as $tranc) {
				if($tranc["lang_code"]==$langCode){
					drowText(
						$pdf,
						$imgWidth*($mask["Mask"]["x"]/100)+$imgXmargin,
						$imgHeight*($mask["Mask"]["y"]/100)+$imgYmargin,
						$imgWidth*($mask["Mask"]["width"]/100), 
						$imgHeight*($mask["Mask"]["height"]/100), 
						$tranc["translation"]);
				}
			}
		}		
	}


	$pdf->SetFont('freeserif');
	$footerFontSize=12;
	$pdf->SetFontSize($footerFontSize);
	$pdf->SetXY($imgXmargin,$a4size[1]-$pdfMargin-$footerFontSize);
	$pdf->Cell($imgWidth, $footerFontSize, "- ".$pageCount." -", 0, 1, 'R');
	$pdf->SetXY($imgXmargin,$a4size[1]-$pdfMargin-$footerFontSize);
	$cop="";
	if(isset($ehon["Ehon"]["copyright"]) && $ehon["Ehon"]["copyright"]!="")
		$cop="(C) ".$ehon["Ehon"]["copyright"]." ";

	$pdf->Cell($imgWidth, $footerFontSize, $cop."Create by ehon.link", 0, 1, 'L');

	$pageCount++;
}

ob_end_clean();
$pdf->Output('seikyuusyo.pdf', 'I');

function drowText($pdf,$x,$y,$w,$h,$baseText, $fontSize = 16){
	$pixsize=0.35;
	$pixheight=0.4;
	$pdf->Rect($x,$y,$w,$h,'F');

	if(strlen($baseText) == mb_strlen($baseText,'utf8')) {
		// english
		$pdf->SetFont('freeserif');
		$pixsize=0.15;
	}else if(preg_match("/[ぁ-んァ-ヶー一-龠０-９、。]+/u",$baseText)) {
		// use kanji
		$pdf->SetFont('kozgopromedium');
		$pixsize=0.35;
	}else{
		$pdf->SetFont('freeserif');
		$pixsize=0.15;
	}


	$aTxts = explode("\n", $baseText);
	$txts=array();
	$fSize=$fontSize;
	foreach($aTxts as $txt){
		$isFix=false;
		for ($i = 0; $i < 6; $i++ ) {
			if ($w >= (mb_strlen(trim($txt),'UTF-8')) * ($fontSize - $i) * $pixsize ) {
				$tSize = $fontSize-$i;
				if($tSize<$fSize) $fSize=$tSize;
				$isFix=true;

				array_push($txts, $txt);
				break;
			}
		}
		// サイズが確定しなかったら折り返し
		if(!$isFix){
			$tSize = $fontSize-$i;
			if($tSize<$fSize) $fSize=$tSize;
			$tmps=mb_str_split($txt,floor($w/($fSize*$pixsize)));
			foreach ( $tmps as $val ) {
        		$txts[] = $val;
    		}
		}
	}
	$pdf->SetFontSize($fSize);
	for ($i = 0; $i < count($txts); $i++ ) {
		//$pixheightPower=1.1;
//		if($fSize<10) $pixheightPower=0.98;
		$pdf->SetXY($x,$y+$i*$fSize*$pixheight);
		$pdf->Cell($w, $fSize*$pixheight, $txts[$i], 0, 1, 'L',1,'',0,'C',false,1,true);
	}
	$pdf->SetFontSize(16);

}

function mb_str_split($str, $split_len = 1) {
    mb_internal_encoding('UTF-8');
    mb_regex_encoding('UTF-8');
    if ($split_len <= 0) {
        $split_len = 1;
    }
    $strlen = mb_strlen($str, 'UTF-8');
    $ret    = array();
    for ($i = 0; $i < $strlen; $i += $split_len) {
        $ret[ ] = mb_substr($str, $i, $split_len);
    }
    return $ret;
}

