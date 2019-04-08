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

    }

    public function delete($id) {

    }

    public function update($data, $where = null) {

    }

    public function find($data = array(), $where = array()) {

    }

}