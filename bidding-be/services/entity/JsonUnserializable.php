<?php

namespace com\appstions\bidding\entity;

interface JsonUnserializable {
	/**
	 * 
	 * @param array $array
	 */
	public function jsonUnserialize(array $array);
}