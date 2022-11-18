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
				<h3 style="text-align:center">NUEVO REGISTRO</h3>
			</div>
			
			<form class="form-horizontal" method="POST" action="guardar.php" enctype="multipart/form-data" autocomplete="off">
				<div class="form-group">
					<label for="nombre" class="col-sm-2 control-label">Nombre del producto</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" >
					</div>
				</div>
				
				<div class="form-group">
					<label for="pais" class="col-sm-2 control-label">pais</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="pais" name="pais" placeholder="pais">
					</div>
				</div>
				
				<div class="form-group">
					<label for="ciudad" class="col-sm-2 control-label">ciudad</label>
					<div class="col-sm-10">
						<input type="tel" class="form-control" id="ciudad" name="ciudad" placeholder="ciudad">
					</div>
				</div>
				
				<div class="form-group">
					<label for="Fnacimiento" class="col-sm-2 control-label">Fnacimiento</label>
					<div class="col-sm-10">
						<input type="tel" class="form-control" id="Fnacimiento" name="Fnacimiento" placeholder="Fnacimiento">
					</div>
				</div>
				
				<div class="form-group">
					<label for="Fdeceso" class="col-sm-2 control-label">Fdeceso</label>
					<div class="col-sm-10">
						<input type="tel" class="form-control" id="Fdeceso" name="Fdeceso" placeholder="Fdeceso">
					</div>
				</div>

				<!-- Hijos
				<div class="form-group">
					<label for="hijos" class="col-sm-2 control-label">¿Tiene Hijos?</label>
					
					<div class="col-sm-10">
						<label class="radio-inline">
							<input type="radio" id="hijos" name="hijos" value="1" checked> SI
						</label>
						
						<label class="radio-inline">
							<input type="radio" id="hijos" name="hijos" value="0"> NO
						</label>
					</div>
				</div>
				-->

				<!-- Intereses
				<div class="form-group">
					<label for="intereses" class="col-sm-2 control-label">INTERESES</label>
					
					<div class="col-sm-10">
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Libros"> Libros
						</label>
						
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Musica"> Musica
						</label>
						
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Deportes"> Deportes
						</label>
						
						<label class="checkbox-inline">
							<input type="checkbox" id="intereses[]" name="intereses[]" value="Otros"> Otros
						</label>
					</div>
				</div>
				-->

				<!-- Imagen del producto-->
				<div class="form-group">
					<label for="archivo" class="col-sm-2 control-label">Pintura</label>
					<div class="col-sm-10">
						<input type="file" class="form-control" id="archivo" name="archivo" accept="image/*">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<a href="check-login.php" class="btn btn-default">Regresar</a>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>