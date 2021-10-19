<?php

namespace A\Session;

class SessionManager {
    protected $_savePath = '/tmp';
    protected $_switch = '';

    public function __construct($obj = null, $switch=0, $savepath='') {
        $this->_switch = $switch;
        $this->_savePath = $savepath;
        
        if ( !$obj instanceof \SessionHandlerInterface ) {
            ini_set('session.save_handler','files');
            $obj = new FileSessionHandler;
        }
        session_set_save_handler($obj);
    }

    /**
     * 开启 session
     *
     * @return void
     */
    public function start() {

        if ( empty($this->_switch) ) {
            return false;
        }
        
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_save_path($this->_savePath);
            session_start();
        }
        
        if ( isset($_SESSION['create_time']) ) {
            if ( $_SESSION['create_time'] + 60 * 60 > time() ) {
                return true;
            }
            $this->_regenerate_id(true);
        }

        $_SESSION['create_time'] = time();
        $this->_commit();
        return true;
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

    protected function _regenerate_id($delete_old_session = false) {
        session_regenerate_id($delete_old_session);
    }
    
    protected function _commit() {
        session_commit();
    }
}