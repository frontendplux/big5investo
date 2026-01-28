<?php
include __DIR__ . '/config/conn.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Get user country from IP (cached in session)
 */
function getUserCountryFromIP(string $default = 'NG'): string
{
    if (isset($_SESSION['country'])) {
        return $_SESSION['country'];
    }

    $ip = $_SERVER['HTTP_CLIENT_IP']
        ?? $_SERVER['HTTP_X_FORWARDED_FOR']
        ?? $_SERVER['REMOTE_ADDR']
        ?? '';

    if ($ip === '127.0.0.1' || $ip === '::1') {
        return $_SESSION['country'] = strtoupper($default);
    }

    $url = "http://ip-api.com/json/{$ip}?fields=status,countryCode";
    $response = @file_get_contents($url);

    if ($response) {
        $data = json_decode($response, true);
        if ($data['status'] === 'success') {
            return $_SESSION['country'] = strtoupper($data['countryCode']);
        }
    }

    return $_SESSION['country'] = strtoupper($default);
}

/**
 * Parse URL
 */
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$router = explode('/', $path);

/**
 * Detect country safely
 */
if (isset($router[0]) && preg_match('/^[a-zA-Z]{2,3}$/', $router[0])) {

    // Country exists in URL
    $country = strtoupper($router[0]);
    $route   = $router[1] ?? 'home';

} else {

    // Country missing → detect & redirect
    $country = getUserCountryFromIP();

    $path = implode('/', $router);
    $path = $path ? '/' . $path : '';

    header("Location: /{$country}{$path}");
    exit;
}
$route = strtolower($route);
/**
 * Router
 */
switch ($route) {

    case '':
    case 'home':
    case 'login':
        $seo_configuration = [
            "title"       => "Big5 Investo - Connect with Investors Worldwide",
            "description" => "Join Big5 Investo to connect with investors globally, share insights, and stay updated on market trends.",
            "keywords"    => "Big5 Investo, investment community, global investors, market insights, financial discussions",
        ];
        include __DIR__ . '/main/auth/index.php';
        break;

    case 'signup':
        include __DIR__ . '/main/auth/signup.php';
        break;

    case 'forgot-password':
        include __DIR__ . '/main/auth/forgot_password.php';
        break;

    case 'confirm-passcode':
        include __DIR__ . '/main/auth/confirm-passcode.php';
        break;

    case 'uk':
        include __DIR__ . '/uk.php';
        break;

    default:
        http_response_code(404);
        include __DIR__ . '/main/errors/404.php';
        break;
}
