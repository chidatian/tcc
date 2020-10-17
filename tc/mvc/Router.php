<?php

namespace Tc\Mvc;

class Router {
    protected $_routes  = array();
    protected $_groupStack  = array();
    protected $_match  = '';
    protected $_method = '';

    public function validate($match, $method = '') {
        $this->_match = $match;
        $this->_method = $method;

        if ( !isset($this->_routes[$match]) ) {
            throw new \Exception("router not exists: [$match]");
        }

        if ( !$this->_checkMethod() ) {
            throw new \Exception("request method error: [$method]");
        }
        return $this->_routes[$match];
    }

    public function match($match, $action, $methods) {
        for($i = 0; $i < count($methods); $i++) {
            $methods[$i] = strtoupper($methods[$i]);
        }
        $this->_setRoutes($match, $action, $methods);
    }
    
    public function get($match, $action) {
        $this->_setRoutes($match, $action, 'GET');
    }

    public function post($match, $action) {
        $this->_setRoutes($match, $action, 'POST');
    }

    public function group($prefix, $callback) {
        array_push($this->_groupStack, $prefix);
        call_user_func($callback);
        array_pop($this->_groupStack);
    }

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

    protected function _checkMethod() {
        if ( is_array($this->_routes[$this->_match]['method']) ) {
            if ( in_array($this->_method, $this->_routes[$this->_match]['method']) ) {
                return true;
            }
        }
        elseif ( $this->_method == $this->_routes[$this->_match]['method'] ) {
            return true;
        }
        return false;
    }
}