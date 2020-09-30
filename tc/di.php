<?php

use Tc\Di;
use Tc\Lib\Request;

$di = new Di;
$di->set('request', function() {
	return new Request();
});
return $di;