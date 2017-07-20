<?php 
class FileUpload{
	
	//过滤代码
	public function str_filter($str) {
	
		// 过滤 js
		$js_string = array("/<script(.*)<\/script>/isU");
		$str = preg_replace($js_string, '', $str);
	
		// 过滤 iframe
		$frame_string = array("/<frame(.*)>/isU", "/<\/fram(.*)>/isU", "/<iframe(.*)>/isU", "/<\/ifram(.*)>/isU",);
		$str = preg_replace($frame_string, '', $str);
	
		// 过滤 css
		$style_string = array("/<style(.*)<\/style>/isU", "/<link(.*)>/isU", "/<\/link>/isU");
		$str = preg_replace($style_string, '', $str);
	
		// 过滤字符串
		if (is_array($str)) {
			foreach ($str as $k=>$v) {
				$str[$k] = htmlspecialchars(strip_tags($v));
			}
		} else {
			$str = htmlspecialchars(strip_tags($str));
		}
		// 过滤关键词，主要为sql方面
		$arr = array('\\', ' IF(', '20%and20%', ' and ', ' AND ', '20%or20%', ' or ', ' OR ', '20%execute20%', ' execute ', '20%update20%', ' update ', '20%master20%', ' master ', '20%truncate20%', ' truncate ', '20%char20%', ' char ', 'CHAR(', '20%declare20%', ' declare ', '20%select20%', ' select ', 'SELECT', '20%create20%', ' create ', '20%delete20%', ' delete ', '20%insert20%', ' insert ', 'sleep', ' sleep ', 'table', ' table ', 'substring', ' substring ', '20%infmation_schema20%', ' infmation_schema ', '20%concat20%', ' concat ', 'CONCAT', '20%limit20%', ' limit ', 'UPDATEXML', 'EXTRACTVALUE', 'CONVERT(', ' WAITFOR DELAY ', '*', '!');
		$str = str_replace($arr, '', $str);
		$str = str_replace("'", "''", $str);
	
		// 过滤回车换行，防止Header Sql注入
		$str = str_replace(array('%0d', '%0a', '%0D', '%0A', '\n', '\r'), '', $str);
	
		return $str;
	}
	
	public function save_file( $file, $save_path ) {
		global $config;
		if( empty($file) ){
			return "";
		}
		$filepath = SITE_PATH.$save_path;
		$this->makeDir( $filepath );
		if( is_uploaded_file($file['tmp_name']) && $file['size']>0 ){
			//$filename = $this->str_filter($file['name']);
			//$arrs = explode(".", $filename);
			//$tp = $arrs[count($arrs)-1];
			//$n_filename = time().rand(10000, 99999).".".$tp;
			$n_filename = $file['name'];
			$filepath = $filepath."/".$n_filename;
			move_uploaded_file($file['tmp_name'], $filepath);
			return $save_path.$n_filename;
		}else{
			return "";
		}
	}
	
	public function makeDir($dir, $mode=0777) {
		if (!dir) return false;
		if( !file_exists($dir) ){
			try{
				return @mkdir($dir, $mode, true);
			}catch (Exception $e){
			}
			return mkdir( $dir );
		} else {
			return true;
		}
	
	}
	
	//删除文件
	public function delete_file( $file_path ){
		if( !empty($file_path) ){
			$result = @unlink($file_path);
			return true;
		}else{
			return false;
		}
	}
	
}