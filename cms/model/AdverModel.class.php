<?php
	//广告实体类
	class AdverModel extends Model {
		private $id;
		private $type;
		private $link;
		private $title;
		private $state;
		private $thumbnail;
		private $info;
		private $kind;
		private $limit;
		
		//拦截器(__set)
		private function __set($_key, $_value) {
			$this->$_key = Tool::mysqlString($_value);
		}
		
		//拦截器(__get)
		private function __get($_key) {
			return $this->$_key;
		}
		
		//获取最新的N条文字广告
		public function getNewTextAdver() {
			$_sql = "SELECT 
											title,
											link 
								FROM 
											cms_adver 
							WHERE 
											state=1 
							AND
											type=1
						ORDER BY 
											date DESC 
								LIMIT 
											0,".ADVER_TEXT_NUM;
			return parent::all($_sql);
		}
		
		//获取N条头部图片广告
		public function getNewHeaderAdver() {
			$_sql = "SELECT 
											title,
											link,
											thumbnail 
								FROM 
											cms_adver 
							WHERE 
											state=1 
								AND
											type=2
						ORDER BY 
											date DESC 
								LIMIT 
											0,".ADVER_PIC_NUM;
			return parent::all($_sql);
		}
		
		//获取N条侧栏图片广告
		public function getNewSidebarAdver() {
			$_sql = "SELECT 
											title,
											link,
											thumbnail 
								FROM 
											cms_adver 
							WHERE 
											state=1 
								AND
											type=3
						ORDER BY 
											date DESC 
								LIMIT 
											0,".ADVER_PIC_NUM;
			return parent::all($_sql);
		}		
		
		//查找单一广告
		public function getOneAdver() {
			$_sql = "SELECT 
											id,
											title,
											info,
											link,
											type,
											thumbnail,
											state
								FROM 
											cms_adver
							WHERE 
											id='$this->id' 
								LIMIT 
											1";
			return parent::one($_sql);
		}
		
		//确定广告
		public function setStateOK() {
			$_sql = "UPDATE 
											cms_adver 
								SET 
											state=1 
							WHERE 
											id='$this->id' 
								LIMIT 
											1";
			return parent::aud($_sql);
		}
		
		//取消广告
		public function setStateCancel() {
			$_sql = "UPDATE 
											cms_adver 
								SET 
											state=0 
							WHERE 
											id='$this->id' 
								LIMIT 
											1";
			return parent::aud($_sql);
		}
		
		
		//获取广告总记录
		public function getAdverTotal() {
			$_sql = "SELECT 
											COUNT(*) 
								FROM 
											cms_adver
							WHERE
											type IN ($this->kind)";
			return parent::total($_sql);
		}
		
		//查询所有广告
		public function getAllAdver() {
			$_sql = "SELECT 
												id,
												title,
												link,
												type,
												state 
								FROM 
												cms_adver
							WHERE
												type IN ($this->kind)
							ORDER BY
												date DESC
								$this->limit";
			return parent::all($_sql);
		}
		
		//新增
		public function addAdver() {
			$_sql = "INSERT INTO 
												cms_adver (
																				title,
																				link,
																				thumbnail,
																				info,
																				type,
																				state,
																				date
																		) 
														VALUES (
																				'$this->title',
																				'$this->link',
																				'$this->thumbnail',
																				'$this->info',
																				'$this->type',
																				1,
																				NOW()
																		)";
			return parent::aud($_sql);
		}
		
		
		//修改	
		public function updateAdver() {
			$_sql = "UPDATE 
											cms_adver 
								  SET 
											title='$this->title',
											state='$this->state',
											link='$this->link',
											info='$this->info',
											thumbnail='$this->thumbnail',
											type='$this->type'	
							WHERE 
											id='$this->id' 
								 LIMIT 
											1";
			return parent::aud($_sql);
		}
		
		//删除
		public function deleteAdver() {
			$_sql ="DELETE FROM 
													cms_adver 
										WHERE 
													id='$this->id' 
										LIMIT 1";
			return parent::aud($_sql);
		}
	}
?>