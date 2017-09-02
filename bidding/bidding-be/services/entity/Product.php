<?php
namespace com\appstions\bidding\entity;


require_once 'entity/JsonUnserializable.php';
require_once 'entity/Category.php';
require_once 'entity/Brand.php';

/**
 * Bean con la informaciòn bàsica del producto
 * @author Appstions
 *
 */
class Product implements \JsonSerializable, JsonUnserializable {
	
	private $idProduct;
	private $description;
	private $observations;
	private $category;
	private $state;
	private $brand;
	private $registrationDate;
	private $price;
		
	public function __construct(){
		$this->category = new Category();
		$this->brand = new Brand();
		$this->price = 0.0;
	}
	
	public function getIdProduct() {
		return $this->idProduct;
	}
	public function setIdProduct($idProduct) {
		$this->idProduct = $idProduct;
		return $this;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	public function getObservatios() {
		return $this->observations;
	}
	public function setObservations($observations) {
		$this->observations = $observations;
		return $this;
	}
	public function getCategory() {
		return $this->category;
	}
	public function setCategory($category) {
		$this->category = $category;
		return $this;
	}
	public function getState() {
		return $this->state;
	}
	public function setState($state) {
		$this->state = $state;
		return $this;
	}
	public function getBrand() {
		return $this->brand;
	}
	public function setBrand($brand) {
		$this->brand = $brand;
		return $this;
	}
	public function setRegistrationDate($registrationDate) {
		$this->registrationDate = $registrationDate;
		return $this;
	}
	public function getRegistrationDate() {
		return $this->registrationDate;
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