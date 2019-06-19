<?php

namespace App\Services;

class MapUtil
{
	private static $gKey = 'ff866ead5e56e02101037c2a49568208'; // 高德 key
	private static $gSig = ''; // 高德签名，非必填

	private static $bAK  = '07wCnPZw3PQCaUkMWrxrotFHYvb28wke'; // 百度AK
	/**
	* @desc 根据经纬度和范围计算出最大最小坐标值
	* @param lat 纬度 lng 经度 raidus 单位米
	* @return minLat,minLng,maxLat,maxLng
	*/
	public static function getAround($lat,$lng,$raidus)
	{
		//计算纬度
		$degree = (24901 * 1609) / 360.0;
		$dpmLat = 1 / $degree;
		$radiusLat = $dpmLat * $raidus;
		$minLat = $lat - $radiusLat; //得到最小纬度
		$maxLat = $lat + $radiusLat; //得到最大纬度
		//计算经度
		$mpdLng = $degree * cos($lat * (PI / 180));
		$dpmLng = 1 / $mpdLng;
		$radiusLng = $dpmLng * $raidus;
		$minLng = $lng - $radiusLng; //得到最小经度
		$maxLng = $lng + $radiusLng; //得到最大经度
		//范围
		$range = array(
			'minLat' => $minLat,
			'maxLat' => $maxLat,
			'minLng' => $minLng,
			'maxLng' => $maxLng
		);
		return $range;
	}
	/**
	 * 百度转高德，坐标
	 * @param lat 纬度 lng 经度
	 */
	public static function B2G($lat,$lng)
	{
		$lnglat = $lng . ',' . $lat;
		$surl  = 'https://restapi.amap.com/v3/assistant/coordinate/convert?';
		$surl .= 'key=%s&locations=%s&coordsys=baidu&output=JSON';
		$url = sprintf($surl, self::$gKey, $lnglat);
		$res = httpUtil::getCurl($url);
		return $res;
	}
	/**
	 * 地址转百度经纬度
	 * @param $address string 详细地址，河北省秦皇岛市... ...
	 */
	public static function addressToBaidu($address)
	{
		$surl = 'http://api.map.baidu.com/geocoder/v2/?address=%s&output=json&ak=%s';
		$url = sprintf($surl, $address, self::$bAK);
		$res = httpUtil::getCurl($url);
		return $res;
	}
}