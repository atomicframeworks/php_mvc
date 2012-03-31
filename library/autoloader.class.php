<?php

class Autoloader {
    // Controller Loader
    static public function controllerLoader($class) {
        $filename = strtolower($class) . '.class.php';
        $file = APP_ROOT . DS . 'controllers' . DS . $filename;
        if (!file_exists($file)){
            return false;
        }
        include $file;
    }
    // Model Loader
	static public function modelLoader($class) {
        $filename = strtolower($class) . '.class.php';
        $file = APP_ROOT . DS . 'models' . DS . $filename;
        if (!file_exists($file)){
            return false;
        }
        include $file;
    }
    // View Loader
	static public function viewLoader($class) {
        $filename = strtolower($class) . '.class.php';
        $file = APP_ROOT . DS . 'views' . DS . $filename;
        if (!file_exists($file)){
            return false;
        }
        include $file;
    }
    // Helper Loader
	static public function helperLoader($class) {
        $filename = strtolower($class) . '.class.php';
        $file = APP_ROOT . DS . 'helpers' . DS . $filename;
        if (!file_exists($file)){
            return false;
        }
        include $file;
    }
    // Register our loader functions
    static public function register() {
	    // Remove existing autoloads
	    spl_autoload_register(null, false);
	    // Specify valid extensions
	    spl_autoload_extensions('.php, .class.php');
	    // Register our loader functions
	    spl_autoload_register('Autoloader::controllerLoader');
	    spl_autoload_register('Autoloader::modelLoader');
	    spl_autoload_register('Autoloader::helperLoader');
	    spl_autoload_register('Autoloader::viewLoader');
    }
    // Register our loader functions
    static public function unregister() {	
	    // Unregister our loader functions
	    spl_autoload_unregister('Autoloader::controllerLoader');
	    spl_autoload_unregister('Autoloader::modelLoader');
	    spl_autoload_unregister('Autoloader::helperLoader');
	    spl_autoload_unregister('Autoloader::viewLoader');

    }
}