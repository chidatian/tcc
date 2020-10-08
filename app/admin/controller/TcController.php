<?php

namespace App\Admin\Controller;

use Tc\Mvc\Controller;

class TcController extends Controller {
    public function index() {
        $this->session->set('user', 'chidatianoooo');
        $res = ['tc' => 'index', 
            'session' => $this->session->get(),
            'id' => $this->session->id(),
            PHP_SESSION_ACTIVE,
            $this->session->get('user'),
            'status'=>session_status()
        ];
        $this->response->json($res);
    }

    public function sess() {
        $res = ['tc' => 'index', 
            'session' => $this->session->get(),
            'id' => $this->session->id(),
            PHP_SESSION_ACTIVE,
            $this->session->get('user'),
            'status'=>session_status()
        ];
        $this->response->json($res);
    }
}