<?php
/**
 * Created by PhpStorm.
 * User: xiangshi
 * Date: 19-4-8
 * Time: 下午7:12
 */

namespace framework\dao;

interface I_DAO {
    // one record
    public function fetchRow($sql);
    // all records
    public function fetchAll($sql);
    // one field
    public function fetchColumn($sql);
    // crud operation
    public function exec($sql);
    // quote
    public function quote($data);
    // last insert id
    public function lastInsertId();
}