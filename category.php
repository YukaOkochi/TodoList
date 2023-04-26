<?php
session_start();
session_regenerate_id();

require_once('./class/config/Config.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');
require_once('./class/db/Categorys.php');
require_once('./class/util/SaftyUtil.php');

if(empty($_SESSION['user'])) {
    header('Location: ./login.php');
}

try{
    $db = new Categorys();
    $category = $db->selectCategory();              
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
        <div class="row my-3 justify-content-center">
            <span class="border-bottom">
                <span class="text-primary display-6">カテゴリー</span>
                <span>ようこそ<?= $_SESSION['user']['user'] ?>さん</span>
                <a href="./login.php">ログアウト</a>
            </span>
            <span style="margin-top:10px;">新規カテゴリー登録</span>
            <div class="text-center">
                <?php if(isset($_SESSION['msg']['err'])) :?>
                <div class="text-danger">
                    <?= $_SESSION['msg']['err'] ?>
                </div>
                <?php endif ?>
            </div>
            <form action="./category_add_action.php" method="post" style="margin-top:20px;">
                <input type="hidden" name="token" value="<?= $token ?>">                             
                <input type="text" name="category_name" placeholder="カテゴリーを入力してください" id="todo_item">                              
                <input type="submit" value="追加">                          
            </form>
            <table style="margin:40px;">
                <tr>
                    <th></th>
                    <th>項目</th>
                </tr>                
                <?php foreach($category as $name) : ?>
                <tr>
                    <td width="20">◆</td>                   
                    <td><?= $name['category_name'] ?></td>
                    <td class="row">
                        <form action="./category_action.php" method="post" class="col-auto">
                            <input type="hidden" name="category_id" value="<?=$name['id'] ?>">
                            <input style="margin-top:5px;" type="submit" value="一覧へ">
                        </form>
                        <form action="./category_delete.php" method="post" class="col-auto">
                            <input type="hidden" name="category_id" value="<?=$name['id'] ?>">
                            <input type="hidden" name="category_name" value="<?=$name['category_name'] ?>">
                            <input type="submit" value="削除" class="btn btn-danger">
                        </form>      
                    </td>
                </tr>
                <?php endforeach ?>                
            </table>
        </div>       
    </div>
</body>

</html>