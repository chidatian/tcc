<?php

namespace App\Services;

use stdClass;

class HttpUtil
{
	//curl抓取
    public static function postCurl($url, $data = ''){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl,CURLOPT_TIMEOUT,10);
        curl_setopt($curl,CURLOPT_HEADER,0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $ret = new stdClass;
        $ret->data = curl_exec($curl);
        $ret->errno = curl_errno($curl);
        $ret->error = curl_error($curl);
        $ret->info = curl_getinfo($curl);

        curl_close($curl);
        return $ret;
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
        $ret = new stdClass;
        $ret->data = curl_exec($curl);
        $ret->errno = curl_errno($curl);
        $ret->error = curl_error($curl);
        $ret->info = curl_getinfo($curl);
        // 关闭
        curl_close($curl);
        return $ret;
    }
    /**
     * PHP发送Json对象数据, 发送HTTP请求
     * @param string $url 请求地址
     * @param array $data 发送数据
     * @return String
     */
    public static function http_post_json($url, $data = '')
    {
        $ch = curl_init ( $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_FRESH_CONNECT, 1 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_FORBID_REUSE, 1 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, [ 'Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen($data) ]);
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );

        $ret = new stdClass;
        $ret->data = curl_exec($ch);
        $ret->errno = curl_errno($ch);
        $ret->error = curl_error($ch);
        $ret->info = curl_getinfo($ch);
        // 关闭
        curl_close($ch);
        return $ret;
    }
}