<?php
require_once 'Model/VO/MasterkeyVO.php';
require_once 'Model/DAO/interfaceMasterkeyDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationMasterkeyDAO_Dummy implements interfaceMasterkeyDAO
{

  private $_masterkeys = array();

  /**
   * @var Singleton
   * @access private
   * @static
   */
   private static $_instance = null;


   /**
    * Constructeur de la classe
    *
    * @param void
    * @return void
    */
   private function __construct() {
     if (file_exists(dirname(__FILE__).'/../XML/masterkeys.xml')) {
       $masterkeys = simplexml_load_file(dirname(__FILE__).'/../XML/masterkeys.xml');
       foreach($masterkeys->children() as $xmlMasterkey)
       {
         $masterkey = new MasterkeyVO;
         // FOREIGNKEYS
         $masterkey->setIdKey((int) $xmlMasterkey->idKey);
         array_push($this->_masterkeys, $masterkey);
       }
     } else {
         throw new RuntimeException('Echec lors de l\'ouverture du fichier masterkeys.xml.');
     }
   }

   /**
    * Méthode qui crée l'unique instance de la classe
    * si elle n'existe pas encore puis la retourne.
    *
    * @param void
    * @return Singleton
    */
   public static function getInstance() {

     if(is_null(self::$_instance)) {
       self::$_instance = new implementationMasterkeyDAO_Dummy();
     }

     return self::$_instance;
   }

   public function getMasterkeys()
   {
     return $this->_masterkeys;
   }
}


?>
