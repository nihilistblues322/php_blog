<?php

use myfrm\App;
use myfrm\Db;
use myfrm\Validator;

$title = "My Blog :: Register";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = App::get(Db::class);
    $data = load(['name', 'email', 'password']);


    if (isset ($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
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
            'ext' => 'jpg|gif',
            'size' => 1 * 1024 * 1024,


        ]

    ]);

    if (!$validation->hasErrors()) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        if (db()->query("INSERT INTO users (`name`, `email`, `password`) VALUES (?,?,?)", [$data['name'], $data['email'], $data['password']])) {


            if (!empty ($data['avatar']['name'])) {
                $id = db()->getInsertId();

                $file_ext = get_file_ext($data['avatar']['name']);
                $dir = '/avatars/' . date('Y') . '/' . date('m') . '/' . date('d');
                if (!is_dir(UPLOADS . $dir)) {
                    mkdir(UPLOADS . $dir, 0777, true);
                }
                $file_path = UPLOADS . "{$dir}/avatar-{$id}.{$file_ext}";
                $file_url = "/uploads{$dir}/avatar-{$id}.{$file_ext}";

                if (move_uploaded_file($data['avatar']['tmp_name'], $file_path)) {
                    db()->query("UPDATE users SET avatar = ? WHERE id = ?", [$file_url, $id]);
                } else {
                    error_log("[" . date('Y-m-d H:i:s') . "] File upload error" . PHP_EOL, 3, ERROR_LOG_FILE);

                }
            }

            $_SESSION['success'] = 'Вы успешно зарегистрировались!';
        } else {
            $_SESSION['error'] = 'DB Error';
        }
        redirect(PATH);
    }

}

require_once VIEWS . '/users/register.tpl.php';
