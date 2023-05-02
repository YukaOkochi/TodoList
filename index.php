<?php
session_start();
session_regenerate_id();

require_once('./class/config/Config.php');
require_once('./class/db/Base.php');
require_once('./class/db/TodoItems.php');
require_once('./class/util/SaftyUtil.php');

if(empty($_SESSION['user'])) {
    header('Location: ./login.php');
}

if(empty($_SESSION['category_id'])) {
    header('Location: ./category.php');
}

if(isset($_SESSION['msg']['err'])) {
    unset($_SESSION['msg']['err']);
}

try{
    $db = new TodoItems();
    
    if(!isset($_POST['search'])) {
        $list = $db->selectAll($_SESSION['category_id']);
    } else {
        $search = $_POST['search'];
        $list = $db->selectSearch($_SESSION['category_id'],$search);        
    }     
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
    <style>
    table td {
        background: #eee;
        height:50px;
    }
    table tr:nth-child(odd) td {
        background: #fff;
    }

    .complete {
        text-decoration: line-through;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row my-3 justify-content-center">
            <span class="border-bottom">
                <span class="text-primary display-6"><?= $_SESSION['category_name'] ?>一覧</span>
                <span>ようこそ<?= $_SESSION['user']['user'] ?>さん</span>
                <a href="./logout.php">ログアウト</a>
            </span>
            <a href="./add.php">作業登録</a>
            <form action="./" method="post">
                <input type="text" name="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                <input type="submit" value="検索">       
            </form>
            <?php if(count($list) > 0) : ?>
                <table style="margin-top:10px;">
                    <tr class="text-light" style="background-color:blue">
                        <th>項目名</th>
                        <th>担当者</th>
                        <th>登録日</th>
                        <th>期限日</th>
                        <th>完了日</th>
                        <th>操作</th>
                    </tr>
                    <?php foreach($list as $v) : ?>
                    <tr <?php if($v['expire_date'] < date("Y-m-d")) echo 'class="text-danger"'?>>                                  
                        <td class="<?php if (isset($v['finished_date'])) echo 'complete' ?>"><?= $v['item_name'] ?></td>
                        <td class="<?php if (isset($v['finished_date'])) echo 'complete' ?>"><?= $v['family_name'] . $v['first_name'] ?></td>
                        <td class="<?php if (isset($v['finished_date'])) echo 'complete' ?>"><?= $v['registration_date'] ?></td>
                        <td class="<?php if (isset($v['finished_date'])) echo 'complete' ?>"><?= $v['expire_date'] ?></td>
                        <td class="<?php if (isset($v['finished_date'])) echo 'complete' ?>"><?php if (isset($v['finished_date'])) { echo $v['finished_date']; } else { echo "未"; }?></td>
                        <td class="row">
                            <form action="./complete_action.php" method="post" class="col-auto">
                                <input type="hidden" name="token" value="<?=$token ?>">
                                <input type="hidden" name="id" value="<?=$v['id'] ?>">
                                <input style="margin-top:5px;" type="submit" value="完了" class="btn btn-primary">
                            </form>
                            <form action="./edit.php" method="GET" class="col-auto">
                                <input type="hidden" name="id" value="<?=$v['id'] ?>">
                                <input style="margin-top:5px;" type="submit" value="更新" class="btn btn-success">
                            </form>
                            <form action="./delete.php" method="post" class="col-auto">
                                <input type="hidden" name="id" value="<?=$v['id'] ?>">
                                <input style="margin-top:5px;" type="submit" value="削除" class="btn btn-danger">
                            </form>                            
                        </td>                         
                    </tr>
                    <?php endforeach ?>
                </table>
            <?php endif ?>
            <?php if(!isset($_POST["search"])) : ?>
                <?php if(isset($_SESSION['category_id'])) {
                unset($_SESSION['category_id']);
                } ?> 
            <a href="./category.php">戻る</a>
            <?php endif ?>

            <?php if(isset($_POST["search"])) : ?>
            <a href="./">戻る</a>
            <?php endif ?>
        </div>       
    </div>
</body>

</html>