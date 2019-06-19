<?php

namespace App\Services;

class UploadUtil
{
    private static $ext = array('xlsx','xls'); // 限制上传的文件类型
    private static $size= array();
    private static $path= '/tmp/upload/'; // 上传的目录
    private static $name= 'client_upload'; // 上传input 框中的name 值
    /**
     * 单个上传文件
     */
    public static function up()
    {
        if(empty($_FILES)) {
            return array('status'=>0,'msg'=>'_FILES is null');
        }
        $file = $_FILES[self::$name]['name'];
        $pathinfo = pathinfo($file);
        if(!in_array(strtolower($pathinfo['extension']),self::$ext)) {
            return array('status'=>0,'msg'=>'文件格式错误');
        }
        $tempfile = $_FILES[self::$name]['tmp_name'];
        $filename = self::$path . 'excel_' . time() . '.' . $pathinfo['extension'];
        if(!is_dir(self::$path)) {
			$bo = mkdir(self::$path, 0777, true);
            if(!$bo) return array('status'=>0,'msg'=>'上传目录不存在');
        }
        $bool = move_uploaded_file($tempfile,$filename);
        if(!$bool) {
            return array('status'=>0,'msg'=>'文件上传失败');
        }
        return array('status'=>1,'msg'=>'ok','file'=>$filename);
    }

}