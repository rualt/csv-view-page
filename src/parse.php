<?php

if ($_FILES["file"]["error"] > 0) {
    header("Location: /index.phtml?status=error");
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
    
    file_put_contents(__DIR__ . "/../data/storage.json", json_encode($mappedUsers));
    header("Location: /index.phtml?status=success");
} else {
    file_put_contents(__DIR__ . "/../data/storage.json", "");
    header("Location: /index.phtml?status=empty");
}
