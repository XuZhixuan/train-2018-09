<?php

function route_class()
{
    return str_replace('.','-',Route::currentRouteName());
}

function generate_password($length)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*+=?';

    $password = '';

    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[mt_rand(0, strlen($chars) - 1)];
    }

    return $password;
}