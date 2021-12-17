<?php
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db' => 'bankingdb'
    ),
    'remember' => array(
        'cookie_name' => 'Hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token',
    )
);

spl_autoload_register(function($class){
    require_once 'Classes/' . $class . '.php';
});

require_once 'functions/Sanitize.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name')); 
    $hashCheck = Db::getInstance()->get('users_session', array('Hash', '=', $hash));

    if ($hashCheck->count()) {
        $user = new User($hashCheck->first()->UserID);
        $user->login();
    }
}