<?php

use myfrm\Db;
require_once __DIR__ . '/../vendor/autoload.php';
require dirname(__DIR__) . '/config/config.php';

require CORE . '/funcs.php';

require CORE . '/classes/Db.php';



$db = (Db::getInstance())->getConnection($db_config);

require CORE . '/router.php';




