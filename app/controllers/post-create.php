<?php

require_once CORE . '/classes/Validator.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fillable = ['title', 'content', 'excerpt'];
    $data = load($fillable);

    $validator = new Validator();
    $validation = $validator->validate($data, [
        'title' => [
            'required' => true,
            'min' => 5,
            'max' => 190
        ],
        'excerpt' => [
            'required' => true,
            'min' => 10,
            'max' => 190
        ],
        'content' => [
            'required' => true,
            'min' => 100,

        ],

    ]);

    $errors = [];
    if (empty($errors)) {
        if (
            $db->query(
                'INSERT INTO posts (`title`, `content`, `excerpt`) VALUES (:title, :content, :excerpt)',
                $data
            )
        ) {
            echo 'ok';
        } else {
            echo 'db error';
        }

        // redirect('/posts/create');
    }
}

$title = "My Blog :: New Post";
require_once VIEWS . '/post-create.tpl.php';
