<?php

$localeData = null;
function i8ln($word)
{
    global $locale;
    $locale = !empty($_COOKIE["LocaleCookie"]) ? $_COOKIE["LocaleCookie"] : $locale;
    if ($locale == "en") {
        return $word;
    }

    global $localeData;
    if ($localeData == null) {
        $filepath = 'static/dist/locales/' . $locale . '.min.json';
        if (file_exists($filepath)) {
            $json_contents = file_get_contents($filepath);
            $localeData = json_decode($json_contents, true);
        } else {
            return $word;
        }
    }

    if (isset($localeData[$word])) {
        return $localeData[$word];
    } else {
        return $word;
    }
}


function setSessionCsrfToken()
{
    if (empty($_SESSION['token'])) {
        generateToken();
    }
}


function refreshCsrfToken()
{
    global $sessionLifetime;
    if (time() - $_SESSION['c'] > $sessionLifetime) {
        session_regenerate_id(true);
        generateToken();
    }
    return $_SESSION['token'];
}


function generateToken()
{
    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
    $_SESSION['c'] = time();
}


function validateToken($token)
{
    global $enableCsrf;
    if ((!$enableCsrf) || ($enableCsrf && isset($token) && $token === $_SESSION['token'])) {
        return true;
    } else {
        return false;
    }
}


function destroyCookiesAndSessions()
{
    global $manualdb;
    
    $manualdb->update("users", ["session_id" => null], ["id" => $_SESSION['user']->id]);
    unset($_SESSION);
    unset($_COOKIE['LoginCookie']);
    setcookie("LoginCookie", "", time() - 3600);
    session_destroy();
    session_write_close();
}

function validateCookie($cookie)
{
    global $manualdb;
    $info = $manualdb->query(
        "SELECT id, user, access_level FROM users WHERE session_id = :session_id", [
            ":session_id" => $cookie
        ]
    )->fetch();

    if (!empty($info['user'])) {
        $_SESSION['user'] = new \stdClass();
        $_SESSION['user']->id = $info['id'];
        $_SESSION['user']->user = htmlspecialchars($info['user'], ENT_QUOTES, 'UTF-8');
        $_SESSION['user']->access_level = $info['access_level'];

        setcookie("LoginCookie", $cookie, time() + 60 * 60 * 24 * 7);
        if (!isset($_SESSION['already_refreshed'])) {
            $_SESSION['already_refreshed'] = true;
            return false;
        } else {
            return true;
        }
    } elseif (!empty($_SESSION['user'])) {
        destroyCookiesAndSessions();
        return false;
    } else {
        unset($_COOKIE['LoginCookie']);
        setcookie("LoginCookie", "", time() - 3600);
        return false;
    }
}