<?php
session_start();
session_regenerate_id();

require_once('./class/config/Config.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');
require_once('./class/db/Categorys.php');
require_once('./class/util/SaftyUtil.php');

$post = SaftyUtil::sanitize($_POST);

if(empty($_SESSION['user'])) {
    header('Location: ./login.php');
}

try{
    $_SESSION['category_id'] = $_POST['category_id'];

    $db = new Categorys();    
    $_SESSION['category_name'] = $db->selectCategoryId($_SESSION['category_id']); 

    header('Location: ./');
} catch (Exception $e) {
    var_dump($e);
    exit; 
}
?>

