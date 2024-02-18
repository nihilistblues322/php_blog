<?php

use myfrm\App;
use myfrm\Db;

$title = 'My Blog :: Home';

$db = App::get(Db::class);

$posts = $db->query("SELECT * FROM posts ORDER BY id DESC")->findAll();
$recent_posts = $db->query("SELECT * FROM posts ORDER BY id DESC LIMIT 3")->findAll();

require_once VIEWS . '/posts/index.tpl.php';
