<?php

class ExcelToArrary {  
    public function __construct() {  
          Vendor("Excel.PHPExcel");//引入phpexcel类(注意你自己的路径)  
          Vendor("Excel.PHPExcel.IOFactory"); 
          Vendor("Excel.PHPExcel.Writer.Excel5.php"); 
          Vendor("Excel.PHPExcel.Writer.Excel2007.php");       
    }  
    //洋码头导入订单处理
    public function read($filename, $encode, $file_type, $is_order=true){  
		  if( $file_type=='xlsx' ){
			  	//建立reader对象
			  	$reader = new PHPExcel_Reader_Excel2007();
			  	if(!$reader->canRead($filename)){
			  		$reader = new PHPExcel_Reader_Excel5();
			  		if(!$reader->canRead($filename)){
			  			return array('f'=>false, 'msg'=>'文件不是2007的excel文件', 'arrs'=>array());
			  		}
			  	}
			  	//建立excel对象，此时你即可以通过excel对象读取文件，也可以通过它写入文件
			  	$PHPExcel = $reader->load($filename);
			  	/**读取excel文件中的第一个工作表*/
			  	$sheet = $PHPExcel->getSheet(0);
			  	/**取得最大的列号*/
			  	$highestColumm = $sheet->getHighestColumn();
			  	/**取得一共有多少行*/
			  	$highestRow = $sheet->getHighestRow();
		  }else{
	          $reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
	          $PHPExcel = $reader->load($filename); // 载入excel文件
	          $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
	          $highestRow = $sheet->getHighestRow(); // 取得总行数
	          $highestColumm = $sheet->getHighestColumn(); // 取得总列数
    	  }
    	  $region = D('Region');
          $str = '';
          /** 循环读取每个单元格的数据 */
          for ($row = 2; $row <= $highestRow; $row++){//行数是以第1行开始
              $item['OrderNo'] = $sheet->getCell('B'.$row)->getValue();
              $res_find = M('order')->where('OrderNo="'.$item['OrderNo'].'"')->find();
              if( !$res_find&&$item['OrderNo']!='' ){
                  $item['PayAmount'] = $sheet->getCell('K'.$row)->getValue();
                  $item['GoodsAmount'] = $sheet->getCell('L'.$row)->getValue();
                  $item['PostFee'] = $sheet->getCell('H'.$row)->getValue();
                  $item['CreateData'] = $sheet->getCell('O'.$row)->getValue();
                  $item['Date'] = $sheet->getCell('R'.$row)->getValue();
                  $item['BuyerAccount'] = $sheet->getCell('T'.$row)->getValue();
                  $item['Consignee'] = $sheet->getCell('U'.$row)->getValue();
                  $item['ConsigneeTel'] = $sheet->getCell('V'.$row)->getValue();
                  $item['ConsigneeAddr'] = $sheet->getCell('X'.$row)->getValue();
                  $item['IsAudit'] = 0;
                  $item['StatusCode'] = '-1';
                  $item['StatusName'] = "未发送";
                  $item['OrderFromId'] = '0008';//洋码头
                  $item['DistributorId'] = 37;//洋码头distributorId
                  $address = explode(',',$item['ConsigneeAddr']);
                  $item['Province'] = $address[0];
                  $item['City'] = $address[1];
                  $item['District'] = $address[2];
                  $region_id = $region->get_region_id($address[0],$address[1],$address[2]);
                  /*
                  $province = trim(mb_substr($address[0],0,2,'utf-8'));
                  $city = trim(mb_substr($address[1],0,2,'utf-8'));
                  $district = trim(mb_substr($address[2],0,2,'utf-8'));
                  $re_province = $region->where('region_name like "'.$province.'%" and region_type=1')->find();
                  $re_city = $region->where('region_name like "'.$city.'%" and region_type=2')->find();
                  $re_district = $region->where('region_name like "'.$district.'%" and region_type=3')->find();
                  */
                  $item['ProvinceId'] = $region_id['province'];
                  $item['CityId'] = $region_id['city'];
                  $item['DistrictId'] = $region_id['district'];
                  $dataset[] = $item;
              }else if( $res_find ){
//                  M('order')->where('OrderNo="'.$item['OrderNo'].'"')->delete();
                  $str .='订单编号为: '.$item['OrderNo'].'已存在 || ';
              }
          }
        $res_add = M('order')->addAll($dataset);
        if($res_add){
            $return_str = $str.'共('.count($dataset).')条插入成功!';
            return array('f'=>true,'msg'=>$return_str);
        }else{
            return array('f'=>false,'msg'=>'插入失败!');
        }
   }

