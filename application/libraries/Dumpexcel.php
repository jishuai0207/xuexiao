<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description : 生成excel表格，仅用与生成有标题的
 * Author      : jishuai
 * Created Time: 2015-02-28 09:56
 */

class Dumpexcel{

	public $thead;//行标题(必填)
	public $content;//内容数组(必填)二维数组
	public $documentTitle = '文件标题';//设置文件标题
	public $subject = '主题';//设置文件主题
	public $description = '描述';//设置描述
	public $lineWidth = 18;//设置描述
	private $objWriter;//暂时存放需要生成的数据

	public function __construct(){
		include(__DIR__."/excel/PHPExcel.php");
		include(__DIR__."/excel/PHPExcel/IOFactory.php");
		$this->objPHPExcel = new PHPExcel();
	}

    /**
 	* Description : 处理设置的数据
 	* Author      : jishuai
 	* Created Time: 2015-02-28 10:15
	*/
	public function dataProcess(){
		$this->objPHPExcel->getProperties()->setCreator("Maarten Balliauw")->setLastModifiedBy("Maarten Balliauw")->setTitle($this->documentTitle)
		->setSubject($this->subject)->setDescription($this->description)->setKeywords("office 2007 openxml php")->setCategory("Test result file");
		$this->objPHPExcel->setActiveSheetIndex(0);
		$objRichText = new PHPExcel_RichText();
		$lieZongShu =  count($this->thead);
		$hangZongShu =  count($this->content);
		$charList = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for($i=0;$i<$lieZongShu;$i++){
			$this->objPHPExcel->getActiveSheet()->getStyle($charList[$i])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->objPHPExcel->getActiveSheet()->getColumnDimension($charList[$i])->setWidth($this->lineWidth);
		}
		for($i=0;$i<$lieZongShu;$i++){
			$this->objPHPExcel->getActiveSheet()->setCellValue($charList[$i].'1',$this->thead[$i]);
		}
		for($h=0;$h<$hangZongShu;$h++){
			for($l=0;$l<$lieZongShu;$l++){
				$this->objPHPExcel->getActiveSheet()->setCellValue($charList[$l].($h+2),$this->content[$h][$l]);
			}
		}
		return $this->objPHPExcel;
	}

    /**
 	* Description : 设置颜色
 	* Author      : jishuai
 	* Created Time: 2015-03-02 15:05
	*/
	public function setColor($h,$l,$rgb){
		$charList = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$this->objPHPExcel->getActiveSheet()->getStyle($charList[$l].($h+1))->getFont()->getColor()->setARGB($rgb);
		//var_dump($this->objPHPExcel);exit;
		return $this->objPHPExcel;
	}

    /**
 	* Description : 将数据保存为excel文件
 	* Author      : jishuai
 	* Created Time: 2015-02-28 10:19
	*/
	public function createExcel($des){
		$this->objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
		return $this->objWriter->save($des);
	}
}
