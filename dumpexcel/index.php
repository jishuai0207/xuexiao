<?php
	set_time_limit(0);
	$q = (int)isset($_GET['q'])?$_GET['q']:1;
	if($q > 5) exit('参数错误');
	$sql = file_get_contents(__DIR__.'/sql/'.$q.'.txt');
	$db = mysql_connect('localhost','root','');
	if(! $db) exit('database connect fail');
	mysql_query ('set names utf8 ');
	mysql_select_db('manageSystem');
	$res = mysql_query($sql);
    while ( $row  =  mysql_fetch_assoc ( $res )) {
		$data[] = $row;
    }
	if(!$data) exit('没有数据');
	$lieZongShu =  count($data[0]);
	foreach($data[0] as $k => $v){
		$title[] = $k;
	}
	$hangZongShu =  count($data);
	//exit;
	$charList = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	include("./excel/PHPExcel.php");
	include("./excel/PHPExcel/IOFactory.php");
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")->setLastModifiedBy("Maarten Balliauw")->setTitle("Office 2007 XLSX Test Document")->setSubject("Office 2007 XLSX Test Document")->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")->setKeywords("office 2007 openxml php")->setCategory("Test result file");
	$objPHPExcel->setActiveSheetIndex(0);
	$objRichText = new PHPExcel_RichText();
	// 列宽
	//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	for($i=0;$i<$lieZongShu;$i++){
		$objPHPExcel->getActiveSheet()->getStyle($charList[$i])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getColumnDimension($charList[$i])->setWidth(18);
	}
	// 行高
		//$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(35);
	for($i=0;$i<$lieZongShu;$i++){
		$objPHPExcel->getActiveSheet()->setCellValue($charList[$i].'1',$title[$i]);
	}
	for($h=2;$h<$hangZongShu;$h++){
		for($l=0;$l<$lieZongShu;$l++){
			$objPHPExcel->getActiveSheet()->setCellValue($charList[$l].$h,$data[$h][$title[$l]]);
		}
	}
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle('1');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$date = date('Y-m-d');
	switch ($q){
		case 1:
		$fileName = 'class-'.$date;
		break;
		case 2:
		$fileName = 'teacher-'.$date;
		break;
		case 3:
		$fileName = 'user-'.$date;
		break;
		case 4:
		$fileName = 'answer-'.$date;
		break;
		case 5:
		$fileName = 'wxhomework-'.$date;
		break;
		default:
		break;
	}
	echo $fileName.'.xlsx';
	$res = $objWriter->save(__DIR__.'/'.$fileName.'.xlsx');


