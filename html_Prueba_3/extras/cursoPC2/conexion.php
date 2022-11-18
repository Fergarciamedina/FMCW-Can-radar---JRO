<?php
	
	$mysqli = new mysqli('localhost', 'DEMO', 'password', 'PC2');
	
	if($mysqli->connect_error){
		
		die('Error en la conexion' . $mysqli->connect_error);
		
	}
?>