<?php
class Base {
    protected $dbh;

    public function __construct() {
        $dsn = 'mysql:dbname=' . Config::DB_NAME . ';host=' . Config::DB_HOST . ';charset=utf8';
        $this->dbh = new PDO($dsn, Config::DB_USER, Config::DB_PASS);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function begin() {
        $this->dbh->beginTransaction();
    }

    public function commit() {
        $this->dbh->commit();
    }

    public function rollback() {
        $this->dbh->rollback();
    }
}
?>