<?php
	
	$mysqli = new mysqli('localhost', 'DEMO', 'password', 'personal');
	
	if($mysqli->connect_error){
		
		die('Error en la conexion' . $mysqli->connect_error);
		
	}
?>