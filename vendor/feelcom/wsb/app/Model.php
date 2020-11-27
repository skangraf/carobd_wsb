<?php
namespace feelcom\wsb;

use \PDO;
use \PDOException;

abstract class Model
{
    protected $dbh;
    protected $stmt;

    public function __construct($_dbh=NULL) {

        // check is DB object exist, if not create it.
        if (is_object($_dbh))
        {
            $this->dbh = $_dbh;
        }
        else
        {
            // try to create DB connection if fail return exception message
            try {

                $this->dbh = new PDO('mysql:host=127.0.0.1:3307;dbname='.DB_NAME,'root','',[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"]);

            } catch (PDOException $e) {
                die ($e->getMessage());
            }

        }

    }


    public function query($query) {
        var_dump($query);

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