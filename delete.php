<?php
session_start();
session_regenerate_id();

require_once('./class/config/Config.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');
require_once('./class/db/Categorys.php');
require_once('./class/util/SaftyUtil.php');

$token = SaftyUtil::generateToken();

try{
    $db = new TodoItems();
    $id = $_POST['id'];
    $list = $db->selectAllId($id);

    $db = new Categorys();  
    $category = $db->selectCategoryAll($id);
} catch (Exception $e) {
    var_dump($e);
    exit; 
}
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
                <div class="text-primary display-6">削除確認</div>
                <span>ようこそ<?= $_SESSION['user']['user'] ?>さん</span>
                <a href="./logout.php">ログアウト</a>
            </span>
            <div class="text-center">
                <?php if(isset($_SESSION['msg']['err'])) :?>
                <div class="text-danger">
                    <?= $_SESSION['msg']['err'] ?>
                </div>
                <?php endif ?>
                <p>下記の項目を削除します。よろしいですか？</p>
            </div>
                <form action="./delete_action.php" method="post">
                <input type="hidden" name="token" value="<?=$token ?>">          
                    <div class="text-left">
                        <div class="pt-5">
                            <span class="text-white bg-primary" style="padding-right:10px;">項目名</span>
                            <span><?= $list['item_name'] ?></span>
                        </div>
                        <div class="pt-1">
                            <span class="text-white bg-primary" style="padding-right:10px;">担当者</span>
                            <span><?= $list['family_name'] . $list['first_name'] ?></span>
                        </div>
                        <div class="pt-1">
                            <span class="text-white bg-primary">カテゴリー</span>
                            <span><?= $category[0]['category_name'] ?></span>
                        </div>                    
                        <div class="pt-1">
                            <span style="padding-right:25px;" class="text-white bg-primary">期限</span>
                            <span><?= $list['expire_date'] ?></span
                        </div>
                        <div class="pt-1">
                            <span style="padding-right:25px;" class="text-white bg-primary">完了</span>
                            <input type="checkbox" value="1" id="finished" name="finished" <?php if(isset($list['finished_date'])) {echo 'disabled checked';} else {echo 'disabled';} ?>>完了
                        </div>
                    </div>
                    
                    <div class="text-center pt-4">
                        <input type="hidden" name="id" value="<?=$list['id'] ?>">
                        <input type="submit" value="削除">
                    </div>
                </form>
                <div class="text-center">
                    <a href="./">キャンセル</a>
                </div>                                               
        </div>    
    </div>
</body>

</html>