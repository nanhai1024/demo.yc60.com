<?php
	class SearchAction extends Action {
		
		//构造方法，初始化 
		public function __construct(&$_tpl) {
			parent::__construct($_tpl, new ContentModel());
		}
		
		//执行
		public function _action() {
			$this->searchTitle();
			$this->searchKeyword();
			$this->searchTag();
		}
		
		
		//按照标题搜索
		private function searchTitle() {
			if ($_GET['type'] == 1) {
				if (empty($_GET['inputkeyword'])) Tool::alertBack('警告：搜索关键字不得为空！');
				$this->_model->inputkeyword = $_GET['inputkeyword'];				
				parent::page($this->_model->searchTitleContentTotal(),ARTICLE_SIZE);	
				$_object = $this->_model->searchTitleContent();
				Tool::subStr($_object,'info',120,'utf-8');
				Tool::subStr($_object,'title',35,'utf-8');
				if ($_object) {
					foreach ($_object as $_value) {
						if (empty($_value->thumbnail)) $_value->thumbnail = 'images/none.jpg';
						$_value->title = str_replace($this->_model->inputkeyword,'<span class="red">'.$this->_model->inputkeyword.'</span>',$_value->title);
					}
				}
				$this->_tpl->assign('SearchContent',$_object);
				$this->_tpl->assign('titlec',$this->_model->inputkeyword);
			}
		}
		
		//按照关键字搜索
		private function searchKeyword() {
			if ($_GET['type'] == 2) {
				if (empty($_GET['inputkeyword'])) Tool::alertBack('警告：搜索关键字不得为空！');
				$this->_model->inputkeyword = $_GET['inputkeyword'];	
				parent::page($this->_model->searchKeywordContentTotal(),ARTICLE_SIZE);	
				$_object = $this->_model->searchKeywordContent();
				Tool::subStr($_object,'info',120,'utf-8');
				Tool::subStr($_object,'title',35,'utf-8');
				if ($_object) {
					foreach ($_object as $_value) {
						if (empty($_value->thumbnail)) $_value->thumbnail = 'images/none.jpg';
						$_value->keyword = str_replace($this->_model->inputkeyword,'<span class="red">'.$this->_model->inputkeyword.'</span>',$_value->keyword);
					}
				}
				$this->_tpl->assign('SearchContent',$_object);
				$this->_tpl->assign('titlec',$this->_model->inputkeyword);
			}
		}
		
		//按照Tag标签搜索
		private function searchTag() {
			if ($_GET['type'] == 3) {
				$this->_model->inputkeyword = $_GET['inputkeyword'];	
				parent::page($this->_model->searchTagContentTotal(),ARTICLE_SIZE);	
				$_object = $this->_model->searchTagContent();
				Tool::subStr($_object,'info',120,'utf-8');
				Tool::subStr($_object,'title',35,'utf-8');
				if ($_object) {
					foreach ($_object as $_value) {
						if (empty($_value->thumbnail)) $_value->thumbnail = 'images/none.jpg';
					}
				}
				
				$_tag = new TagModel();
				$_tag->tagname = $this->_model->inputkeyword;
				$_tag->getOneTag() ? $_tag->addTagCount() : $_tag->addTag();

				
				
				$this->_tpl->assign('SearchContent',$_object);
				$this->_tpl->assign('titlec',$this->_model->inputkeyword);
			}
		}
		
	}
?>