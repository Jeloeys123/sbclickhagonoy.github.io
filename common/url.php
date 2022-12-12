<?php
    $curr_path = trim($_SERVER["REQUEST_URI"]);
    $active_url =  explode('/', $curr_path);
    
    $url_size = sizeof($active_url) - 1;
    
    $active_path = "";
    $url_size = sizeof($url_size);
	if($url_size == 10) {
		$active_path = "../../../../../../../";
	}
	if($url_size == 9) {
		$active_path = "../../../../../../";
	}
	if($url_size == 8) {
		$active_path = "../../../../";
    }
    if($url_size == 7) {
		$active_path = "../../../";
	}
	if($url_size == 6) {
		$active_path = "../../";
	}
	if($url_size == 5) {
		$active_path = "../";
    }
    if($url_size == 4) {
		$active_path = "";
    }
?>