<?php

/**
* 2020.04.17 chidatian
* 验证
*/
$v = new Validate('TA1LTI2',1587297926,'oA@#JisI');
var_dump($v->check());
class Validate
{
	protected $_sign = '';
	protected $_time = 0;
	protected $_key  = '';
	/**
	* @param $sign string 加密信息
	* @param $time int 时间戳
	* @param $key string 密钥
	*/
	public function __construct($sign, $time, $key, $debug = false)
	{
		$this->_sign = $sign;
		$this->_time = $time;
		$this->_key  = $key;
		if ($debug) {
			$this->_time = time();
			print 'time='.$this->_time.'&sign='.$this->parse();
			exit;
		}
	}

	public function check()
	{
		$t = time();
		if ($this->_time > $t || $this->_time + 3600 < $t) {
			return false;
		}

		if ($this->_sign != $this->parse()) {
			return false;
		}
		return true;
	}

	/**
	* 加密规则 
	*/
	public function parse()
	{
        return substr(base64_encode(substr(date('Y/m/d H-i-s', $this->_time), 0, 4) . $this->_key . substr(date('Y/m/d H-i-s', $this->_time), 4, count(str_split((String) date('Y/m/d H-i-s', $this->_time))) - 1)), -7);
		// return substr(md5(date('Y-m-d H:i:s', $this->_time)), -5).substr(base64_encode($this->_time.$this->_key), -5).count(str_split($this->_time.$this->_key));
	}
}