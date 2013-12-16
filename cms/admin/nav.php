<?php
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
Validate::checkSession();
Validate::checkPremission('6','警告，权限不足，您不能管理导航！');
global $_tpl;
$_nav = new NavAction($_tpl);   //入口
$_nav->_action();
$_tpl->display('nav.tpl');
?>