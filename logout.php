<?php
session_start();
session_regenerate_id();

unset($_SESSION['user']);
unset($_SESSION['login']);
unset($_SESSION['msg']['err']);

header('Location: ./login.php');
exit;
?>