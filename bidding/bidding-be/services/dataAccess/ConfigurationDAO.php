<?php
namespace com\appstions\bidding\dataAccess;

use com\appstions\bidding\helper\ExceptionHelper;
use com\appstions\bidding\helper\QueryHelper;
use com\appstions\bidding\dataAccess\DAO;

require_once 'dataAccess/DAO.php';

/**
 * Description of ConfigurationDAO
 *
 * @author macbook
 */
class ConfigurationDAO extends DAO {
    
  
    private $dao;
    
    public function __construct() {
        parent::__construct();
        $this->dao = new QueryHelper('configurationQueries');
    }
    
    public function getConfigurationValue($configurationCode){
        
        try {
            
            $value = null;
            $sqlQuery = $this->dao->getQuery('getConfigurationValue');
			
			$query = $this->getConnection()->prepare($sqlQuery);
            
            $query->bindValue(":configuration_code", $configurationCode);
            $query->execute();

            if ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
                $value = $row['configuration_value'];
            }

            return $value;
            
        } catch (\Exception $e) {
            ExceptionHelper::log($e, $this);
			ExceptionHelper::throwException($e, $this);
        }
    }
}
