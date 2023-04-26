<?php
session_start();
session_regenerate_id();

if(empty($_SESSION['user'])) {
    header('Location: ./login.php');
}

if (!SaftyUtil::isValidToken($_POST['token'])) {
    $_SESSION['msg']['err']  = Config::MSG_INVALID_PROCESS;
    header('Location: ./');
    exit;
}

$post = SaftyUtil::sanitize($_POST);

try {
    $db = new TodoItems();

    if(isset($post['delete']) && $post['delete'] == "1") {
        $db->delete($post['id']);
    } else {
        $db->updateIsCompletedById($post['id'],$post['is_completed']);
    }
    header('Location: ./');
} catch (Exception $e) {
    var_dump($e);
    exit;
}
?>