<?php

namespace A;

use A\Lib;
use A\Http\Cookie;
use A\Http\Request;
use A\Http\Response;
use A\Session\SessionManager;

class App
{
    public function __construct()
    {
		$lib = Lib::getInstance();

		$lib->set('request', new Request());
		
		$lib->set('cookie', new Cookie());

		$lib->set('response', new Response());

		if ( ! $lib->get('session') ) {
			$switch = isset($this->config->session->switch) ? $this->config->session->switch : 0;
			
			$savepath = isset($this->config->session->savepath) ? $this->config->session->savepath : '';
			
			$lib->set('session', new SessionManager(null,$switch, $savepath));
		}

	}

    public function __get($name)
    {
        return Lib::getInstance()->get($name);
    }

	public function run()
    {
		$request  = $this->request;
		$response = $this->response;

		$response->obStart();

		$this->session->start();
		
		// 使用 路由
		if ( $this->router && 
			false !== $routes = $this->router->validate($request->route(), $request->method()) 
		) {
			$request->setController($routes['controller']);
			$request->setAction($routes['action']);
	
			call_user_func([new $routes['controller'], $routes['action']]);
		}
		// 不使用 路由
		else {
			$c = $request->controller();
			$a = $request->action();
			call_user_func([new $c, $a]);
		}

		return $response;
	}
}