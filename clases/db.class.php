<?php  
/* Clase encargada de gestionar las conexiones a la base de datos */
class Db
{
	private $servidor;
	private $usuario;
	private $password;
	private $base_datos;
	public $conn;
	private $consulta;
	private $array;
	 
	static $_instance;
 
	/*La función construct es privada para evitar que el objeto pueda ser instanciado*/
	private function __construct()
	{
		$this->setConexion();
		$this->conectar();
	}
	 
	/*Método para establecer los parámetros de la conexión*/
	private function setConexion()
	{
		$conf = Conf::getInstance();
		$this->servidor=$conf->getHostDB();
		$this->base_datos=$conf->getDB();
		$this->usuario=$conf->getUserDB();
		$this->password=$conf->getPassDB();
	}
	 
	/*Evitamos el clonaje del objeto. Patrón Singleton*/
	private function __clone(){ }
	 
	/*Función encargada de crear, si es necesario, el objeto. Esta es la función que debemos llamar desde fuera de la clase para instanciar el objeto, y así, poder utilizar sus métodos*/
	public static function getInstance()
	{
		if (!(self::$_instance instanceof self))
		{
			self::$_instance=new self();
		}
		return self::$_instance;
	}
	 
	/*Realiza la conexión a la base de datos.*/
	private function conectar()
	{
		$this->conn = mysqli_connect($this->servidor, $this->usuario, $this->password, $this->base_datos);
		//@mysqli_query("SET NAMES 'utf8'");
	}

	public function desconectar()
	{
		if(isset($this->conn))
		{
			mysqli_close($this->conn);
			unset($this->conn);
		}
	}
	 
	/*Método para ejecutar una sentencia sql*/
	public function query($consulta)
	{
		$this->consulta = mysqli_query($this->conn, $consulta);
		return $this->consulta;
	}
	 
	/*Método para obtener una fila de resultados de la sentencia sql*/
	public function obtener_fila($consulta)
	{
		$result = $this->query($consulta);
		$obj = mysqli_fetch_object($result);
		mysqli_free_result($result);
		return $obj;
	}
	 
	//Devuelve el último id del insert introducido
	public function UltimoID()
	{
		return mysqli_insert_id($this->conn);
	}
	 
	 
	public function obtener_valor($consulta)
	{
		$result = $this->query($consulta." LIMIT 1"); 
		$row = mysqli_fetch_row($result); 
		mysqli_free_result($result); 
		return $row[0]; 
	}

}
?>