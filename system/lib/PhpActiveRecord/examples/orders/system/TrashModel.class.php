<?php

namespace System\Models;

use ActiveRecord;

class TrashModel extends ActiveRecord\Model{

 	/** @var array Methods */
    protected static $methods = [];
    

    /**
     * Prototype class
     *
     * @param string $name Prototype name
     * @param \Closure $closure Prototype
     */
    public static function extend_methods($methods){
    	foreach ($methods as $name => $closure){
    		if (!array_key_exists(__CLASS__, self::$methods)) {
	            self::$methods[__CLASS__] = [];
	        }
	        self::$methods[__CLASS__][$name] = $closure;
    	}
    }

   
	/**
     * Call method
     *
     * @param string $name Method name
     * @param array $arguments Method arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments = [])
    {
        if (array_key_exists(__CLASS__, self::$methods)) {
            $methods = self::$methods[__CLASS__];

            if (array_key_exists($name, $methods)) {
                $method = $methods[$name];

                if ($method instanceof \Closure) {
                    $method = $method->bindTo($this);
                }

                return call_user_func_array($method, $arguments);
            }
        }else{
			echo "PARETN";
			parent::__call($name, $arguments);
		}
    }

}


?>