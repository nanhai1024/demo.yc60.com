var header = [];
header[1] = {
	'title' : '暑假人气网游推荐',
	'pic' : '/cms/uploads/20110821/20110821220150378.png',
	'link' : 'http://www.163.com'
};
header[2] = {
	'title' : '生活家买一送三',
	'pic' : '/cms/uploads/20110821/20110821220130319.png',
	'link' : 'http://www.tmall.com'
};
header[3] = {
	'title' : '水润BB霜，买一赠一',
	'pic' : '/cms/uploads/20110821/20110821220119177.png',
	'link' : 'http://www.taobao.com'
};
var i = Math.floor(Math.random()*3+1);
document.write('<a href="'+header[i].link+'" target="_blank" title="'+header[i].title+'"><img src="'+header[i].pic+'"></a>');