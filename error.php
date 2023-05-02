<?php
require_once('./class/config/Config.php');
require_once('./class/db/Base.php');
?>

<!DOCTYPE html>
<html lang="jp">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>共有型TODO管理アプリケーション</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row my-3">           
            <span class="border-bottom">
                <div class="text-primary display-6">エラー</div>
                <a href="./logout.php">ログアウト</a>
            </span>
            <div class="text-center">
                <?php if(isset($_SESSION['msg']['err'])) :?>
                <div class="text-danger">
                    <?= $_SESSION['msg']['err'] ?>
                </div>
                <?php endif ?>
                <a href="./login.php">ログアウト</a>
            </div>                                
        </div>    
    </div>
</body>

</html>