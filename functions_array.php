<?php
	function array_compare($arr1, $arr2){
		return knjarray::compare($arr1, $arr2);
	}
	
	function array_keydiffs($arr1, $arr2){
		return knjarray::keydiffs($arr1, $arr2);
	}
	
	/** Searches a string for an array of posibilities. */
	function array_stringsearch($string, $arr){
		return knjarray::stringsearch($string, $arr);
	}
	
	class knjarray{
		function compare($arr1, $arr2){
			foreach($arr1 AS $key => $value){
				if (!array_key_exists($key, $arr2)){
					return false;
				}
				
				if ($value != $arr2[$key]){
					return false;
				}
			}
			
			foreach($arr2 AS $key => $value){
				if (!array_key_exists($key, $arr1)){
					return false;
				}
				
				if ($value != $arr1[$key]){
					return false;
				}
			}
			
			return true;
		}
		
		function keydiffs($arr1, $arr2){
			$arr_res = array();
			foreach($arr2 AS $key => $value){
				if ($arr1[$key] != $value){
					$arr_res[$key] = array(
						"1" => $arr1[$key],
						"2" => $arr2[$key]
					);
				}
			}
			
			return $arr_res;
		}
		
		function stringsearch($string, $arr){
			foreach($arr AS $value){
				$pos = strpos($string, $value);
				if ($pos !== false){
					return array(
						"matched" => $value,
						"pos" => $pos
					);
				}
			}
			
			return false;
		}
		
		function implode_func($arr, $impl, $func, $func_para = null){
			$string = "";
			
			$first = true;
			foreach($arr AS $key => $value){
				if ($first){
					$first = false;
				}else{
					$string .= $impl;
				}
				
				$string .= call_user_func(array($value, $func), $func_para);
			}
			
			return $string;
		}
		
		function implode($paras){
			$string = "";
			
			$first = true;
			foreach($paras["array"] AS $key => $value){
				if ($first){
					$first = false;
				}else{
					$string .= $paras["impl"];
				}
				
				if ($paras["bykey"]){
					$val = $key;
				}else{
					$val = $value;
				}
				
				if ($paras["func_callback"]){
					$string .= call_user_func(array($val, $paras["func_callback"]), $paras["func_paras"]);
				}else{
					$string .= $val;
				}
			}
			
			return $string;
		}
	}
?>