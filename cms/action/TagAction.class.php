<?php
	class TagAction extends Action {
		
		//构造方法，初始化 
		public function __construct(&$_tpl) {
			parent::__construct($_tpl, new TagModel()); 
		}
		
		//action
		public function _action() {

		}
		
		
		//前台显示5条
		public function getFiveTag() {
			$this->_tpl->assign('FiveTag',$this->_model->getFiveTag());
		}
		
		
	}
?>