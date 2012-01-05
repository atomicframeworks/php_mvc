<?php

	class proxy {
	
		public $id;
		public $ip;
		public $port;
		public $country;


		public function __construct($args = array()){
			foreach ($args as $key=>$item){
				$this->$key = $item;
			}
		}
		
	}

?>