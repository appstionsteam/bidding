<?php

namespace com\appstions\bidding\dataAccess;

use com\appstions\bidding\entity\User;
use com\appstions\bidding\helper\Helper;
use com\appstions\bidding\helper\DateHelper;
use com\appstions\bidding\constant\Constant;
use com\appstions\bidding\helper\ExceptionHelper;
use com\appstions\bidding\helper\QueryHelper;

require_once 'dataAccess/DAO.php';
require_once 'helper/Helper.php';
require_once 'helper/DateHelper.php';
require_once 'constant/Constant.php';

class UserDAO extends DAO {
	
	private $dao;

	public function __construct() {
		parent::__construct ();
		$this->dao = new QueryHelper ( 'userQueries' );
	}
	
	/**
	 * Agrega un usuario nuevo al sistema
	 *
	 * @param User $user        	
	 */
	public function addUser(User $user) {
		$idRecipe = NULL;
		try {
			
			$sqlQuery = $this->dao->getQuery ( 'addUser' );
			
			$query = $this->getConnection ()->prepare ( $sqlQuery );
			
			$query->bindValue ( ":name", $user->getName () );
			// Llamada al método que encripta el password
			$query->bindValue ( ":lastname", $user->getLastName () );
			$query->bindValue ( ":password", $user->getPassword () );
			$query->bindValue ( ":registrationDate", DateHelper::toFormatDateSQL($user->getRegistrationDate()) );
			
			$query->execute ();
			
			// Obtiene el id de la receta recièn agregada
			$idRecipe = $this->getConnection ()->lastInsertId ();
			
			return $idRecipe;
			
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
	}
	
	/**
	 * Agrega un correo nuevo al sistema
	 *
	 * @param User $user
	 */
	public function addEmail($emails, $idUser) {
		try {
				
			$sqlQuery = $this->dao->getQuery ( 'addEmail' );
			
			$query = $this->getConnection ()->prepare ( $sqlQuery );
			
			foreach ( $emails as $e ) {
				
				$email = ( object ) $e;
					
				$query->bindValue ( ":idUser", $idUser );
				$query->bindValue ( ":status",  $email->{"state"} );
				$query->bindValue ( ":email",   $email->{"email"} );
				$query->bindValue ( ":mainEmail", $email->{"mainEmail"} );
				
				$query->execute ();
				
				//Obtiene el id de la receta recièn agregada
				$updatedRows = $query->rowCount ();
			}
				
			return $updatedRows;
				
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
	}
	
	/**
	 * Agrega una direccio nueva al sistema
	 *
	 * @param User $user
	 */
	public function addAddress($addresses, $idUser) {
		try {
	
			$sqlQuery = $this->dao->getQuery ( 'addAddress' );
				
			$query = $this->getConnection ()->prepare ( $sqlQuery );
				
			foreach ( $addresses as $e ) {
	
				$address = ( object ) $e;
					
				$query->bindValue ( ":idUser", $idUser );
				$query->bindValue ( ":status",  $address->{"state"});
				$query->bindValue ( ":description",   $address->{"description"});
				$query->bindValue ( ":country", $address->{"country"});
				$query->bindValue ( ":province", $address->{"province"});
				$query->bindValue ( ":city", $address->{"city"} );
	
				$query->execute ();
	
				//Obtiene el id de la receta recièn agregada
				$updatedRows = $query->rowCount ();
			}
	
			return $updatedRows;
	
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
	}
	
	
	/**
	 * Realiza el login de un usuario en la aplicación
	 *
	 * @param User $user        	
	 * @return NULL
	 */
	public function login(User $user) {
		$usuerToReturn = NULL;
		
		try {
		
			$sqlQuery = $this->dao->getQuery ( 'login' );
			
			$query = $this->getConnection ()->prepare ( $sqlQuery );
			
			$query->bindValue ( ":email", $user->getLoginEmail());
			$query->bindValue ( ":pwd", $user->getPassword () );
			$query->execute ();
			
			
			if ($fila = $query->fetch ( \PDO::FETCH_ASSOC )) {
				
				$usuerToReturn = new User ();
				
				$usuerToReturn->setIdUser ( $fila ['ID_USUARIO'] );
				$usuerToReturn->setIdType( $fila ['C_TIPO_IDENTIFICACION'] );
				$usuerToReturn->setIdNumber( $fila ['N_IDENTIFICAC'] );
				$usuerToReturn->setName ( $fila ['D_NOMBRE'] );
				$usuerToReturn->setLastName ( $fila ['D_APELLIDO'] );
				$usuerToReturn->setLoginEmail( $fila ['D_CORREO'] );
				$usuerToReturn->setPassword( $fila ['C_CLAVE'] );
				$usuerToReturn->setStatus( $fila ['C_ESTADO'] );
			}
			
			
			return $usuerToReturn;
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
	}
	

	
	/**
	 * Devuelve la información asociada a un usuario
	 *
	 * @param unknown $idUser        	
	 * @return User
	 */
	public function getUser($idUser) {
		$usuerToReturn = NULL;
		
		try {
			
			$sqlQuery = $this->dao->getQuery ( 'getUser' );
			
			$query = $this->getConnection ()->prepare ( $sqlQuery );
			
			$query->bindValue ( ":idUser", $idUser );
			$query->execute ();
			
			if ($fila = $query->fetch ( \PDO::FETCH_ASSOC )) {
				
				$usuerToReturn = new User ();
				
				$usuerToReturn->setIdUser ( $fila ['id_user'] );
				$usuerToReturn->setName ( $fila ['name'] );
				$usuerToReturn->setLastName ( $fila ['lastname'] );
				$usuerToReturn->setEmail ( $fila ['email'] );
				$usuerToReturn->setUserName ( $fila ['username'] );
			}
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
		
		return $usuerToReturn;
	}
	
	/**
	 * Devuelve la información asociada a un usuario
	 *
	 * @param unknown $idUser
	 * @return User
	 */
	public function getUserInfoByUserName($userName) {
		$usuerToReturn = NULL;
	
		try {
				
			$sqlQuery = $this->dao->getQuery ( 'getUserByUserName' );
				
			$query = $this->getConnection ()->prepare ( $sqlQuery );
				
			$query->bindValue ( ":username", $userName );
			$query->execute ();
				
			if ($fila = $query->fetch ( \PDO::FETCH_ASSOC )) {
	
				$usuerToReturn = new User ();
	
				$usuerToReturn->setIdUser ( $fila ['id_user'] );
				$usuerToReturn->setName ( $fila ['name'] );
				$usuerToReturn->setLastName ( $fila ['lastname'] );
				$usuerToReturn->setEmail ( $fila ['email'] );
				$usuerToReturn->setUserName ( $fila ['username'] );
			}
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
	
		return $usuerToReturn;
	}
	
	/**
	 * Obtiene los datos del usuario realizando la búsqueda por el nombre de usuario que se envía por parámetro
	 *
	 * @param int $userName        	
	 */
	public function getUserByUserName($userName) {
		$isValidUser = TRUE;
		
		try {
			
			$sqlQuery = $this->dao->getQuery ( 'getUserByUserName' );
			
			$query = $this->getConnection ()->prepare ( $sqlQuery );
			
			$query->bindValue ( ":name", $userName );
			$query->execute ();
			
			if ($query->rowCount () > 0) {
				$isValidUser = FALSE;
			}
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
		
		return $isValidUser;
	}
	
	/**
	 * Obtiene los datos del usuario realizando la búsqueda por un email que se envía por parámetro
	 *
	 * @param int $email        	
	 */
	public function getUserByEmail($email) {
		$isValidUser = TRUE;
		
		try {
			
			$sqlQuery = $this->dao->getQuery ( 'getUserByEmail' );
			
			$query = $this->getConnection ()->prepare ( $sqlQuery );
			
			$query->bindValue ( ":email", $email );
			$query->execute ();
			
			if ($query->rowCount () > 0) {
				$isValidUser = FALSE;
			}
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
		
		return $isValidUser;
	}
	
	/**
	 * Obtiene los datos del usuario realizando la búsqueda por un email que se envía por parámetro
	 *
	 * @param int $email
	 */
	public function regeneratePassword(User $user) {
		
		try {
			
			$sqlQuery = $this->dao->getQuery ( 'regeneratePassword' );
				
			$query = $this->getConnection ()->prepare ( $sqlQuery );
				
			$query->bindValue ( ":password", $user->getPassword());
			$query->bindValue ( ":email", $user->getEmail());
			
			$query->execute ();
				
			$updatedRows = $query->rowCount ();
				
			return ($updatedRows == 1);
			
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
	}
	
	
	/**
	 * Modifica los datos del usuario
	 * 
	 * @param Player $player        	
	 */
	public function updateUser(User $user) {
		try {
			
			$sqlQuery = $this->dao->getQuery ( 'updateUser' );
			
			$query = $this->getConnection ()->prepare ( $sqlQuery );
			
			$query->bindValue ( ":email", $user->getEmail () );
			$query->bindValue ( ":name", $user->getName () );
			$query->bindValue ( ":lastname", $user->getLastName () );
			$query->bindValue ( ":username", $user->getUserName () );
			$query->bindValue ( ":id_user", $user->getIdUser () );
			
			$query->execute ();
			
			$updatedRows = $query->rowCount ();
			
			return ($updatedRows == 1);
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
	}
	
	/**
	 * Obtiene los datos del usuario realizando la búsqueda por un email que se envía por parámetro
	 *
	 * @param int $email
	 */
	public function updatePassword(User $user) {
	
		try {
				
			$sqlQuery = $this->dao->getQuery ( 'updatePassword' );
	
			$query = $this->getConnection ()->prepare ( $sqlQuery );
	
			$query->bindValue ( ":password", $user->getPassword());
			$query->bindValue ( ":id_user", $user->getIdUser() );
				
			$query->execute ();
	
			$updatedRows = $query->rowCount ();
	
			return ($updatedRows == 1);
				
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
	}
	
	/**
	 * Devuelve la información asociada a un usuario
	 *
	 * @param unknown $idUser
	 * @return User
	 */
	public function getUserInformationByEmail($email) {
		$usuerToReturn = NULL;
	
		try {
	
			$sqlQuery = $this->dao->getQuery ( 'getUserByEmail' );
	
			$query = $this->getConnection ()->prepare ( $sqlQuery );
	
			$query->bindValue ( ":email", $email );
			$query->execute ();
	
			if ($fila = $query->fetch ( \PDO::FETCH_ASSOC )) {
	
				$usuerToReturn = new User ();
	
				$usuerToReturn->setIdUser ( $fila ['id_user'] );
				$usuerToReturn->setName ( $fila ['name'] );
				$usuerToReturn->setLastName ( $fila ['lastname'] );
				$usuerToReturn->setEmail ( $fila ['email'] );
				$usuerToReturn->setUserName ( $fila ['username'] );
			}
		} catch ( \Exception $e ) {
			ExceptionHelper::log ( $e, $this );
			ExceptionHelper::throwException ( $e, $this );
		}
	
		return $usuerToReturn;
	}
	
}