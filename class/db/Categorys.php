<?php
class Categorys extends Base {
    
    public function __construct() {
        parent::__construct();
    }

    public function selectCategory() {
        $sql = 'select * from category order by category_name ASC';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectCategoryId($category_id) {
        $sql = 'select category_name from category where id=:id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        $name = $stmt->fetch(PDO::FETCH_ASSOC);
        return $name['category_name'];
    }

    public function insertCategory($category_name) {
        $sql = 'insert into category(category_name) values (:category_name)';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCategoryAll($id) {
        $sql = 'delete from todo_items where category_id=:id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findCategoryId($id) {
        $sql = 'select * from category where id=:id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function selectCategoryAll($id) {
        $sql = 'select category.*, todo_items.*';
        $sql .= ' from todo_items join category on todo_items.category_id = category.id where todo_items.id=:id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCategory($id) {
        $sql = 'delete from category where id=:id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>