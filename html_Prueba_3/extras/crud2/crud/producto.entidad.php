<?php
class Producto
{
	private $id;
	private $description;
	private $precio;
	private $stock;
	private $imagen;

	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}