<?php 
class Export{
	
	//导出excel
	public function export_xls($titleList, $datas){
		import('ExcelToArrary');//导入excelToArray类
		$ExcelToArrary = new \ExcelToArrary();//实例化
		$ExcelToArrary->export($titleList, $datas, array(), 'orderlist', 'this is a orderlist');
	}
	
	//导出cvs
    //导出CSV表格
    //$arrs数据列表
    public function export_csv($arrs, $titleList, $is_utf8=true) {
    	//文件名
	$filename = date('YmdHis').".csv";//文件名
        header("Content-type:text/csv");   
        header("Content-Disposition:attachment;filename=".$filename);   
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
        header('Expires:0');   
        header('Pragma:public');
        echo $this->array_to_string($arrs, $titleList, $is_utf8);
        exit;
    }
    public function array_to_string($result,$titleList, $is_utf8) {
        if(empty($result)) {
            return i("没有符合您要求的数据！");
        }
        $data = array();
        $title = implode(',',$titleList);
        if( $is_utf8 ){
       		array_push($data, $this->en($title)); //栏目名称
        }else{
        	array_push($data, $title); //栏目名称
        }
        foreach( $result as $value){
            $str_data = '';
            foreach($value as $v){
            	if( $is_utf8 ){
                	$str_data .= $this->en(str_replace(',',' ',$v))."\t,";
            	}else{
            		$str_data .= str_replace(',',' ',$v)."\t,";
            	}
            }
            array_push( $data, $str_data );
        }
        return join("\n", $data);
    }
    public function en($strInput) {
        //$str= php_uname('v') ;
//         $f = stristr($str,'Windows 7');
//     	if( $f ){
//         	return iconv('UTF-8','gb2312',$strInput);//页面编码为utf-8时使用，否则导出的中文为乱码
//     	}else{
//     		return $strInput;
//     	}
//     	$encode = mb_detect_encoding($strInput, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
//     	if( $encode=="UTF-8" ){
    		return iconv('UTF-8','GBK',$strInput);//页面编码为utf-8时使用，否则导出的中文为乱码
//     	}else{
//     		return $strInput;
//     	}
    }
	
}