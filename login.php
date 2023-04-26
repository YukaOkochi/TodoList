<?php
session_start();
session_regenerate_id();

require_once('./class/config/Config.php');
require_once('./class/util/SaftyUtil.php');
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
        <div class="row my-3 justify-content-center">           
            <span class="border-bottom">
                <div class="text-primary display-6">ログイン</div>
            </span>
            <div class="text-center">
                <?php if(isset($_SESSION['msg']['err'])) :?>
                <div class="text-danger">
                    <?= $_SESSION['msg']['err'] ?>
                </div>
                <?php endif ?>
                <form action="./login_action.php" method="post">
                    <input type="hidden" name="token" value="<?= SaftyUtil::generateToken() ?>">
                    <div class="pt-5">
                        <span style="padding-right:5px;">ユーザー名</span>
                        <input type="text" name="name" value="<?php if (isset($_SESSION['login']['name'])) echo $_SESSION['login']['name'] ?>">
                    </div>
                    <div class="pt-1">
                        <span style="padding-right:14px;">パスワード</span><input type="text" name="password">
                    </div>
                    <div class="pt-4">
                        <input type="submit" value="ログイン">
                    </div>
                </form>
            </div>                                                
        </div>    
    </div>
</body>

</html>