   public function OrderTableSave($dataset){
	   	$addr = explode(' ', $dataset[8]);
	   	$order = M('Order');
	   	$data['OrderNo']  =   $dataset[0];
	   	$data['BuyerAccount']    =   $dataset[1];
	   	$data['GoodsAmount']    =   $dataset[2];
	   	$data['Amount']    =   $dataset[2];
	   	$data['PostFee']    =   $dataset[4];
	   	$data['Consignee']    =   $dataset[5];
	   	$data['ConsigneeTel']    =   $dataset[6];
	   	$data['LogisticsName']    =   $dataset[7];
	   	$data['ConsigneeAddr']    =   $dataset[8];
	   	$data['PaymentNo']    =   $dataset[9];
	   	$data['Source']    =   $dataset[10];
	   	$data['TaxAmount']    =   $dataset[12];
	   	$data['OrderFromId']    =   $dataset[14];
	   	$data['PeopleId']    =   $dataset[15];
	   	$data['Province']    = $addr[0];
	   	$data['City']    = $addr[1];
	   	$data['District']    = $addr[2];
	   	$data['Date'] = date("Y-m-d H:i:s",time());
	   	
	   	//插入订单商品
	   	//新西兰爱他美4段奶粉,2,罐,179,310520146160600046;
	   	$goods = M('Order_goods');
	   	$product = explode(',', $dataset[11]);
	   	$gdata['GoodsName'] = $product[0];
	   	$gdata['ProductId'] = str_replace(';','',$product[4]);
	   	$gdata['Qty'] = $product[1];
	   	$gdata['Unit'] = $product[2];
	   	$gdata['GoodsAmountOnly'] = $product[3];
	   	$gdata['OrderId'] = $dataset[0];
	   	
	   	//插入优惠信息
	   	$value = explode(',', $dataset[13]);
	   	$promotion = M('Order_discount');
	   	$pdata['ProRemark'] = $value[0];
	   	$pdata['ProAmount'] = $value[1];
	   	$pdata['OrderId'] = $dataset[0];
	   	
	   	if($order->add($data) &&  $goods->add($gdata) && $promotion->add($pdata))
	   		$res = 1;
	   	else
	   		$res = 0;
	   	return $res;
   }
   
   
    //导出excel
    //导出Excel表格
    public function export($headerArr=array(), $contentArr=array(), $footerArr=array(), $excelFileName,$sheetTitle){
        $this->__construct();
        /* 实例化类 */
        $objPHPExcel = new \PHPExcel(); 

        /* 设置输出的excel文件为2007兼容格式 */
        //$objWriter=new PHPExcel_Writer_Excel5($objPHPExcel);//非2007格式
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

        /* 设置当前的sheet */
        $objPHPExcel->setActiveSheetIndex(0);

        $objActSheet = $objPHPExcel->getActiveSheet();

        /*设置宽度*/
        //$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);

        /*设置栏目名*/
        foreach ($headerArr as $k=>$v) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($k, $v);
        }
        /* sheet标题 */
        $objActSheet->setTitle($sheetTitle);  
        $i = 2;
        foreach($contentArr as $value)
        { 
            /* excel文件内容 */
            $j = 'A';
            foreach($value as $value2)
            { 
                $objActSheet->setCellValue($j.$i,$value2.' ');
                $j++;
            }
            $i++;
        }
        /*尾部信息*/
        if(count($footerArr) > 0) {
            foreach ($footerArr as $k=>$v) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($k, $v);
            }
        }

        /* 生成到浏览器，提供下载 */ 
        ob_end_clean();  //清空缓存      
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="'.$excelFileName.'.xlsx"');
        header("Content-Transfer-Encoding:binary"); 
        $objWriter->save('php://output');
    }
    public function read_info($filename, $encode, $file_type){
        if( $file_type=='xlsx' ){
            //建立reader对象
            $reader = new PHPExcel_Reader_Excel2007();
            if(!$reader->canRead($filename)){
                $reader = new PHPExcel_Reader_Excel5();
                if(!$reader->canRead($filename)){
                    return array('f'=>false, 'msg'=>'文件不是2007的excel文件', 'arrs'=>array());
                }
            }
            //建立excel对象，此时你即可以通过excel对象读取文件，也可以通过它写入文件
            $PHPExcel = $reader->load($filename);
            /**读取excel文件中的第一个工作表*/

        }else{
            $reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
            $PHPExcel = $reader->load($filename); // 载入excel文件
        }
        $sheetCount = $PHPExcel->getSheetCount()-1;
        for($sheet_no=0;$sheet_no<=$sheetCount;$sheet_no++){
            $sheet = $PHPExcel->getSheet($sheet_no); // 读取第一個工作表
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数
            $data = array();
            /** 循环读取每个单元格的数据 */
            for($currentRow = 1;$currentRow <= $highestRow;$currentRow++){

                /**从第A列开始输出*/
                for($currentColumn= 'A';$currentColumn<= $highestColumm; $currentColumn++){
                    $val = $sheet->getCell($currentColumn.$currentRow)->getValue();
                    //$val = $sheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/
                    if($val!=''){
                        $erp_orders_id[$sheet_no][$currentRow][$currentColumn] = trim($val);
                    }
                    /**如果输出汉字有乱码，则需将输出内容用iconv函数进行编码转换，如下将gb2312编码转为utf-8编码输出*/
                    //echo iconv('utf-8','gb2312', $val)."\t";

                }
            }
        }
        if(!empty($erp_orders_id)){
            return array('f'=>true,'data'=>$erp_orders_id);
        }else{
            return array('f'=>false);
        }
    }
}  
?>