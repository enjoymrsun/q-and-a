<?php
/**
 * Created by PhpStorm.
 * User: xiangshi
 * Date: 19-4-8
 * Time: 下午4:52
 */

namespace framework\core;

class Framework {
    // init in constructor
    public function __construct() {
        $this->initConst();

        $this->autoload();

        $config1 = $this->loadFrameworkConfig();
        $config2 = $this->loadCommonConfig();
        $GLOBALS['config'] = array_merge($config1, $config2);

        $this->initMCA();
        // default model was defined in MCA method
        $config3 = $this->loadModuleConfig();
        $GLOBALS['config'] = array_merge($GLOBALS['config'], $config3);

        $this->dispatch();
    }

    private function initConst() {
        // root dir for project
        define('ROOT_PATH', str_replace('\\', '/', getcwd() . '/'));
        define('APP_PATH', ROOT_PATH . 'application/');
        define('FRAMEWORK_PATH', ROOT_PATH . 'framework/');
        define('PUBLIC_PATH', '/q-and-a/application/public/');
        // upload files path
        define('UPLOADS_PATH', './application/public/uploads/');
        define('THUMB_PATH', './application/public/thumb/');
    }

    // register autoload
    public function autoload() {
        spl_autoload_register(array($this, "autoloader"));
    }

    public function autoloader($className) {
        if ($className == 'Smarty') {
            require_once './framework/vendor/smarty/Smarty.class.php';
            return;
        }
        $arr = explode('\\', $className);

        if ($arr[0] == 'framework') {
            $basic_path = './';
        } else {
            $basic_path = './application/';
        }
        $sub_path = str_replace('\\', '/', $className);

        if (substr($arr[count($arr) - 1], 0, 2) == 'I_') {
            // means interface
            $fix = '.interface.php';
        } else {
            $fix = '.class.php';
        }
        $class_file = $basic_path . $sub_path . $fix;

        if (file_exists($class_file)) {
            require_once $class_file;
        }
    }

    public function initMCA() {
        // home or admin
        $m = isset($_GET['m']) ? $_GET['m'] : $GLOBALS['config']['default_module'];
        define('MODULE', $m);

        // which controller
        $c = isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['default_controller'];
        define('CONTROLLER', $c);

        // which action
        $a = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['default_action'];
        define('ACTION', $a);
    }

    public function dispatch() {
        $controller_name = MODULE . '\controller\\' . CONTROLLER . 'Controller';

        $controller = new $controller_name;

        $a = ACTION;
        $controller->$a();
    }

    private function loadFrameworkConfig() {
        $config_file = './framework/config/config.php';
        return require_once $config_file;
    }

    private function loadCommonConfig() {
        $config_file = './application/common/config/config.php';
        if (file_exists($config_file)) {
            return require_once $config_file;
        } else {
            return array();
        }
    }

    private function loadModuleConfig() {
        $config_file = './application/' . MODULE . '/config/config.php';
        if (file_exists($config_file)) {
            return require_once $config_file;
        } else {
            return array();
        }
    }
}