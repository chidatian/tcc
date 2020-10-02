<?php

namespace Tc\Http;

class Router {
    protected $_routes  = array();

    public function match($match, $method = '') {
        if ( !isset($this->_routes[$match]) ) {
            return false;
        }
        if ( $this->_routes[$match]['method'] == $method ) {
            return $this->_routes[$match]['controller'];
        }
        return false;
    }
    
    public function get($match, $action) {
        list($c, $a) = explode('@', $action);
        $this->_routes[$match] = array(
            'match' => $action,
            'controller' => $c,
            'action'     => $a,
            'method' => 'GET',
        );
    }

    public function post($match, $action) {
        list($c, $a) = explode('@', $action);
        $this->_routes[$match] = array(
            'match' => $action,
            'controller' => $c,
            'action'     => $a,
            'method' => 'POST',
        );
    }
}