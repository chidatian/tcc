<?php

// 常量
include __DIR__ . '/const.php';

// 帮助函数
include __DIR__ . '/helper.php';

// 配置文件
include CONF . 'config.php';

// 自动加载
include CORE . 'Autoload.php';

Autoload::register();

Phpini::setup();

App::run();