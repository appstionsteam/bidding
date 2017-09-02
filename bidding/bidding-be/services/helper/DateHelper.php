<?php

namespace com\appstions\bidding\helper;

use com\appstions\bidding\exceptions\DAOException;
use com\appstions\bidding\exceptions\ServiceException;
use com\appstions\bidding\service\Rest;

require_once 'exceptions/DAOException.php';
require_once 'logger/LoggerService.php';

final class DateHelper {
	
	const INDEX_DAY = 0;
	const INDEX_MONTH = 1;
	const INDEX_YEAR = 2;
	const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';
	
	/**
	 * Convierte el formato d.m.Y al formato MySQL (Y-m-d H:i:s)
	 * 
	 * @param string $date        	
	 * @throws DAOException
	 * @return string
	 */
	public static function toFormatDateSQL($date) {
		$dateArray = explode ( '.', $date );
		
		if (count ( $dateArray ) != 3) {
			throw new ServiceException ( "El formato de fecha es incorrecto. Esperado: " . self::DATE_FORMAT, Rest::CUSTOM_ERROR_CODE );
		}
		
		$time = mktime ( 0, 0, 0, $dateArray [self::INDEX_MONTH], $dateArray [self::INDEX_DAY], $dateArray [self::INDEX_YEAR] );
		
		if ($time == false) {
			throw new ServiceException ( "El formato de fecha es incorrecto. Esperado: " . self::DATE_FORMAT, Rest::CUSTOM_ERROR_CODE );
		}
		
		return date ( self::MYSQL_DATE_FORMAT, $time );
	}
	
	/**
	 * Convierte una fecha al formato (d.m.y) Ejemplo: 21.02.2015
	 * 
	 * @param string $date        	
	 */
	public static function formatDate($date) {
		if ($date == null || $date == '0000-00-00 00:00:00') {
			$date = '1900-01-01';
		}
		return date ( self::DATE_FORMAT, strtotime ( $date ) );
	}
}