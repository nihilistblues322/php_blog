<?php

use myfrm\Db;
use myfrm\App;
use myfrm\ServiceContainer;



$container = new ServiceContainer();
$container->setService(Db::class, function () {
    $db_config = require CONFIG . '/db.php';
    return (Db::getInstance())->getConnection($db_config);
});

App::setContainer($container);