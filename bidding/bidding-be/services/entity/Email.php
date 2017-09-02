<?php
namespace com\appstions\bidding\entity;


require_once 'entity/JsonUnserializable.php';

/**
 * Clase que contiene la definicíón de los correos electrónicos
 * @author Appstions
 *
 */
class Email implements \JsonSerializable, JsonUnserializable {
	
	private $idUser;
	private $idEmail;
	private $email;	
	private $state;
	private $mainEmail;
		
	public function __construct(){		
	}
	
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}
	public function getState() {
		return $this->state;
	}
	public function setState($state) {
		$this->state = $state;
		return $this;
	}
	public function getIdUser() {
		return $this->idUser;
	}
	public function setIdUser($idUser) {
		$this->idUser = $idUser;
		return $this;
	}
	public function getIdEmail() {
		return $this->idEmail;
	}
	public function setIdEmail($idEmail) {
		$this->idEmail = $idEmail;
		return $this;
	}
	public function getMainEmail() {
		return $this->mainEmail;
	}
	public function setMainEmail($mainEmail) {
		$this->mainEmail = $mainEmail;
		return $this;
	}


	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see JsonSerializable::jsonSerialize()
	 */
	public function jsonSerialize() {
		$json = [];
		$vars = get_class_vars(get_class($this));
		
		foreach ($vars as $key => $value) {
			
			$json[$key] = $this->{$key};
		}
		return $json;
	}

	/**
	 * {@inheritDoc}
	 * @see \com\appstions\yourChallenge\entity\JsonUnserializable::jsonUnserialize()
	 */
	public function jsonUnserialize(array $array) {
		$isValid = true;
	
		foreach ($array as $key => $value) {
			if(property_exists($this, $key)){
				
				if($this->{$key} instanceof JsonUnserializable){
					
					if(is_array($value)){
						call_user_func_array(array($this->{$key}, 'jsonUnserialize'), array($value));
					}else{
						$isValid = false;
					}
	
				}else{
					$this->{$key} = $value;
				}
			} else {
				$isValid = false;
			}
		}
	
		return $isValid;
	

	}
	

}