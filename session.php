<?php
	if(!isset($_SESSION['langue'])){
		$_SESSION['langue'] = $_ENV['langue'];
	}
?>