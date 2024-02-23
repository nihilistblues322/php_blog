<?php

use myfrm\Db;
use myfrm\App;
use myfrm\Pagination;

$title = 'My Blog :: Home';

$db = App::get(Db::class);



$page = $_GET['page'] ?? 1;
$per_page = 6;
$total = $db->query("SELECT COUNT(*) FROM posts")->getColumn();
$pagination = new Pagination((int)$page, $per_page, $total);

$start = $pagination->getStart();

$posts = $db->query("SELECT * FROM posts ORDER BY id DESC LIMIT $start, $per_page")->findAll();
$recent_posts = $db->query("SELECT * FROM posts ORDER BY id DESC LIMIT 3")->findAll();

require_once VIEWS . '/posts/index.tpl.php';
