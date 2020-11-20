<?php
namespace feelcom\wsb;

use PDO;

abstract class Model
{
    protected $dbh;
    protected $stmt;

    public function __construct() {
        $this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS,[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"]);
    }

    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null){

        if (is_null($type)) {

            if (is_int($value)) {
                $type = PDO::PARAM_INT;
            }
            else if (is_bool($value)) {
                $type = PDO::PARAM_BOOL;
            }
            else if (is_null($value)) {
                $type = PDO::PARAM_NULL;
            }
            else {
                $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {

        $this->stmt->execute();

    }

    public function resultSet() {

        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function rowCount() {

        return $this->stmt->rowCount();

    }

    public function lastInsertId() {

        return $this->dbh->lastInsertId();

    }

    public function single() {

        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);

    }

}