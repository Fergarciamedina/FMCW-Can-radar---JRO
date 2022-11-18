<?php
class ProductoModel
{
	private $pdo; //<--libreria que pertime hacer toda la conección hacia la basename(path)ase de datos-->

	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = new PDO('mysql:host=localhost;dbname=inventario', 'DEMO', 'password');//Esta linea conecta
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		        
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Listar()
	{
		try
		{
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM producto");
			$stm->execute(); // ejecuta la sentencia anterior y la guarda en $stm

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)// $r es el i en el for, esta linea busca desde el principio de la linea hasta el final
			{
				$vo = new Producto();

				$vo->__SET('id', $r->id);
				$vo->__SET('description', $r->description);
				$vo->__SET('precio', $r->precio);
				$vo->__SET('stock', $r->stock);
				$vo->__SET('imagen', $r->imagen);

				$result[] = $vo;
			}

			return $result;
		}
		catch(Exception $e) //mostrar error
		{
			die($e->getMessage());
		}
	}

	public function Obtener($id)
	{
		try 
		{
			$stm = $this->pdo->prepare("SELECT * FROM producto WHERE id = ?");
			          

			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$vo = new Producto();

			$vo->__SET('id', $r->id);
			$vo->__SET('description', $r->description);
			$vo->__SET('precio', $r->precio);
			$vo->__SET('stock', $r->stock);
			$vo->__SET('imagen', $r->imagen);

			return $vo;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM producto WHERE id = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(Producto $data)
	{
		try 
		{
			$sql = "UPDATE producto SET 
						description          = ?, 
						precio        = ?,
						stock            = ?, 
						imagen = ?
				    WHERE id = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('description'), 
					$data->__GET('precio'), 
					$data->__GET('stock'),
					$data->__GET('imagen'),
					$data->__GET('id')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(Producto $data)
	{
		try 
		{
		$sql = "INSERT INTO producto (description,precio,stock,imagen) 
		        VALUES (?, ?, ?, ?)";

		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('description'), 
				$data->__GET('precio'), 
				$data->__GET('stock'),
				$data->__GET('imagen')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}