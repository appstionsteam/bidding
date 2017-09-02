<?php
namespace com\appstions\bidding\entity;


require_once 'entity/JsonUnserializable.php';

/**
 * Clase que contiene un catàlogo de descripciones asociadas a un GenCode
 * @author Appstions
 *
 */
class DetCode implements \JsonSerializable, JsonUnserializable {
	
	private $idDet;
	private $description;
	private $state;
		
	public function __construct(){		
	}
	

	public function getIdDet() {
		return $this->idDet;
	}
	public function setIdDet($idDet) {
		$this->idDet = $idDet;
		return $this;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
	public function setDescription($description){
		$this->description = $description;
	}

	public function getState(){
		return $this->state;
	}
	
	public function setState($state){
		$this->state = $state;
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