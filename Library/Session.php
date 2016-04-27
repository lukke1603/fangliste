<?php


namespace MVC\Library;

class Session{
	
	public static function &get($path){
		$keys = array_filter(explode(DIRECTORY_SEPARATOR, $path));	
		
		$session = &$_SESSION;
		foreach($keys as $index => $key){
			if(!array_key_exists($key, $session)){
				return null;
			}
			
			$session = $session[$key];
		}
		
		return $session;
	}
	
	
//	public static function &set($path, $val){
//		$keys = array_filter(explode(DIRECTORY_SEPARATOR, $path));	
//		
//		$session = $_SESSION;
//		for($i = count($keys)-1 ; $i>=0 ; $i--){
//			$key =
//			
//			if($i === 0){
//				$session[$key] = $val;
//			}else{
//				if(!array_key_exists($key, $session)){
//					$session[$key] = array();
//				}
//			}
//			
//		}
//	}
	
}
