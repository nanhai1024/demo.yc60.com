<script type="text/javascript" src="http://demo.yc60.com/cms/config/static.php?type=header"></script>
<div id="top">
	{$header}
	<script type="text/javascript" src="http://demo.yc60.com/cms/js/text_adver.js"></script>
</div>
<div id="header">
	<h1><a href="http://demo.yc60.com/cms/">{$webname}</a></h1>
	<div class="adver"><script type="text/javascript" src="http://demo.yc60.com/cms/js/header_adver.js"></script></div>
</div>
<div id="nav">
	<ul>
		<li><a href="http://demo.yc60.com/cms/">首页</a></li>
		{if $FrontNav}
		{foreach $FrontNav(key,value)}
		<li><a href="http://demo.yc60.com/cms/topic-{@value->id}.html">{@value->nav_name}</a></li>
		{/foreach}
		{/if}
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
		{if $FiveTag}
		{foreach $FiveTag(key,value)}
		<li><a href="http://demo.yc60.com/cms/search.php?type=3&inputkeyword={@value->tagname}">{@value->tagname}({@value->count})</a></li>
		{/foreach}
		{/if}
	</ul>
</div>