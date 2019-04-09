<?php
/**
 * Created by PhpStorm.
 * User: xiangshi
 * Date: 19-4-8
 * Time: 下午5:30
 */

namespace framework\core;

use framework\dao\DAOPDO;

/*
 * code for all kinds of model
 */

class Model {
    protected $dao;
    protected $true_table;  // true table name
    protected $pk;          // primary key

    public function __construct() {
        $this->initDAO();
        $this->initTrueTable();
        $this->initField();
    }

    public function initDAO() {
        $option = $GLOBALS['config'];
        $this->dao = DAOPDO::getSingleton($option);
    }

    public function initTrueTable() {
        $this->true_table = '`' . $GLOBALS['config']['table_prefix'] . $this->logic_table . '`';
    }

    public function initField() {
        $sql = "DESC $this->true_table";
        $result = $this->dao->fetchAll($sql);

        foreach ($result as $k => $v) {
            if ($v['Key'] == 'PRI') {
                // $v['Field'] is the primary key
                $this->pk = $v['Field'];
            }
        }
    }

    public function insert($data) {
        $sql = "INSERT INTO $this->true_table";

        $fields = array_keys($data);
        $field_list = array_map(function ($v) {
            return '`' . $v . '`';
        }, $fields);

        $field_list = '(' . implode(',', $field_list) . ')';
        $sql .= $field_list;

        $field_value = array_values($data);
        // for safety, use quote to transfer character
        $field_value = array_map(array($this->dao, "quote"), $field_value);
        $field_value = ' VALUES(' . implode(',', $field_value) . ')';

        $sql .= $field_value;

        $this->dao->exec($sql);
        return $this->dao->lastInsertId();
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->true_table WHERE $this->pk=$id";
        die($sql);
        return $this->dao->exec($sql);
    }

    /*
     * must have a where clause
     */
    public function update($data, $where = null) {
        if (!$where) {
            // directly stop
            return false;
        } else {
            foreach ($where as $k => $v) {
                $where_str = " WHERE `$k`='$v'";
            }
        }

        $sql = "UPDATE $this->true_table SET ";
        // eg. array{0=>`goods_name`,1=>`shop_price`}
        $fields = array_keys($data);
        $fields = array_map(function ($v) {
            return '`' . $v . '`';
        }, $fields);

        $field_values = array_values($data);
        $field_values = array_map(array($this->dao, "quote"), $field_values);

        $str = '';
        foreach ($fields as $k => $v) {
            $str .= $v . '=' . $field_values[$k] . ',';
        }

        // delete last comma
        $str = substr($str, 0, -1);

        $sql .= $str . $where_str;

        return $this->dao->exec($sql);
    }

    public function find($data = array(), $where = array()) {
        if (!$data) {
            $fields = '*';
        } else {
            $fields = array_map(function ($v) {
                return '`' . $v . '`';
            }, $data);
            $fields = implode(',', $fields);
        }

        if (!$where) {
            $sql = "SELECT $fields FROM $this->true_table";
            return $this->dao->fetchAll($sql);
        } else {
            foreach ($where as $k => $v) {
                $where_str = '`' . $k . '`=' . "'$v'";
            }
            $sql = "SELECT $fields FROM $this->true_table WHERE $where_str";
             return $this->dao->fetchRow($sql);
        }
        die($sql);
    }
}