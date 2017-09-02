<?php
namespace com\appstions\bidding\helper;

use com\appstions\bidding\dataAccess\UserDAO;
use com\appstions\bidding\entity\User;
use com\appstions\bidding\exceptions\DAOException;
use com\appstions\bidding\service\Rest;
use com\appstions\bidding\exceptions\ServiceException;
use com\appstions\bidding\helper\ExceptionHelper;

require_once 'dataAccess/UserDAO.php';
require_once 'exceptions/DAOException.php';
require_once 'entity/User.php';
require_once 'logger/LoggerService.php';

final class Helper{ 
	
	//Constante para almacenar la ruta en que se guardaran las imagenes de los equipos
	const IMAGE_STORAGE_PATH_EQUIPMENT = "../resources/images/team/";
	//Constante para almacenar la ruta en que se guardaran las imagenes de los jugadores 
	const IMAGE_STORAGE_PATH_PLAYER = "../resources/images/player/";
	//Otorga permisos de escritura para el proceso de almacenamiento de la imagen
	const WRITABLE_PERMISSION = "w";
	
	//Signo de punto 
	const POINT = ".";
	//Raiz para generar el nombre de la imagen del equipo 
	const TEAM_NAME_BASE = "IMGTEAM_";
	//Raiz para generar el nombre de la imagen del jugador
	const PLAYER_NAME_BASE = "IMGPLAYER_";
	//Tipo de imagen para equipos 
	const TEAM_TYPE = "T";
	//Cosntante para el valor mínimo 
	const MIN_VALUE = 1;
	//Constante para el valor máximo
	const MAX_VALUE = 9999999;
	
	const DATE_FORMAT = 'd.m.Y';
	const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';
	const INDEX_DAY = 0;
	const INDEX_MONTH = 1;
	const INDEX_YEAR = 2;
	
	/**
	 * Valida la existencia de un usuario preregistrado en la base de datos
	 * @param User $user
	 */
	public static function validateExistingUser(User $user){
		$userDAO = new UserDAO();
		//Determina si el usuario a insertar es valido o no
		$isValidUser = TRUE;
		try {
			//Se valida si el usuario existe realizando una busqueda por nombre
			$isValidUserByName = $userDAO->getUserByUserName($user->getUserName());
			//Se valida si el usuario existe realizando una busqueda por email
			$isValidUserByEmail = $userDAO->getUserByEmail($user->getEmail());
			//Validar que el usuario sea nulo
			if(!$isValidUserByName || !$isValidUserByEmail){
				$isValidUser = FALSE;
			}
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, self);
			ExceptionHelper::throwException($e, self);
		}
	
		return $isValidUser;
	}
	
	
	/**
	 * Valida la existencia de un usuario preregistrado en la base de datos
	 * @param User $user
	 */
	public static function isValidUserName(User $user){
		$userDAO = new UserDAO();
		try {
			//Se valida si el usuario existe realizando una busqueda por nombre
			$isValidUserByName = $userDAO->getUserByUserName($user->getName());
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, self);
			ExceptionHelper::throwException($e, self);
		}
	
		return $isValidUserByName;
	}
	
	/**
	 * Valida la existencia de un usuario preregistrado en la base de datos
	 * @param User $user
	 */
	public static function isValidUserEmail(User $user){
		$userDAO = new UserDAO();
		try {
			//Se valida si el usuario existe realizando una busqueda por email
			$isValidUserByEmail = $userDAO->getUserByEmail($user->getEmail());
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, self);
			ExceptionHelper::throwException($e, self);
		}
	
		return $isValidUserByEmail;
	}
	
	
	/**
	 * Valida la existencia de un usuario preregistrado en la base de datos
	 * @param User $user
	 */
	public static function isValidUserNameForUpdate(User $user){
		$userDAO = new UserDAO();
		$isValidUserByName = FALSE;
		$userBase = $userDAO->getUser($user->getIdUser());
		try {
			if($userBase != null){
				if($user->getUserName() != $userBase->getUserName()){
					//Se valida si el usuario existe realizando una busqueda por nombre
					$isValidUserByName = $userDAO->getUserByUserName($user->getUserName());
				}else{
					$isValidUserByName = TRUE;
				}
			}
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, self);
			ExceptionHelper::throwException($e, self);
		}
	
		return $isValidUserByName;
	}
	
	/**
	 * Valida la existencia de un usuario preregistrado en la base de datos
	 * @param User $user
	 */
	public static function isValidUserEmailForUpdate(User $user){
		$userDAO = new UserDAO();
		$isValidUserByEmail = FALSE;
		$userBase = $userDAO->getUser($user->getIdUser());
		try {
			if($userBase != null){
				if($user->getEmail() != $userBase->getEmail()){
					//Se valida si el usuario existe realizando una busqueda por email
					$isValidUserByEmail = $userDAO->getUserByEmail($user->getEmail());
				}else{
					$isValidUserByEmail = TRUE;
				}
			}
			
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, self);
			ExceptionHelper::throwException($e, self);
		}
	
		return $isValidUserByEmail;
	}

	/**
	 * Obtiene el valor de la propiedad
	 * @param unknown $configurationCode
	 * @return NULL|mixed
	 */
	public static function getConfigurationValue($configurationCode){
		try{
			$configurationDAO = new ConfigurationDAO();
			$value = $configurationDAO->getConfigurationValue($configurationCode);
			return $value;
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, self);
			ExceptionHelper::throwException($e, self);
		}
	
	}

	/**
	 * Genera un password aleatorio de 8 caracteres
	 * @param unknown $length
	 * @return string
	 */
	public static function rand_string($length = 8) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr ( str_shuffle ( $chars ), 0, $length );
	}
	
}
