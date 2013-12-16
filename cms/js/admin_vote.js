window.onload = function () {
	var title = document.getElementById('title');
	var ol = document.getElementsByTagName('ol');
	var a = ol[0].getElementsByTagName('a');

	for (i=0;i<a.length;i++) {
		a[i].className = null;
		if (title.innerHTML == a[i].innerHTML) {
			a[i].className = 'selected';
		}
	}
};

//验证等级表单
function checkForm() {
	var fm = document.add;
	if (fm.title.value == '' || fm.title.value.length < 2 || fm.title.value.length > 20) {
		alert('警告：标题不得为空并且不得小于两位并且不得大于20位！');
		fm.title.focus();
		return false;
	}
	if (fm.info.value.length > 200) {
		alert('警告：描述不得大于200位！');
		fm.info.focus();
		return false;
	}
	return true;
}








