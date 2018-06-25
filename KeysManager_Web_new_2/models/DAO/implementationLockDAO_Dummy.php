<?php
require_once 'models/DAO/implementationObjectDAO_Dummy.php';
require_once 'models/VO/LockVO.php';
require_once 'models/DAO/interfaceLockDAO.php';



// Implémentation de l'interface
// Ceci va fonctionner
class implementationLockDAO_Dummy extends implementationObjectDAO_Dummy implements interfaceLockDAO
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
         echo '<pre>';
         throw new RuntimeException('Echec lors de l\'ouverture du fichier locks.xml.');
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
       self::$_instance = new implementationLockDAO_Dummy();
     }
     return self::$_instance;
   }

   public function getLocks() {
     return $this->_locks;
   }

   ////////
   public function getLockById($id_lock) {
     return parent::genericGetObjectById($this->_locks, $id_lock);
   }

   public function setLock($lock_object) {
     $this->_locks = parent::genericSetObject($this->_locks, $lock_object);
     $this->saveLock();
   }

   public function delLock($id_lock) {
     $this->_locks = parent::genericDelObject($this->_locks, $id_lock);
     $this->saveLock();
   }

   public function toString() {
     return parent::genericToString($this->_locks);
   }

   private function saveLock() {
     parent::genericSaveObject($this->_locks, 'lock');
   }

   public function getLockIdsWithProviderId($id_provider) {
      $ids = array();
      foreach ($this->_locks as $infos) {
        if($infos->getIdProvider() == $id_provider) {
          $ids[] = $infos->getId();
        }
      }
      return $ids;
   }

   public function getLockIdsWithLengthId($length) {
      $ids = array();
      foreach ($this->_locks as $infos) {
        if($infos->getLength() == $length) {
          $ids[] = $infos->getId();
        }
      }
      return $ids;
   }
}
?>
