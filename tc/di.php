<?php

use Tc\Di;

$di = new Di;
$di->set('session', function() {
	return 'session';
});
return $di;