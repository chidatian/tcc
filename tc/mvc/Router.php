<?php

namespace Tc\Mvc;

class Router {
    protected $_routes  = array();
    protected $_groupStack  = array();
    protected $_match  = '';
    protected $_method = '';

    /**
     * 验证路由
     *
     * @param string $match
     * @param string $method
     * @return array
     */
    public function validate($match, $method = '') {
        $this->_match = $match;
        $this->_method = $method;

        if ( !isset($this->_routes[$match]) ) {
            return false;
        }

        if ( !$this->_checkMethod() ) {
            return false;
        }
        return $this->_routes[$match];
    }

    /**
     * 添加 路由
     *
     * @param string $match
     * @param string $action
     * @param string $methods [get, post, put ...]
     * @return void
     */
    public function match($match, $action, $methods) {
        for($i = 0; $i < count($methods); $i++) {
            $methods[$i] = strtoupper($methods[$i]);
        }
        $this->_setRoutes($match, $action, $methods);
    }
    
    /**
     * 添加 路由 get 
	 * $router->get('/index/index', '\IndexController@index');
     *
     * @param [type] $match
     * @param [type] $action
     * @return void
     */
    public function get($match, $action) {
        $this->_setRoutes($match, $action, 'GET');
    }

    /**
     * 添加路由 post
     *
     * @param [type] $match
     * @param [type] $action
     * @return void
     */
    public function post($match, $action) {
        $this->_setRoutes($match, $action, 'POST');
    }

    /**
     * 分组 路由
     *$router->group(['prefix' => '/admin', 'namespace' => '\App\Admin'], function() use ($router){
	 *	$router->group(['prefix' => '/tc', 'namespace' => '\Controller'], function() use ($router){
	 *		$router->match('/index', '\TcController@index',['get','post']);
	 *	});
	 *});
     * @param string $prefix
     * @param callback $callback
     * @return void
     */
    public function group($prefix, $callback) {
        array_push($this->_groupStack, $prefix);
        call_user_func($callback);
        array_pop($this->_groupStack);
    }

    /**
     * 设置路由 格式
     * '/index/index', '\IndexController@index'
     *
     * @param [type] $match
     * @param [type] $action
     * @param [type] $method
     * @return void
     */
    protected function _setRoutes($match, $action, $method) {
        if ( $c = count($this->_groupStack) ) {
            $match = implode('', array_column($this->_groupStack, 'prefix')).$match;
            $action = implode('', array_column($this->_groupStack, 'namespace')).$action;
        }
        list($c, $a) = explode('@', $action);
        $this->_routes[$match] = array(
            'controller' => $c,
            'action'     => $a,
            'method' => $method,
        );
    }
    
    // 验证请求方法
    protected function _checkMethod() {
        // 验证多个请求方法
        if ( is_array($this->_routes[$this->_match]['method']) ) {
            if ( in_array($this->_method, $this->_routes[$this->_match]['method']) ) {
                return true;
            }
        }
        // 验证一个请求方法
        elseif ( $this->_method == $this->_routes[$this->_match]['method'] ) {
            return true;
        }
        return false;
    }
}