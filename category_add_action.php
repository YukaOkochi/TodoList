<?php
session_start();
session_regenerate_id();

require_once('./class/config/Config.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');
require_once('./class/db/Categorys.php');
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

try{
    $db = new Categorys(); 
    
    if(($_POST['category_name']) == '') {
        $_SESSION['msg']['err'] = Config::MSG_WRITE_CATEGORY;
        header('Location: ./category.php');
        exit;
    } elseif(isset($_POST['category_name']) && mb_strlen($_POST['category_name']) > 5) {
        $_SESSION['msg']['err'] = Config::MSG_OVER_CATEGORY;
        header('Location: ./category.php');
        exit;
    }

    if(isset($_SESSION['msg']['err'])) {
        unset($_SESSION['msg']['err']);
    }
    
    $db->insertCategory($_POST['category_name']); 
    header('Location: ./category.php');
} catch (Exception $e) {
    var_dump($e);
    exit; 
}
?>