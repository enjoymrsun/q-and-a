<?php
/**
 * Created by PhpStorm.
 * User: xiangshi
 * Date: 19-4-7
 * Time: 下午2:53
 */

namespace framework\core;

/*
 * factory class, will produce singleton class from user required
 */

class Factory {
    // public static method
    // $modelName: what the model name person required

    public static function M($modelName) {
        if (substr($modelName, -5) != 'Model') {
            $modelName .= 'Model';
        }

        if (!strchr($modelName, '\\')) {
            // connect with namespace
            $modelName = MODULE . '\model\\' . $modelName;
        }

        static $model_list = array();

        if (!isset($model_list[$modelName])) {
            $model_list[$modelName] = new $modelName;
        }
        return $model_list[$modelName];
    }
}