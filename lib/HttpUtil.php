<?php

namespace App\Services;

class HttpUtil
{
	//curl抓取
    public static function postCurl($url, $data = ''){
        $curl           = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    public static function getCurl($url)
    {
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        // 去除响应头和行
        curl_setopt($curl,CURLOPT_HEADER,0);
        // 超时时间 单位是秒
        curl_setopt($curl,CURLOPT_TIMEOUT,10);
        // 不检测ssl证书
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        // 执行
        $data = curl_exec($curl);
        // 关闭
        curl_close($curl);
        return $data;
    }
    /**
     * PHP发送Json对象数据, 发送HTTP请求
     * @param string $url 请求地址
     * @param array $data 发送数据
     * @return String
     */
    public static function http_post_json($functionName, $url, $data) {
        $ch = curl_init ( $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_FRESH_CONNECT, 1 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_FORBID_REUSE, 1 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen ( $data ) ) );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        $ret = curl_exec ( $ch );
        //echo $functionName . " : Request Info : url: " . $url . " ,send data: " . $data . "  \n";
        //echo $functionName . " : Respnse Info : " . $ret . "  \n";
        curl_close ( $ch );
        return $ret;
    }
    public function curl($url, $data, $method = 'GET')
    {
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        $method = strtoupper($method);
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        } elseif (in_array($method, array('PUT', 'DELETE'))) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); 
        }
        if ($method != 'GET' && !empty($data)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200 );
        $result = curl_exec($ch);

        curl_close($ch);
    
        return $result;
    }
}