<?php
	
	require 'conexion.php';
	
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$pais = $_POST['pais'];
	$ciudad = $_POST['ciudad'];
	$Fnacimiento = $_POST['Fnacimiento'];
	$Fdeceso = $_POST['Fdeceso'];
	$hijos = isset($_POST['hijos']) ? $_POST['hijos'] : 0;
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
	
	$sql = "UPDATE pintores SET nombre='$nombre', pais='$pais', ciudad='$ciudad', Fnacimiento='$Fnacimiento', Fdeceso='$Fdeceso' WHERE id = '$id'"; //, hijos='$hijos', inte<reses='$arrayIntereses'
	
	$resultado = $mysqli->query($sql);
	$id_insert = $id;
	
	if($_FILES["archivo"]["error"]>0){
		echo "Error al cargar archivo";	
		} else {
		
		$permitidos = array("image/gif","image/png","image/jpg","image/jpeg");
		$limite_kb = 200;
		
		if(in_array($_FILES["archivo"]["type"], $permitidos) && $_FILES["archivo"]["size"] <= $limite_kb * 1024){
			
			$ruta = 'files/'.$id_insert.'/';
			$archivo = $ruta.$_FILES["archivo"]["name"];
			
			if(!file_exists($ruta)){
				mkdir($ruta);
			}
			
			if(!file_exists($archivo)){
				
				$resultado = @move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo);
				
				if($resultado){
					echo "Imagen Guardada";
					} else {
					echo "Error al guardar imagen";
				}
				
				} else {
				echo "La imagen ya existe";
			}
			
			} else {
			echo "La imagen no es permitida o excede el tamaño";
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
						<h3>REGISTRO MODIFICADO</h3>
						<?php } else { ?>
						<h3>ERROR AL MODIFICAR</h3>
					<?php } ?>
					
					<a href="check-login.php" class="btn btn-primary">Regresar</a>
					
				</div>
			</div>
		</div>
	</body>
</html>
