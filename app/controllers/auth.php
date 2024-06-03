<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../database/config.php';

use Medoo\Medoo;

$msg = '';

//  Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register-btn'])) {
    $username = strip_tags(htmlspecialchars(str_replace(' ', '', $_POST['username'])));
    $email = strip_tags(htmlspecialchars(str_replace(' ', '', $_POST['email'])));
    $password = strip_tags(htmlspecialchars(str_replace(' ', '', $_POST['password'])));
    $passwordAgain = strip_tags(htmlspecialchars(str_replace(' ', '', $_POST['passwordAgain'])));

    if (mb_strlen($username, 'UTF-8') < 3): $msg = 'Username can\'t be shorter than 3 characters!';
    elseif (mb_strlen($username, 'UTF-8') > 20): $msg = 'Username can\'t be longer than 20 characters!';
    elseif (!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD',
    $email)): $msg = 'Email address is in incorrect format!';
    elseif (!empty($db->select('users', ['id'], ['username' => $username])) || !empty($db->select('users', ['id'], ['email' => $email]))):
        $msg = 'This account is already registered';
    elseif (mb_strlen($password, 'UTF-8') < 5): $msg = 'Password can\'t be shorter than 5 characters!';
    elseif ($password !== $passwordAgain): $msg = 'Passwords don\'t match!';
    endif;

    if (!empty($msg)): return;
    endif;

    if (isset($_POST['remember'])){
        $user_token = base64_encode(openssl_random_pseudo_bytes(mt_rand(15, 35)));

        setcookie('ut', $user_token, time() + 3600 * 24 * (365 / 2), '/');
    } elseif (empty($_POST['remember'])) {
        $_SESSION['user'] = $username;
    }

    $db->insert('users', [
        'username' => $username,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'user_token' => $user_token ?? null,
    ]);

    header('Location: /public');

} else {
    $username = null;
    $email = null;
}

//  Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login-btn'])) {
    $email = strip_tags(htmlspecialchars(str_replace(' ', '', $_POST['email'])));
    $password = strip_tags(htmlspecialchars(str_replace(' ', '', $_POST['password'])));

    $password_hash = $db->select('users', ['password'], ['email' => $email])[0]['password'] ?? '';

    $verifyPassword = password_verify($password, $password_hash) ?? '';

    $verifyEmail = $db->select('users', ['email'], ['email' => $email])[0]['email'] ?? '';

    if (!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD',
    $email)): $msg = 'Email address is in incorrect format!';
    elseif (mb_strlen($password, 'UTF-8') < 5): $msg = 'Password can\'t be shorter than 5 characters!';
    elseif (!$verifyEmail || !$verifyPassword):
        $msg = 'Email or password is incorrect';
    endif;

    if (!empty($msg)): return;
    endif;


    if (isset($_POST['remember'])){
        $user_token = $db->select('users', ['user_token'], ['email' => $email])[0]['user_token']
                    ?? base64_encode(openssl_random_pseudo_bytes(mt_rand(15, 35)));

        $db->update('users', ['user_token' => $user_token], ['email' => $email]);

        setcookie('ut', $user_token, time() + 3600 * 24 * (365 / 2), '/');
    } else {
        $_SESSION['user'] = $db->select('users', ['username'], ['email' => $email])[0]['username'];
    }

    header('Location: /public');

} else {
    $email = null;
}


//      Get info
if (isset($_SESSION['user'])) {
    $user = $db->select('users', '*', ['username' => $_SESSION['user']])[0];

} elseif (isset($_COOKIE['ut'])) {
    $user = $db->select('users', '*', ['user_token' => $_COOKIE['ut']])[0];
}

//      Log out
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['logout'])) {
    setcookie('ut', '', time() - 3600 * 24 * 365, '/');
    unset($_SESSION['user']);

    header('Location: /public');
}