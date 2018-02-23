<?php
class MySQL {
    private $conexion;
    private $baseDatos;
    private $servidor = "localhost"; // servidor
    private $usuario = "root"; // usuario
    private $contrasena = "1qaz2015+"; // contraseña
    private $puerto = 3306;
    public $result;    
    
    function __construct($baseDatos = "mysqll") {//Nombre de tu base de datos
        $this->baseDatos = $baseDatos;
        try { 
            $this->conecta();
        }catch (Exception $exc) {
            echo $exc->getTraceAsString();
			exit();
        }
    }
    public function conecta(){
		$this->conexion = new mysqli($this->servidor,$this->usuario,$this->contrasena,"",$this->puerto);
		$this->conexion->query("use " . $this->baseDatos);      
    }

    public function solicitud($sql){
        $this->conecta();
		$this->result = $this->conexion->query($sql);
		$this->conexion->close();
		if($this->result)
            return true;
        else{
			$this->result = null;
			return false;
        }
    }
	public function getResultado(){
		return $this->result;
	}
}