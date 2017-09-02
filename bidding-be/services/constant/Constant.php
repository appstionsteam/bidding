<?php

namespace com\appstions\bidding\constant;

/**
 * Contiene constantes a utilizar en el proyecto 
 * @author 
 *
 */
class Constant {
	
	/** Mensajes de registro en el log de los Helper**/
	const METHOD_NOT_FOUND = "Peticion no encontrada";
	
	/** Mensajes de registro en el log de los Service**/
	const METHOD_NOTT_FOUND = "Peticion no encontrada";
	
	/** Mensajes de registro en el log de los DAO**/
	const DAO_ERROR = "Error registrado en el DAO";
	
	/** Define un estado activo para el usuario. Si es la primera vez que ingresa a la aplicaciór**/
	const FIRST_TIME_ACTIVE = "A";
	
	/** Define un estado inactivo para el usuario. Si no es la primera vez que ingresa a la aplicación**/
	const FIRST_TIME_INACTIVE = "I";

	/** Define un estado activo para el login**/
	const LOGIN_STATUS_ACTIVE = "A";
	
	/** Define un estado inactivo para el login**/
	const LOGIN_STATUS_INACTIVE = "I";
	
	/** Tag utilizado en el proceso de creaciòn de recetas**/
	const ID_ALIMENT = 'id_aliment';
	
	/** Tag utilizado en el proceso de creaciòn de recetas**/
	const QUANTITY_ALIMENT = 'quantity_aliment';
	
	/** Tag utilizado en el proceso de creaciòn de recetas**/
	const QUANTITY = 'quantity';
	
	/** Tag utilizado en el proceso de creaciòn de recetas**/
	const UNITY = 'unity';
	
	/** Tag utilizado en el proceso de creaciòn de recetas**/
	const ID_COMPONENT = 'id_component';
	
	/** Tag utilizado en el proceso de creaciòn de recetas**/
	const EMPTY_STRING = '';
	
	/** Tag**/
	const TR_OPEN_TAG = '<tr>';
	
	/** Tag**/
	const TR_END_TAG= '</tr>';
	
	/** Tag**/
	const TD_OPEN_TAG = '<td>';
	
	/** Tag**/
	const TD_END_TAG= '</td>';
	
	
}