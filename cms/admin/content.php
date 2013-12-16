<?php
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
Validate::checkSession();
Validate::checkPremission('7','警告，权限不足，您不能发布文档！');
global $_tpl;
$_content = new ContentAction($_tpl);   //入口
$_content->_action();
$_tpl->display('content.tpl');
?>