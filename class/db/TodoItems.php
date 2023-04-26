<?php
class TodoItems extends Base {
    
    public function __construct() {
        parent::__construct();
    }

    public function selectAll($category_id) {
        $sql = 'select users.id, users.family_name, users.first_name, todo_items.*';
        $sql .= ' from todo_items join users on todo_items.user_id = users.id where category_id=:id order by expire_date';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function selectSearch($category_id,$seach) {
        $sql = 'select users.id, users.family_name, users.first_name, todo_items.*';
        $sql .= ' from todo_items join users on todo_items.user_id = users.id';
        $sql .= ' where todo_items.category_id=:id and (todo_items.item_name like :item_name or users.family_name like :family_name or users.first_name like :first_name) order by expire_date';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':item_name', '%'. $_POST['search'] .'%', PDO::PARAM_STR);
        $stmt->bindValue(':family_name', '%' . $_POST['search'] .'%', PDO::PARAM_STR);
        $stmt->bindValue(':first_name', '%'. $_POST['search'] .'%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertComplete($id) {
        $sql = 'update todo_items set finished_date=:finished_date where id=:id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':finished_date', date('Y-m-d'), PDO::PARAM_STR);
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($item_name, $user_id, $category_id, $expire_date) {
        $sql = 'insert into todo_items(item_name,user_id,category_id,expire_date,registration_date,finished_date';
        $sql .= ') values (';
        $sql .= ':item_name,:user_id,:category_id,:expire_date,:registration_date,:finished_date)';
        $stmt = $this->dbh->prepare($sql);      
        $stmt->bindValue(':item_name', $item_name, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':expire_date', $expire_date, PDO::PARAM_STR);
        $stmt->bindValue(':registration_date', date('Y-m-d'), PDO::PARAM_STR);
        
        if(isset($_POST['finished']) && $_POST['finished'] == 1) {
            $stmt->bindValue(':finished_date', date('Y-m-d'), PDO::PARAM_STR);
        } else {
            $stmt->bindValue(':finished_date', null, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function selectAllId($id) {
        $sql = 'select users.id, users.family_name, users.first_name, todo_items.*';
        $sql .= ' from todo_items join users on todo_items.user_id = users.id where todo_items.id=:id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id,$item_name,$user_id,$category_id,$expire_date) {
        $sql = 'update todo_items set item_name=:item_name,user_id=:user_id,category_id=:category_id,expire_date=:expire_date,registration_date=:registration_date,finished_date=:finished_date where id=:id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':item_name', $item_name, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':expire_date', $expire_date, PDO::PARAM_STR);
        $stmt->bindValue(':registration_date', date('Y-m-d'), PDO::PARAM_STR);

        if(isset($_POST['finished']) && $_POST['finished'] == 1) {
            $stmt->bindValue(':finished_date', date('Y-m-d'), PDO::PARAM_STR);
        } else {
            $stmt->bindValue(':finished_date', null, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = 'delete from todo_items where id=:id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function selectAllItem($category_id) {
        $sql = 'select users.id, users.family_name, users.first_name, todo_items.*,category.*';
        $sql .= ' from todo_items join users on todo_items.user_id = users.id join category on todo_items.category_id = category.id where category_id=:category_id order by expire_date';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>