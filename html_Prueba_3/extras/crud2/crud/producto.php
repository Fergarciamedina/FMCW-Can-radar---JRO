<?php
require_once 'producto.entidad.php';
require_once 'producto.model.php';


// Logica
$alm = new Producto();
$model = new ProductoModel();

if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('id',            $_REQUEST['id']);
			$alm->__SET('description',   $_REQUEST['description']);
			$alm->__SET('precio',        $_REQUEST['precio']);
			$alm->__SET('stock',         $_REQUEST['stock']);
			$alm->__SET('imagen',        $_REQUEST['imagen']);

			$model->Actualizar($alm);
			header('Location: producto.php');
			break;

		case 'registrar':
			$alm->__SET('description',   $_REQUEST['description']);
			$alm->__SET('precio',        $_REQUEST['precio']);
			$alm->__SET('stock',         $_REQUEST['stock']);
			$alm->__SET('imagen',        $_REQUEST['imagen']);

			$model->Registrar($alm);
			header('Location: producto.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['id']);
			header('Location: producto.php');
			break;

		case 'editar':
			$alm = $model->Obtener($_REQUEST['id']);
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
                
                <form action="?action=<?php echo $alm->id > 0 ? 'actualizar' : 'registrar'; ?>" method="post" class="pure-form pure-form-stacked" enctype="multipart/form-data" style="margin-bottom:30px;">
                    <input type="hidden" name="id" value="<?php echo $alm->__GET('id'); ?>" />
                    
                    <table style="width:500px;">
                        
                        <tr>
                            <th style="text-align:left;">description</th>
                            <td><input type="text" name="description" value="<?php echo $alm->__GET('description'); ?>" style="width:100%;" /></td>
                        </tr>
                        
                        <tr>
                            <th style="text-align:left;">precio</th>
                            <td><input type="text" name="precio" value="<?php echo $alm->__GET('precio'); ?>" style="width:100%;" /></td>
                        </tr>
                        
                        <tr>
                            <th style="text-align:left;">stock</th>
                            <td>
                                <select name="stock" style="width:100%;">
                                    <option value="1" <?php echo $alm->__GET('stock') == 1 ? 'selected' : ''; ?>>Masculino</option>
                                    <option value="2" <?php echo $alm->__GET('stock') == 2 ? 'selected' : ''; ?>>Femenino</option>
                                </select>
                            </td>
                        </tr> 
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                            </td>
                        </tr>
                    </table>
                </form>

                        <form enctype="multipart/form-data" action="uploader.php" method="POST">
                            <input name="uploadedfile" type="file" />
                            <input type="submit" value="Subir archivo" />
                        </form>  


                <table class="pure-table pure-table-horizontal">
                    <thead>
                        <tr>
                            <th style="text-align:left;">description</th>
                            <th style="text-align:left;">precio</th>
                            <th style="text-align:left;">stock</th>
                            <th style="text-align:left;">imagen</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    

                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('description'); ?></td>
                            <td><?php echo $r->__GET('precio'); ?></td>
                            <td><?php echo $r->__GET('stock') == 1 ? 'H' : 'F'; ?></td>
                            <td><?php echo $r->__GET('imagen'); ?></td>
                            <td>
                                <a href="?action=editar&id=<?php echo $r->id; ?>">Editar</a>
                            </td>
                            <td>
                                <a href="?action=eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>     
              
            </div>
        </div>

    </body>
</html>