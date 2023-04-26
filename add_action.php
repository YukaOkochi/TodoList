<?php
session_start();
session_regenerate_id();

require_once('./class/config/Config.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');
require_once('./class/util/SaftyUtil.php');

if (!SaftyUtil::isValidToken($_POST['token'])) {
    $_SESSION['msg']['err']  = Config::MSG_INVALID_PROCESS;
    header('Location: ./');
    exit;
}

$post = SaftyUtil::sanitize($_POST);

if(empty($_SESSION['user'])) {
    header('Location: ./login.php');
}

$_SESSION['post'] = $post;

try {
    $db = new TodoItems(); 
    if(($_POST['item_name']) == '') {
        $_SESSION['msg']['err'] = Config::MSG_SELECT_ITEM;
        header('Location: ./add.php');
        exit;
    } elseif(isset($_POST['item_name']) && mb_strlen($_POST['item_name']) > 100) {
        $_SESSION['msg']['err'] = Config::MSG_OVER_ITEM;
        header('Location: ./add.php');
        exit;
    }

    if(empty($_POST['name'])) {
        $_SESSION['msg']['err'] = Config::MSG_SELECT_NAME;
        header('Location: ./add.php');
        exit;
    }

    if(!is_numeric($_POST['name'])) {
        $_SESSION['msg']['err'] = Config::MSG_PROPER_NAME;
        header('Location: ./add.php');
        exit;
    }

    if(empty($_POST['category'])) {
        $_SESSION['msg']['err'] = Config::MSG_SELECT_CATEGORY;
        header('Location: ./add.php');
        exit;
    }

    if(!is_numeric($_POST['category'])) {
        $_SESSION['msg']['err'] = Config::MSG_PROPER_CATEGORY;
        header('Location: ./add.php');
        exit;
    }

    if(empty($_POST['expire_date'])) {
        $_SESSION['msg']['err'] = Config::MSG_MISTAKEN_DATE;
        header('Location: ./add.php');
        exit;
    }
              
    $db->insert($_POST['item_name'], $_POST['name'],$_POST['category'], $_POST['expire_date']);

    if(isset($_SESSION['post'])) {
        unset($_SESSION['post']);
    }

    if(isset($_SESSION['msg']['err'])) {
        unset($_SESSION['msg']['err']);
    }
    
    header('Location: ./category.php');
} catch (Exception $e) {
    $_SESSION['msg']['err'] = Config::MSG_EXCEPTION;
    header('Location: ./error.php');
    exit;
}
?>