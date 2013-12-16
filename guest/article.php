<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2010-2012 yc60
* Web: http://www.yc60.com
* ================================================
* Author: Lee
* Date: 2010-8-23
*/
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','article');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';	
//处理精华帖
if ($_GET['action'] == 'nice' && isset($_GET['id']) && isset($_GET['on'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_uniqid
														FROM 
																	tg_user 
													 WHERE 
																	tg_username='{$_COOKIE['username']}' 
														 LIMIT 
																	1"
	)) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		//设置精华帖，或者取消精华帖
		_query("UPDATE tg_article SET tg_nice='{$_GET['on']}' WHERE tg_id='{$_GET['id']}'");
		if (_affected_rows() == 1) {
			_close();
			_location('精华帖操作成功！','article.php?id='.$_GET['id']);
		} else {
			_close();
			_alert_back('精华帖设置失败！');
		}
	}
	else {
		_alert_back('非法登录！');
	}
}
//处理回帖
if ($_GET['action'] == 'rearticle') {
	global $_system;
	if (!empty($_system['code'])) {
		_check_code($_POST['code'],$_SESSION['code']); //验证码判断
	}
	if (!!$_rows = _fetch_array("SELECT 
																	tg_uniqid,
																	tg_article_time 
														FROM 
																	tg_user 
													 WHERE 
																	tg_username='{$_COOKIE['username']}' 
														 LIMIT 
																	1"
			)) {
			_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
			_timed(time(),$_rows['tg_article_time'],$_system['re']);
			//接受数据
			$_clean = array();
			$_clean['reid'] = $_POST['reid'];
			$_clean['type'] = $_POST['type'];
			$_clean['title'] = $_POST['title'];
			$_clean['content'] = $_POST['content'];
			$_clean['username'] = $_COOKIE['username'];
			$_clean = _mysql_string($_clean);
			//写入数据库
			_query("INSERT INTO tg_article (
																	tg_reid,
																	tg_username,
																	tg_title,
																	tg_type,
																	tg_content,
																	tg_date
																)
												 VALUES (
												 					'{$_clean['reid']}',
												 					'{$_clean['username']}',
												 					'{$_clean['title']}',
												 					'{$_clean['type']}',
												 					'{$_clean['content']}',
												 					NOW()
												 				)"
			);
			if (_affected_rows() == 1) {
				//setcookie('article_time',time());
				$_clean['time'] = time();
				_query("UPDATE tg_user SET tg_article_time='{$_clean['time']}' WHERE tg_username='{$_COOKIE['username']}'");
				_query("UPDATE tg_article SET tg_commendcount=tg_commendcount+1 WHERE tg_reid=0 AND tg_id='{$_clean['reid']}'");
				_close();
				//_session_destroy();
				_location('回帖成功！','article.php?id='.$_clean['reid']);
			} else {
				_close();
				//_session_destroy();
				_alert_back('回帖失败！');
			}
	} else {
		_alert_back('非法登录！');
	}
}
//读出数据
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_id,
																	tg_username,
																	tg_title,
																	tg_type,
																	tg_content,
																	tg_readcount,
																	tg_commendcount,
																	tg_last_modify_date,
																	tg_nice,
																	tg_date 
													  FROM 
																	tg_article 
													WHERE
																	tg_reid=0
															AND
																	tg_id='{$_GET['id']}'")) {
	
		//累积阅读量
		_query("UPDATE tg_article SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
	
		$_html = array();
		$_html['reid'] = $_rows['tg_id'];
		$_html['username_subject'] = $_rows['tg_username'];
		$_html['title'] = $_rows['tg_title'];
		$_html['type'] = $_rows['tg_type'];
		$_html['content'] = $_rows['tg_content'];
		$_html['readcount'] = $_rows['tg_readcount'];
		$_html['commendcount'] = $_rows['tg_commendcount'];
		$_html['nice'] = $_rows['tg_nice'];
		$_html['last_modify_date'] = $_rows['tg_last_modify_date'];
		$_html['date'] = $_rows['tg_date'];
		
		
		
		//拿出用户名，去查找用户信息
		if (!!$_rows = _fetch_array("SELECT 
																		tg_id,
																		tg_sex,
																		tg_face,
																		tg_email,
																		tg_url,
																		tg_switch,
																		tg_autograph
														  FROM 
														  				tg_user 
														WHERE 
																		tg_username='{$_html['username_subject']}'")) {
			//提取用户信息
			$_html['userid'] = $_rows['tg_id'];
			$_html['sex'] = $_rows['tg_sex'];
			$_html['face'] = $_rows['tg_face'];
			$_html['email'] = $_rows['tg_email'];
			$_html['url'] = $_rows['tg_url'];
			$_html['switch'] = $_rows['tg_switch'];
			$_html['autograph'] = $_rows['tg_autograph'];
			$_html = _html($_html);
			
			
			//创建一个全局变量，做个带参的分页
			global $_id;
			$_id = 'id='.$_html['reid'].'&';
			
			//主题帖子修改
			if ($_html['username_subject'] == $_COOKIE['username'] || isset($_SESSION['admin'])) {
				$_html['subject_modify'] = '[<a href="article_modify.php?id='.$_html['reid'].'">修改</a>]';
			}
			
			//读取最后修改信息
			if ($_html['last_modify_date'] != '0000-00-00 00:00:00') {
				$_html['last_modify_date_string'] = '本贴已由['.$_html['username_subject'].']于'.$_html['last_modify_date'].'修改过！';
			}
			
			//给楼主回复
			if ($_COOKIE['username']) {
				$_html['re'] = '<span>[<a href="#ree" name="re" title="回复1楼的'.$_html['username_subject'].'">回复</a>]</span>';
			}
			
			//个性签名
			if ($_html['switch'] == 1) {
				$_html['autograph_html'] = '<p class="autograph">'._ubb($_html['autograph']).'</p>';
			}
			
			
			//读取回帖
			global $_pagesize,$_pagenum,$_page;
			_page("SELECT tg_id FROM tg_article WHERE tg_reid='{$_html['reid']}'",10); 
			$_result = _query("SELECT 
												tg_username,tg_type,tg_title,tg_content,tg_date 
									FROM 
												tg_article 
									WHERE
												tg_reid='{$_html['reid']}'
							ORDER BY 
												tg_date ASC 
									 LIMIT 
												$_pagenum,$_pagesize
			");	
												
			
												
		} else {
			//这个用户已被删除
			
		}
	} else {
		_alert_back('不存在这个主题！');
	}
} else {
	_alert_back('非法操作！');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/article.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="article">
	<h2>帖子详情</h2>
	<?php 
		if (!empty($_html['nice'])) {
	?>
	<img src="images/nice.gif" alt="精华帖" class="nice" />
	
	<?php 
		}
		//浏览量达到400，并且评论量达到20即可为热帖
		if ($_html['readcount'] >= 400 && $_html['commendcount'] >=20) {
	?>
	<img src="images/hot.gif" alt="热帖" class="hot" />
	
	<?php 
		}
		if ($_page == 1) {
	?>
	<div id="subject">
		<dl>
			<dd class="user"><?php echo $_html['username_subject']?>(<?php echo $_html['sex']?>)[楼主]</dd>
			<dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username_subject']?>" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid']?>">发消息</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid']?>">加为好友</a></dd>
			<dd class="guest">写留言</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid']?>">给他送花</a></dd>
			<dd class="email">邮件：<a href="mailto:<?php echo $_html['email']?>"><?php echo $_html['email']?></a></dd>
			<dd class="url">网址：<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span>
					<?php 
					if ($_SESSION['admin']) {
						if (empty($_html['nice'])) {
					?>
					[<a href="article.php?action=nice&on=1&id=<?php echo $_html['reid']?>">设置精华</a>]
					<?php } else {?>
					[<a href="article.php?action=nice&on=0&id=<?php echo $_html['reid']?>">取消精华</a>]
					<?php 
						}
					}
					?>
					<?php echo $_html['subject_modify']?> 1#
				</span><?php echo $_html['username_subject']?> | 发表于：<?php echo $_html['date']?>
			</div>
			<h3>主题：<?php echo $_html['title']?> <img src="images/icon<?php echo $_html['type']?>.gif" alt="icon" /> <?php echo $_html['re']?></h3>
			<div class="detail">
				<?php echo _ubb($_html['content'])?>
				<?php echo $_html['autograph_html']?>
			</div>
			<div class="read">
				<p><?php echo $_html['last_modify_date_string']?></p>
				阅读量：(<?php echo $_html['readcount']?>) 评论量：(<?php echo $_html['commendcount']?>)
			</div>
		</div>
	</div>
	<?php }?>
	
	
	<p class="line"></p>
	
	<?php 
		$_i = 2;
		while (!!$_rows = _fetch_array_list($_result)) {
			$_html['username'] = $_rows['tg_username'];
			$_html['type'] = $_rows['tg_type'];
			$_html['retitle'] = $_rows['tg_title'];
			$_html['content'] = $_rows['tg_content'];
			$_html['date'] = $_rows['tg_date'];
			$_html = _html($_html);
			

			
			if (!!$_rows = _fetch_array("SELECT 
																			tg_id,
																			tg_sex,
																			tg_face,
																			tg_email,
																			tg_url,
																			tg_switch,
																			tg_autograph
															  FROM 
															  				tg_user 
															WHERE 
																			tg_username='{$_html['username']}'")) {
				//提取用户信息
				$_html['userid'] = $_rows['tg_id'];
				$_html['sex'] = $_rows['tg_sex'];
				$_html['face'] = $_rows['tg_face'];
				$_html['email'] = $_rows['tg_email'];
				$_html['url'] = $_rows['tg_url'];
				$_html['switch'] = $_rows['tg_switch'];
				$_html['autograph'] = $_rows['tg_autograph'];
				$_html = _html($_html);
				
				//楼层
				if ($_page == 1 && $_i == 2) {
					if ($_html['username'] == $_html['username_subject']) {
						$_html['username_html'] = $_html['username'].'(楼主)';
					} else {
						$_html['username_html'] = $_html['username'].'(沙发)';
					}
				} else {
					$_html['username_html'] = $_html['username'];
				}
				
			} else {
				//这个用户可能已经被删除了
			}
			
			//跟帖回复
			if ($_COOKIE['username']) {
				$_html['re'] = '<span>[<a href="#ree" name="re" title="回复'.($_i + (($_page-1) * $_pagesize)).'楼的'.$_html['username'].'">回复</a>]</span>';
			}
	?>
	<div class="re">
		<dl>
			<dd class="user"><?php echo $_html['username_html']?>(<?php echo $_html['sex']?>)</dd>
			<dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username']?>" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid']?>">发消息</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid']?>">加为好友</a></dd>
			<dd class="guest">写留言</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid']?>">给他送花</a></dd>
			<dd class="email">邮件：<a href="mailto:<?php echo $_html['email']?>"><?php echo $_html['email']?></a></dd>
			<dd class="url">网址：<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span><?php echo $_i + (($_page-1) * $_pagesize);?>#</span><?php echo $_html['username']?> | 发表于：<?php echo $_html['date']?>
			</div>
			<h3>主题：<?php echo $_html['retitle']?> <img src="images/icon<?php echo $_html['type']?>.gif" alt="icon" /> <?php echo $_html['re']?></h3>
			<div class="detail">
				<?php echo _ubb($_html['content'])?>
				<?php 
					if ($_html['switch'] == 1) {
					echo '<p class="autograph">'._ubb($_html['autograph']).'</p>';
					}
				?>
			</div>
		</div>
	</div>
	<p class="line"></p>
	<?php 
			$_i ++;		
		}
		_free_result($_result);
		_paging(1);
	?>
	
	<?php if (isset($_COOKIE['username'])) {?>
	<a name="ree"></a>
	<form method="post" action="?action=rearticle">
		<input type="hidden" name="reid" value="<?php echo $_html['reid']?>" />
		<input type="hidden" name="type" value="<?php echo $_html['type']?>" />
		<dl>
			<dd>标　　题：<input type="text" name="title" class="text" value="RE:<?php echo $_html['title']?>" /> (*必填，2-40位)</dd>
			<dd id="q">贴　　图：　<a href="javascript:;">Q图系列[1]</a>　 <a href="javascript:;">Q图系列[2]</a>　 <a href="javascript:;">Q图系列[3]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php'?>
				<textarea name="content" rows="9"></textarea>
			</dd>
			
			<dd>
			<?php if (!empty($_system['code'])) {?>
			验 证 码：
			<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" onclick="javascript:this.src='code.php?tm='+Math.random();" /> 
			<?php }?>
			<input type="submit" class="submit" value="发表帖子" /></dd>
		</dl>
	</form>
	<?php }?>
</div>
<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
