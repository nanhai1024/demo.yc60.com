var sidebar = [];
sidebar[1] = {
	'title' : '车优惠伴我行',
	'pic' : '/cms/uploads/20110821/20110821220251713.png',
	'link' : 'http://www.yc60.com'
};
sidebar[2] = {
	'title' : 'M绅士全场3折',
	'pic' : '/cms/uploads/20110821/20110821220231540.png',
	'link' : 'http://www.tmall.com'
};
sidebar[3] = {
	'title' : '爱制造旗舰店',
	'pic' : '/cms/uploads/20110821/20110821220209387.png',
	'link' : 'http://www.360.cn'
};
var i = Math.floor(Math.random()*3+1);
document.write('<a href="'+sidebar[i].link+'" target="_blank" title="'+sidebar[i].title+'"><img border="0" src="'+sidebar[i].pic+'"></a>');