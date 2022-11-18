<?php
class AlumnoModel
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

			$stm = $this->pdo->prepare("SELECT * FROM alumnos");
			$stm->execute(); // ejecuta la sentencia anterior y la guarda en $stm

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)// $r es el i en el for, esta linea busca desde el principio de la linea hasta el final
			{
				$vo = new Alumno();

				$vo->__SET('id', $r->id);
				$vo->__SET('Nombre', $r->Nombre);
				$vo->__SET('Apellido', $r->Apellido);
				$vo->__SET('Sexo', $r->Sexo);
				$vo->__SET('FechaNacimiento', $r->FechaNacimiento);

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
			$stm = $this->pdo
			          ->prepare("SELECT * FROM alumnos WHERE id = ?");
			          

			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$vo = new Alumno();

			$vo->__SET('id', $r->id);
			$vo->__SET('Nombre', $r->Nombre);
			$vo->__SET('Apellido', $r->Apellido);
			$vo->__SET('Sexo', $r->Sexo);
			$vo->__SET('FechaNacimiento', $r->FechaNacimiento);

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
			          ->prepare("DELETE FROM alumnos WHERE id = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(Alumno $data)
	{
		try 
		{
			$sql = "UPDATE alumnos SET 
						Nombre          = ?, 
						Apellido        = ?,
						Sexo            = ?, 
						FechaNacimiento = ?
				    WHERE id = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('Nombre'), 
					$data->__GET('Apellido'), 
					$data->__GET('Sexo'),
					$data->__GET('FechaNacimiento'),
					$data->__GET('id')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(Alumno $data)
	{
		try 
		{
		$sql = "INSERT INTO alumnos (Nombre,Apellido,Sexo,FechaNacimiento) 
		        VALUES (?, ?, ?, ?)";

		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('Nombre'), 
				$data->__GET('Apellido'), 
				$data->__GET('Sexo'),
				$data->__GET('FechaNacimiento')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}