<?php
require_once 'Model/VO/OuvreVO.php';
require_once 'Model/DAO/interfaceOuvreDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationOuvreDAO_Dummy implements interfaceOuvreDAO
{

  private $_ouvres = array();

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
     if (file_exists(dirname(__FILE__).'/../XML/ouvres.xml')) {
       $ouvres = simplexml_load_file(dirname(__FILE__).'/../XML/ouvres.xml');
       foreach($ouvres->children() as $xmlOuvre)
       {
         $ouvre = new OuvreVO;
         // PRIMARYKEY
         $ouvre->setIdLock((int) $xmlOuvre->idLock);
         $ouvre->setIdKey((int) $xmlOuvre->idKey);
         array_push($this->_ouvres, $ouvre);
       }
     } else {
         throw new RuntimeException('Echec lors de l\'ouverture du fichier ouvres.xml.');
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
       self::$_instance = new implementationOuvreDAO_Dummy();
     }

     return self::$_instance;
   }

   public function getOuvres()
   {
     return $this->_ouvres;
   }

   public function getIdsWithIdLock($id_lock) {
     $ids = array();
     foreach ($this->_ouvres as $infos) {
       if($infos->getIdLock() == $id_lock) {
         array_push($ids, $infos);
       }
     }
     return $ids;
   }
}


?>
