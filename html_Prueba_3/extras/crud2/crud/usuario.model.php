<?php
class UsuarioModel
{
	private $pdo;

	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = new PDO('mysql:host=localhost;dbname=jupiter', 'root', '');
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

			$stm = $this->pdo->prepare("SELECT * FROM usuario");
			$stm->execute();

			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$vo = new Usuario();

				$vo->__SET('idusuario', $r->idusuario);
				$vo->__SET('login', $r->login);
				$vo->__SET('clave', $r->clave);
				$vo->__SET('estado', $r->estado);

				$result[] = $vo;
			}

			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM usuarios WHERE id = ?");
			          

			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$vo = new Usuario();

			$vo->__SET('id', $r->id);
			$vo->__SET('Login', $r->Login);
			$vo->__SET('Clave', $r->Clave);
			$vo->__SET('Estado', $r->Estado);
			

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
			          ->prepare("DELETE FROM usuarios WHERE id = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(Usuario $data)
	{
		try 
		{
			$sql = "UPDATE usuarios SET 
						Login          = ?, 
						Clave        = ?,
						Estado            = ? 
				    WHERE id = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('Login'), 
					$data->__GET('Clave'), 
					$data->__GET('Estado'),
					$data->__GET('id')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Registrar(Usuario $data)
	{
		try 
		{
		$sql = "INSERT INTO usuarios (Login,Clave,Estado) 
		        VALUES (?, ?, ?)";

		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('Login'), 
				$data->__GET('Clave'), 
				$data->__GET('Estado')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}

?>