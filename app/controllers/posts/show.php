<?php

$db = \myfrm\App::get(\myfrm\Db::class);

$slug = route_param('slug');

$post = $db->query("SELECT * FROM posts WHERE slug = ? LIMIT 1", [$slug])->findOrFail();


$title = "My Blog :: {$post['title']}";
require_once VIEWS . '/posts/show.tpl.php';