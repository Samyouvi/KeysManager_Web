<?php
require_once 'Model/VO/LockVO.php';
require_once 'Model/DAO/interfaceLockDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationLockDAO_Dummy implements interfaceLockDAO
{

  private $_locks = array();

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
     if (file_exists(dirname(__FILE__).'/../XML/locks.xml')) {
       $locks = simplexml_load_file(dirname(__FILE__).'/../XML/locks.xml');
       foreach($locks->children() as $xmlLock)
       {
         $lock = new LockVO;
         // PRIMARYKEY
         $lock->setId((int) $xmlLock->idLock);
         // FOREIGNKEYS
         $lock->setIdProvider((int) $xmlLock->idProvider);
         // Parametres
         $lock->setLength((float) $xmlLock->length);
         array_push($this->_locks, $lock);
       }
     } else {
         throw new RuntimeException('Echec lors de l\'ouverture du fichier locks.xml.');
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
       self::$_instance = new implementationLockDAO_Dummy();
     }

     return self::$_instance;
   }

   public function getLocks()
   {
     return $this->_locks;
   }
}


?>
