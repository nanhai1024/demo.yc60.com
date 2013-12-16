<?php
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
Validate::checkSession();
Validate::checkPremission('8','警告，权限不足，您不能管理评论！');
global $_tpl;
$_comment = new CommentAction($_tpl);   //入口 
$_comment->_action();
$_tpl->display('comment.tpl');
?>