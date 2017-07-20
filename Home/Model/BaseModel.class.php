<?php
namespace Home\Model;
use Think\Model;
class BaseModel extends Model{
	
	public function get_admin_user(){
		$admin_user = M('admin_user')->where("id=%d", array($_SESSION['admin_user_id']))->find();
		return $admin_user;
	}
	
	//分页
	public function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE) {
		import('Page');
		if ($Page_Size == 0) {
			$Page_Size = C("PAGE_LISTROWS");
		}
		if (empty($PageParam)) {
			$PageParam = C("VAR_PAGE");
		}
		$Page = new \Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
		$Page->SetPager('Admin', '{first}{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}{last}', array("listlong" => "6", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
		return $Page;
	}
	
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
	
}