<?php
	//分页类
	class Page {
		private $total;											//总记录
		private $pagesize;										//每页显示多少条
		private $limit;												//limit
		private $page;											//当前页码
		private $pagenum;										//总页码
		private $url;												//地址
		private $bothnum;										//两边保持数字分页的量
		private $htmlpage;										//判断是否伪静态页面

		
		//构造方法初始化
		public function __construct($_total, $_pagesize) {
			$this->total = $_total ? $_total : 1;
			$this->pagesize = $_pagesize;
			$this->pagenum = ceil($this->total / $this->pagesize);
			$this->page = $this->setPage();
			$this->limit = "LIMIT ".($this->page-1)*$this->pagesize.",$this->pagesize";
			$this->url = $this->setUrl();
			$this->bothnum = 2;
		}
		
		//拦截器
		private function __get($_key) {
			return $this->$_key;
		}
		
		//获取当前页码
		private function setPage() {
			if(empty($_GET['page'])) {
				$_url = $_SERVER["REQUEST_URI"];
				$_par = parse_url($_url);
				$_pattern = '/\/([\w]+)\/([\w]+)-([\w]+)-([\w]+).html/';
				$_str = '$4';
				if(preg_match($_pattern, $_par['path'])){
					$this->htmlpage = preg_replace($_pattern,$_str,$_par['path']);
				} 
			} else {
				$this->htmlpage = $_GET['page'];
			}
			
			if (!empty($this->htmlpage)) {
				if ($this->htmlpage > 0) {
					if ($this->htmlpage > $this->pagenum) {
						return $this->pagenum;
					} else {
						return $this->htmlpage;
					}
				} else {
					return 1;
				}
			} else {
				return 1;
			}
		}	
		
		//获取地址
		private function setUrl() {
			$_url = $_SERVER["REQUEST_URI"];
			$_par = parse_url($_url);
			if (isset($_par['query'])) {
				parse_str($_par['query'],$_query);
				unset($_query['page']);
				$_url = $_par['path'].'?'.http_build_query($_query);
			}
			return $_url;
		}
		
		//伪静态地址
		private function pageHtml($_page, $_pagename) {
			$_url = $_SERVER["REQUEST_URI"];
			$_par = parse_url($_url);
			
			$_pattern = '/\/([\w]+)\/([\w]+)-([\w]+)-([\w]+).html/';
			$_str = ' <a href="/$1/$2-$3-'.$_page.'.html">'.$_pagename.'</a> ';
			if(preg_match($_pattern, $_par['path'])){
				$urlhtml = preg_replace($_pattern,$_str,$_par['path']);
			}
			
			$_pattern1 = '/\/([\w]+)\/([\w]+)-([\w]+).html/';
			$_str1 = ' <a href="/$1/$2-$3-'.$_page.'.html">'.$_pagename.'</a> ';
			if(preg_match($_pattern1, $_par['path'])){
				$urlhtml = preg_replace($_pattern1,$_str1,$_par['path']);
			} 
			
			if(empty($urlhtml)) {
				$urlhtml = ' <a href="'.$this->url.'&page='.$_page.'">'.$_pagename.'</a> ';
			}
		
			return $urlhtml;
		}

		//数字目录
		private function pageList() {
			for ($i=$this->bothnum;$i>=1;$i--) {
				$_page = $this->page-$i;
				if ($_page < 1) continue;
				//$_pagelist .=' <a href="'.$this->url.'&page='.$_page.'">'.$_page.'</a> ';
				$_pagelist .= $this->pageHtml($_page, $_page);
			}
			$_pagelist .= ' <span class="me">'.$this->page.'</span> ';
			for ($i=1;$i<=$this->bothnum;$i++) {
				$_page = $this->page+$i;
				if ($_page > $this->pagenum) break;
				//$_pagelist .= ' <a href="'.$this->url.'&page='.$_page.'">'.$_page.'</a> ';
				$_pagelist .= $this->pageHtml($_page, $_page);
			}
			return $_pagelist;
		}
		
		//首页
		private function first() {
			if ($this->page > $this->bothnum+1) {
				return ' <a href="'.$this->url.'">1</a> ...';
			}
		}
		
		//上一页
		private function prev() {
			if ($this->page == 1) {
				return '<span class="disabled">上一页</span>';
			}
			//return ' <a href="'.$this->url.'&page='.($this->page-1).'">上一页</a> ';
			return $this->pageHtml(($this->page-1),'上一页');
		}
		
		//下一页
		private function next() {
			if ($this->page == $this->pagenum) {
				return '<span class="disabled">下一页</span>';
			}
			//return ' <a href="'.$this->url.'&page='.($this->page+1).'">下一页</a> ';
			return $this->pageHtml(($this->page+1),'下一页');
		}
		
		//尾页
		private function last() {
			if ($this->pagenum - $this->page > $this->bothnum) {
				//return ' ...<a href="'.$this->url.'&page='.$this->pagenum.'">'.$this->pagenum.'</a> ';
				return ' ...'.$this->pageHtml($this->pagenum, $this->pagenum);
			}
		}
		
		//分页信息
		public function showpage() {
			$_page .= $this->first();
			$_page .= $this->pageList();
			$_page .= $this->last();
			$_page .= $this->prev();
			$_page .= $this->next();
			return $_page;
		}
	}
?>