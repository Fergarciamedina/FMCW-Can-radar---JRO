<?php
class cursoModel
{
	private $pdo; //<--libreria que pertime hacer toda la conección hacia la vase de datos-->

	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = new PDO('mysql:host=localhost;dbname=acad', 'DEMO', 'password');//Esta linea conecta
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

			$stm = $this->pdo->prepare("SELECT * FROM curso");
			$stm->execute(); // ejecuta la sentencia anterior y la guarda en $stm

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)// $r es el i en el for, esta linea busca desde el principio de la linea hasta el final
			{
				$vo = new Curso();

				$vo->__SET('codigo', $r->codigo);
				$vo->__SET('nombre', $r->nombre);
				$vo->__SET('creditos', $r->creditos);
				//$vo->__SET('Sexo', $r->Sexo);
				//$vo->__SET('FechaNacimiento', $r->FechaNacimiento);

				$result[] = $vo;
			}

			return $result;
		}
		catch(Exception $e) //mostrar error
		{
			die($e->getMessage());
		}
	}

	public function Obtener($codigo)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM curso WHERE codigo = ?");
			          

			$stm->execute(array($codigo));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$vo = new Curso();

			$vo->__SET('codigo', $r->codigo);
			$vo->__SET('nombre', $r->nombre);
			$vo->__SET('creditos', $r->creditos);
			//$vo->__SET('Sexo', $r->Sexo);
			//$vo->__SET('FechaNacimiento', $r->FechaNacimiento);

			return $vo;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($codigo)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM curso WHERE codigo = ?");			          

			$stm->execute(array($codigo));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(Curso $data)
	{
		try 
		{
			$sql = "UPDATE curso SET 
						nombre          = ?, 
						creditos        = ?
						/*Sexo            = ?, 
						FechaNacimiento = ?*/
				    WHERE codigo = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('nombre'), 
					$data->__GET('creditos'), 
					//$data->__GET('Sexo'),
					//$data->__GET('FechaNacimiento'),
					$data->__GET('codigo')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(curso $data)
	{
		try 
		{
		$sql = "INSERT INTO curso (nombre) 
		        VALUES (?)";

		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('nombre'), 
				$data->__GET('creditos'), 
				//$data->__GET('Sexo'),
				//$data->__GET('FechaNacimiento')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}