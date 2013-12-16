<?php
	//Tag实体类
	class TagModel extends Model {
		private $id;
		private $count;
		private $tagname;
		
		//拦截器(__set)
		private function __set($_key, $_value) {
			$this->$_key = Tool::mysqlString($_value);
		}
		
		//拦截器(__get)
		private function __get($_key) {
			return $this->$_key;
		}
		
		//获取前5条Tag数据
		public function getFiveTag() {
			$_sql = "SELECT 
											tagname,count 
								FROM 
											cms_tag 
						ORDER BY 
											count DESC 
								LIMIT 
											0,5";
			return parent::all($_sql);
		}
		
		
		//查找单一
		public function getOneTag() {
			$_sql = "SELECT 
											id 
								FROM 
											cms_tag 
							WHERE 
											tagname='$this->tagname'";
			return parent::one($_sql);
		}
		
		//累计
		public function addTagCount() {
			$_sql = "UPDATE 
											cms_tag 
								SET 
											count=count+1 
							WHERE 
											tagname='$this->tagname'";
			return parent::aud($_sql);
		}
		
		//新增
		public function addTag() {
			$_sql = "INSERT INTO 
												cms_tag (
																				tagname
																		) 
														VALUES (
																				'$this->tagname'
																		)";
			return parent::aud($_sql);
		}
		

		
	}
?>