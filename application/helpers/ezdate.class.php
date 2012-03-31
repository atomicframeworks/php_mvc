<?php

	class EZDate extends DateTime {
		// MySQL DATETIME friendly format
	    public static $format = 'Y-m-d H:i:s';
	 
	    public function __construct($time = null, DateTimeZone $timeZone = null)
	    {
	    	// Ensure we have timestamp and not string
	    	if(isTimestamp($time)){
				$time = date(self::$format,$time);
			}
			// If no timezone set to default
	        if($timeZone === null)
	        {
	            $timeZone = new DateTimeZone(date_default_timezone_get());
	        }
	        // construct DateTime with current props
	        parent::__construct($time, $timeZone);
	    }
	 	
	    public function __toString()
	    {
	    	// Return the DateTime formatted by our format prop and cast as string
	        return (string)parent::format(self::$format);
	    }
	}
	
	// Return true if $timestamp is an int && 10 characters long && a valid php int
	function isTimestamp($timestamp) {
	    return ((int) $timestamp === $timestamp) 
	        && ($timestamp <= PHP_INT_MAX)
	        && ($timestamp >= ~PHP_INT_MAX)
	        && (strlen($timestamp) === 10);
	}
	
?>