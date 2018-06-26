<?php
require_once 'models/DAO/implementationObjectDAO_Dummy.php';
require_once 'models/VO/MasterkeyVO.php';
require_once 'models/DAO/interfaceMasterkeyDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationMasterkeyDAO_Dummy extends implementationObjectDAO_Dummy implements interfaceMasterkeyDAO
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
         $masterkey->setId((int) $xmlMasterkey->idKey);
         array_push($this->_masterkeys, $masterkey);
       }
     } else {
         echo '<pre>';
         throw new RuntimeException('Echec lors de l\'ouverture du fichier masterkeys.xml.');
         echo '</pre>';
         exit();
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

   public function getMasterkeys() {
     return $this->_masterkeys;
   }

   /////////
   public function getMasterkeyById($id_masterkey) {
     return parent::genericGetObjectById($this->_masterkeys, $id_masterkey);
   }

   public function setMasterkey($masterkey_object) {
     $this->_masterkeys = parent::genericSetObject($this->_masterkeys, $masterkey_object);
     $this->saveMasterkey();
   }

   public function delMasterkey($id_masterkey) {
     $this->_masterkeys = parent::genericDelObject($this->_masterkeys, $id_masterkey);
     $this->saveMasterkey();
   }

   public function toString() {
     return parent::genericToString($this->_masterkeys);
   }

   private function saveMasterkey() {
     parent::genericSaveObject($this->_masterkeys, 'masterkey');
   }
}


?>
