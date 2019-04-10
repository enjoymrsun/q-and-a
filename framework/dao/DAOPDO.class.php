<?php
/**
 * Created by PhpStorm.
 * User: xiangshi
 * Date: 19-4-8
 * Time: 下午7:18
 */

namespace framework\dao;

use framework\dao\I_DAO;
use PDO;
use PDOException;

class DAOPDO implements I_DAO {
    // private attribute
    private static $instance;   // DAOPDO singleton
    private $pdo;               // PDO object

    // private constructor
    private function __construct($option) {
        // constructor
        $host = isset($option['host']) ? $option['host'] : '';
        $user = isset($option['user']) ? $option['user'] : '';
        $pass = isset($option['pass']) ? $option['pass'] : '';
        $dbname = isset($option['dbname']) ? $option['dbname'] : '';
        $port = isset($option['port']) ? $option['port'] : '';
        $charset = isset($option['charset']) ? $option['charset'] : '';

        $dsn = "mysql:host=$host;dbname=$dbname;port=$port;charset=$charset";
        try {
            $this->pdo = new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // private clone, do not let clone
    private function __clone() {
    }

    public static function getSingleton($option) {
        if (!self::$instance instanceof self) {
            self::$instance = new self($option);
        }
        return self::$instance;
    }

    // one record
    public function fetchRow($sql) {
        $pdo_statement = $this->pdo->query($sql);
        if ($pdo_statement == false) {
            // sql error
            $error = $this->pdo->errorInfo();
            $err_str = "SQL Error:<br>" . $error[2];
            echo $err_str;
            return false;
        }
        // no problem for sql
        $result = $pdo_statement->fetch(PDO::FETCH_ASSOC);
        $pdo_statement->closeCursor();          // close cursor
        return $result;
    }

    // all records
    public function fetchAll($sql) {
        $pdo_statement = $this->pdo->query($sql);
        if ($pdo_statement == false) {
            $error = $this->pdo->errorInfo();
            $err_str = "SQL Error:<br>" . $error[2];
            echo $err_str;
            return false;
        }
        $result = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo_statement->closeCursor();
        return $result;
    }

    // one field
    public function fetchColumn($sql) {
        $pdo_statement = $this->pdo->query($sql);
        if ($pdo_statement == false) {
            $error = $this->pdo->errorInfo();
            $err_str = "SQL Error:<br>" . $error[2];
            echo $err_str;
            return false;
        }
        $result = $pdo_statement->fetchColumn();
        $pdo_statement->closeCursor();
        return $result;
    }

    // crud operation
    public function exec($sql) {
        $result = $this->pdo->exec($sql);
        if ($result === false) {
            $error = $this->pdo->errorInfo();
            $err_str = 'SQL Error:<br>' . $error[2];
            echo $err_str;
            return false;
        }
        return $result;
    }

    // quote
    public function quote($data) {
        return $this->pdo->quote($data);
    }

    // last insert id
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}