<?php
class Users extends Base {

    public function __construct() {
        parent::__construct();
    }

    public function getUser(string $name, string $password): array {
        $rec = $this->findUserByName($name);
        if (empty($rec)) {
            return [];
        }

        if (password_verify($password, $rec['pass'])) {
            return $rec;
        }
        return [];
    }

    private function findUserByName(string $name): array {
        $sql = 'select * from users where user=:name';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        return $rec;
    }

    public function selectAdd() {
        $sql = 'select users.id, users.family_name, users.first_name from users';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUserId($id) {
        $sql = 'select * from users where id=:id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

       
    }


}
?>