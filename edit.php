<?php
session_start();
session_regenerate_id();

require_once('./class/config/Config.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');
require_once('./class/db/Users.php');
require_once('./class/db/Categorys.php');
require_once('./class/util/SaftyUtil.php');

$token = SaftyUtil::generateToken();

try{
    $db = new TodoItems();
    $id = $_GET['id'];
    $list = $db->selectAllId($id);

    $db = new Users();
    $userAll = $db->selectAdd();

    $db = new Categorys();  
    $category = $db->selectCategory();
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
                <div class="text-primary display-6">作業更新</div>
                <span>ようこそ<?= $_SESSION['user']['user'] ?>さん</span>
                <a href="./logout.php">ログアウト</a>
            </span>
            <div class="text-center">
                <?php if(isset($_SESSION['msg']['err'])) :?>
                <div class="text-danger">
                    <?= $_SESSION['msg']['err'] ?>
                </div>
                <?php endif ?>
                <p>作業内容を修正してください</p>
            </div>
                <form action="./edit_action.php" method="post">
                <input type="hidden" name="token" value="<?=$token ?>">          
                    <div class="text-left">
                        <div class="pt-5">
                            <span class="text-white bg-primary" style="padding-right:10px;">項目名</span>
                            <input type="text" name="item_name" value="<?= isset($_SESSION['post']['item_name']) ? $_SESSION['post']['item_name'] : $list['item_name'] ?>">
                        </div>
                        <div class="pt-1">
                            <span class="text-white bg-primary" style="padding-right:10px;">担当者</span>
                            <select name="name">
                                <option value="">--選択してください--</option>
                                <?php foreach($userAll as $v) : ?>
                                    <option value="<?= $v['id'] ?>" 
                                    <?php 
                                    if(isset($_SESSION['post']['name']) && $_SESSION['post']['name'] == $v['id']) {
                                        echo 'selected';
                                    } else {
                                        echo '';
                                        if(!isset($_SESSION['post']['name']) && $list['user_id'] == $v['id']) {
                                        echo 'selected'; 
                                        } else {echo '';}
                                    }   
                                    ?>><?= $v['family_name'] . $v['first_name'] ?></option>                                                                                                   
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="pt-1">
                            <span class="text-white bg-primary">カテゴリー</span>
                            <select name="category">
                                <option value="">--選択してください--</option>
                                <?php foreach($category as $v) : ?>
                                    <option value="<?= $v['id'] ?>" 
                                    <?php 
                                    if(isset($_SESSION['post']['category']) && $_SESSION['post']['category'] == $v['id']) {
                                        echo 'selected';
                                    } else {
                                        echo '';
                                        if(!isset($_SESSION['post']['category']) && $list['category_id'] == $v['id']) {
                                        echo 'selected'; 
                                        } else {echo '';}
                                    }                                  
                                    ?>><?= $v['category_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="pt-1">
                            <span style="padding-right:25px;" class="text-white bg-primary">期限</span>
                            <input type="date" name="expire_date" value="<?= isset($_SESSION['post']['expire_date']) ? $_SESSION['post']['expire_date'] : $list['expire_date'] ?>">
                        </div>
                        <div class="pt-1">
                            <span style="padding-right:25px;" class="text-white bg-primary">完了</span>
                            <input type="checkbox" value="1" name="finished" <?php if(isset($list['finished_date'])) {echo 'checked';} ?>>完了
                        </div>
                    </div>
                    
                    <div class="text-center pt-4">
                        <input type="hidden" name="id" value="<?=$list['id'] ?>">
                        <input type="submit" value="更新">
                    </div>
                </form>
                <div class="text-center">
                    <a href="./">キャンセル</a>
                </div>                                                 
        </div>    
    </div>
</body>

</html>