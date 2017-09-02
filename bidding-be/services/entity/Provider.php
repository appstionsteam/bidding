<?php
namespace com\appstions\bidding\entity;


require_once 'entity/JsonUnserializable.php';

class Provider implements \JsonSerializable, JsonUnserializable {
	
	private $idUser;
	private $idType;
	private $idNumber;
	private $password;
	private $name;
	private $lastName;
	private $status;
	private $registrationDate;
	private $updateDate;
	private $emails;
	private $phoneNumbers;
	private $addresses;
	private $roles;
		
	public function __construct(){		
		$this->emails = array();
		$this->phoneNumbers = array();
		$this->addresses = array();
		$this->roles = array();
	}
	
	public function setIdUser($idUser){
		$this->idUser = $idUser;
		return $this;
	}
	public function getIdUser(){
		return $this->idUser;
	}
	public function setIdType($idType){
		$this->idType = $idType;
		return $this;
	}
	public function getIdType(){
		return $this->idType;
	}
	public function setIdNumber($idNumber){
		$this->idNumber = $idNumber;
		return $this;
	}
	public function getIdNumber(){
		return $this->idNumber;
	}
	public function setPassword($password){
		$this->password = $password;
		return $this;
	}	
	public function getPassword(){
		return $this->password;
	}
	public function setName($name){
		$this->name = $name;
		return $this;
	}
	public function getName(){
		return $this->name;
	}
	public function setLastName($lastName) {
		$this->lastName = $lastName;
		return $this;
	}
	public function getLastName() {
		return $this->lastName;
	}
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	public function getStatus() {
		return $this->status;
	}
	public function setRegistrationDate($registrationDate) {
		$this->registrationDate = $registrationDate;
		return $this;
	}
	public function getRegistrationDate() {
		return $this->registrationDate;
	}
	public function setUpdateDate($updateDate) {
		$this->updateDate = $updateDate;
		return $this;
	}
	public function getUpdateDate() {
		return $this->updateDate;
	}
	public function setEmails($emails){
		$this->emails = $emails;
		return $this;
	}
	public function getEmails(){
		return $this->emails;
	}
	public function setPhoneNumbers($phoneNumbers) {
		$this->phoneNumbers = $phoneNumbers;
		return $this;
	}
	public function getPhoneNumbers() {
		return $this->phoneNumbers;
	}
	public function setAddresses($addresses) {
		$this->addresses = $addresses;
		return $this;
	}
	public function getAddresses() {
		return $this->addresses;
	}
	public function setRoles($addresses) {
		$this->roles = $roles;
		return $this;
	}
	public function getRoles() {
		return $this->roles;
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