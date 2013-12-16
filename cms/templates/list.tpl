<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$titlec} - {$webname} - CMS内容管理系统</title>
<link rel="stylesheet" type="text/css" href="http://demo.yc60.com/cms/style/basic.css" />
<link rel="stylesheet" type="text/css" href="http://demo.yc60.com/cms/style/list.css" />
</head>
<body>
{include file='header.tpl'}
<div id="list">
	<h2>当前位置 &gt; {$nav}</h2>
	{if $AllListContent}
	{foreach $AllListContent(key,value)}
	<dl>
		<dt><a href="http://demo.yc60.com/cms/archiver-{@value->id}.html" target="_blank"><img src="{@value->thumbnail}" alt="{@value->title}" /></a></dt>
		<dd>[<strong>{@value->nav_name}</strong>] <a href="http://demo.yc60.com/cms/archiver-{@value->id}.html" target="_blank">{@value->title}</a></dd>
		<dd>日期：{@value->date} 点击率：{@value->count} 关键字：[{@value->keyword}]</dd>
		<dd>核心提示：{@value->info}</dd>
	</dl>
	{/foreach}
	{else}
	<p class="none">没有任何数据</p>
	{/if}
	<div id="page">{$page}</div>
</div>
<div id="sidebar">
	<div class="nav">
		<h2>子栏目列表</h2>
		{if $childnav}
		{foreach $childnav(key,value)}
		<strong><a href="http://demo.yc60.com/cms/topic-{@value->id}.html">{@value->nav_name}</a></strong>
		{/foreach}
		{else}
		<span>该栏目没有子类</span>
		{/if}
	</div>
	<div class="right">
		<h2>本月本类推荐</h2>
		<ul>
			{if $MonthNavRec}
			{foreach $MonthNavRec(key,value)}
			<li><em>{@value->date}</em><a href="http://demo.yc60.com/cms/archiver-{@value->id}.html" target="_blank">{@value->title}</a></li>
			{/foreach}
			{/if}
		</ul>
	</div>
	<div class="right">
		<h2>本月本类热点</h2>
		<ul>
			{if $MonthNavHot}
			{foreach $MonthNavHot(key,value)}
			<li><em>{@value->date}</em><a href="http://demo.yc60.com/cms/archiver-{@value->id}.html" target="_blank">{@value->title}</a></li>
			{/foreach}
			{/if}
		</ul>
	</div>
	<div class="right">
		<h2>本月本类图文</h2>
		<ul>
			{if $MonthNavPic}
			{foreach $MonthNavPic(key,value)}
			<li><em>{@value->date}</em><a href="http://demo.yc60.com/cms/archiver-{@value->id}.html" target="_blank">{@value->title}</a></li>
			{/foreach}
			{/if}
		</ul>
	</div>
</div>
{include file='footer.tpl'}
</body>
</html>