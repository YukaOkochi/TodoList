<?php
session_start();
session_regenerate_id();

require_once('./class/config/Config.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');
require_once('./class/db/Users.php');
require_once('./class/db/Categorys.php');
require_once('./class/util/SaftyUtil.php');

if (!SaftyUtil::isValidToken($_POST['token'])) {
    $_SESSION['msg']['err']  = Config::MSG_INVALID_PROCESS;
    header('Location: ./edit.php');
    exit;
}

$post = SaftyUtil::sanitize($_POST);

if(empty($_SESSION['user'])) {
    header('Location: ./login.php');
}

$_SESSION['post'] = $post;


try {    
    if(($_POST['item_name']) == '') {
        $_SESSION['msg']['err'] = Config::MSG_SELECT_ITEM;
        header('Location: ./edit.php?id=' . $_POST['id']);
        exit;
    } elseif(isset($_POST['item_name']) && mb_strlen($_POST['item_name']) > 100) {
        $_SESSION['msg']['err'] = Config::MSG_OVER_ITEM;
        header('Location: ./edit.php?id=' . $_POST['id']);
        exit;
    }

    if(empty($_POST['name'])) {
        $_SESSION['msg']['err'] = Config::MSG_SELECT_NAME;
        header('Location: ./edit.php?id=' . $_POST['id']);
        exit;
    }

    $db = new Users();
    $user = $db->findUserId($_POST['name']);
    if(!($user)) {
        $_SESSION['msg']['err'] = Config::MSG_PROPER_NAME;
        header('Location: ./edit.php?id=' . $_POST['id']);
        exit;
    }

    if(empty($_POST['category'])) {
        $_SESSION['msg']['err'] = Config::MSG_SELECT_CATEGORY;
        header('Location: ./edit.php?id=' . $_POST['id']);
        exit;
    }

    $db = new Categorys();
    $category = $db->findCategoryId($_POST['category']);
    if(!($category)) {
        $_SESSION['msg']['err'] = Config::MSG_PROPER_CATEGORY;
        header('Location: ./edit.php?id=' . $_POST['id']);
        exit;
    }

    if(empty($_POST['expire_date'])) {
        $_SESSION['msg']['err'] = Config::MSG_MISTAKEN_DATE;
        header('Location: ./edit.php?id=' . $_POST['id']);
        exit;
    }
    
    $db = new TodoItems(); 
    $db->update($_POST['id'],$_POST['item_name'], $_POST['name'], $_POST['category'], $_POST['expire_date']);

    if(isset($_SESSION['post'])) {
        unset($_SESSION['post']);
    }
    
    header('Location: ./');
    exit;
} catch (Exception $e) {
    $_SESSION['msg']['err'] = Config::MSG_EXCEPTION;
    header('Location: ./error.php');
    exit;
}
?>