<?php

class Registry {
	// Static singleton instance var
    private static $instance;
    // Registered objects
	private $objects = array();
	
	// Private construction must access through ::construct
    private function __construct(){}
	
	// Create singleton
    public static function construct()
    {
    	// Create new registry through self
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }


	public function __set($key, $value){
    	$this->objects[$key] = $value;
    	return self::$instance;
    }
	
	public function __get($key){
        return $this->objects[$key];
    }
    public function __clone(){
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup(){
        trigger_error('Unserializing is not allowed.', E_USER_ERROR);
    }
}