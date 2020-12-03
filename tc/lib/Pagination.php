<?php

namespace Tc\Lib;

/**
 * 分页
 */
class Pagination {
    public $offset   = 0;
    public $page     = 0;
    public $pageSize = 0;

    /**
     * 构造
     *
     * @param integer $page
     * @param integer $pageSize
     */
    public function __construct($page=1, $pageSize=20) {
        $page       = intval($page);
        $pageSize   = intval($pageSize);

        $this->page     = $page > 0 ? $page : 1 ;
        $this->pageSize = $pageSize > 0 ? $pageSize : 20;
        
        $this->offset   = ($this->page-1) * $this->pageSize;
    }

    public function limit() {
        return $this->offset . ',' . $this->pageSize;
    }

    /**
     * 页数
     *
     * @param int $total
     * @return array
     */
    public function page($total) {
        return array(
            'page'      => $this->page,
            'pageSize'  => $this->pageSize,
            'total'     => $total,
            'pageTotal' => ceil($total/$this->pageSize),
        );
    }

    /**
     * 格式化分页数据
     *
     * @param mixed $data
     * @param int $total
     * @return array
     */
    public function format($data, $total) {
        
        return array(
            'data' => $data,
            'page' => $this->page($total)
        );
    }
}