<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_vars['webname'];?></title>
<link rel="stylesheet" type="text/css" href="style/basic.css" />
<link rel="stylesheet" type="text/css" href="style/friendlink.css" />
<script type="text/javascript" src="js/link.js"></script>
</head>
<body>
<?php $_tpl->create('header.tpl')?>
<?php if ($this->_vars['frontadd']) {?>
<div id="friendlink">
	<h2>申请加入链接</h2>
	<form method="post" name="friendlink">
		<input type="hidden" value="0" name="state" />
		<dl>
			<dd>网站类型：<input type="radio" name="type" onclick="link(1)" value="1" checked="checked" /> 文字链接
									<input type="radio" name="type" onclick="link(2)" value="2" /> Logo链接
			</dd>
			<dd>网站名称：<input type="text" class="text" name="webname" /> <span class="red">[必填]</span> ( * 网站名称不能为空，不大于20位 )</dd>
			<dd>网站地址：<input type="text" class="text" name="weburl" /> <span class="red">[必填]</span> ( *  网站地址不能为空，不大于100位 )</dd>
			<dd id="logo" style="display:none;">Logo地址：<input type="text" class="text" name="logourl" /> <span class="red">[必填]</span> ( * Logo地址不能为空，不大于100位 )</dd>
			<dd>站 长 名：<input type="text" class="text" name="user" /></dd>
			<dd>验 证 码：<input type="text" class="text" name="code" /> <span class="red">[必填]</span></dd>
			<dd><img src="config/code.php" onclick="javascript:this.src='config/code.php?tm='+Math.random();" class="code" /></dd>
			<dd><input type="submit" class="submit" name="send" onclick="return checkLink();" value="申请友情链接" /></dd>
		</dl>
	</form>
</div>
<?php } ?>

<?php if ($this->_vars['frontshow']) {?>
<div id="friendlink">
	<h2>所有链接</h2>
	<h3>文字链接</h3>
	<div>
		<?php if ($this->_vars['Alltext']) {?>
		<?php foreach ($this->_vars['Alltext'] as $key=>$value) { ?>
		<a href="<?php echo $value->weburl?>" target="_blank"><?php echo $value->webname?></a> 
		<?php } ?>
		<?php } ?>
	</div>
	<h3>Logo链接</h3>
	<div>
		<?php if ($this->_vars['Alllogo']) {?>
		<?php foreach ($this->_vars['Alllogo'] as $key=>$value) { ?>
		<a href="<?php echo $value->weburl?>" target="_blank"><img src="<?php echo $value->logourl?>" alt="<?php echo $value->webname?>" /></a>
		<?php } ?>
		<?php } ?>
	</div>
</div>
<?php } ?>
<?php $_tpl->create('footer.tpl')?>
</body>
</html>