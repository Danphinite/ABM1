<?php
// Importar modelo de abstracción de base de datos
require_once ('../core/db_abstract_model.php');
class Usuario extends DBAbstractModel {
	// ############################## PROPIEDADES ################################
	public $nombre;
	public $apellido;
	public $email;
	private $clave;
	protected $id;
	
	// Método constructor
	function __construct(){
		$this->db_name = 'ejemplo_php';
	}
	
	// ################################ MÉTODOS ##################################
	// Traer datos de un usuario
	public function get($user_email = '') {
		if ($user_email != '') {
			$this->query = "SELECT id, nombre, apellido, email, clave
							FROM usuarios WHERE email = '$user_email'";
			$this->get_results_from_query ();
		}
		if (count ( $this->rows ) == 1) {
			foreach ( $this->rows [0] as $propiedad => $valor ) {
				$this->$propiedad = $valor;
			}
			$this->mensaje = 'Usuario encontrado';
		} else {
			$this->mensaje = 'Usuario no encontrado';
		}
	}
	
	// Crear un nuevo usuario
	public function set($user_data = array()) {
		if (array_key_exists ( 'email', $user_data )) {
			$this->get ( $user_data ['email'] );
			if ($user_data ['email'] != $this->email) {
				foreach ( $user_data as $campo => $valor ) {
					$$campo = $valor;
				}
				$this->query = "INSERT INTO usuarios (nombre, apellido, email, clave)
								VALUES ('$nombre', '$apellido', '$email', '$clave')";
				$this->execute_single_query ();
				$this->mensaje = 'Usuario agregado exitosamente';
			} else {
				$this->mensaje = 'El usuario ya existe';
			}
		} else {
			$this->mensaje = 'No se ha agregado al usuario';
		}
	}
	
	// Modificar un usuario
	public function edit($user_data = array()) {
		foreach ( $user_data as $campo => $valor ) {
			$$campo = $valor;
		}
		$this->query = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido'
						WHERE email = '$email'";
		$this->execute_single_query ();
		$this->mensaje = 'Usuario modificado';
	}
	
	// Modificar un dato de un usuario
	public function edit_1($user_data = array()) {
		$email = $user_data ['email'];
		$this->query = "UPDATE usuarios SET ";
		$contador = 1;
		foreach ( $user_data as $campo => $valor ) :
			if ($campo != 'email') :
				$this->query .= $campo . "='$valor'";
				if ($contador < count ( $user_data ) - 1) :
					$this->query .= ",";
					$contador ++;
				endif;
			endif;
		endforeach;
		$this->query .= " WHERE email = '$email'";
		// echo $this->query;
		$this->execute_single_query ();
		$this->mensaje = 'Usuario modificado';
	}
	
	// Eliminar un usuario
	public function delete($user_email = '') {
		$this->query = "DELETE FROM usuarios WHERE email = '$user_email'";
		$this->execute_single_query ();
		$this->mensaje = 'Usuario eliminado';
	}
	
	public function login($user_email = '', $user_clave = ''){
		if ($user_email != '' && $user_clave != '') {
				$this->query = "SELECT email, clave
								FROM usuarios WHERE email = '$user_email' AND clave = '$user_clave'";
				$this->get_results_from_query ();
			}
			if (count ( $this->rows ) == 1) {
				/* Hace el login */
				
				$this->mensaje = 'Usuario logueado';
				return true;
			} else {
				$this->mensaje = 'Error de acceso';
				return false;
			}
	}
	
	// Método destructor del objeto
	function __destruct() {
		unset ( $this );
	}
}
?>