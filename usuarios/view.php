<?php
$diccionario = array (
		'subtitle' => array (
				VIEW_LOGIN_USER => 'Login de usuario',
				VIEW_SET_USER => 'Crear un nuevo usuario',
				VIEW_GET_USER => 'Buscar usuario',
				VIEW_DELETE_USER => 'Eliminar un usuario',
				VIEW_EDIT_USER => 'Modificar usuario'
		),
		'links_menu' => array (
				'VIEW_LOGIN_USER' => MODULO . VIEW_LOGIN_USER . '/',
				'VIEW_SET_USER' => MODULO . VIEW_SET_USER . '/',
				'VIEW_GET_USER' => MODULO . VIEW_GET_USER . '/',
				'VIEW_EDIT_USER' => MODULO . VIEW_EDIT_USER . '/',
				'VIEW_DELETE_USER' => MODULO . VIEW_DELETE_USER . '/'				
		),
		'form_actions' => array (
				'LOGIN' => '/workspace/ABM1/' . MODULO . LOGIN_USER . '/',
				'SET' => '/workspace/ABM1/' . MODULO . SET_USER . '/',
				'GET' => '/workspace/ABM1/' . MODULO . GET_USER . '/',
				'DELETE' => '/workspace/ABM1/' . MODULO . DELETE_USER . '/',
				'EDIT' => '/workspace/ABM1/' . MODULO . EDIT_USER . '/',
				'LOGOUT' => '/workspace/ABM1/' . MODULO . LOGOUT_USER . '/'
		) 
);
function get_template($form = 'get') {
	$file = '../site_media/html/usuario_' . $form . '.html';
	$template = file_get_contents ( $file );
	return $template;
}
function render_dinamic_data($html, $data) {
	foreach ( $data as $clave => $valor ) {
		$html = str_replace ( '{' . $clave . '}', $valor, $html );
	}
	return $html;
}
function retornar_vista($vista, $data = array()) {
	global $diccionario;
	$html = get_template ( 'template' );
	$html = str_replace ( '{subtitulo}', $diccionario ['subtitle'] [$vista], $html );
	session_start();
	if (isset($_SESSION['email'])) {
		$html = str_replace ( '{formulario}', get_template ( $vista ), $html );
		$html = str_replace ( '{logout}', get_template ( 'logout' ), $html );
		$html = str_replace('{menu}', get_template ( 'menu' ), $html);
	} else {
		$html = str_replace ( '{formulario}', get_template ( 'registro' ), $html );
		$html = str_replace ( '{logout}', '', $html );
		$html = str_replace('{menu}', '', $html);
	}
	$html = render_dinamic_data ( $html, $diccionario ['form_actions'] );
	$html = render_dinamic_data ( $html, $diccionario ['links_menu'] );
	$html = render_dinamic_data ( $html, $data );
	// render {mensaje}
	if (array_key_exists ( 'nombre', $data ) && array_key_exists ( 'apellido', $data ) && $vista == VIEW_EDIT_USER) {
		$mensaje = 'Editar usuario ' . $data ['nombre'] . ' ' . $data ['apellido'];
	} else {
		if (array_key_exists ( 'mensaje', $data )) {
			$mensaje = $data ['mensaje'];
		} else {
			$mensaje = 'Datos del usuario:';
		}
	}
	$html = str_replace ( '{mensaje}', $mensaje, $html );
	print $html;
}
?>