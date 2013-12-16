<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2010-2012 yc60
* Web: http://www.yc60.com
* ================================================
* Author: Lee
* Date: 2010-10-9
*/
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','article_modify');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
$_skinurl = $_SERVER["HTTP_REFERER"];
//必须从上一页点击过来，而且必须有ID
if (empty($_skinurl) || !isset($_GET['id'])) {
	_alert_back('非法操作！');
} else {
	//最好判断一下id必须是1，2，3中的一个
	//生成一个cookie，用来保存皮肤的种类
	setcookie('skin',$_GET['id']);
	_location(null,$_skinurl);
}
?>