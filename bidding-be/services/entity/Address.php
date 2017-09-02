<?php
namespace com\appstions\bidding\entity;


require_once 'entity/JsonUnserializable.php';

/**
 * Clase que contiene la definicíón de las direcciones asociadas a un usuario
 * @author Appstions
 *
 */
class Address implements \JsonSerializable, JsonUnserializable {
	
	private $country;	
	private $city;
	private $province;
	private $status;
	private $idUser;
	private $idAddress;
	private $description;

		
	public function __construct(){		
	}
	
	public function getCountry() {
		return $this->country;
	}
	public function setCountry($country) {
		$this->country = $country;
		return $this;
	}
	public function getCity() {
		return $this->city;
	}
	public function setCity($city) {
		$this->city = $city;
		return $this;
	}
	public function getProvince() {
		return $this->province;
	}
	public function setProvince($province) {
		$this->province = $province;
		return $this;
	}
	public function getState() {
		return $this->state;
	}
	public function setState($state) {
		$this->state = $state;
		return $this;
	}
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	public function getIdUser() {
		return $this->idUser;
	}
	public function setIdUser($idUser) {
		$this->idUser = $idUser;
		return $this;
	}
	public function getIdAddress() {
		return $this->idAddress;
	}
	public function setIdAddress($idAddress) {
		$this->idAddress = $idAddress;
		return $this;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
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