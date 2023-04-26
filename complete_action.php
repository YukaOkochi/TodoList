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

try{
    $db = new TodoItems(); 
    $id = $_POST['id'];   
    $db->insertComplete($id); 
    
    header('Location: ./');
} catch (Exception $e) {
    var_dump($e);
    exit; 
}
?>