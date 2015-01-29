<?php
	require_once ('usuarios/model.php');
	
	// Traer los datos de un usuario
	$usuario1 = new Usuario ();
	$usuario1->get ( 'user@email.com' );
	print $usuario1->nombre . ' ' . $usuario1->apellido . ' existe<br>';
	
	// Crear un nuevo usuario
	$new_user_data = array (
		'nombre' => 'Alberto',
		'apellido' => 'Jacinto',
		'email' => 'albert2000@mail.com',
		'clave' => 'jacaranda');
	$usuario2 = new Usuario ();
	$usuario2->set ( $new_user_data );
	$usuario2->get ( $new_user_data ['email'] );
	print $usuario2->nombre . ' ' . $usuario2->apellido . ' ha sido creado<br>';
	
	// Editar los datos de un usuario existente
	$edit_user_data = array (
		'nombre' => 'Aythami',
		'apellido' => 'Marica',
		'email' => 'albert2000@mail.com',
		'clave' => '69274' );
	$usuario3 = new Usuario ();
	$usuario3->edit ( $edit_user_data );
	$usuario3->get ( $edit_user_data ['email'] );
	print $usuario3->nombre . ' ' . $usuario3->apellido . ' ha sido editado<br>';
	
	//Editar un dato de un usuario
	/*$usuario5 = new Usuario();
	$usuario5->get('albert2000@mail.com');
	$edit_clave_user_data = array(
		'nombre' => $usuario5->nombre,
		'apellido' => $usuario5->apellido,
		'email' => $usuario5->email,
		'clave' => '123');
	$usuario5->edit($edit_clave_user_data);*/
	
	//Editar varios datos de un usuario
	$edit_user_datos = array (
		'clave' => '666',
		'email' => 'albert2000@mail.com',
		'nombre'=>'Alejandro'
		);
	$usuario6 = new Usuario();
	$usuario6->edit_1($edit_user_datos);
	
	// Eliminar un usuario
	$usuario4 = new Usuario ();
	$usuario4->get ( 'lei@mail.com' );
	$usuario4->delete ( 'lei@mail.com' );
	print $usuario4->nombre . ' ' . $usuario4->apellido . ' ha sido eliminado';
?>