<?php
session_start();
require 'conexion.php';

    $where = "";
  
  if(!empty($_POST))
  {
    $valor = $_POST['campo'];
    if(!empty($valor)){
      $where = "WHERE nombre LIKE '%$valor'";
    }
  }
  $sql = "SELECT * FROM pintores $where";
  $resultado = $mysqli->query($sql);

?>

<!doctype html>
<html lang="en">
	<head>
		<title>Pintores del Perú</title>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link href="css/bootstrap.min.css" rel="stylesheet">
	    <link href="css/bootstrap-theme.css" rel="stylesheet">
	    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
	    <script src="js/jquery-3.1.1.min.js"></script>
	    <script src="js/bootstrap.min.js"></script> 
	    <script src="js/jquery.dataTables.min.js"></script>

	    <script>
	      $(document).ready(function(){
	        $('#mitabla').DataTable({
	          "order": [[1, "asc"]],
	          "language":{
	          "lengthMenu": "Mostrar _MENU_ registros por pagina",
	          "info": "Mostrando pagina _PAGE_ de _PAGES_",
	            "infoEmpty": "No hay registros disponibles",
	            "infoFiltered": "(filtrada de _MAX_ registros)",
	            "loadingRecords": "Cargando...",
	            "processing":     "Procesando...",
	            "search": "Buscar:",
	            "zeroRecords":    "No se encontraron registros coincidentes",
	            "paginate": {
	              "next":       "Siguiente",
	              "previous":   "Anterior"
	            },          
	          },
	          "bProcessing": true,
	          "bServerSide": true,
	          "sAjaxSource": "server_process.php"
	        }); 
	      });
	    </script>
	</head>

	<body>
		<div class="container">
		
			<?php
			// Connection info. file
			include 'conn.php';	
			
			// Connection variables
			$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

			// Check connection
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			
			// data sent from form login.html 
			$email = $_POST['email']; 
			$password = $_POST['password'];
			
			// Query sent to database
			$result = mysqli_query($conn, "SELECT Email, Password, Name FROM users WHERE Email = '$email'");
			
			// Variable $row hold the result of the query
			$row = mysqli_fetch_assoc($result);
			
			// Variable $hash hold the password hash on database
			$hash = $row['Password'];
			
			/* 
			password_Verify() function verify if the password entered by the user
			match the password hash on the database. If everything is OK the session
			is created for one minute. Change 1 on $_SESSION[start] to 5 for a 5 minutes session.
			*/
			if (password_verify($_POST['password'], $hash)) {	
				
				$_SESSION['loggedin'] = true;
				$_SESSION['name'] = $row['Name'];
				$_SESSION['start'] = time();
				$_SESSION['expire'] = $_SESSION['start'] + (1 * 60) ;						
				
				echo "<div class='alert alert-success mt-4' role='alert'><strong>Bienvenido!</strong> $row[Name]			
				
				<p><a href='logout.php'>Logout</a></p></div>";	
			//<p><a href='edit-profile.php'>Edit Profile</a></p>
			} else {
				echo "<div class='alert alert-danger mt-4' role='alert'>Email or Password are incorrects!
				<p><a href='login.html'><strong>Please try again!</strong></a></p></div>";			
			}	
			?>
		</div>

		<div class="container">
		      <!--<div class="row">
		        <h2 style="text-align:center">Productos</h2>
		      </div> -->
		      
		      <div class="row">
		        <a href="nuevo.php" class="btn btn-primary">Nuevo Registro</a>
		        </a>
		        <br>
		        
		        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
		        	<br>
		          <b>Buscar por nombre </b><input type="text" id="campo" name="campo" />
		          <input type="submit" id="enviar" name="enviar" value="Buscar" class="btn btn-info" />
		        </form>

		      </div>
		      
		      <br>
		      
		      <div class="row table-responsive">
		        <table class="display" id="mitabla", width="100%">
		          <thead>
		            <tr>
		              <th>ID-Pintor</th>
		              <th>Nombre del pintor</th>
		              <th>País</th>
		              <th>Ciudad</th>
		              <th>Fecha de Nacimiento</th>
		              <th>Fecha de Deceso</th>
		              <th></th>
		              <th></th>
		            </tr>
		          </thead>
		          
		          <tbody>
		            <?php while($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>
		              <tr>
		                <td><?php echo $row['id']; ?></td>
		                <td><?php echo $row['nombre']; ?></td>
		                <td><?php echo $row['pais']; ?></td>
		                <td><?php echo $row['ciudad']; ?></td>
		                <td><?php echo $row['Fnacimiento']; ?></td>
		                <td><?php echo $row['Fdeceso']; ?></td>
		                <td><a href="modificar.php?id=<?php echo $row['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
		                <td><a href="#" data-href="eliminar.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete"><span class="glyphicon glyphicon-trash"></span></a></td>
		              </tr>
		            <?php } ?>
		          </tbody>
		        </table>
		      </div>
		    </div>
		    
		    <!-- Modal -->
		    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		      <div class="modal-dialog">
		        <div class="modal-content">
		          
		          <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		            <h4 class="modal-title" id="myModalLabel">Eliminar Registro</h4>
		          </div>
		          
		          <div class="modal-body">
		            ¿Desea eliminar este registro?
		          </div>
		          
		          <div class="modal-footer">
		            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		            <a class="btn btn-danger btn-ok">Delete</a>
		          </div>
		        </div>
		      </div>
		    </div>
		    
		    <script>
		      $('#confirm-delete').on('show.bs.modal', function(e) {
		        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		        
		        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
		      });
		    </script> 


		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

	</body>
</html>