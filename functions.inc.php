<?php
function replace_space($str) {
	$str = str_replace("&nbsp;", "",$str);
	return $str;
}

function getTrainNumber($str) {
	$str = preg_replace("/\<a href\=\"javascript:getZugLauf\('[0-9]*'\)\">/", "", $str);
	$str = str_replace("</a>&nbsp;", "", $str);
	return $str;
}

function html_escape($str) {
	return htmlspecialchars(htmlentities($str));
}


function postToTwitter($user,$msg) {
	$username = 'sbb' . strtolower($user);
	$password = 'keller';

	$message = urlencode($msg);
	$url = 'http://twitter.com/statuses/update.xml';
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, "$url");
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_handle, CURLOPT_POST, 1);
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$message");
	curl_setopt($curl_handle, CURLOPT_USERPWD, "$username:$password");
	$buffer = curl_exec($curl_handle);
	curl_close($curl_handle);
	if (empty($buffer)) {
		return false;
	} else {
		return true;
	}

}

?>