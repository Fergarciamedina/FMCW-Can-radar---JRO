<?php
	
	require 'conexion.php';
	
	//$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$pais = $_POST['pais'];
	$ciudad = $_POST['ciudad'];
	$Fnacimiento = $_POST['Fnacimiento'];
	$Fdeceso = $_POST['Fdeceso'];
	$hijos = isset($_POST['hijo']) ? $_POST['hijos'] : 0;
	$intereses = isset($_POST['intereses']) ? $_POST['intereses'] : null;
	
	$arrayIntereses = null;
	
	$num_array = count($intereses);
	$contador = 0;
	
	if($num_array>0){
		foreach ($intereses as $key => $value) {
			if ($contador != $num_array-1)
			$arrayIntereses .= $value.' ';
			else
			$arrayIntereses .= $value;
			$contador++;
		}
	}
	
	$sql = "INSERT INTO pintores (nombre, pais, ciudad, Fnacimiento, Fdeceso) VALUES ('$nombre', '$pais', '$ciudad', '$Fnacimiento', $Fdeceso)";//, '$hijos', '$arrayIntereses'

	$resultado = $mysqli->query($sql);
	$id_insert = $mysqli->insert_id;
	
	/*Lógica para guardar el archivo*/

	if($_FILES["archivo"]["error"]>0){
		echo "Error al cargar archivo";	
		} else {
		
		$permitidos = array("image/jpg","image/jpeg","image/png","application/pdf");
		$limite_kb = 1000;
		
		if(in_array($_FILES["archivo"]["type"], $permitidos) && $_FILES["archivo"]["size"] <= $limite_kb * 1024){
			
			$ruta ='files/'.$id_insert.'/';
			$archivo =  $ruta.$_FILES["archivo"]["name"];
			
			if(!file_exists($ruta)){
				mkdir($ruta);
			}
			
			if(!file_exists($archivo)){
				
			$resultado = @move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo);
				
				if($resultado){
					echo "Archivo Guardado";
					} else {
					echo "Error al guardar archivo";
				}
				
			} else {
				echo "Archivo ya existe";
			}
			
			} else {
			echo "Archivo no permitido o excede el tamaño";
		}
	}
?>

<html lang="es">
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>	
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<div class="row" style="text-align:center">
					<?php if($resultado) { ?>
						<h3>REGISTRO GUARDADO</h3>
						<?php } else { ?>
						<h3>ERROR AL GUARDAR</h3>
					<?php } ?>
					
					<a href="check-login.php" class="btn btn-primary">Regresar</a>
					
				</div>
			</div>
		</div>
	</body>
</html>
