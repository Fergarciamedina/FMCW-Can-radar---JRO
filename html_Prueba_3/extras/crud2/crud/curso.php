<?php
require_once 'curso.entidad.php';
require_once 'curso.model.php';

// Logica
$alm = new curso();
$model = new cursoModel();

if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('codigo',          $_REQUEST['codigo']);
			$alm->__SET('nombre',          $_REQUEST['nombre']);
			$alm->__SET('creditos',        $_REQUEST['creditos']);
			//$alm->__SET('Sexo',            $_REQUEST['Sexo']);
			//$alm->__SET('FechaNacimiento', $_REQUEST['FechaNacimiento']);

			$model->Actualizar($alm);
			header('Location: curso.php');
			break;

		case 'registrar':
			$alm->__SET('nombre',          $_REQUEST['nombre']);
			$alm->__SET('creditos',        $_REQUEST['creditos']);
			//$alm->__SET('Sexo',            $_REQUEST['Sexo']);
			//$alm->__SET('FechaNacimiento', $_REQUEST['FechaNacimiento']);

			$model->Registrar($alm);
			header('Location: curso.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['codigo']);
			header('Location: curso.php');
			break;

		case 'editar':
			$alm = $model->Obtener($_REQUEST['codigo']);
			break;
	}
}

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Mantenimiento</title>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	</head>
    <body style="padding:15px;">

        <div class="pure-g">
            <div class="pure-u-1-12">
                
                <form action="?action=<?php echo $alm->codigo > 0 ? 'actualizar' : 'registrar'; ?>" method="post" class="pure-form pure-form-stacked" style="margin-bottom:30px;">
                    <input type="hidden" name="codigo" value="<?php echo $alm->__GET('codigo'); ?>" />
                    
                    <table style="width:500px;">
                        <tr>
                            <th style="text-align:left;">nombre</th>
                            <td><input type="text" name="nombre" value="<?php echo $alm->__GET('nombre'); ?>" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">creditos</th>
                            <td><input type="text" name="creditos" value="<?php echo $alm->__GET('creditos'); ?>" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                            </td>
                        </tr>
                    </table>
                </form>

                <table class="pure-table pure-table-horizontal">
                    <thead>
                        <tr>
                            <th style="text-align:left;">nombre</th>
                            <th style="text-align:left;">creditos</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('nombre'); ?></td>
                            <td><?php echo $r->__GET('creditos'); ?></td>
                            <td>
                                <a href="?action=editar&codigo=<?php echo $r->codigo; ?>">Editar</a>
                            </td>
                            <td>
                                <a href="?action=eliminar&codigo=<?php echo $r->codigo; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>     
              
            </div>
        </div>

    </body>
</html>