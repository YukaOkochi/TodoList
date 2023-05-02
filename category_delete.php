<?php
session_start();
session_regenerate_id();

require_once('./class/config/Config.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');
require_once('./class/util/SaftyUtil.php');

$post = SaftyUtil::sanitize($_POST);

if(empty($_SESSION['user'])) {
    header('Location: ./login.php');
}

try{
    $db = new TodoItems();    
    $item = $db->selectAllItem($_POST['category_id']);
} catch (Exception $e) {
    var_dump($e);
    exit;
}

$token = SaftyUtil::generateToken();
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
                <div class="text-primary display-6">一覧削除確認</div>
                <span>ようこそ<?= $_SESSION['user']['user'] ?>さん</span>
                <a href="./logout.php">ログアウト</a>
            </span>
            <div><?= $_POST['category_name'] ?>の中に入っている下記のデータも全て削除しますがよろしいですか？</div>
            <?php foreach($item as $v) : ?>                       
                <div class="text-left">
                    <div class="pt-5">
                        <span class="text-white bg-primary" style="padding-right:10px;">項目名</span>
                        <span><?= $v['item_name'] ?></span>
                    </div>
                    <div class="pt-1">
                        <span class="text-white bg-primary" style="padding-right:10px;">担当者</span>
                        <span><?= $v['family_name'] . $v['first_name'] ?></span>
                    </div>
                    <div class="pt-1">
                        <span class="text-white bg-primary">カテゴリー</span>
                        <span><?= $v['category_name'] ?></span>
                    </div>                    
                    <div class="pt-1">
                        <span style="padding-right:25px;" class="text-white bg-primary">期限</span>
                        <span><?= $v['expire_date'] ?></span
                    </div>
                    <div class="pt-1">
                        <span style="padding-right:25px;" class="text-white bg-primary">完了</span>
                        <input type="checkbox" value="1" id="finished" name="finished" <?php if(isset($list['finished_date'])) {echo 'disabled checked';} else {echo 'disabled';} ?>>完了
                    </div>
                </div>
                <?php endforeach ?>
                <form action="./category_delete_action.php" method="post">
                    <div class="text-center pt-4">
                        <input type="hidden" name="token" value="<?= $token ?>">
                        <input type="hidden" name="category_id" value="<?= $_POST['category_id'] ?>">
                        <input type="submit" value="削除">
                    </div>                   
                </form>
            
                <div class="text-center">
                    <a href="./category.php">キャンセル</a>
                </div>                          
            </div>                                
        </div>    
    </div>
</body>

</html>