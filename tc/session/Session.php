<?php

namespace Tc;

class Session {
    protected $_savePath = 'E:\www\test\tcc\public\sess';

    public function __construct($obj = null) {
        if ( !$obj instanceof \SessionHandlerInterface ) {
            $obj = new \Tc\Session\FileSessionHandler;
        }
        session_set_save_handler($obj);
    }

    public function start() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_save_path($this->_savePath);
            session_start();
        }
        if ( isset($_SESSION['create_time']) ) {
            if ( $_SESSION['create_time'] + 60 * 60 > time() ) {
                return true;
            }
            $this->_regenerate_id();
            // $this->_session_id = session_id();
        }
        // Di::getDi()->call('cookie')->set($this->_cookie, $this->_session_id);
        $_SESSION['create_time'] = time();
        $this->_commit();
        return true;
    }

    public function setSavePath($path) {
        $this->_savePath = $path;
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
        $this->_commit();
    }

    public function get($key = '') {
        return $key == '' ? $_SESSION : (isset($_SESSION[$key]) ? $_SESSION[$key] : null);
    }

    public function destory() {
        session_destroy();
    }

    public function id() {
        return session_id();//$this->_session_id;
    }

    protected function _regenerate_id() {
        session_regenerate_id();
    }
    
    protected function _commit() {
        session_commit();
    }
}