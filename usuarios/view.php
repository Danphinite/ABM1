<?php
$diccionario = array (
		'subtitle' => array (
				VIEW_SET_USER => 'Crear un nuevo usuario',
				VIEW_GET_USER => 'Editar usuario',
				VIEW_DELETE_USER => 'Eliminar un usuario',
				VIEW_EDIT_USER => 'Modificar usuario',
				VIEW_SEARCH_USER => 'Listar usuarios' 
		),
		'links_menu' => array (
				'VIEW_SET_USER' => MODULO . VIEW_SET_USER . '/',
				'VIEW_GET_USER' => MODULO . VIEW_GET_USER . '/',
				'VIEW_EDIT_USER' => MODULO . VIEW_EDIT_USER . '/',
				'VIEW_DELETE_USER' => MODULO . VIEW_DELETE_USER . '/',
				'VIEW_SEARCH_USER' => MODULO . VIEW_SEARCH_USER . '/' 
		),
		'form_actions' => array (
				'SET' => '/ABM1/' . MODULO . SET_USER . '/',
				'GET' => '/ABM1/' . MODULO . GET_USER . '/',
				'DELETE' => '/ABM1/' . MODULO . DELETE_USER . '/',
				'EDIT' => '/ABM1/' . MODULO . EDIT_USER . '/',
				'SEARCH' => '/ABM1/' . MODULO . SEARCH_USER . '/' 
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
function creaTabla($data) {
	$tabla = "<table border='2'><tr>";
	foreach ( $data [0] as $titulo => $v )
		$tabla .= "<th>" . $titulo . "</th>";
	$tabla .= "</tr>";
	foreach ( $data as $k => $fila ) {
			$tabla .= "<tr>";
			foreach ( $fila as $k2 => $celda )
				$tabla .= "<td>" . $celda . "</td>";
			$tabla .= "</tr>";
	}
	$tabla .= "</table>";
	return $tabla;
}

function retornar_vista($vista, $data = array()) {
	global $diccionario;
	$html = get_template ( 'template' );
	$html = str_replace ( '{subtitulo}', $diccionario ['subtitle'] [$vista], $html );
	$html = str_replace ( '{formulario}', get_template ( $vista ), $html );
	$html = render_dinamic_data ( $html, $diccionario ['form_actions'] );
	$html = render_dinamic_data ( $html, $diccionario ['links_menu'] );
	if ($vista == VIEW_SEARCH_USER && array_key_exists ( 0, $data )) 
			$html = str_replace ( '{table}', creaTabla ( $data ), $html );
	else {
		$html = str_replace ( '{table}', '', $html );
		$html = render_dinamic_data ( $html, $data );
	}
	
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