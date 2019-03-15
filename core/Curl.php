<?php


class Curl
{
	public static function request($url, $data = '', $path = '')
	{
		if($path){
			$data = [];
			$data['media'] = new CURLFile($path);
		}
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// 去除响应头和行
		curl_setopt($curl, CURLOPT_HEADER, 0);
		// 超时时间 单位是秒
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		// 不检测ssl证书
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		if($data){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}
}