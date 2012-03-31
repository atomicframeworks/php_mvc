<?php

class Router {
    // Controller Loader
    static public function route(&$url) {
	    global $routes;
	
		foreach ($routes as $pattern => $result) {
	        if (preg_match($pattern, $url)) {
	        	$url = preg_replace($pattern, $result, $url);
				return true;
			}		
		}
    }
}