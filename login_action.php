<?php
session_start();
session_regenerate_id();

require_once('./class/config/Config.php');
require_once('./class/db/Base.php');
require_once('./class/db/Users.php');
require_once('./class/util/SaftyUtil.php');

if(!isset($_SESSION['token']) || $_SESSION['token'] !== $_POST['token']) {
    $_SESSION['msg']['err'] = Config::MSG_INVALID_PROCESS;
    header('Location: ./');
    exit;
}

$post = SaftyUtil::sanitize($_POST);

$_SESSION['login'] = $_POST;

try {
    $db = new Users();

    $user = $db->getUser($_POST['name'], $_POST['password']);

    if(empty($user)) {
        $_SESSION['msg']['err'] = Config::MSG_USER_LOGIN_FAILURE;
        header('Location: ./login.php');
        exit;
    }

    $_SESSION['user'] = $user;

    unset($_SESSION['msg']['err']);
    header('Location: ./category.php');
} catch (Exception $e) {
    var_dump($e);
    exit;
}
?>