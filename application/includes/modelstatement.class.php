<?php
	class ModelStatement {
		public $statement_str;	
		public $select_str;
		public $as_str;
		public $from_str;
		public $where_str;
		public $group_str;
		public $having_str;
		public $order_str;
		
		public function __construct($args = array ()){
			
			if(is_array($args)){
				foreach ($args as $key=>$item){
					$this->$key = $item;
				}
			}
			elseif(is_string($args)){
				$this->statement_str = $args;
			}
			
			// AS		
			if(!empty($this->as_str)){
				$asArray = explode(' , ',$this->as_str);
				
			}
			
			//// SELECT	
			
			
			if (!empty($this->select_str)){
				// Explode multiple select fields and stagger with as fields 
				$this->select_str = 'SELECT '.$this->select_str;
				$this->select_str = explode(' , ',$this->select_str);
				foreach ($this->select_str as $index=>$select_str){
					$as = $asArray[$index];
					//// Form statement "select $item as $itemName , $itemTwo as $itemNameTwo"
					if ($as){
						$this->select_str[$index] .= ' as '.$as;
					}
				}
				//// Implode with comma separator
				$this->select_str = implode(' , ', $this->select_str);
			}
			else {
			//// Default select all
				$this->select_str = 'SELECT *';
			}
						
			if(!empty($this->from_str)){
				$this->from_str = 'FROM '.$this->from_str;
			}
			
			if(!empty($this->where_str)){
				$this->where_str = 'WHERE '.$this->where_str;
			}
			
			if(!empty($this->group_str)){
				$this->group_str = 'GROUP BY '.$this->group_str;
			}
			
			if(!empty($this->having_str)){
				$this->having_str = 'HAVING '.$this->having_str;
			}
			
			if(!empty($this->order_str)){
				$this->order_str = 'ORDER BY '.$this->order_str;
			}
			
			//// If specified keep otherwise construct
			if (empty($this->statement_str)){
				$this->statement_str = "{$this->select_str} {$this->from_str} {$this->where_str} {$this->group_str} {$this->having_str} {$this->order_str} ";
			}
			else{
			}
			
			//echo "Statement: ".$this->statement_str;
			//echo '<br/>';		
		}
		
		public function __toString(){
			return (string) $this->statement_str;
		}

	
	}

?>