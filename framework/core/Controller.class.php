<?php
/**
 * Created by PhpStorm.
 * User: xiangshi
 * Date: 19-4-8
 * Time: 下午4:24
 */

namespace framework\core;

class Controller {
    protected $smarty;

    public function __construct() {
        $this->initTimezone();
        $this->initSmarty();
    }

    public function initTimezone() {
        date_default_timezone_set("America/New_York");
    }

    public function initSmarty() {
        $this->smarty = new \Smarty();
        $this->smarty->left_delimiter = '<{';
        $this->smarty->right_delimiter = '}>';
        $this->smarty->setTemplateDir(APP_PATH . MODULE . '/view/');
        $this->smarty->setCompileDir(APP_PATH . MODULE . '/runtime/tpl_c');
    }

    public function jump($url, $message, $delay=3) {
        header("Refresh:$delay;url=$url");
        echo $message;
        die;
    }
}