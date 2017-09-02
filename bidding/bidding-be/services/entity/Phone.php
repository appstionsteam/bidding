<?php
namespace com\appstions\bidding\entity;


require_once 'entity/JsonUnserializable.php';

/**
 * Contiene las categorías de alimentos 
 * @author Appstions
 *
 */
class Phone implements \JsonSerializable, JsonUnserializable {
	
	private $phoneNumber;	
	private $state;
		
	public function __construct(){		
	}
	
	public function getPhoneNumber() {
		return $this->email;
	}
	public function setPhoneNumber($phoneNumber) {
		$this->phoneNumber = $phoneNumber;
		return $this;
	}
	public function getState() {
		return $this->state;
	}
	public function setState($state) {
		$this->state = $state;
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