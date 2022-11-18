<?php
class curso
{
	private $codigo;
	private $nombre;
	private $creditos;

	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}