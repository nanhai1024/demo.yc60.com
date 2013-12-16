<?php
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
Validate::checkSession();
Validate::checkPremission('14','警告，权限不足，您不能管理系统配置！');
global $_tpl;
$_system = new SystemAction($_tpl);   //入口
$_system->_action();
$_tpl->display('system.tpl');
?>