<?php
namespace com\appstions\bidding\entity;


require_once 'entity/JsonUnserializable.php';
require_once 'entity/Customer.php';
require_once 'entity/Product.php';

class RequestCustomer implements \JsonSerionializable, JsonUnserializable {
	
	private $idRequest;
	private $customer;
	private $status;
	private $product;
	private $description;
	private $status;
	private $registrationDate;
	private $updateDate;
		
	public function __construct(){
		$this->customer = new Customer();		
		$this->product = new Product();		
	}
	
	public function setIdRequest($idRequest){
		$this->idRequest = $idRequest;
		return $this;
	}
	public function getIdRequest(){
		return $this->idRequest;
	}
	public function setCustomer($customer){
		$this->customer = $customer;
		return $this;
	}
	public function getCustomer(){
		return $this->customer;
	}
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	public function getStatus() {
		return $this->status;
	}
	public function setDescription($description){
		$this->description = $description;
		return $this;
	}
	public function getDescription(){
		return $this->description;
	}
	public function setProduct($product){
		$this->product = $product;
		return $this;
	}
	public function getProduct(){
		return $this->product;
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
		return $json;Description**description {@inheritDoc}
	 * @see \com\descriptionons\description\entity\JsonUnserializable::jsonUnserialize()
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