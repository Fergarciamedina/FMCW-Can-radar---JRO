<?php
class Usuario
{
	private $idusuario;
	private $login;
	private $clave;
	private $estado;

	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}
?>