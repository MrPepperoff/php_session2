<?php 

	function jsonConvertArray($data_json){
		$data = json_decode($data_json);
		return (array)$data;
	}

	function status_request($str_code){
		if($str_code == 501 || $str_code == 502){
			return "alert-danger";
		}
		
		if($str_code == 201){
			return "alert-success";
		}

		return '';
	}
?>