<?php

if ($_FILES["file"]["error"] > 0) {
    //header("Location: /index.html?status=error");
}

if($_FILES["file"]["size"] > 0) {
    $tmpName = $_FILES['file']['tmp_name'];
    $users = array_map('str_getcsv', file($tmpName));

    $colors= [];
    for ($i = 0; count($users) > $i; $i++) {
        $colors[] = sprintf("#%06X", mt_rand(0, 0x222222));
        $colors = array_unique($colors);
    }
            
    $mappedUsers = array_map(function ($user, $color) {
        return [
            'name' => $user[0],
            'phone' => $user[1],
            'color' => $color
        ];
        }, $users, $colors);

    setcookie('users', json_encode($mappedUsers), time()+3600, '/');
    header("Location: /index.phtml?status=success");
} else {
    header("Location: /index.html?status=empty");
}
