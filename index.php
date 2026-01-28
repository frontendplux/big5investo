<?php
include __DIR__.'/config/conn.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$router=parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$router=explode('/', $router);
// print_r($router);
$country=$router[1] ?? 'NG';
$route=$router[2] ?? '';

    switch($route){
        case '':
        case 'login':
        case 'home':
            $seo_configuration=[
                "title"=>"Big5 Investo - Connect with Investors Worldwide",
                "description"=>"Join Big5 Investo to connect with investors globally, share insights, and stay updated on market trends.",
                "keywords"=>"Big5 Investo, investment community, global investors, market insights, financial discussions",
                "icon"=>"/image/logo.png"
            ];
            include __DIR__.'/main/auth/index.php';
            break;

        case 'signup':
            include __DIR__.'/main/auth/signup.php';
            break;

        case 'forgot-password':
            include __DIR__.'/main/auth/forgot_password.php';
            break;

        case 'confirm-passcode':
            include __DIR__.'/main/auth/confirm-passcode.php';
            break;

        
        case 'uk':
            require 'uk.php';
            break;

        default:
            echo "Country not supported.";
            break;
    }
