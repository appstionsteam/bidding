<?php
namespace com\appstions\bidding\entity;


require_once 'entity/JsonUnserializable.php';
require_once 'entity/Seller.php';

/**
 * Bean para manejar las cotizaciones asociadas a una solicitud
 * @author Appstions
 *
 */
class Bidding implements \JsonSerializable, JsonUnserializable {
	
	private $idBidding;
	private $seller;
	private $idRequest;
	private $registrationDate;
	private $updateDate;
	private $price;
	private $description;
		
	public function __construct(){
		$this->seller = new Seller();
		$this->price = 0.0;
	}
	
	public function getIdBiddding() {
		return $this->idBidding;
	}
	public function setIdBidding($idBidding) {
		$this->idBidding = $idBidding;
		return $this;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	public function getState() {
		return $this->state;
	}
	public function setState($state) {
		$this->state = $state;
		return $this;
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
	public function getPrice() {
		return $this->price;
	}
	public function setPrice($price) {
		$this->price = $price;
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