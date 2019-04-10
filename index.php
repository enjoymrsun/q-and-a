<?php
/**
 * Created by PhpStorm.
 * User: xiangshi
 * Date: 19-4-9
 * Time: 下午1:33
 */


/*
 * dispatch controller
 * use to respond with user requests
 */

// put full path to Smarty.class.php
require('/var/www/html/q-and-a/framework/vendor/smarty/Smarty.class.php');
$smarty = new Smarty();
echo "load smarty success";

$smarty->setTemplateDir('/var/www/html/q-and-a/application/admin/view');
$smarty->setCompileDir('/var/www/html/q-and-a/application/admin/runtime/tpl_c');
$smarty->setCacheDir('/var/www/html/q-and-a/application/admin/cache');
$smarty->setConfigDir('/var/www/html/q-and-a/framework/config');

$tI = $smarty->testInstall();
$smarty->assign('t', "fsdgsgdsgsda");
$smarty->assign('name', 'xiangshi');
$smarty->display('category/index.html');




?>