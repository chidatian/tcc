<?php

namespace Tc\Db\Mysql;

use PDO;

class Mresult implements \Iterator, \Countable, \ArrayAccess {
	protected $array = [];
	protected $position = null;
	/* 方法 */
	// abstract public current ( ) : mixed
	public function current ( ) {
		return $this->array[$this->position];
	}
	// abstract public key ( ) : scalar
	public function key ( ) {
		return $this->position;
	}
	// abstract public next ( ) : void
	public function next ( ) {
		$this->position++;
	}
	// abstract public rewind ( ) : void
	public function rewind ( ) {
		$this->position = 0;
	}
	// abstract public valid ( ) : bool
	public function valid ( ) {
		return isset($this->array[$this->position]);
    }
    /* 方法 */
    // abstract public count ( ) : int
    public function count ( ) {
        return count($this->array);
    }
    /* 方法 */
    // abstract public offsetExists ( mixed $offset ) : boolean
    public function offsetExists ( $offset ) {
        return isset($this->array[$offset]);
    }
    // abstract public offsetGet ( mixed $offset ) : mixed
    public function offsetGet ( $offset ) {
        return isset($this->array[$offset]) ? $this->array[$offset] : null;
    }
    // abstract public offsetSet ( mixed $offset , mixed $value ) : void
    public function offsetSet ( $offset , $value ) {
        if (is_null($offset)) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }
    // abstract public offsetUnset ( mixed $offset ) : void
    public function offsetUnset ( $offset ) {
        unset($this->array[$offset]);
    }

	public function __construct($result, $isSingleRow = false)
	{
        if ( $isSingleRow) {
            $this->array = $result->fetch(PDO::FETCH_ASSOC);
            // $result->closeCursor();
        }

        else while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $this->array[] = $row;
        }
        $this->rewind();
		// $this->array = $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function toArray() {
		return $this->array;
	}
}