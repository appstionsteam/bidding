<?php
namespace com\appstions\bidding\service;

use com\appstions\bidding\dataAccess\UserDAO;
use com\appstions\bidding\entity\User;
use com\appstions\bidding\helper\ExceptionHelper;
use com\appstions\bidding\exceptions\ServiceException;
use com\appstions\bidding\constant\Constant;
use com\appstions\bidding\helper\Helper;

require_once 'service/IUserService.php';
require_once 'entity/User.php';
require_once 'constant/Constant.php';
require_once 'dataAccess/UserDAO.php';	
require_once 'helper/DateHelper.php';

class UserService extends Rest implements IUserService {
	private $userDAO;
	public function __construct() {
		parent::__construct ();
		$this->userDAO = new UserDAO ();
	}
	
	/**
	 * Agrega un usuario al sistema (non-PHPdoc)
	 * 
	 * @see \com\appstions\nutrifun\service\IUserService::addUser()
	 */
	public function addUser() {
		try {
			$this->checkPostRequest ( Rest::DISABLE_AUTHENTICATION );
			
			$header = $this->getRequestBody ()[Rest::HEADER];
			$body = $this->getRequestBody ()[Rest::BODY];
			
			// $countryCode = $header[Rest::COUNTRY];
			
			$user = new User ();
			// Validar que el nombre de usuario y el email no se encunetren registrados en la base
			$this->unserializeBody ( $body, $user );
			$name=  html_entity_decode($user->getName(), ENT_QUOTES | ENT_HTML401, "UTF-8");
			$lastname =  html_entity_decode($user->getLastName(), ENT_QUOTES | ENT_HTML401, "UTF-8");
			$password =  html_entity_decode($user->getPassword(), ENT_QUOTES | ENT_HTML401, "UTF-8");
			//
			$user->setName($name);
			$user->setLastName($lastname);
			$user->setPassword($password);
			//
			if(Helper::isValidUserName($user)){
				//if(Helper::isValidUserEmail($user)){
					// El constructor del padre ya se encarga de setear los datos de entrada
					$idUser= $this->userDAO->addUser ( $user );
					
					if($idUser != NULL){
						// Registrar el correo del usuario 
						$inserted = $this->userDAO->addEmail($user->getEmails(), $idUser);
						// Registrar el la direcciòn del usuario
						$inserted =  $this->userDAO->addAddress($user->getAddresses(), $idUser);
					}else{
						throw new ServiceException(IUserService::USER_NOT_CREATED, Rest::CUSTOM_ERROR_CODE);
					}	
					/*$user->setStatus($inserted);
					// Se valida el proceso
					if ($inserted == TRUE) {
						/*Se le envia al usuario una notificacion de que ha sido registrado correctamente*/
						/*Helper::sendRegisterConfirmation($user);*/
						/*Se continua el proceso en la forma exitosa*/
						$this->processSuccessResponse ( $inserted );
					/*} else {
						throw new ServiceException ( IUserService::PLAYER_NOT_CREATED, Rest::CUSTOM_ERROR_CODE );
					}*/
					/*}else{throw new ServiceException(IUserService::EXISTING_USER_EMAIL, Rest::CUSTOM_ERROR_CODE);
					
				}*/
			}else{
				throw new ServiceException(IUserService::EXISTING_USER_NAME, Rest::CUSTOM_ERROR_CODE);
			}
			
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, $this);
			ExceptionHelper::throwException($e, $this);
		}
	}
	
	/* (non-PHPdoc)
	 * @see \Service\IPlayerService::login()
	*/
	public function login() {
	
		try {
			//Deshabilitar la autenticación
			$this->checkPostRequest(Rest::DISABLE_AUTHENTICATION);
				
			//$header = $this->getRequestBody()[Rest::HEADER];
			$body = $this->getRequestBody()[Rest::BODY];
				
			//$countryCode = $header[Rest::COUNTRY];
				
			$user = new User();
			$this->unserializeBody($body, $user);
				
			//Se obtiene la información del usuario
			$user = $this->userDAO->login($user);
			if($user){
				$this->processSuccessResponse($user);
			} else {
				throw new ServiceException(IUserService::NOT_AUTHENTICATED, Rest::CUSTOM_ERROR_CODE);
			}
	
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, $this);
			ExceptionHelper::throwException($e, $this);
		}
	
	}
	
	
	/* (non-PHPdoc)
	 * @see \Service\IPlayerService::login()
	 */
	public function getUserById() {
	
		try {
			//Deshabilitar la autenticación
			$this->checkPostRequest(Rest::DISABLE_AUTHENTICATION);
	
			$header = $this->getRequestBody()[Rest::HEADER];
			$body = $this->getRequestBody()[Rest::BODY];
	
			//$countryCode = $header[Rest::COUNTRY];
	
			$user = new User();
			$this->unserializeBody($body, $user);
	
			//Se obtiene la información del usuario
			$data = $this->userDAO->getUser($user->getIdUser());
	
			if($data != NULL){
				$this->processSuccessResponse($data);
			} else {
				throw new ServiceException(IUserService::NOT_AUTHENTICATED, Rest::CUSTOM_ERROR_CODE);
			}
	
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, $this);
			ExceptionHelper::throwException($e, $this);
		}
	}
	
	/* (non-PHPdoc)
	 * @see \Service\IPlayerService::login()
	 */
	public function updateUser() {
	
		try {
			//Deshabilitar la autenticación
			$this->checkPostRequest(Rest::DISABLE_AUTHENTICATION);
	
			$header = $this->getRequestBody()[Rest::HEADER];
			$body = $this->getRequestBody()[Rest::BODY];
	
			//$countryCode = $header[Rest::COUNTRY];
	
			$user = new User();
			$this->unserializeBody($body, $user);
		
			// Validar que el nombre de usuario y el email no se encunetren registrados en la base
			$this->unserializeBody ( $body, $user );
			$userName =  html_entity_decode($user->getUserName(), ENT_QUOTES | ENT_HTML401, "UTF-8");
			$name=  html_entity_decode($user->getName(), ENT_QUOTES | ENT_HTML401, "UTF-8");
			$lastname =  html_entity_decode($user->getLastName(), ENT_QUOTES | ENT_HTML401, "UTF-8");
			$email =  html_entity_decode($user->getEmail(), ENT_QUOTES | ENT_HTML401, "UTF-8");
			$password =  html_entity_decode($user->getPassword(), ENT_QUOTES | ENT_HTML401, "UTF-8");
			//
			$user->setUserName($userName);
			$user->setName($name);
			$user->setLastName($lastname);
			$user->setEmail($email);
			$user->setPassword($password);
			//
			if(Helper::isValidUserNameForUpdate($user)){
				if(Helper::isValidUserEmailForUpdate($user)){
					//Se obtiene la información del usuario
					$updated = $this->userDAO->updateUser($user);
					$user->setStatus($updated);
					//Validar actualización
					if($updated){
						$this->processSuccessResponse($user);
					} else {
						throw new ServiceException(IUserService::PLAYER_NOT_UPDATED, Rest::CUSTOM_ERROR_CODE);
					}
				}else{throw new ServiceException(IUserService::EXISTING_USER_EMAIL, Rest::CUSTOM_ERROR_CODE);
					
				}
			}else{
				throw new ServiceException(IUserService::EXISTING_USER_NAME, Rest::CUSTOM_ERROR_CODE);
			}
			
	
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, $this);
			ExceptionHelper::throwException($e, $this);
		}
	
	}
	
	/**
	 * Genera un password aleatorio
	 * @throws ServiceException
	 */
	public function regeneratePassword() {
		$updated = FALSE;
		try {
			//Deshabilitar la autenticación
			$this->checkPostRequest(Rest::DISABLE_AUTHENTICATION);
	
			$header = $this->getRequestBody()[Rest::HEADER];
			$body = $this->getRequestBody()[Rest::BODY];
	
			//$countryCode = $header[Rest::COUNTRY];
	
			$user = new User();
			$this->unserializeBody($body, $user);
			
			//Se genera el password de manera aleatoria
			$newPassword = Helper::rand_string();
			
			/** Obtiene el correo registrado del usuario y otros datos asociados*/
			$user =  $this->userDAO->getUserInformationByEmail($user->getEmail());
			
			//Si el correo es diferente de null
			if($user->getEmail()!= NULL){
				//Se agrega el nuevo password al usuario
				$user->setPassword($newPassword);
				
				//Se obtiene la información del usuario
				$updated= $this->userDAO->regeneratePassword($user);
				$user->setStatus($updated);
			}	
			if($updated){
				/*Se le envia al usuario una notificacion de que ha sido registrado correctamente*/
				Helper::sendRegeneratePasswordEmail($user);
				//Enviar correo de notificación 
				$this->processSuccessResponse($user);
			} else {
				throw new ServiceException(IUserService::NOT_AUTHENTICATED, Rest::CUSTOM_ERROR_CODE);
			}
	
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, $this);
			ExceptionHelper::throwException($e, $this);
		}
	
	}
	
	/* (non-PHPdoc)
	 * @see \Service\IPlayerService::login()
	 */
	public function updatePassword() {
	
		try {
			//Deshabilitar la autenticación
			$this->checkPostRequest(Rest::DISABLE_AUTHENTICATION);
	
			$header = $this->getRequestBody()[Rest::HEADER];
			$body = $this->getRequestBody()[Rest::BODY];
	
			//$countryCode = $header[Rest::COUNTRY];
	
			$user = new User();
			$this->unserializeBody($body, $user);
			
			// 
			$password =  html_entity_decode($user->getPassword(), ENT_QUOTES | ENT_HTML401, "UTF-8");
			$user->setPassword($password);
			//
			
			//Se obtiene la información del usuario
			$updated = $this->userDAO->updatePassword($user);
			$user->setStatus($updated);
				
			if($updated){
				$this->processSuccessResponse($user);
			} else {
				throw new ServiceException(IUserService::NOT_AUTHENTICATED, Rest::CUSTOM_ERROR_CODE);
			}
	
		} catch ( \Exception $e ) {
			ExceptionHelper::log($e, $this);
			ExceptionHelper::throwException($e, $this);
		}
	
	}

}