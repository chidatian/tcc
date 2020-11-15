<?php

namespace Tc\Lib;

class Page {
    public $offset = 0;

    public function __construct($page=1, $pageSize=20) {
        $page       = intval($page);
        $pageSize   = intval($pageSize);

        $this->page     = $page > 0 ? $page : 1 ;
        $this->pageSize = $pageSize > 0 ? $pageSize : 20;
        
        $this->offset   = ($this->page-1) * $this->pageSize;
        $this->limit    = $this->pageSize;
    }

    public function limit() {
        return $this->offset . ',' . $this->limit;
    }

    public function page($total) {
        return array(
            'page'      => $this->page,
            'pageSize'  => $this->pageSize,
            'total'     => $total,
            'pageTotal' => ceil($total/$this->pageSize),
        );
    }

    public function format($data, $total) {
        if ($total <= 0) {
            return $data;
        }

        return array(
            'data' => $data,
            'page' => $this->page($total)
        );
    }
}