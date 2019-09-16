<?php


class Elastic7
{
	// 创建 index
    public $host  		= '';
    public $index 		= '';
    protected $type  	= '_doc';
	public $mapping 	= array();
	// 插入 document
	public $_id 		= '';
	public $document 	= array();
	// scroll
	private $scroll_id	= '';
	
	protected function curl($url, $data, $method = 'GET')
	{
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, $url);
		$method = strtoupper($method);
		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
		} elseif (in_array($method, array('PUT', 'DELETE'))) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); 
		}
		if (!empty($data)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 200 );
		$result = curl_exec($ch);

		curl_close($ch);
	
		return $result;
	}

	protected function fileCurl($url, $data)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		$headers = array(
			'Content-type: application/json',
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 500 );
		$result = curl_exec($ch);

		curl_close($ch);
	
		return $result;
	}

	public function file($file, $content)
	{
		if ( $f = @fopen($file, 'a') ) {
			fwrite($f, $content);
			fclose($f);
			return true;
		}
		return false;
	}

	public function bulk($file)
	{
		$url = $this->host . '/_bulk?pretty';
		$res = $this->fileCurl($url, file_get_contents($file));
		return $res;
	}

	public function scroll($query = array('size'=>1000), $m = '1m')
	{
		$url = $this->host . '/' . $this->index . '/_search?pretty&scroll='.$m;
		if ($this->scroll_id) {
			$url = $this->host . '/_search/scroll';
			$query = array('scroll_id'=>$this->scroll_id, 'scroll'=>$m);
		}
		$res = $this->curl($url, $query, 'GET');
		$res = json_decode($res, true);
		$this->scroll_id = isset($res["_scroll_id"]) ? $res["_scroll_id"] : '';
		return $res;
	}
	
	public function search($query = array())
	{
		$url = $this->host . '/' . $this->index . '/_search?pretty';
		$res = $this->curl($url, $query, 'GET');
		return $res;
	}

	public function getById($id)
	{
		$url = $this->host . '/' . $this->index . '/'. $this->type .'/' . $id . '?pretty';
		$res = $this->curl($url, array(), 'GET');
		return $res;
	}

	public function save()
	{
		$url = $this->host . '/' . $this->index . '/'. $this->type .'/' . $this->_id;
		$method = empty($this->_id) ? 'POST' : 'PUT';
		echo $this->curl($url.'?pretty', $this->document, $method);
	}
    
    public function createIndex()
    {
		if (!is_array($this->index)) {
			echo $this->curl($this->host . '/' . $this->index . '?pretty', array(), 'PUT');
			return;
		}
        foreach ($this->index as $item) {
            echo $this->curl($this->host . '/' . $item . '?pretty', array(), 'PUT');
        }
    }

    public function setMapping()
    {
		if (!is_array($this->index)) {
            return $this->curl($this->host . '/' . $this->index . '/_mapping?pretty', $this->mapping, 'POST');
		}
        foreach ($this->index as $item) {
            $this->curl($this->host . '/' . $item . '/_mapping?pretty', $this->mapping[$item], 'POST');
        }
    }

    public function deleteIndex()
    {
		if (!is_array($this->index)) {
			echo $this->curl($this->host . '/' . $this->index . '?pretty', array(), 'DELETE');
			return;
		}
        foreach ($this->index as $item) {
            echo $this->curl($this->host . '/' . $item . '?pretty', array(), 'DELETE');
        }
    }
}