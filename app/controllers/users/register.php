<?php

use myfrm\App;
use myfrm\Db;
use myfrm\Validator;

$title = "My Blog :: Register";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = App::get(Db::class);
    $data = load(['name', 'email', 'password']);


    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $data['avatar'] = $_FILES['avatar'];
    } else {
        $data['avatar'] = [];
    }

    $validator = new Validator();

    $validation = $validator->validate($data, [
        'name' => [
            'required' => true,
            'max' => 100,
        ],
        'email' => [
            'email' => true,
            'min' => 10,
            'max' => 100,
            'unique' => 'users:email',
        ],
        'password' => [
            'required' => true,
            'min' => 6,
        ],
        'avatar' => [
            'required' => true,
            'ext' => 'jpeg|gif',
            'size' => 1 * 1024 * 1024,

             
        ]

    ]);
    
    if (!$validation->hasErrors()) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        if (db()->query("INSERT INTO users (`name`, `email`, `password`) VALUES (:name, :email, :password)", $data)) {
            $_SESSION['success'] = 'Вы успешно зарегистрировались!';
        } else {
            $_SESSION['error'] = 'DB Error';
        }
        redirect(PATH);
    }

}

require_once VIEWS . '/users/register.tpl.php';
