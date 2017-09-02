	<?php

	namespace com\appstions\biddin\helper;

	use com\appstions\bidding\exceptions\DAOException;
	use com\appstions\bidding\service\Rest;
	use com\appstions\bidding\exceptions\ServiceException;
	use com\appstions\bidding\helper\ExceptionHelper;

	require_once 'exceptions/DAOException.php';
	require_once 'logger/LoggerService.php';

	final class StringLiteralHelper {
		/**
		 * Compara dos cadenas de caracteres
		 * 
		 * @param unknown $a        	
		 * @param unknown $b        	
		 * @return number
		 */
		public static function compare($a, $b) {
			return strcmp ( $a, $b );
		}
		
		/**
		 * Determina si una cadena esta vacia
		 * 
		 * @param unknown $input        	
		 * @return boolean
		 */
		public static function isNotEmpty($input) {
			if (! is_null ( $input )) {
				if ($input !== '') // Also tried this "if(strlen($strTemp) > 0)"
{
					return true;
				}
			}
			
			return false;
		}
	}