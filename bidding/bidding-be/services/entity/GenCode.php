<?php
namespace com\appstions\bidding\entity;


require_once 'entity/JsonUnserializable.php';

/**
 * Clase que contiene un catàlogo de còdigos
 * @author Appstions
 *
 */
class GenCode implements \JsonSerializable, JsonUnserializable {
	
	private $idGen;
	private $description;
	private $state;
	private $user;
	private $detCodes;
		
	public function __construct(){
		$this->detCodes = array();		
	}
	

	public function getIdGen() {
		return $this->idGen;
	}
	public function setIdGen($idGen) {
		$this->idGen = $idGen;
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
	
	public function getUser(){
		return $this->user;
	}
	
	public function setUser($user){
		$this->user = $user;
	}

	public function getDetCodes(){
		return $this->detCodes;
	}
	
	public function setDetCodes($detCodes){
		$this->detCodes = $detCodes;
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