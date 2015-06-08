<?php
/**
 * Class Model ErrorLog
 */
Class ErrorLog {
	/**
	 * @param $message
	 */
	public function error($message) {
		$pathInfo = "";
		if (isset($_SERVER['PATH_INFO'])) {
			$pathInfo = $_SERVER['PATH_INFO'];
		}
		$server = print_r($_SERVER, true);
		echo "
			<pre>
			Message: {$message}, <br>
			Path: {$pathInfo}, <br>
			Server: {$server}
		";
		die();
	}
}