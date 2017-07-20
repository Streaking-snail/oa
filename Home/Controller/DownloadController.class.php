<?php
namespace Home\Controller;
use Think\Controller;
class DownloadController extends Controller{
	
	public function index(){
                 header("Content-type:text/html;charset=utf-8");
		$file = C('WEBROOT').urldecode($_GET['file']);
		$suffix = substr($file,strrpos($file,'.')); //获取文件后缀
		$arrs = explode("/", $file);
		//$file = 'E:/por/wjb2b'.$file;
		$down_name = $arrs[count($arrs)-1]; //新文件名，就是下载后的名字
		//判断给定的文件存在与否
		if( !file_exists($file) ){
			die("您要下载的文件已不存在，可能是被删除");
		}
		$fp = fopen($file,"r");
		$file_size = filesize($file);
		//下载文件需要用到的头
		header("Content-type: application/octet-stream");
		header("Accept-Ranges: bytes");
		header("Accept-Length:".$file_size);
		header("Content-Disposition: attachment; filename=".$down_name);
		$buffer = 1024;
		$file_count = 0;
		//向浏览器返回数据
		while(!feof($fp) && $file_count < $file_size){
			$file_con = fread($fp,$buffer);
			$file_count += $buffer;
			echo $file_con;
		}
		fclose($fp);
	}
        
        public function deletefile ($id){
            include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
            $FileUpload = new \FileUpload();
            $re = M('product_pic_status_attach')->find($id);
            $filename = ".$re[url]";
            $res = M('product_pic_status_attach')->delete($id);
            $r = $FileUpload->delete_file($filename);
            if( $res && $r){
                M()->commit();
            }else{
                M()->rollback();
            }
            $this->redirect("ProductPic/index");
        }
	
        public function delete_file ($id){
            include_once SITE_PATH.'/Home/Model/FileUpload.class.php';
            $FileUpload = new \FileUpload();
            $re = M('count_info_status_attach')->find($id);
            $filename = ".$re[url]";
            $res = M('count_info_status_attach')->delete($id);
            $r = $FileUpload->delete_file($filename);
            if( $res && $r){
                M()->commit();
            }else{
                M()->rollback();
            }
            $this->redirect("ShopCount/index");
        }
}