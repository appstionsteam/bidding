<?php
namespace com\appstions\bidding\service;

interface IUserService {
	
	const METHOD_NOT_FOUND = "Peticion no encontrada";
	const NO_CONTENT = "Peticion sin contenido";
	const NOT_AUTHENTICATED = "Usuario o cntraseña incorrectos";
	const NOT_AUTHENTICATED_BY_EMAIL = "El correo ingresado no ha sido registrado en la aplicacion";
	const ERROR_WHILE_CREATE_NEW_PASSWORD = "Error mientras se llevaba a cabo el proceso";
	const REQUIRED = "Faltan datos";
	const PLAYER_NOT_UPDATED = "Hubo un error a la hora de actualizar los datos del usuario";
	const USER_NOT_CREATED = "Hubo un error a la hora de crear el usuario";
	const EXISTING_USER_NAME = "El nombre de usuario ingresado ya existe. Por favor seleccione otro.";
	const EXISTING_USER_EMAIL = "El correo ingresado ya existe. Por favor seleccione otro.";
	const PLAYER_NOT_DELETED = "Hubo un error a la hora de borrar el usuario";
	const PLAYER_EXIST = "EL usuario ya existe";
	const PLAYER_NOT_EXIST = "El jugador no existe";
	

	/**
	 * Agrega un usuario
	 */
	public function addUser();
	
	/**
	 * Realiza el proceso de login de un usuario en el sistema
	 */
	public function login();
	
	/**
	 * Obtiene información de un usuario
	 */
	public function getUserById();
	
	/**
	 * Actualiza la información del usuario
	 */
	public function updateUser();
	
	/**
	 * Actualiza la contraseña del usuario
	 */
	public function updatePassword();
	
	/**
	 * Genera un password temporal
	 */
	public function regeneratePassword();
}