<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_vars['webname'];?></title>
<link rel="stylesheet" type="text/css" href="style/basic.css" />
<link rel="stylesheet" type="text/css" href="style/feedback.css" />
<script type="text/javascript" src="js/details.js"></script>
</head>
<body>
<?php $_tpl->create('header.tpl')?>
<div id="feedback">
	<h2>评论列表</h2>
	<h3><?php echo $this->_vars['titlec'];?></h3>
	<p class="info"><?php echo $this->_vars['info'];?><a href="details.php?id=<?php echo $this->_vars['id'];?>" target="_blank">[详情]</a></p>
	<?php if ($this->_vars['HotThreeComment']) {?>
	<?php foreach ($this->_vars['HotThreeComment'] as $key=>$value) { ?>
	<dl>
		<dt><img src="images/<?php echo $value->face?>" alt="<?php echo $value->user?>" /></dt>
		<dd><em><?php echo $value->date?> 发表</em><span>[<?php echo $value->user?>]</span> <img src="images/hot.gif" alt="热" /></dd>
		<dd class="info">[<?php echo $value->manner?>]<?php echo $value->content?></dd>
		<dd class="bottom"><a href="feedback.php?cid=<?php echo $value->cid?>&id=<?php echo $value->id?>&type=sustain">[<?php echo $value->sustain?>]支持</a> <a href="feedback.php?cid=<?php echo $value->cid?>&id=<?php echo $value->id?>&type=oppose">[<?php echo $value->oppose?>]反对</a></dd>
	</dl>
	<?php } ?>
	<?php } ?>
	<h4>最新评论</h4>
	<?php if ($this->_vars['AllComment']) {?>
	<?php foreach ($this->_vars['AllComment'] as $key=>$value) { ?>
	<dl>
		<dt><img src="images/<?php echo $value->face?>" alt="<?php echo $value->user?>" /></dt>
		<dd><em><?php echo $value->date?> 发表</em><span>[<?php echo $value->user?>]</span></dd>
		<dd class="info">[<?php echo $value->manner?>]<?php echo $value->content?></dd>
		<dd class="bottom"><a href="feedback.php?cid=<?php echo $value->cid?>&id=<?php echo $value->id?>&type=sustain">[<?php echo $value->sustain?>]支持</a> <a href="feedback.php?cid=<?php echo $value->cid?>&id=<?php echo $value->id?>&type=oppose">[<?php echo $value->oppose?>]反对</a></dd>
	</dl>
	<?php } ?>
	<?php } else { ?>
	<dl>
		<dd>此文档没有任何评论！</dd>
	</dl>
	<?php } ?>
	<div id="page"><?php echo $this->_vars['page'];?></div>
</div>
<div id="sidebar">
	<h2>热评文档总排行</h2>
	<ul>
		<?php if ($this->_vars['HotTwentyComment']) {?>
		<?php foreach ($this->_vars['HotTwentyComment'] as $key=>$value) { ?>
		<li><a href="details.php?id=<?php echo $value->id?>" target="_blank"><?php echo $value->title?></a></li>
		<?php } ?>
		<?php } ?>
	</ul>
</div>
<div class="d5">
	<form method="post" name="comment" action="feedback.php?cid=<?php echo $this->_vars['cid'];?>">
		<p>你对本文的态度：<input type="radio" name="manner" value="1" checked="checked" /> 支持
									<input type="radio" name="manner" value="0" /> 中立
									<input type="radio" name="manner" value="-1" /> 反对
		</p>
		<p class="red">请互联网规则，不要发表关于政治、反动、色情之类的评论。</p>
		<p><textarea name="content"></textarea></p>
		<p style="position:relative;top:-5px;">
			 验证码：<input type="text" class="text" name="code" />
			 <img src="config/code.php" onclick="javascript:this.src='config/code.php?tm='+Math.random();" class="code" /> 
			 <input type="submit" class="submit" onclick="return checkComment();" name="send" value="提交评论" />
		</p>
	</form>
</div>
<?php $_tpl->create('footer.tpl')?>
</body>
</html>