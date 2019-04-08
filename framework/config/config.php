<?php
/**
 * Created by PhpStorm.
 * User: xiangshi
 * Date: 19-4-8
 * Time: 下午3:57
 */

// framework config
return array(
    // database config
    "host"              => "127.0.0.1",
    "user"              => "root",
    "pass"              => "sxs07@MySQL",
    "dbname"            => "qa",
    "port"              => 3306,
    'charset'           => 'utf8',
    'table_prefix'      => 'qa_',

    // smarty config
    'left_delimiter'    => '<{',
    'right_delimiter'   => '}>',

    // default admin or home
    'default_module'    => 'home',
    'default_controller'=> 'Index',
    // indexAction
    'default_action'    => 'indexAction'
);

