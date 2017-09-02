<?php
namespace com\appstions\bidding\exceptions;

class ServiceException extends \Exception{
	public function __construct($message = null, $code = null){
		parent::__construct($message, $code);
	}
	
}