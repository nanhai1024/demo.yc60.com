<script type="text/javascript" src="http://demo.yc60.com/cms/config/static.php?type=header"></script>
<div id="top">
	<?php echo $this->_vars['header'];?>
	<script type="text/javascript" src="http://demo.yc60.com/cms/js/text_adver.js"></script>
</div>
<div id="header">
	<h1><a href="http://demo.yc60.com/cms/"><?php echo $this->_vars['webname'];?></a></h1>
	<div class="adver"><script type="text/javascript" src="http://demo.yc60.com/cms/js/header_adver.js"></script></div>
</div>
<div id="nav">
	<ul>
		<li><a href="http://demo.yc60.com/cms/">首页</a></li>
		<?php if ($this->_vars['FrontNav']) {?>
		<?php foreach ($this->_vars['FrontNav'] as $key=>$value) { ?>
		<li><a href="http://demo.yc60.com/cms/topic-<?php echo $value->id?>.html"><?php echo $value->nav_name?></a></li>
		<?php } ?>
		<?php } ?>
	</ul>
</div>
<div id="search">
	<form method="get" action="search.php">
		<select name="type">
			<option selected="selected" value="1">按标题</option>
			<option value="2">按关键字</option>
		</select>
		<input type="text" name="inputkeyword" class="text" />
		<input type="submit" class="submit" value="搜索" />
	</form>
	<strong>TAG标签：</strong>
	<ul>
		<?php if ($this->_vars['FiveTag']) {?>
		<?php foreach ($this->_vars['FiveTag'] as $key=>$value) { ?>
		<li><a href="http://demo.yc60.com/cms/search.php?type=3&inputkeyword=<?php echo $value->tagname?>"><?php echo $value->tagname?>(<?php echo $value->count?>)</a></li>
		<?php } ?>
		<?php } ?>
	</ul>
</div>