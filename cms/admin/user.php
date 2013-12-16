<?php
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
Validate::checkSession();
Validate::checkPremission('13','警告，权限不足，您不能管理会员！');
global $_tpl;
$_user = new UserAction($_tpl);    //入口
$_user->_action();
$_tpl->display('user.tpl');
?>